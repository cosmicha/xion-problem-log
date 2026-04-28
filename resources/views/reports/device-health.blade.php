<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Device Health Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        *{box-sizing:border-box}
        body{margin:0;font-family:Inter,system-ui,sans-serif;background:linear-gradient(135deg,#071737,#173a88);color:#0f172a}
        .page{max-width:1400px;margin:0 auto;padding:28px}
        .hero{color:white;display:flex;justify-content:space-between;align-items:flex-start;gap:18px;margin-bottom:18px}
        h1{margin:0;font-size:36px;letter-spacing:-.045em}
        .sub{color:#bfdbfe;margin-top:7px;font-size:14px}
        .actions{display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end}
        .btn{display:inline-flex;align-items:center;min-height:40px;padding:0 14px;border-radius:12px;background:white;color:#0f172a;text-decoration:none;font-weight:900;border:0;cursor:pointer}
        .btn-dark{background:rgba(255,255,255,.12);color:white;border:1px solid rgba(255,255,255,.18)}
        .stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:16px}
        .stat{background:white;border-radius:24px;padding:18px;box-shadow:0 18px 50px rgba(0,0,0,.16)}
        .label{font-size:11px;text-transform:uppercase;letter-spacing:.09em;color:#64748b;font-weight:950}
        .value{font-size:38px;font-weight:950;letter-spacing:-.05em;margin-top:7px}
        .filters{background:white;border-radius:24px;padding:16px;box-shadow:0 18px 50px rgba(0,0,0,.13);margin-bottom:16px}
        .filter-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;align-items:end}
        select,input{width:100%;min-height:42px;border:1px solid #dbeafe;border-radius:14px;padding:0 12px;font-size:14px;background:#f8fbff}
        .panel{background:white;border-radius:24px;padding:18px;box-shadow:0 18px 50px rgba(0,0,0,.16);overflow:auto}
        table{width:100%;border-collapse:collapse;min-width:1100px}
        th{text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:#64748b;padding:12px;border-bottom:1px solid #e2e8f0}
        td{padding:14px 12px;border-bottom:1px solid #eef2f7;font-size:14px;vertical-align:top}
        .device{font-weight:950;color:#0f172a}
        .muted{color:#64748b;font-size:12px;margin-top:3px}
        .pill{display:inline-flex;align-items:center;min-height:26px;padding:0 10px;border-radius:999px;font-size:12px;font-weight:950}
        .excellent{background:#dbeafe;color:#1d4ed8}
        .good{background:#dcfce7;color:#166534}
        .watch{background:#fef3c7;color:#92400e}
        .critical{background:#fee2e2;color:#991b1b}
        .issue-chip{display:inline-flex;margin:3px 4px 3px 0;padding:5px 8px;border-radius:999px;background:#eef2ff;color:#3730a3;font-size:12px;font-weight:800}
        .bar{height:8px;border-radius:999px;background:#e5e7eb;overflow:hidden;min-width:120px}
        .bar span{display:block;height:100%;background:linear-gradient(90deg,#60a5fa,#1d4ed8)}
        @media(max-width:900px){.stats,.filter-grid{grid-template-columns:1fr 1fr}.hero{display:block}.actions{justify-content:flex-start;margin-top:14px}}
    </style>
</head>
<body>
<div class="page">
    <div class="hero">
        <div>
            <h1>Device Health Report</h1>
            <div class="sub">Identify devices that often fail, devices with no issues, recurring problem categories, and replacement risk.</div>
        </div>
        <div class="actions">
            <a class="btn btn-dark" href="/devices">Back to Devices</a>
            <a class="btn" href="/problem-logs">Tickets</a>
        </div>
    </div>

    <div class="stats">
        <div class="stat"><div class="label">Total Devices</div><div class="value">{{ $stats['total_devices'] }}</div></div>
        <div class="stat"><div class="label">Never Reported</div><div class="value">{{ $stats['never_reported'] }}</div></div>
        <div class="stat"><div class="label">Watch List</div><div class="value">{{ $stats['watch'] }}</div></div>
        <div class="stat"><div class="label">Critical</div><div class="value">{{ $stats['critical'] }}</div></div>
    </div>

    <form method="GET" class="filters">
        <div class="filter-grid">
            <div>
                <div class="label">Company</div>
                <select name="company_id">
                    <option value="">All Companies</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <div class="label">Category</div>
                <select name="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <div class="label">Status</div>
                <select name="status">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;gap:8px">
                <button class="btn" type="submit">Apply Filter</button>
                <a class="btn btn-dark" href="/reports/device-health">Reset</a>
            </div>
        </div>
    </form>

    <div class="panel">
        <table>
            <thead>
                <tr>
                    <th>Device</th>
                    <th>Company</th>
                    <th>Tickets</th>
                    <th>Open / Closed</th>
                    <th>Top Issues</th>
                    <th>Last Issue</th>
                    <th>Health</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($devices as $device)
                @php
                    $healthClass = strtolower($device->health_status);
                    $total = max((int)$device->total_tickets, 1);
                    $openPct = min(100, round(((int)$device->open_tickets / $total) * 100));
                @endphp
                <tr>
                    <td>
                        <div class="device">{{ $device->device_code ?: '-' }} — {{ $device->name ?: '-' }}</div>
                        <div class="muted">{{ ucfirst($device->category ?: '-') }} • {{ $device->brand ?: '-' }} {{ $device->model ?: '' }}</div>
                        <div class="muted">{{ $device->site ?: '-' }} / {{ $device->location ?: '-' }}</div>
                    </td>
                    <td>{{ optional($device->company)->name ?: '-' }}</td>
                    <td>
                        <strong>{{ $device->total_tickets }}</strong>
                        <div class="muted">total reports</div>
                    </td>
                    <td>
                        <strong>{{ $device->open_tickets }}</strong> open / <strong>{{ $device->closed_tickets }}</strong> closed
                        <div class="bar" style="margin-top:7px"><span style="width:{{ $openPct }}%"></span></div>
                    </td>
                    <td>
                        @forelse($device->top_issues as $issue)
                            <span class="issue-chip">{{ $issue['category'] }}: {{ $issue['total'] }}</span>
                        @empty
                            <span class="muted">No issue history</span>
                        @endforelse
                    </td>
                    <td>
                        {{ $device->last_issue_title ?: '-' }}
                        <div class="muted">{{ $device->last_issue_at ? $device->last_issue_at->format('d M Y H:i') : '-' }}</div>
                    </td>
                    <td><span class="pill {{ $healthClass }}">{{ $device->health_status }}</span></td>
                    <td>
                        <a class="btn" href="/devices/{{ $device->id }}">View Device</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center;color:#64748b;padding:34px;">No device data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
