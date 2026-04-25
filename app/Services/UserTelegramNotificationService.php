<?php

namespace App\Services;

use App\Models\ProblemLog;
use App\Models\User;

class UserTelegramNotificationService
{
    public function __construct(
        private TelegramAlertService $telegram
    ) {}

    public function sendToUser(?User $user, string $message): void
    {
        if (!$user || empty($user->telegram_chat_id)) {
            return;
        }

        $this->telegram->send([$user->telegram_chat_id], $message);
    }

    public function ticketMessage(ProblemLog $ticket, string $title, string $message, ?string $activity = null): string
    {
        $ticket->loadMissing(['company', 'device']);

        $device = $ticket->device;
        $company = $ticket->company;

        $locationParts = array_filter([
            $device?->site,
            $device?->location,
        ]);

        $deviceLine = $device
            ? trim(($device->device_code ?: '-') . ' — ' . ($device->name ?: '-') . ' (' . ucfirst($device->category ?: 'Device') . ')')
            : '-';

        $locationLine = count($locationParts) ? implode(' / ', $locationParts) : '-';

        $lines = [
            "<b>{$title}</b>",
            $message,
            "",
            "<b>Ticket:</b> " . ($ticket->ticket_number ?: ('#' . $ticket->id)),
            "<b>Problem:</b> " . e($ticket->title ?: '-'),
            "<b>Description:</b> " . e($ticket->description ?: '-'),
            "<b>Status:</b> " . e((string) $ticket->status),
            "<b>Priority:</b> " . e((string) $ticket->priority),
            "<b>Company:</b> " . e($company?->name ?: '-'),
            "<b>Device:</b> " . e($deviceLine),
            "<b>Location:</b> " . e($locationLine),
        ];

        if ($activity) {
            $lines[] = "";
            $lines[] = "<b>Update:</b> " . e($activity);
        }

        $lines[] = "";
        $lines[] = "<b>Link:</b> " . url('/problem-logs/' . $ticket->id);

        return implode("\n", $lines);
    }
}
