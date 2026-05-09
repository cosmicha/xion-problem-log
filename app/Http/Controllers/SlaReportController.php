<?php

namespace App\Http\Controllers;

use App\Models\ProblemLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SlaReportController extends Controller
{
    private function query(Request $request)
    {
        $query = ProblemLog::with(['company', 'device', 'vendor']);

        if ($request->filled('date_from')) $query->whereDate('created_at', '>=', $request->date_from);
        if ($request->filled('date_to')) $query->whereDate('created_at', '<=', $request->date_to);
        if ($request->filled('root_cause_category')) $query->where('root_cause_category', $request->root_cause_category);
        if ($request->filled('sla_responsibility')) $query->where('sla_responsibility', $request->sla_responsibility);
        if ($request->filled('cost_responsibility')) $query->where('cost_responsibility', $request->cost_responsibility);

        return $query;
    }

    public function index(Request $request)
    {
        $tickets = $this->query($request)->latest()->get();

        $kpis = [
            'total' => $tickets->count(),
            'included_sla' => $tickets->where('sla_excluded', false)->count(),
            'excluded_sla' => $tickets->where('sla_excluded', true)->count(),
            'customer_misuse' => $tickets->where('customer_misuse', true)->count(),
            'vendor_responsibility' => $tickets->where('sla_responsibility', 'vendor_responsibility')->count(),
            'sla_breached' => $tickets->filter(fn($t) => $t->response_sla_breached || $t->resolution_sla_breached)->count(),
        ];

        $rootCauseStats = $tickets->groupBy(fn($t) => $t->root_cause_category ?: 'unclassified')->map->count()->sortDesc();
        $slaStats = $tickets->groupBy(fn($t) => $t->sla_responsibility ?: 'unclassified')->map->count()->sortDesc();
        $costStats = $tickets->groupBy(fn($t) => $t->cost_responsibility ?: 'unclassified')->map->count()->sortDesc();

        return view('reports.sla', compact('tickets', 'kpis', 'rootCauseStats', 'slaStats', 'costStats'));
    }

    public function export(Request $request): StreamedResponse
    {
        $tickets = $this->query($request)->latest()->get();
        $filename = 'sla-rca-report-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($tickets) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Ticket Number','Title','Company','Device','Vendor','Status','Priority',
                'Root Cause','SLA Responsibility','SLA Excluded','Cost Responsibility',
                'Customer Misuse','Response Breach','Resolution Breach','Root Cause Note',
                'Preventive Action','Created At','Closed At'
            ]);

            foreach ($tickets as $t) {
                fputcsv($handle, [
                    $t->ticket_number,
                    $t->title,
                    optional($t->company)->name,
                    optional($t->device)->device_code . ' - ' . optional($t->device)->name,
                    optional($t->vendor)->name,
                    $t->status,
                    $t->priority,
                    $t->root_cause_category,
                    $t->sla_responsibility,
                    $t->sla_excluded ? 'Yes' : 'No',
                    $t->cost_responsibility,
                    $t->customer_misuse ? 'Yes' : 'No',
                    $t->response_sla_breached ? 'Yes' : 'No',
                    $t->resolution_sla_breached ? 'Yes' : 'No',
                    $t->root_cause_note,
                    $t->preventive_action,
                    optional($t->created_at)->format('Y-m-d H:i:s'),
                    $t->closed_at,
                ]);
            }

            fclose($handle);
        }, $filename);
    }
}
