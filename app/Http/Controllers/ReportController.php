<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\ProblemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function deviceHealth(Request $request)
    {
        $companyId = $request->input('company_id');
        $status = $request->input('status');
        $category = $request->input('category');

        $devicesQuery = Device::with(['company'])
            ->withCount([
                'problemLogs as total_tickets',
                'problemLogs as open_tickets' => fn ($q) => $q->where('status', '!=', 'closed'),
                'problemLogs as closed_tickets' => fn ($q) => $q->where('status', 'closed'),
            ]);

        if ($companyId) {
            $devicesQuery->where('company_id', $companyId);
        }

        if ($category) {
            $devicesQuery->where('category', $category);
        }

        if ($status) {
            $devicesQuery->where('status', $status);
        }

        $devices = $devicesQuery->get()->map(function ($device) {
            $lastIssue = ProblemLog::where('device_id', $device->id)->latest()->first();

            $topIssues = ProblemLog::where('device_id', $device->id)
                ->select('issue_category', DB::raw('COUNT(*) as total'))
                ->groupBy('issue_category')
                ->orderByDesc('total')
                ->limit(3)
                ->get()
                ->map(fn ($row) => [
                    'category' => $row->issue_category ?: 'Uncategorized',
                    'total' => $row->total,
                ]);

            $score = (int) $device->total_tickets;
            $open = (int) $device->open_tickets;

            $health = 'GOOD';
            if ($score >= 10 || $open >= 3) {
                $health = 'CRITICAL';
            } elseif ($score >= 5 || $open >= 1) {
                $health = 'WATCH';
            } elseif ($score === 0) {
                $health = 'EXCELLENT';
            }

            $device->last_issue_title = $lastIssue?->title;
            $device->last_issue_at = $lastIssue?->created_at;
            $device->top_issues = $topIssues;
            $device->health_status = $health;

            return $device;
        })->sortByDesc('total_tickets')->values();

        $stats = [
            'total_devices' => $devices->count(),
            'never_reported' => $devices->where('total_tickets', 0)->count(),
            'critical' => $devices->where('health_status', 'CRITICAL')->count(),
            'watch' => $devices->where('health_status', 'WATCH')->count(),
        ];

        $companies = \App\Models\Company::orderBy('name')->get();
        $categories = Device::query()->select('category')->distinct()->pluck('category')->filter()->values();
        $statuses = Device::query()->select('status')->distinct()->pluck('status')->filter()->values();

        return view('reports.device-health', compact('devices', 'stats', 'companies', 'categories', 'statuses'));
    }
}
