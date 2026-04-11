<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Engineer Dashboard</title>

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
            padding: 16px 16px 60px;
        }

        .hero {
            color: white;
            padding: 28px 30px 36px;
            border-radius: 28px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(29, 78, 216, 0.88));
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.28);
            margin-bottom: 28px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.82);
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
            margin: 0 0 8px;
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
            border-radius: 16px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background: rgba(255,255,255,0.10);
            color: white;
            border: 1px solid rgba(255,255,255,0.16);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .stats {
            margin-top: 22px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .stat-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 22px 24px;
            backdrop-filter: blur(8px);
            min-height: 140px;
        }

        .stat-label {
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.74);
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 800;
            color: white;
            margin-bottom: 6px;
        }

        .stat-sub {
            color: rgba(255,255,255,0.76);
            font-size: 13px;
        }

        .content-card {
            background: rgba(255,255,255,0.90);
            border-radius: 28px;
            padding: 28px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
            margin-bottom: 24px;
        }

        .toolbar-title {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: 24px;
            border: 1px solid #dbe3ef;
            background: white;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        th {
            background: #edf3fb;
            color: #24408e;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            text-align: left;
            padding: 18px;
            border-bottom: 1px solid #d9e4f3;
        }

        td {
            padding: 18px;
            border-bottom: 1px solid #edf2f7;
            vertical-align: middle;
            font-size: 14px;
            color: #0f172a;
        }

        .ticket-chip {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 14px;
            background: #dbe7fb;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 800;
        }

        .log-title {
            font-weight: 800;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .log-sub {
            color: #64748b;
            font-size: 12px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .badge-open { background: #fee2e2; color: #b91c1c; }
        .badge-progress { background: #fef3c7; color: #b45309; }
        .badge-closed { background: #dcfce7; color: #15803d; }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-small {
            padding: 10px 14px;
            border-radius: 14px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-view {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
        }

        .btn-take {
            background: #2563eb;
            color: white;
        }

        .empty-box {
            padding: 24px;
            border-radius: 18px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
            color: #64748b;
            font-weight: 600;
            margin-top: 20px;
        }

        @media (max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .page {
                padding: 14px 14px 40px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .content-card,
            .hero {
                border-radius: 20px;
            }
        }
    </style>
</head>
<body>
    @php
        $assignedCount = $assigned->count();
        $availableCount = $available->count();
        $myOpenCount = $assigned->where('status', 'open')->count();
        $myProgressCount = $assigned->where('status', 'in_progress')->count();
    @endphp

    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">EN</span>
                        ENGINEER WORKSPACE
                    </div>
                    <h1>Engineer Dashboard</h1>
                    <p>See tickets assigned to you and open tickets that have not been acknowledged yet.</p>
                    <p style="margin-top:10px;">
                        <strong>{{ auth()->user()->name }}</strong>
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">All Tickets</a>
                    <form method="POST" action="/logout" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>

            <div class="stats">
                <div class="stat-card">
                    <div class="stat-label">Assigned to You</div>
                    <div class="stat-value">{{ $assignedCount }}</div>
                    <div class="stat-sub">Current workload</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Available Open</div>
                    <div class="stat-value">{{ $availableCount }}</div>
                    <div class="stat-sub">Open and not acknowledged</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">My Open</div>
                    <div class="stat-value">{{ $myOpenCount }}</div>
                    <div class="stat-sub">Assigned but not started</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">My In Progress</div>
                    <div class="stat-value">{{ $myProgressCount }}</div>
                    <div class="stat-sub">Already acknowledged</div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="toolbar-title">Assigned To You</div>
            <div class="muted">Tickets currently assigned under your name.</div>

            @if($assignedCount > 0)
                <div class="table-wrap">
                    <table>
                        <tr>
                            <th>Ticket</th>
                            <th>Incident</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>

                        @foreach($assigned as $log)
                            <tr>
                                <td><span class="ticket-chip">{{ $log->ticket_number ?: '-' }}</span></td>
                                <td>
                                    <div class="log-title">{{ $log->title }}</div>
                                    <div class="log-sub">{{ \Illuminate\Support\Str::limit($log->description, 60) }}</div>
                                </td>
                                <td>{{ optional($log->company)->name ?? '-' }}</td>
                                <td>
                                    @if($log->status === 'open')
                                        <span class="badge badge-open">Open</span>
                                    @elseif($log->status === 'in_progress')
                                        <span class="badge badge-progress">In Progress</span>
                                    @else
                                        <span class="badge badge-closed">Closed</span>
                                    @endif
                                </td>
                                <td>{{ $log->created_at ? $log->created_at->format('d M Y H:i') : '-' }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="/problem-logs/{{ $log->id }}" class="btn-small btn-view">View</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @else
                <div class="empty-box">No assigned tickets.</div>
            @endif
        </div>

        <div class="content-card">
            <div class="toolbar-title">Open Tickets Not Yet Acknowledged</div>
            <div class="muted">These can still be taken and acknowledged by an engineer.</div>

            @if($availableCount > 0)
                <div class="table-wrap">
                    <table>
                        <tr>
                            <th>Ticket</th>
                            <th>Incident</th>
                            <th>Company</th>
                            <th>Assigned</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>

                        @foreach($available as $log)
                            <tr>
                                <td><span class="ticket-chip">{{ $log->ticket_number ?: '-' }}</span></td>
                                <td>
                                    <div class="log-title">{{ $log->title }}</div>
                                    <div class="log-sub">{{ \Illuminate\Support\Str::limit($log->description, 60) }}</div>
                                </td>
                                <td>{{ optional($log->company)->name ?? '-' }}</td>
                                <td>{{ optional($log->assignedEngineer)->name ?? '-' }}</td>
                                <td><span class="badge badge-open">Open</span></td>
                                <td>{{ $log->created_at ? $log->created_at->format('d M Y H:i') : '-' }}</td>
                                <td>
                                    <div class="actions">
                                        <form method="POST" action="/problem-logs/{{ $log->id }}/take" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-small btn-take">Take Ticket</button>
                                        </form>

                                        <a href="/problem-logs/{{ $log->id }}" class="btn-small btn-view">View</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @else
                <div class="empty-box">No open unacknowledged tickets.</div>
            @endif
        </div>
    </div>
</body>
</html>
