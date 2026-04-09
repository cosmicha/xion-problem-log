<?php

namespace App\Http\Controllers;

use App\Exports\ProblemLogsExport;
use App\Models\ProblemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProblemLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ProblemLog::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', '%' . $search . '%')
                  ->orWhere('title', 'like', '%' . $search . '%');
            });
        }

        $logs = $query->latest()->get();

        return view('problem-logs.index', compact('logs'));
    }

    public function export()
    {
        return Excel::download(new ProblemLogsExport, 'problem_logs.xlsx');
    }

    public function create()
    {
        return view('problem-logs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('problem-photos');
        }

        $validated['opened_at'] = now();

        if ($validated['status'] === 'in_progress') {
            $validated['in_progress_at'] = now();
        }

        if ($validated['status'] === 'closed') {
            $validated['closed_at'] = now();
        }

        $priorityCode = strtoupper(substr($validated['priority'], 0, 1));
        $dateCode = now()->format('ymd');
        $random = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 4));
        $validated['ticket_number'] = 'CS-' . $dateCode . '-' . $priorityCode . '-' . $random;

        ProblemLog::create($validated);

        return redirect('/problem-logs')->with('success', 'Problem log created.');
    }

    public function show(ProblemLog $problemLog)
    {
        return view('problem-logs.show', compact('problemLog'));
    }

    public function edit(ProblemLog $problemLog)
    {
        return view('problem-logs.edit', compact('problemLog'));
    }

    public function update(Request $request, ProblemLog $problemLog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($problemLog->photo) {
                Storage::delete($problemLog->photo);
            }

            $validated['photo'] = $request->file('photo')->store('problem-photos');
        }

        if ($validated['status'] === 'in_progress' && !$problemLog->in_progress_at) {
            $validated['in_progress_at'] = now();
        }

        if ($validated['status'] === 'closed' && !$problemLog->closed_at) {
            $validated['closed_at'] = now();
        }

        if ($validated['status'] === 'open') {
            $validated['in_progress_at'] = null;
            $validated['closed_at'] = null;
        }

        if ($validated['status'] === 'in_progress') {
            $validated['closed_at'] = null;
        }

        $problemLog->update($validated);

        return redirect('/problem-logs')->with('success', 'Problem log updated.');
    }

    public function destroy(ProblemLog $problemLog)
    {
        if ($problemLog->photo) {
            Storage::delete($problemLog->photo);
        }

        if ($problemLog->closed_photo) {
            Storage::delete($problemLog->closed_photo);
        }

        $problemLog->delete();

        return redirect('/problem-logs')->with('success', 'Problem log deleted.');
    }

    public function acknowledge(Request $request, ProblemLog $problemLog)
    {
        $request->validate([
            'engineer_name' => 'required|string|max:255',
        ]);

        $problemLog->update([
            'engineer_name' => $request->engineer_name,
            'acknowledged_at' => now(),
            'in_progress_at' => now(),
            'status' => 'in_progress',
        ]);

        return redirect('/problem-logs/' . $problemLog->id)
            ->with('success', 'Acknowledged by ' . $request->engineer_name);
    }

    public function close(Request $request, ProblemLog $problemLog)
    {
        $validated = $request->validate([
            'close_note' => 'nullable|string',
            'closed_photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('closed_photo')) {
            $validated['closed_photo'] = $request->file('closed_photo')->store('problem-photos');
        }

        $validated['closed_at'] = now();
        $validated['status'] = 'closed';

        $problemLog->update($validated);

        return redirect('/problem-logs/' . $problemLog->id)
            ->with('success', 'Problem closed');
    }
}
