<!DOCTYPE html>
<html>
<head>
    <title>SLA Dashboard</title>
    <meta http-equiv="refresh" content="30">
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), transparent 30%),
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 30%),
                linear-gradient(180deg, #081120 0%, #0d1728 42%, #f4f7fb 42%, #f4f7fb 100%);
            color: #0f172a;
            margin: 0;
            padding: 20px;
        }

        .page {
            max-width: 1500px;
            margin: 0 auto;
        }

        .hero {
            color: white;
            padding: 26px 28px 30px;
            border-radius: 28px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(29, 78, 216, 0.88));
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.28);
            margin-bottom: 24px;
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
            width: 40px;
            height: 40px;
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

        .hero h2 {
            margin: 0 0 8px;
            font-size: 32px;
            line-height: 1.1;
        }

        .hero p {
            margin: 0;
            color: rgba(255,255,255,0.82);
            font-size: 15px;
            line-height: 1.6;
            max-width: 760px;
        }

        .hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 14px;
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

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .summary-card {
            padding: 18px;
            border-radius: 20px;
            text-align: left;
            font-weight: 700;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .summary-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 8px;
            opacity: .88;
        }

        .summary-value {
            font-size: 30px;
            font-weight: 900;
        }

        .safe { background: rgba(22,163,74,.22); color: white; }
        .warning { background: rgba(245,158,11,.22); color: white; }
        .breach { background: rgba(220,38,38,.22); color: white; }
        .na { background: rgba(148,163,184,.22); color: white; }
        .total { background: rgba(59,130,246,.22); color: white; }

        .card {
            background: rgba(255,255,255,0.94);
            padding: 22px;
            border-radius: 24px;
            margin-top: 24px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .card-title {
            margin: 0 0 8px;
            font-size: 22px;
            font-weight: 800;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 16px;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .live-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 999px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
            color: #1e3a8a;
            font-size: 13px;
            font-weight: 800;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1180px;
        }

        th, td {
            padding: 12px 14px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            vertical-align: middle;
        }

        th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
            background: #f8fafc;
        }

        .row-link {
            cursor: pointer;
            transition: background-color .15s ease;
        }

        .row-link:hover {
            background: rgba(59,130,246,0.08);
        }

        .row-safe { background: rgba(22,163,74,0.12); }
        .row-warning { background: rgba(245,158,11,0.12); }
        .row-breach { background: rgba(220,38,38,0.12); }
        .row-na { background: rgba(148,163,184,0.10); }

        .pill {
            display: inline-flex;
            align-items: center;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .pill-safe { background: #dcfce7; color: #15803d; }
        .pill-warning { background: #fef3c7; color: #b45309; }
        .pill-breach { background: #fee2e2; color: #b91c1c; }
        .pill-na { background: #e5e7eb; color: #374151; }

        .status {
            font-weight: 700;
            color: #0f172a;
        }

        @media (max-width: 1100px) {
            .summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .summary {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">SLA</span>
                        GLOBAL MONITORING
                    </div>
                    <h2>SLA Dashboard</h2>
                    <p>Real-time operational visibility for all tickets, with correct final SLA states after acknowledge and close events.</p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Back to Dashboard</a>
                    <a href="/problem-logs/export" class="btn btn-primary">Export</a>
                </div>
            </div>

            <div class="summary">
                <div class="summary-card total">
                    <div class="summary-label">Total</div>
                    <div class="summary-value">{{ $summary['total'] }}</div>
                </div>
                <div class="summary-card safe">
                    <div class="summary-label">Safe</div>
                    <div class="summary-value">{{ $summary['safe'] }}</div>
                </div>
                <div class="summary-card warning">
                    <div class="summary-label">Warning</div>
                    <div class="summary-value">{{ $summary['warning'] }}</div>
                </div>
                <div class="summary-card breach">
                    <div class="summary-label">Breach</div>
                    <div class="summary-value">{{ $summary['breach'] }}</div>
                </div>
                <div class="summary-card na">
                    <div class="summary-label">No SLA</div>
                    <div class="summary-value">{{ $summary['na'] }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="toolbar">
                <div>
                    <div class="card-title">Live SLA Ticket Board</div>
                    <div class="muted">Response SLA stops after acknowledge. Resolution SLA stops after close. Rows are clickable.</div>
                </div>
                <div class="live-chip" id="liveRefreshText">Auto refresh: 30s</div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Engineer</th>
                            <th>Status</th>
                            <th>Response SLA</th>
                            <th>Resolution SLA</th>
                            <th>Overall</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr class="row-link row-{{ $log->sla_state }}" onclick="window.location='/problem-logs/{{ $log->id }}'">
                            <td>{{ $log->ticket_number ?: ('TICKET-' . $log->id) }}</td>
                            <td>{{ $log->title }}</td>
                            <td>{{ $log->company->name ?? '-' }}</td>
                            <td>{{ optional($log->assignedEngineer)->name ?? $log->engineer_name ?? '-' }}</td>
                            <td class="status">{{ ucfirst(str_replace('_', ' ', $log->status ?? '-')) }}</td>

                            <td>
                                @if($log->response_sla_state === 'breach')
                                    <span class="pill pill-breach">Breach</span>
                                @elseif($log->response_sla_state === 'warning')
                                    <span class="pill pill-warning">{{ $log->response_sla_label }}</span>
                                @elseif($log->response_sla_state === 'counting')
                                    <span class="pill pill-safe">{{ $log->response_sla_label }}</span>
                                @elseif($log->response_sla_state === 'ontime')
                                    <span class="pill pill-safe">On Time</span>
                                @else
                                    <span class="pill pill-na">N/A</span>
                                @endif
                            </td>

                            <td>
                                @if($log->resolution_sla_state === 'breach')
                                    <span class="pill pill-breach">Breach</span>
                                @elseif($log->resolution_sla_state === 'warning')
                                    <span class="pill pill-warning">{{ $log->resolution_sla_label }}</span>
                                @elseif($log->resolution_sla_state === 'counting')
                                    <span class="pill pill-safe">{{ $log->resolution_sla_label }}</span>
                                @elseif($log->resolution_sla_state === 'ontime')
                                    <span class="pill pill-safe">On Time</span>
                                @else
                                    <span class="pill pill-na">N/A</span>
                                @endif
                            </td>

                            <td>
                                @if($log->sla_state === 'breach')
                                    <span class="pill pill-breach">Breach</span>
                                @elseif($log->sla_state === 'warning')
                                    <span class="pill pill-warning">Warning</span>
                                @elseif($log->sla_state === 'safe')
                                    <span class="pill pill-safe">Safe</span>
                                @else
                                    <span class="pill pill-na">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let countdown = 30;
        const chip = document.getElementById('liveRefreshText');

        setInterval(() => {
            countdown--;
            if (countdown <= 0) {
                chip.textContent = 'Refreshing...';
                window.location.reload();
                return;
            }
            chip.textContent = `Auto refresh: ${countdown}s`;
        }, 1000);
    </script>
</body>
</html>
