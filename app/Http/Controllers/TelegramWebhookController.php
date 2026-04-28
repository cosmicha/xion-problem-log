<?php

namespace App\Http\Controllers;

use App\Models\ProblemLog;
use App\Models\User;
use App\Services\TelegramAlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

        if (!$chatId || !$text) {
            return response()->json(['ok' => true]);
        }

        $user = User::where('telegram_chat_id', $chatId)->first();

        if (!$user) {
            $telegram->send([$chatId], "Telegram account belum terhubung ke user system.\n\nBuka web → Connect Telegram dulu.");
            return response()->json(['ok' => true]);
        }

        if (preg_match('/^\/clear/i', $text)) {
            Cache::forget("tg_ticket_context_{$chatId}");
            $telegram->send([$chatId], "Context ticket sudah dibersihkan.");
            return response()->json(['ok' => true]);
        }

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

            Cache::put("tg_ticket_context_{$chatId}", $ticket->id, now()->addHours(2));

            $telegram->send([$chatId], $this->ticketContextMessage($ticket, "Ticket context aktif.\nSekarang kamu bisa tanya apa saja tentang ticket ini."));

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
            $telegram->send([$chatId], "Ticket context tidak ditemukan. Ketik /ticket NOMOR lagi.");
            return response()->json(['ok' => true]);
        }

        $isEngineer = $ticket->assigned_engineer_id && $user->id === $ticket->assigned_engineer_id;

        $recipient = $isEngineer
            ? $ticket->createdByUser
            : $ticket->assignedEngineer;

        if (!$recipient || !$recipient->telegram_chat_id) {
            $telegram->send([$chatId], $isEngineer
                ? "User pembuat ticket belum connect Telegram."
                : "Engineer ticket ini belum connect Telegram atau belum assigned."
            );
            return response()->json(['ok' => true]);
        }

        Cache::put("tg_ticket_context_{$recipient->telegram_chat_id}", $ticket->id, now()->addHours(2));

        $senderRole = $isEngineer ? "Engineer" : "User";
        $recipientRole = $isEngineer ? "User" : "Engineer";

        $forwardMessage = $this->chatForwardMessage($ticket, $user, $senderRole, $text);

        $telegram->send([$recipient->telegram_chat_id], $forwardMessage);
        $telegram->send([$chatId], "Pesan sudah dikirim ke {$recipientRole}.");

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
        $chatId = (string) data_get($callback, 'message.chat.id');
        $data = (string) data_get($callback, 'data');

        $user = User::where('telegram_chat_id', $chatId)->first();

        if (!$user) {
            $telegram->answerCallback($callbackId, 'Telegram account belum terhubung.');
            return response()->json(['ok' => true]);
        }

        [$action, $ticketId] = array_pad(explode(':', $data, 2), 2, null);

        $ticket = ProblemLog::with(['company', 'device', 'createdByUser', 'assignedEngineer'])->find($ticketId);

        if (!$ticket) {
            $telegram->answerCallback($callbackId, 'Ticket not found.');
            return response()->json(['ok' => true]);
        }

        if ($action === 'ticket_ack') {
            if ($ticket->status === 'closed') {
                $telegram->answerCallback($callbackId, 'Ticket already closed.');
                return response()->json(['ok' => true]);
            }

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

            Cache::put("tg_ticket_context_{$chatId}", $ticket->id, now()->addHours(2));

            $telegram->answerCallback($callbackId, 'Ticket acknowledged.');
            $telegram->send([$chatId], "Ticket acknowledged via Telegram.\n" . url('/problem-logs/' . $ticket->id));

            return response()->json(['ok' => true]);
        }

        if ($action === 'ticket_close') {
            if ($ticket->status === 'closed') {
                $telegram->answerCallback($callbackId, 'Ticket already closed.');
                return response()->json(['ok' => true]);
            }

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
            $telegram->send([$chatId], "Ticket closed via Telegram.\n" . url('/problem-logs/' . $ticket->id));

            return response()->json(['ok' => true]);
        }

        $telegram->answerCallback($callbackId, 'Unknown action.');
        return response()->json(['ok' => true]);
    }

    private function ticketContextMessage(ProblemLog $ticket, string $intro): string
    {
        $device = $ticket->device;
        $location = $device ? implode(' / ', array_filter([$device->site, $device->location])) : '-';

        return implode("\n", [
            "<b>{$intro}</b>",
            "",
            "<b>Ticket:</b> " . ($ticket->ticket_number ?: '#' . $ticket->id),
            "<b>Judul:</b> " . e($ticket->title ?: '-'),
            "<b>Status:</b> " . e($ticket->status ?: '-'),
            "<b>Customer:</b> " . e(optional($ticket->company)->name ?: '-'),
            "<b>Device:</b> " . e($device ? (($device->device_code ?: '-') . ' — ' . ($device->name ?: '-')) : '-'),
            "<b>Lokasi:</b> " . e($location ?: '-'),
            "<b>Engineer:</b> " . e(optional($ticket->assignedEngineer)->name ?: '-'),
            "",
            "<b>Link:</b> " . url('/problem-logs/' . $ticket->id),
            "",
            "Ketik pesan biasa untuk chat dengan engineer/user terkait.",
            "Ketik /clear untuk keluar dari context ticket ini.",
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
