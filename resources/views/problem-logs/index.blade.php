<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xion1 Problem Logs</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), transparent 30%),
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 30%),
                linear-gradient(180deg, #081120 0%, #0d1728 45%, #f4f7fb 45%, #f4f7fb 100%);
            color: #0f172a;
        }

        .page {
            max-width: 1380px;
            margin: 0 auto;
            padding: 36px 24px 60px;
        }

        .hero {
            color: white;
            padding: 28px 30px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(29, 78, 216, 0.88));
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.28);
            margin-bottom: 24px;
            border: 1px solid rgba(255,255,255,0.08);
            overflow: hidden;
            position: relative;
        }

        .hero::after {
            content: "";
            position: absolute;
            right: -60px;
            top: -60px;
            width: 220px;
            height: 220px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(34, 211, 238, 0.22), transparent 65%);
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.8);
            margin-bottom: 14px;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, #60a5fa, #22d3ee);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: #081120;
            box-shadow: 0 0 20px rgba(96,165,250,0.45);
            font-size: 15px;
        }

        .hero h1 {
            margin: 0 0 10px;
            font-size: 34px;
            line-height: 1.1;
        }

        .hero p {
            margin: 0;
            color: rgba(255,255,255,0.8);
            max-width: 760px;
            font-size: 15px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35);
        }

        .btn-primary:hover { transform: translateY(-1px); }

        .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.16);
            backdrop-filter: blur(8px);
        }

        .stats {
            margin-top: 22px;
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr 1fr 1fr;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .stat-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 18px;
            backdrop-filter: blur(8px);
        }

        .stat-card.featured {
            background: linear-gradient(135deg, rgba(255,255,255,0.12), rgba(255,255,255,0.07));
        }

        .stat-label {
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.7);
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 800;
            color: white;
        }

        .stat-sub {
            margin-top: 6px;
            color: rgba(255,255,255,0.72);
            font-size: 13px;
        }

        .summary-bar-wrap {
            margin-top: 14px;
        }

        .summary-bar {
            width: 100%;
            height: 12px;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(255,255,255,0.12);
            display: flex;
        }

        .seg-open { background: #ef4444; }
        .seg-progress { background: #f59e0b; }
        .seg-closed { background: #22c55e; }

        .summary-legend {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-top: 10px;
            font-size: 12px;
            color: rgba(255,255,255,0.8);
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
        }

        .content-card {
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 22px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 20px;
        }

        .toolbar-title {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .select {
            padding: 11px 14px;
            min-width: 180px;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: white;
            font-size: 14px;
            color: #0f172a;
            outline: none;
        }

        .success {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            background: #ecfdf5;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-weight: 600;
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        th {
            background: #eff6ff;
            color: #1e3a8a;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            text-align: left;
            padding: 16px 14px;
            border-bottom: 1px solid #dbeafe;
        }

        td {
            padding: 16px 14px;
            border-bottom: 1px solid #eef2f7;
            vertical-align: middle;
            font-size: 14px;
        }

        tr:hover td {
            background: #f8fbff;
        }

        .log-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .log-sub {
            color: #64748b;
            font-size: 12px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .badge-open {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-progress {
            background: #fef3c7;
            color: #b45309;
        }

        .badge-closed {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-low {
            background: #e5e7eb;
            color: #374151;
        }

        .badge-medium {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-high {
            background: #fee2e2;
            color: #b91c1c;
        }

        .thumb {
            width: 62px;
            height: 62px;
            object-fit: cover;
            border-radius: 14px;
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.12);
            border: 1px solid #e2e8f0;
        }

        .thumb-placeholder {
            width: 62px;
            height: 62px;
            border-radius: 14px;
            background: #f1f5f9;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            border: 1px dashed #cbd5e1;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .btn-small {
            padding: 9px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid #dbeafe;
            background: #eff6ff;
            color: #1d4ed8;
        }

        .btn-delete {
            padding: 9px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #dc2626;
            cursor: pointer;
        }

        .inline-form {
            display: inline;
        }

        @media (max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .hero h1 {
                font-size: 28px;
            }
        }

        @media (max-width: 640px) {
            .page {
                padding: 18px 14px 40px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .content-card,
            .hero {
                border-radius: 18px;
            }
        }
    </style>
</head>
<body>
    @php
        use Illuminate\Support\Facades\Storage;

        $totalLogs = $logs->count();
        $openCount = $logs->where('status', 'open')->count();
        $progressCount = $logs->where('status', 'in_progress')->count();
        $closedCount = $logs->where('status', 'closed')->count();

        $barTotal = max($totalLogs, 1);
        $openWidth = ($openCount / $barTotal) * 100;
        $progressWidth = ($progressCount / $barTotal) * 100;
        $closedWidth = ($closedCount / $barTotal) * 100;
    @endphp

    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">X1</span>
                        Xion1 Operations Console
                    </div>
                    <h1>Problem Log Dashboard</h1>
                    <p>
                        Modern incident tracking for operational teams, engineer ownership, visual evidence, and closure accountability.
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs/create" class="btn btn-primary">+ Add New Log</a>
                    <a href="/problem-logs" class="btn btn-secondary">Refresh List</a>
                </div>
            </div>

            <div class="stats">
                <div class="stat-card featured">
                    <div class="stat-label">Operational Snapshot</div>
                    <div class="stat-value">{{ $totalLogs }}</div>
                    <div class="stat-sub">Total incidents tracked in this view</div>

                    <div class="summary-bar-wrap">
                        <div class="summary-bar">
                            <div class="seg-open" style="width: {{ $openWidth }}%;"></div>
                            <div class="seg-progress" style="width: {{ $progressWidth }}%;"></div>
                            <div class="seg-closed" style="width: {{ $closedWidth }}%;"></div>
                        </div>

                        <div class="summary-legend">
                            <span class="legend-item"><span class="legend-dot seg-open"></span> Open</span>
                            <span class="legend-item"><span class="legend-dot seg-progress"></span> In Progress</span>
                            <span class="legend-item"><span class="legend-dot seg-closed"></span> Closed</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Open</div>
                    <div class="stat-value">{{ $openCount }}</div>
                    <div class="stat-sub">Need attention</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">In Progress</div>
                    <div class="stat-value">{{ $progressCount }}</div>
                    <div class="stat-sub">Engineer assigned</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Closed</div>
                    <div class="stat-value">{{ $closedCount }}</div>
                    <div class="stat-sub">Resolved issues</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Closure Rate</div>
                    <div class="stat-value">
                        {{ $totalLogs > 0 ? round(($closedCount / $totalLogs) * 100) : 0 }}%
                    </div>
                    <div class="stat-sub">Based on current logs</div>
                </div>
            </div>
        </div>

        <div class="content-card">
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif

            <div class="toolbar">
                <div>
                    <div class="toolbar-title">Incident List</div>
                    <div class="muted">Track issue lifecycle from open to close.</div>
                </div>

                <form method="GET" action="/problem-logs" class="filter-form">
                    <select name="status" class="select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>

                    <noscript>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </noscript>
                </form>
            </div>

            <div class="table-wrap">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Incident</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Engineer</th>
                        <th>Closed At</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>

                    @foreach($logs as $log)
                        <tr>
                            <td>#{{ $log->id }}</td>

                            <td>
                                <div class="log-title">{{ $log->title }}</div>
                                <div class="log-sub">
                                    {{ \Illuminate\Support\Str::limit($log->description, 55) ?: 'No description' }}
                                </div>
                            </td>

                            <td>{{ $log->created_at ? $log->created_at->format('d M Y H:i') : '-' }}</td>

                            <td>
                                @if($log->status === 'open')
                                    <span class="badge badge-open">Open</span>
                                @elseif($log->status === 'in_progress')
                                    <span class="badge badge-progress">In Progress</span>
                                @else
                                    <span class="badge badge-closed">Closed</span>
                                @endif
                            </td>

                            <td>
                                @if($log->priority === 'high')
                                    <span class="badge badge-high">High</span>
                                @elseif($log->priority === 'medium')
                                    <span class="badge badge-medium">Medium</span>
                                @else
                                    <span class="badge badge-low">Low</span>
                                @endif
                            </td>

                            <td>{{ $log->engineer_name ?: '-' }}</td>
                            <td>{{ $log->closed_at ? $log->closed_at->format('d M Y H:i') : '-' }}</td>

                            <td>
                                @if($log->photo)
                                    <img src="{{ Storage::url($log->photo) }}" class="thumb" alt="Problem Photo">
                                @else
                                    <div class="thumb-placeholder">No Img</div>
                                @endif
                            </td>

                            <td>
                                <div class="actions">
                                    <a href="/problem-logs/{{ $log->id }}" class="btn-small">View</a>
                                    <a href="/problem-logs/{{ $log->id }}/edit" class="btn-small">Edit</a>

                                    <form action="/problem-logs/{{ $log->id }}" method="POST" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('Delete this log?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</body>
</html>
