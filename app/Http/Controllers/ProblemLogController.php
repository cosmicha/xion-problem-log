<?php

namespace App\Http\Controllers;

use App\Models\ProblemLog;
use Illuminate\Http\Request;

class ProblemLogController extends Controller
{
    public function index()
    {
        $logs = ProblemLog::with(['company', 'assignedEngineer'])->latest()->get();
        return view('problem-logs.index', compact('logs'));
    }

    public function create()
    {
        return view('problem-logs.create');
    }

    public function store(Request $request)
    {
        $path = null;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
        }

        ProblemLog::create([
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $path,
            'status' => 'open',
            'priority' => $request->priority,
            'company_id' => auth()->user()->company_id,
            'ticket_number' => strtoupper(uniqid('TKT'))
        ]);

        return redirect('/problem-logs');
    }

    public function show(ProblemLog $problemLog)
    {
        $problemLog->load(['company', 'assignedEngineer']);
        return view('problem-logs.show', compact('problemLog'));
    }

    public function edit(ProblemLog $problemLog)
    {
        $problemLog->load(['company', 'assignedEngineer']);
        return view('problem-logs.edit', compact('problemLog'));
    }

    public function update(Request $request, ProblemLog $problemLog)
    {
        $data = $request->only(['title', 'description', 'status', 'priority']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $problemLog->update($data);

        return redirect('/problem-logs');
    }

    public function destroy(ProblemLog $problemLog)
    {
        $problemLog->delete();
        return back();
    }

    public function acknowledge(ProblemLog $problemLog)
    {
        $problemLog->update([
            'acknowledged_at' => now(),
            'status' => 'in_progress',
            'in_progress_at' => now(),
        ]);

        return back();
    }

    public function assignEngineer(Request $request, ProblemLog $problemLog)
    {
        $problemLog->update([
            'assigned_engineer_id' => $request->engineer_id
        ]);

        return back();
    }

    public function take(ProblemLog $problemLog)
    {
        $user = auth()->user();

        if ($user->role !== 'engineer') {
            abort(403);
        }

        if (!$problemLog->assigned_engineer_id) {
            $problemLog->update([
                'assigned_engineer_id' => $user->id,
                'acknowledged_at' => now(),
                'in_progress_at' => now(),
                'status' => 'in_progress'
            ]);
        }

        return back();
    }

    public function close(Request $request, ProblemLog $problemLog)
    {
        $path = null;

        if ($request->hasFile('closed_photo')) {
            $path = $request->file('closed_photo')->store('photos', 'public');
        }

        $problemLog->update([
            'status' => 'closed',
            'closed_at' => now(),
            'close_note' => $request->close_note,
            'closed_photo' => $path
        ]);

        return back();
    }

    public function export()
    {
        $logs = ProblemLog::with('company')->get();

        $filename = "report.csv";
        $handle = fopen($filename, 'w+');

        fputcsv($handle, [
            'Ticket',
            'Title',
            'Company',
            'Status',
            'Priority',
            'Created'
        ]);

        foreach ($logs as $log) {
            fputcsv($handle, [
                $log->ticket_number,
                $log->title,
                optional($log->company)->name ?? '-',
                $log->status,
                $log->priority,
                $log->created_at
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function engineerDashboard()
    {
        $user = auth()->user();

        if ($user->role !== 'engineer') {
            abort(403);
        }

        $assigned = ProblemLog::with('company')
            ->where('assigned_engineer_id', $user->id)
            ->latest()
            ->get();

        $unassigned = ProblemLog::with('company')
            ->whereNull('assigned_engineer_id')
            ->latest()
            ->get();

        return view('engineer.dashboard', compact('assigned', 'unassigned'));
    }
}
