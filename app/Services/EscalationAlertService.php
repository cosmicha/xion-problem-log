<?php

namespace App\Services;

use App\Mail\TicketUpdateMail;
use App\Models\Company;
use App\Models\ProblemLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EscalationAlertService
{
    public function __construct(
        private TelegramAlertService $telegramAlertService
    ) {}

    public function sendForEvent(ProblemLog $problemLog, string $eventType): void
    {
        $problemLog->loadMissing(['company', 'device', 'createdByUser', 'assignedEngineer']);

        $company = $problemLog->company;

        if (!$company) {
            return;
        }

        [$emails, $chatIds, $title, $message] = $this->resolveRecipientsAndMessage($company, $eventType);

        if ($emails) {
            try {
                Mail::to($emails)->send(new TicketUpdateMail($problemLog, $title, $message));
            } catch (\Throwable $e) {
                Log::error('Escalation email failed', [
                    'event_type' => $eventType,
                    'problem_log_id' => $problemLog->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        if ($chatIds) {
            $telegramMessage = $this->buildTelegramMessage($problemLog, $title, $message, $eventType);
            $this->telegramAlertService->send($chatIds, $telegramMessage);
        }
    }

    private function resolveRecipientsAndMessage(Company $company, string $eventType): array
    {
        return match ($eventType) {
            'response_breach' => [
                $this->splitList($company->alert_spv_emails),
                $this->splitList($company->alert_spv_telegram_chat_ids),
                'Response SLA Breach',
                'A ticket has breached response SLA and needs supervisor attention.',
            ],

            'resolution_breach' => [
                $this->splitList($company->alert_manager_emails),
                $this->splitList($company->alert_manager_telegram_chat_ids),
                'Resolution SLA Breach',
                'A ticket has breached resolution SLA and needs manager escalation.',
            ],

            'create' => [
                $this->splitList($company->alert_admin_emails),
                $this->splitList($company->alert_admin_telegram_chat_ids),
                'Ticket Created',
                'A new ticket has been created.',
            ],

            'update' => [
                $this->splitList($company->alert_admin_emails),
                $this->splitList($company->alert_admin_telegram_chat_ids),
                'Ticket Updated',
                'A ticket has received a progress update.',
            ],

            'close' => [
                $this->splitList($company->alert_admin_emails),
                $this->splitList($company->alert_admin_telegram_chat_ids),
                'Ticket Closed',
                'A ticket has been resolved and closed.',
            ],

            default => [[], [], 'Ticket Alert', 'A ticket alert has been triggered.'],
        };
    }

    private function buildTelegramMessage(ProblemLog $ticket, string $title, string $message, string $eventType): string
    {
        $device = $ticket->device;
        $company = $ticket->company;

        $deviceLine = $device
            ? trim(($device->device_code ?: '-') . ' — ' . ($device->name ?: '-') . ' (' . ucfirst($device->category ?: 'Device') . ')')
            : '-';

        $locationLine = $device
            ? implode(' / ', array_filter([$device->site, $device->location])) ?: '-'
            : '-';

        $slaLine = match ($eventType) {
            'response_breach' => $ticket->response_due_at
                ? 'Response due at: ' . $ticket->response_due_at->format('d M Y H:i')
                : 'Response due at: -',

            'resolution_breach' => $ticket->resolution_due_at
                ? 'Resolution due at: ' . $ticket->resolution_due_at->format('d M Y H:i')
                : 'Resolution due at: -',

            default => null,
        };

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

        if ($slaLine) {
            $lines[] = "";
            $lines[] = "<b>SLA:</b> " . e($slaLine);
        }

        $lines[] = "";
        $lines[] = "<b>Link:</b> " . url('/problem-logs/' . $ticket->id);

        return implode("\n", $lines);
    }

    private function splitList(?string $raw): array
    {
        if (!$raw) {
            return [];
        }

        $parts = preg_split('/[,\n\r]+/', $raw) ?: [];

        return array_values(array_unique(array_filter(array_map('trim', $parts))));
    }
}
