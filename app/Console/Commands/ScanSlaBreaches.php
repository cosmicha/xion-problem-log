<?php

namespace App\Console\Commands;

use App\Models\ProblemLog;
use App\Services\EscalationAlertService;
use Illuminate\Console\Command;

class ScanSlaBreaches extends Command
{
    protected $signature = 'alerts:scan-sla';
    protected $description = 'Scan tickets for SLA breaches and send escalation alerts';

    public function handle(EscalationAlertService $alerts): int
    {
        $now = now();

        $responseBreaches = ProblemLog::with(['company', 'device'])
            ->where('status', '!=', 'closed')
            ->whereNotNull('response_due_at')
            ->whereNull('response_sla_alert_sent_at')
            ->where('response_due_at', '<', $now)
            ->get();

        foreach ($responseBreaches as $ticket) {
            $ticket->forceFill([
                'response_sla_breached' => true,
                'response_sla_alert_sent_at' => now(),
            ])->save();

            $alerts->sendForEvent($ticket, 'response_breach');
        }

        $resolutionBreaches = ProblemLog::with(['company', 'device'])
            ->where('status', '!=', 'closed')
            ->whereNotNull('resolution_due_at')
            ->whereNull('resolution_sla_alert_sent_at')
            ->where('resolution_due_at', '<', $now)
            ->get();

        foreach ($resolutionBreaches as $ticket) {
            $ticket->forceFill([
                'resolution_sla_breached' => true,
                'resolution_sla_alert_sent_at' => now(),
            ])->save();

            $alerts->sendForEvent($ticket, 'resolution_breach');
        }

        $this->info('SLA breach scan complete.');
        $this->info('Response breaches alerted: ' . $responseBreaches->count());
        $this->info('Resolution breaches alerted: ' . $resolutionBreaches->count());

        return self::SUCCESS;
    }
}
