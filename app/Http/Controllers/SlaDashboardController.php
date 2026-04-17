<?php

namespace App\Http\Controllers;

use App\Models\ProblemLog;

class SlaDashboardController extends Controller
{
    public function index()
    {
        $logs = ProblemLog::with(['company', 'assignedEngineer', 'createdByUser'])
            ->latest()
            ->get();

        $now = now();

        foreach ($logs as $log) {
            $company = method_exists($log, 'effectiveCompany') ? $log->effectiveCompany() : $log->company;

            $responseMinutes = (int) ($company->sla_response_minutes ?? 0);
            $resolutionMinutes = (int) ($company->sla_resolution_minutes ?? 0);

            // -----------------------------
            // RESPONSE SLA
            // -----------------------------
            $log->response_sla_state = 'na';
            $log->response_sla_label = 'N/A';
            $log->response_sla_sort = 99;

            if ($log->created_at && $responseMinutes > 0) {
                if ($log->acknowledged_at) {
                    $responseStatus = method_exists($log, 'responseSlaStatus')
                        ? $log->responseSlaStatus()
                        : null;

                    if ($responseStatus === 'breached') {
                        $log->response_sla_state = 'breach';
                        $log->response_sla_label = 'Breach';
                        $log->response_sla_sort = 1;
                    } elseif ($responseStatus === 'ok') {
                        $log->response_sla_state = 'ontime';
                        $log->response_sla_label = 'On Time';
                        $log->response_sla_sort = 3;
                    } else {
                        $log->response_sla_state = 'na';
                        $log->response_sla_label = 'N/A';
                        $log->response_sla_sort = 99;
                    }
                } else {
                    $elapsed = $log->created_at->diffInMinutes($now);
                    $remaining = $responseMinutes - $elapsed;

                    if ($remaining <= 0) {
                        $log->response_sla_state = 'breach';
                        $log->response_sla_label = 'Breach';
                        $log->response_sla_sort = 1;
                    } elseif ($remaining <= max(5, (int) floor($responseMinutes * 0.2))) {
                        $log->response_sla_state = 'warning';
                        $log->response_sla_label = $remaining . ' min';
                        $log->response_sla_sort = 2;
                    } else {
                        $log->response_sla_state = 'counting';
                        $log->response_sla_label = $remaining . ' min';
                        $log->response_sla_sort = 3;
                    }
                }
            }

            // -----------------------------
            // RESOLUTION SLA
            // -----------------------------
            $log->resolution_sla_state = 'na';
            $log->resolution_sla_label = 'N/A';
            $log->resolution_sla_sort = 99;

            if ($log->created_at && $resolutionMinutes > 0) {
                if ($log->closed_at) {
                    $resolutionStatus = method_exists($log, 'resolutionSlaStatus')
                        ? $log->resolutionSlaStatus()
                        : null;

                    if ($resolutionStatus === 'breached') {
                        $log->resolution_sla_state = 'breach';
                        $log->resolution_sla_label = 'Breach';
                        $log->resolution_sla_sort = 1;
                    } elseif ($resolutionStatus === 'ok') {
                        $log->resolution_sla_state = 'ontime';
                        $log->resolution_sla_label = 'On Time';
                        $log->resolution_sla_sort = 3;
                    } else {
                        $log->resolution_sla_state = 'na';
                        $log->resolution_sla_label = 'N/A';
                        $log->resolution_sla_sort = 99;
                    }
                } else {
                    $elapsed = $log->created_at->diffInMinutes($now);
                    $remaining = $resolutionMinutes - $elapsed;

                    if ($remaining <= 0) {
                        $log->resolution_sla_state = 'breach';
                        $log->resolution_sla_label = 'Breach';
                        $log->resolution_sla_sort = 1;
                    } elseif ($remaining <= max(5, (int) floor($resolutionMinutes * 0.2))) {
                        $log->resolution_sla_state = 'warning';
                        $log->resolution_sla_label = $remaining . ' min';
                        $log->resolution_sla_sort = 2;
                    } else {
                        $log->resolution_sla_state = 'counting';
                        $log->resolution_sla_label = $remaining . ' min';
                        $log->resolution_sla_sort = 3;
                    }
                }
            }

            // Summary / headline state for table row
            if ($log->resolution_sla_state === 'breach' || $log->response_sla_state === 'breach') {
                $log->sla_state = 'breach';
            } elseif ($log->resolution_sla_state === 'warning' || $log->response_sla_state === 'warning') {
                $log->sla_state = 'warning';
            } elseif (
                in_array($log->response_sla_state, ['counting', 'ontime'], true) ||
                in_array($log->resolution_sla_state, ['counting', 'ontime'], true)
            ) {
                $log->sla_state = 'safe';
            } else {
                $log->sla_state = 'na';
            }
        }

        $summary = [
            'safe' => $logs->where('sla_state', 'safe')->count(),
            'warning' => $logs->where('sla_state', 'warning')->count(),
            'breach' => $logs->where('sla_state', 'breach')->count(),
            'na' => $logs->where('sla_state', 'na')->count(),
            'total' => $logs->count(),
        ];

        return view('sla-dashboard.index', compact('logs', 'summary'));
    }
}
