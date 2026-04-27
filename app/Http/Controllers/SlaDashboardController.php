<?php

namespace App\Http\Controllers;

use App\Models\ProblemLog;

class SlaDashboardController extends Controller
{
    public function index()
    {
        $now = now();

        $tickets = ProblemLog::with(['company', 'device', 'assignedEngineer'])
            ->where('status', '!=', 'closed')
            ->orderByRaw('COALESCE(resolution_due_at, response_due_at) ASC')
            ->get();

        $stats = [
            'open' => $tickets->count(),
            'near_breach' => $tickets->filter(fn ($t) =>
                $t->resolution_due_at &&
                $t->resolution_due_at->between($now, $now->copy()->addMinutes(60))
            )->count(),
            'response_breached' => $tickets->filter(fn ($t) =>
                $t->response_due_at &&
                $t->response_due_at->lt($now)
            )->count(),
            'resolution_breached' => $tickets->filter(fn ($t) =>
                $t->resolution_due_at &&
                $t->resolution_due_at->lt($now)
            )->count(),
        ];

        return view('sla.dashboard', compact('tickets', 'stats', 'now'));
    }
}
