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
            return $this->handleCallback($request, $telegram);
        }

        if ($request->has('message')) {
            return $this->handleMessage($request, $telegram);
        }

        return response()->json(['ok' => true]);
    }

    private function handleMessage(Request $request, TelegramAlertService $telegram)
    {
        $message = $request->input('message');
        $chatId = (string) data_get($message, 'chat.id');
        $text = trim((string) data_get($message, 'text', ''));

        Log::info('TELEGRAM_INCOMING', ['chat_id' => $chatId, 'text' => $text]);

        if (!$chatId || !$text) {
            return response()->json(['ok' => true]);
        }

        if (preg_match('/^\/myid/i', $text)) {
            $telegram->send([$chatId], "Your Telegram Chat ID is:\n\n<code>{$chatId}</code>\n\nCopy this number into the web Telegram Connect page.");
            return response()->json(['ok' => true]);
        }


        // Connect Telegram: /start CODE
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
                $telegram->send([$chatId], "Invalid Telegram connect code. Please generate a new code from the web.");
            }

            return response()->json(['ok' => true]);
        }

        $user = User::where('telegram_chat_id', $chatId)->first();

        if (!$user) {
            $telegram->send([$chatId], "Telegram account belum terhubung.\n\nBuka web → Connect Telegram dulu.");
            return response()->json(['ok' => true]);
        }

        // Clear context
        if (preg_match('/^\/clear/i', $text)) {
            Cache::forget("tg_ticket_context_{$chatId}");
            $telegram->send([$chatId], "Context ticket sudah dibersihkan.");
            return response()->json(['ok' => true]);
        }

        // Select ticket context
        if (preg_match('/^\/ticket\s+(.+)/i', $text, $m)) {
            $ticketNumber = trim($m[1]);

            $ticket = ProblemLog::with(['company', 'device', 'createdByUser', 'assignedEngineer'])
                ->where('ticket_number', $ticketNumber)
                ->orWhere('id', $ticketNumber)
                ->first();

            if (!$ticket) {
                $telegram->send([$chatId], "Ticket tidak ditemukan: {$ticketNumber}");
                return response()->json(['ok' => true]);
            }

            Cache::put("tg_ticket_context_{$chatId}", $ticket->id, now()->addHours(6));

            $telegram->send([$chatId], $this->ticketContextMessage($ticket));

            return response()->json(['ok' => true]);
        }

        // Normal chat forwarding
        $ticketId = Cache::get("tg_ticket_context_{$chatId}");

        if (!$ticketId) {
            $telegram->send([$chatId], "Ketik nomor ticket dulu:\n\n/ticket TKTxxxx\n\nContoh:\n/ticket TKTAA95381B63C0");
            return response()->json(['ok' => true]);
        }

        $ticket = ProblemLog::with(['company', 'device', 'createdByUser', 'assignedEngineer'])->find($ticketId);

        if (!$ticket) {
            Cache::forget("tg_ticket_context_{$chatId}");
            $telegram->send([$chatId], "Ticket context tidak ditemukan. Ketik /ticket NOMOR lagi.");
            return response()->json(['ok' => true]);
        }

        $isEngineer = $ticket->assigned_engineer_id && $user->id === $ticket->assigned_engineer_id;

        $recipient = $isEngineer ? $ticket->createdByUser : $ticket->assignedEngineer;

        if (!$recipient || !$recipient->telegram_chat_id) {
            $telegram->send([$chatId], $isEngineer
                ? "User pembuat ticket belum connect Telegram."
                : "Engineer ticket ini belum connect Telegram atau belum assigned."
            );
            return response()->json(['ok' => true]);
        }

        Cache::put("tg_ticket_context_{$recipient->telegram_chat_id}", $ticket->id, now()->addHours(6));

        $senderRole = $isEngineer ? "Engineer" : "User";
        $recipientRole = $isEngineer ? "User" : "Engineer";

        $telegram->send([$recipient->telegram_chat_id], $this->chatForwardMessage($ticket, $user, $senderRole, $text));
        $telegram->send([$chatId], "Pesan sudah dikirim ke {$recipientRole} ✅");

        DB::table('problem_log_updates')->insert([
            'problem_log_id' => $ticket->id,
            'user_id' => $user->id,
            'type' => $isEngineer ? 'telegram_engineer_reply' : 'telegram_user_message',
            'message' => "[Telegram {$senderRole}] " . $text,
            'old_status' => $ticket->status,
            'new_status' => $ticket->status,
            'meta' => json_encode([
                'telegram_chat_id' => $chatId,
                'recipient_user_id' => $recipient->id,
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }

    private function handleCallback(Request $request, TelegramAlertService $telegram)
    {
        $callback = $request->input('callback_query');
        $callbackId = (string) data_get($callback, 'id');

        // 🔥 Anti duplicate (Telegram retry protection)
        if (\Illuminate\Support\Facades\Cache::has('tg_cb_'.$callbackId)) {
            return response()->json(['ok' => true]);
        }
        \Illuminate\Support\Facades\Cache::put('tg_cb_'.$callbackId, true, now()->addMinutes(5));

        $callback = $request->input('callback_query');
        $callbackId = (string) data_get($callback, 'id');
        $chatId = (string) data_get($callback, 'message.chat.id');
        $data = (string) data_get($callback, 'data');

        $user = User::where('telegram_chat_id', $chatId)->first();

        if (!$user) {
            $telegram->answerCallback($callbackId, 'Telegram belum connect.');
            return response()->json(['ok' => true]);
        }

        [$action, $ticketId] = array_pad(explode(':', $data, 2), 2, null);

        $ticket = ProblemLog::find($ticketId);

        if (!$ticket) {
            $telegram->answerCallback($callbackId, 'Ticket tidak ditemukan.');
            return response()->json(['ok' => true]);
        }

        if ($action === 'ticket_ack' && $ticket->status !== 'closed') {
            $oldStatus = $ticket->status;

            $ticket->status = 'in_progress';
            $ticket->acknowledged_at = $ticket->acknowledged_at ?: now();
            $ticket->in_progress_at = $ticket->in_progress_at ?: now();
            $ticket->acknowledged_by_user_id = $user->id;
            $ticket->save();

            DB::table('problem_log_updates')->insert([
                'problem_log_id' => $ticket->id,
                'user_id' => $user->id,
                'type' => 'telegram_ack',
                'message' => 'Ticket acknowledged via Telegram.',
                'old_status' => $oldStatus,
                'new_status' => 'in_progress',
                'meta' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Cache::put("tg_ticket_context_{$chatId}", $ticket->id, now()->addHours(6));

            $telegram->answerCallback($callbackId, 'Ticket acknowledged.');
            $telegram->send([$chatId], "Ticket acknowledged via Telegram ✅\n" . url('/problem-logs/' . $ticket->id));
        }

        if ($action === 'ticket_close' && $ticket->status !== 'closed') {
            $oldStatus = $ticket->status;

            $ticket->status = 'closed';
            $ticket->closed_at = now();
            $ticket->closed_by_user_id = $user->id;
            $ticket->close_note = $ticket->close_note ?: 'Closed via Telegram.';
            $ticket->save();

            DB::table('problem_log_updates')->insert([
                'problem_log_id' => $ticket->id,
                'user_id' => $user->id,
                'type' => 'telegram_close',
                'message' => 'Ticket closed via Telegram.',
                'old_status' => $oldStatus,
                'new_status' => 'closed',
                'meta' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Cache::forget("tg_ticket_context_{$chatId}");

            $telegram->answerCallback($callbackId, 'Ticket closed.');
            $telegram->send([$chatId], "Ticket closed via Telegram ✅\n" . url('/problem-logs/' . $ticket->id));
        }

        return response()->json(['ok' => true]);
    }

    private function ticketContextMessage(ProblemLog $ticket): string
    {
        $device = $ticket->device;
        $location = $device ? implode(' / ', array_filter([$device->site, $device->location])) : '-';

        return implode("\n", [
            "<b>Ticket chat aktif ✅</b>",
            "",
            "<b>Ticket:</b> " . ($ticket->ticket_number ?: '#' . $ticket->id),
            "<b>Judul:</b> " . e($ticket->title ?: '-'),
            "<b>Status:</b> " . e($ticket->status ?: '-'),
            "<b>Customer:</b> " . e(optional($ticket->company)->name ?: '-'),
            "<b>Device:</b> " . e($device ? (($device->device_code ?: '-') . ' — ' . ($device->name ?: '-')) : '-'),
            "<b>Lokasi:</b> " . e($location ?: '-'),
            "<b>Engineer:</b> " . e(optional($ticket->assignedEngineer)->name ?: '-'),
            "",
            "Ketik pesan biasa untuk chat dengan engineer/user terkait.",
            "Ketik /clear untuk keluar dari ticket ini.",
            "",
            "<b>Link:</b> " . url('/problem-logs/' . $ticket->id),
        ]);
    }

    private function chatForwardMessage(ProblemLog $ticket, User $sender, string $senderRole, string $text): string
    {
        return implode("\n", [
            "<b>Pesan Telegram dari {$senderRole}</b>",
            "",
            "<b>Ticket:</b> " . ($ticket->ticket_number ?: '#' . $ticket->id),
            "<b>Judul:</b> " . e($ticket->title ?: '-'),
            "<b>Dari:</b> " . e($sender->name ?: $sender->email ?: '-'),
            "",
            "<b>Pesan:</b>",
            e($text),
            "",
            "Reply pesan biasa untuk membalas di ticket yang sama.",
            "<b>Link:</b> " . url('/problem-logs/' . $ticket->id),
        ]);
    }
}
