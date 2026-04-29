<?php

namespace App\Http\Controllers;

use App\Models\ProblemLog;
use App\Models\User;
use App\Services\TelegramAlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request, TelegramAlertService $telegram)
    {
        if ($request->has('callback_query')) {
            return response()->json(['ok' => true]);
        }

        $message = $request->input('message', []);
        $chatId = (string) data_get($message, 'chat.id');
        $text = trim((string) data_get($message, 'text', ''));

        Log::info('TG_INCOMING', ['chat_id' => $chatId, 'text' => $text]);

        if (!$chatId || !$text) {
            return response()->json(['ok' => true]);
        }

        if (preg_match('/^\/myid/i', $text)) {
            $telegram->send([$chatId], "Your Telegram Chat ID is:\n\n<code>{$chatId}</code>");
            return response()->json(['ok' => true]);
        }

        if (preg_match('/^\/start\s+([A-Z0-9]{6,30})/i', $text, $m)) {
            $code = strtoupper(trim($m[1]));

            $user = User::where('telegram_link_code', $code)->first();

            if (!$user && Schema::hasColumn('users', 'telegram_connect_code')) {
                $user = User::where('telegram_connect_code', $code)->first();
            }

            if ($user) {
                $user->telegram_chat_id = $chatId;
                if (Schema::hasColumn('users', 'telegram_linked_at')) {
                    $user->telegram_linked_at = now();
                }
                $user->save();

                $telegram->send([$chatId], "Telegram connected successfully ✅\n\nUser: " . ($user->name ?: $user->email));
            } else {
                $telegram->send([$chatId], "Invalid connect code. Please generate a new code from the web.");
            }

            return response()->json(['ok' => true]);
        }

        $user = User::where('telegram_chat_id', $chatId)->first();

        if (!$user) {
            $telegram->send([$chatId], "Telegram belum connect ke user system.\n\nBuka web → Connect Telegram.");
            return response()->json(['ok' => true]);
        }

        if (preg_match('/^\/clear/i', $text)) {
            Cache::forget("tg_ticket_context_{$chatId}");
            $telegram->send([$chatId], "Ticket context cleared ✅");
            return response()->json(['ok' => true]);
        }

        if (preg_match('/^\/ticket\s+(.+)/i', $text, $m)) {
            $key = trim($m[1]);

            $ticket = ProblemLog::with(['company', 'device', 'createdByUser', 'assignedEngineer'])
                ->where('ticket_number', $key)
                ->orWhere('id', $key)
                ->first();

            if (!$ticket) {
                $telegram->send([$chatId], "Ticket tidak ditemukan: {$key}");
                return response()->json(['ok' => true]);
            }

            Cache::put("tg_ticket_context_{$chatId}", $ticket->id, now()->addHours(12));

            $telegram->send([$chatId], $this->ticketContextMessage($ticket));

            return response()->json(['ok' => true]);
        }

        $ticketId = Cache::get("tg_ticket_context_{$chatId}");

        if (!$ticketId) {
            $telegram->send([$chatId], "Ketik nomor ticket dulu:\n\n/ticket TKTxxxx\n\nContoh:\n/ticket TKTAA95381B63C0");
            return response()->json(['ok' => true]);
        }

        $ticket = ProblemLog::with(['company', 'device', 'createdByUser', 'assignedEngineer'])->find($ticketId);

        if (!$ticket) {
            Cache::forget("tg_ticket_context_{$chatId}");
            $telegram->send([$chatId], "Ticket context hilang. Ketik /ticket NOMOR lagi.");
            return response()->json(['ok' => true]);
        }

        $isEngineer = $ticket->assigned_engineer_id && $user->id === (int) $ticket->assigned_engineer_id;

        $recipient = $isEngineer ? $ticket->createdByUser : $ticket->assignedEngineer;

        if (!$recipient || !$recipient->telegram_chat_id) {
            $telegram->send([$chatId], $isEngineer
                ? "User pembuat ticket belum connect Telegram."
                : "Engineer ticket ini belum connect Telegram / belum assigned."
            );
            $this->saveTimeline($ticket, $user, $isEngineer ? 'telegram_engineer_reply' : 'telegram_user_message', $text);
            return response()->json(['ok' => true]);
        }

        Cache::put("tg_ticket_context_{$recipient->telegram_chat_id}", $ticket->id, now()->addHours(12));

        $senderRole = $isEngineer ? 'Engineer' : 'User';
        $recipientRole = $isEngineer ? 'User' : 'Engineer';

        $telegram->send([$recipient->telegram_chat_id], $this->forwardMessage($ticket, $user, $senderRole, $text));
        $telegram->send([$chatId], "Pesan sudah dikirim ke {$recipientRole} ✅");

        $this->saveTimeline($ticket, $user, $isEngineer ? 'telegram_engineer_reply' : 'telegram_user_message', $text);

        return response()->json(['ok' => true]);
    }

    private function ticketContextMessage(ProblemLog $ticket): string
    {
        $device = $ticket->device;
        $location = $device ? implode(' / ', array_filter([$device->site, $device->location])) : '-';

        return implode("\n", [
            "<b>Ticket Chat Active ✅</b>",
            "",
            "<b>Ticket:</b> " . ($ticket->ticket_number ?: '#' . $ticket->id),
            "<b>Title:</b> " . e($ticket->title ?: '-'),
            "<b>Status:</b> " . e($ticket->status ?: '-'),
            "<b>Company:</b> " . e(optional($ticket->company)->name ?: '-'),
            "<b>Device:</b> " . e($device ? (($device->device_code ?: '-') . ' — ' . ($device->name ?: '-')) : '-'),
            "<b>Location:</b> " . e($location ?: '-'),
            "<b>Engineer:</b> " . e(optional($ticket->assignedEngineer)->name ?: '-'),
            "",
            "Ketik pesan biasa untuk chat dengan lawan bicara ticket ini.",
            "Ketik /clear untuk keluar dari context ticket.",
            "",
            "<b>Link:</b> " . url('/problem-logs/' . $ticket->id),
        ]);
    }

    private function forwardMessage(ProblemLog $ticket, User $sender, string $senderRole, string $text): string
    {
        return implode("\n", [
            "<b>New Telegram Message from {$senderRole}</b>",
            "",
            "<b>Ticket:</b> " . ($ticket->ticket_number ?: '#' . $ticket->id),
            "<b>Title:</b> " . e($ticket->title ?: '-'),
            "<b>From:</b> " . e($sender->name ?: $sender->email ?: '-'),
            "",
            "<b>Message:</b>",
            e($text),
            "",
            "Reply biasa untuk membalas di ticket yang sama.",
            "Ketik /clear untuk keluar.",
            "",
            "<b>Link:</b> " . url('/problem-logs/' . $ticket->id),
        ]);
    }

    private function saveTimeline(ProblemLog $ticket, User $user, string $type, string $text): void
    {
        DB::table('problem_log_updates')->insert([
            'problem_log_id' => $ticket->id,
            'user_id' => $user->id,
            'type' => $type,
            'message' => '[Telegram] ' . $text,
            'old_status' => $ticket->status,
            'new_status' => $ticket->status,
            'meta' => json_encode(['telegram_chat_id' => $user->telegram_chat_id]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
