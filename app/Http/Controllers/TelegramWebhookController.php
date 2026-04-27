<?php

namespace App\Http\Controllers;

use App\Models\ProblemLog;
use App\Models\User;
use App\Services\TelegramAlertService;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request, TelegramAlertService $telegram)
    {
        $callback = $request->input('callback_query');

        if (!$callback) {
            return response()->json(['ok' => true]);
        }

        $callbackId = (string) data_get($callback, 'id');
        $chatId = (string) data_get($callback, 'message.chat.id');
        $data = (string) data_get($callback, 'data');

        $user = User::where('telegram_chat_id', $chatId)->first();

        if (!$user) {
            $telegram->answerCallback($callbackId, 'Telegram account is not connected to any user.');
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

            $ticket->updates()->create([
                'user_id' => $user->id,
                'type' => 'telegram_ack',
                'message' => 'Ticket acknowledged via Telegram.',
                'old_status' => $oldStatus,
                'new_status' => 'in_progress',
            ]);

            $telegram->answerCallback($callbackId, 'Ticket acknowledged.');
            $telegram->send([$chatId], "✅ Ticket acknowledged via Telegram.\n" . url('/problem-logs/' . $ticket->id));

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

            $ticket->updates()->create([
                'user_id' => $user->id,
                'type' => 'telegram_close',
                'message' => 'Ticket closed via Telegram.',
                'old_status' => $oldStatus,
                'new_status' => 'closed',
            ]);

            $telegram->answerCallback($callbackId, 'Ticket closed.');
            $telegram->send([$chatId], "✅ Ticket closed via Telegram.\n" . url('/problem-logs/' . $ticket->id));

            return response()->json(['ok' => true]);
        }

        $telegram->answerCallback($callbackId, 'Unknown action.');
        return response()->json(['ok' => true]);
    }
}
