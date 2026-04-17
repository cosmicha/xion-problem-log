<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), transparent 30%),
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 30%),
                linear-gradient(180deg, #081120 0%, #0d1728 42%, #f4f7fb 42%, #f4f7fb 100%);
            color: #0f172a;
        }
        .page { max-width: 1550px; margin: 0 auto; padding: 16px 16px 60px; }
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
        .hero h1 { margin: 0 0 8px; font-size: 34px; line-height: 1.1; }
        .hero p { margin: 0; color: rgba(255,255,255,0.8); max-width: 760px; font-size: 15px; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
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

        .grid-4, .grid-3, .grid-2 {
            display: grid;
            gap: 16px;
            margin-bottom: 24px;
        }
        .grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }

        .card {
            background: rgba(255,255,255,0.92);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .stat-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            margin-bottom: 10px;
            font-weight: 800;
        }
        .stat-value {
            font-size: 34px;
            font-weight: 900;
            color: #0f172a;
        }
        .stat-sub {
            margin-top: 6px;
            color: #64748b;
            font-size: 14px;
        }
        .danger .stat-value { color: #b91c1c; }
        .warning .stat-value { color: #b45309; }
        .success .stat-value { color: #15803d; }

        .section-title {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 8px;
        }
        .muted {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .list {
            display: grid;
            gap: 12px;
        }
        .list-item {
            padding: 14px 16px;
            border-radius: 16px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
        }
        .list-top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            margin-bottom: 10px;
        }
        .list-name {
            font-weight: 700;
            color: #0f172a;
        }
        .list-count {
            padding: 8px 12px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 800;
            font-size: 13px;
        }

        .bar-wrap {
            width: 100%;
            height: 10px;
            border-radius: 999px;
            background: #e5e7eb;
            overflow: hidden;
        }
        .bar {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }
        .bar-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        .bar-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        .bar-success {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }

        .ticket {
            padding: 16px;
            border-radius: 18px;
            background: #fff7ed;
            border: 1px solid #fed7aa;
        }
        .ticket-title {
            font-weight: 800;
            margin-bottom: 6px;
            color: #9a3412;
        }
        .ticket-meta {
            font-size: 13px;
            color: #7c2d12;
            line-height: 1.7;
        }

        .mini-chart {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            align-items: end;
            gap: 10px;
            min-height: 180px;
            padding-top: 10px;
        }
        .mini-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        .mini-bar-wrap {
            width: 100%;
            height: 140px;
            display: flex;
            align-items: end;
        }
        .mini-bar {
            width: 100%;
            border-radius: 12px 12px 0 0;
            min-height: 8px;
        }
        .mini-label {
            font-size: 12px;
            color: #64748b;
            text-align: center;
        }
        .mini-value {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
        }

        @media (max-width: 1100px) {
            .grid-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .grid-3, .grid-2 { grid-template-columns: 1fr; }
        }
        @media (max-width: 640px) {
            .grid-4 { grid-template-columns: 1fr; }
            .page { padding: 14px 14px 40px; }
            .hero, .card { border-radius: 20px; }
            .mini-chart { gap: 6px; }
        }
    </style>
</head>
<body>
    @php
        $maxCompany = max(1, $byCompany->max('count') ?? 1);
        $maxEngineer = max(1, $byEngineer->max('count') ?? 1);
        $maxBreachCompany = max(1, $topBreachedCompanies->max('count') ?? 1);
        $maxTopEngineer = max(1, $topEngineers->max('count') ?? 1);
        $maxAging = max(1, max($agingBuckets));
        $maxMonthlyTickets = max(1, $monthlyTickets->max() ?? 1);
        $maxMonthlyClosed = max(1, $monthlyClosed->max() ?? 1);
        $maxMonthlyBreaches = max(1, $monthlyBreaches->max() ?? 1);
        $maxIssueCategory = max(1, $topIssueCategories->max() ?? 1);
    @endphp

    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">AN</span>
                        ANALYTICS DASHBOARD
                    </div>
                    <h1>Executive Operations Analytics</h1>
                    <p>Board-level visibility into ticket volume, SLA risk, aging backlog, engineer workload, monthly movement, and critical operational priorities.</p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>

        <div class="grid-4">
            <div class="card">
                <div class="stat-label">Total Tickets</div>
                <div class="stat-value">{{ $total }}</div>
                <div class="stat-sub">All recorded incidents</div>
            </div>

            <div class="card">
                <div class="stat-label">Open</div>
                <div class="stat-value">{{ $open }}</div>
                <div class="stat-sub">Waiting for action</div>
            </div>

            <div class="card">
                <div class="stat-label">In Progress</div>
                <div class="stat-value">{{ $progress }}</div>
                <div class="stat-sub">Currently being handled</div>
            </div>

            <div class="card success">
                <div class="stat-label">Closure Rate</div>
                <div class="stat-value">{{ $closureRate }}%</div>
                <div class="stat-sub">Closed vs total tickets</div>
            </div>
        </div>

        <div class="grid-3">
            <div class="card danger">
                <div class="stat-label">Response SLA Breached</div>
                <div class="stat-value">{{ $responseBreached }}</div>
                <div class="stat-sub">Exceeded response target</div>
            </div>

            <div class="card danger">
                <div class="stat-label">Resolution SLA Breached</div>
                <div class="stat-value">{{ $resolutionBreached }}</div>
                <div class="stat-sub">Exceeded resolution target</div>
            </div>

            <div class="card warning">
                <div class="stat-label">Overdue Now</div>
                <div class="stat-value">{{ $overdueNow }}</div>
                <div class="stat-sub">Active tickets already overdue</div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="stat-label">Average Response Time</div>
                <div class="stat-value">{{ round(($avgResponse ?? 0) / 60, 1) }} min</div>
                <div class="stat-sub">Average time to acknowledge or start handling</div>
            </div>

            <div class="card">
                <div class="stat-label">Average Resolution Time</div>
                <div class="stat-value">{{ round(($avgResolution ?? 0) / 60, 1) }} min</div>
                <div class="stat-sub">Average time from in progress to closed</div>
            </div>
        </div>

        <div class="grid-3">
            <div class="card">
                <div class="section-title">Monthly Ticket Trend</div>
                <div class="muted">New tickets created in the last 6 months.</div>
                <div class="mini-chart">
                    @foreach($monthlyTickets as $month => $count)
                        <div class="mini-col">
                            <div class="mini-value">{{ $count }}</div>
                            <div class="mini-bar-wrap">
                                <div class="mini-bar" style="height: {{ ($count / $maxMonthlyTickets) * 100 }}%; background: linear-gradient(135deg, #3b82f6, #2563eb);"></div>
                            </div>
                            <div class="mini-label">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M y') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Monthly Closure Trend</div>
                <div class="muted">Tickets closed in the last 6 months.</div>
                <div class="mini-chart">
                    @foreach($monthlyClosed as $month => $count)
                        <div class="mini-col">
                            <div class="mini-value">{{ $count }}</div>
                            <div class="mini-bar-wrap">
                                <div class="mini-bar" style="height: {{ ($count / $maxMonthlyClosed) * 100 }}%; background: linear-gradient(135deg, #22c55e, #16a34a);"></div>
                            </div>
                            <div class="mini-label">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M y') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Monthly SLA Breach Trend</div>
                <div class="muted">Tickets created in each month that breached SLA.</div>
                <div class="mini-chart">
                    @foreach($monthlyBreaches as $month => $count)
                        <div class="mini-col">
                            <div class="mini-value">{{ $count }}</div>
                            <div class="mini-bar-wrap">
                                <div class="mini-bar" style="height: {{ ($count / $maxMonthlyBreaches) * 100 }}%; background: linear-gradient(135deg, #ef4444, #dc2626);"></div>
                            </div>
                            <div class="mini-label">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M y') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="section-title">Aging Buckets</div>
                <div class="muted">Current active ticket age distribution.</div>

                <div class="list">
                    @foreach($agingBuckets as $label => $count)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $label }}</div>
                                <div class="list-count">{{ $count }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar bar-warning" style="width: {{ ($count / $maxAging) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Most Critical Tickets</div>
                <div class="muted">High priority or SLA-risk tickets that need immediate focus.</div>

                <div class="list">
                    @forelse($criticalTickets as $ticket)
                        <div class="ticket">
                            <div class="ticket-title">{{ $ticket->title }}</div>
                            <div class="ticket-meta">
                                Ticket: {{ $ticket->ticket_number ?: '-' }}<br>
                                Company: {{ optional($ticket->company)->name ?? '-' }}<br>
                                Engineer: {{ optional($ticket->assignedEngineer)->name ?? 'Unassigned' }}<br>
                                Status: {{ $ticket->status }} | Priority: {{ $ticket->priority }}
                            </div>
                        </div>
                    @empty
                        <div class="list-item">
                            <div class="list-name">No critical tickets right now.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="section-title">Tickets by Company</div>
                <div class="muted">Volume distribution across customer companies.</div>

                <div class="list">
                    @foreach($byCompany as $name => $data)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $name }}</div>
                                <div class="list-count">{{ $data['count'] }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar" style="width: {{ ($data['count'] / $maxCompany) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Tickets by Engineer</div>
                <div class="muted">Handling load across assigned engineers.</div>

                <div class="list">
                    @foreach($byEngineer as $name => $data)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $name }}</div>
                                <div class="list-count">{{ $data['count'] }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar" style="width: {{ ($data['count'] / $maxEngineer) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="section-title">Top Breached Companies</div>
                <div class="muted">Companies with the highest number of SLA breaches.</div>

                <div class="list">
                    @foreach($topBreachedCompanies as $name => $data)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $name }}</div>
                                <div class="list-count">{{ $data['count'] }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar bar-danger" style="width: {{ ($data['count'] / $maxBreachCompany) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Top Loaded Engineers</div>
                <div class="muted">Engineers with the highest assigned ticket volume.</div>

                <div class="list">
                    @foreach($topEngineers as $name => $data)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $name }}</div>
                                <div class="list-count">{{ $data['count'] }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar" style="width: {{ ($data['count'] / $maxTopEngineer) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="section-title">Top Issue Categories</div>
                <div class="muted">Most common incident types inferred from ticket titles.</div>

                <div class="list">
                    @foreach($topIssueCategories as $name => $count)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $name }}</div>
                                <div class="list-count">{{ $count }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar bar-success" style="width: {{ ($count / $maxIssueCategory) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Executive Summary</div>
                <div class="muted">Quick interpretation of the current operating condition.</div>

                <div class="list">
                    <div class="list-item">
                        <div class="list-name">Current backlog</div>
                        <div class="list-count">{{ $open + $progress }}</div>
                    </div>
                    <div class="list-item">
                        <div class="list-name">Immediate SLA risk</div>
                        <div class="list-count">{{ $overdueNow }}</div>
                    </div>
                    <div class="list-item">
                        <div class="list-name">Most pressured area</div>
                        <div class="list-count">{{ $topBreachedCompanies->keys()->first() ?? 'N/A' }}</div>
                    </div>
                    <div class="list-item">
                        <div class="list-name">Top workload owner</div>
                        <div class="list-count">{{ $topEngineers->keys()->first() ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
