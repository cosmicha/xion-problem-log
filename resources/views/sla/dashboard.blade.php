<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SLA Command Center</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="20">
    <style>
        *{box-sizing:border-box}
        body{margin:0;font-family:Inter,system-ui,sans-serif;background:#030712;color:#e5e7eb;overflow-x:hidden}
        body:before{content:"";position:fixed;inset:0;background:radial-gradient(circle at top left,rgba(37,99,235,.35),transparent 30%),radial-gradient(circle at bottom right,rgba(14,165,233,.18),transparent 35%);pointer-events:none}
        .page{position:relative;z-index:1;padding:24px;max-width:1600px;margin:0 auto}
        .top{display:flex;justify-content:space-between;align-items:center;gap:20px;margin-bottom:20px}
        h1{font-size:42px;letter-spacing:-.05em;margin:0}
        .sub{color:#93c5fd;margin-top:6px;font-size:15px}
        .btn{display:inline-flex;align-items:center;min-height:40px;padding:0 16px;border-radius:999px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);color:white;text-decoration:none;font-weight:800}
        .clock{font-size:14px;color:#bfdbfe;text-align:right}
        .stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:18px}
        .stat{background:linear-gradient(180deg,rgba(255,255,255,.11),rgba(255,255,255,.05));border:1px solid rgba(147,197,253,.22);border-radius:26px;padding:22px;box-shadow:0 20px 60px rgba(0,0,0,.3)}
        .label{font-size:12px;text-transform:uppercase;letter-spacing:.12em;color:#93c5fd;font-weight:900}
        .value{font-size:54px;font-weight:950;letter-spacing:-.06em;margin-top:8px;color:#fff}
        .redval{color:#fca5a5}.yellowval{color:#fde68a}.greenval{color:#86efac}
        .ticker{border:1px solid rgba(248,113,113,.35);background:rgba(127,29,29,.35);border-radius:22px;padding:14px 18px;margin-bottom:18px;overflow:hidden}
        .ticker strong{color:#fecaca}
        .panel{background:rgba(255,255,255,.08);border:1px solid rgba(147,197,253,.20);border-radius:26px;padding:18px;box-shadow:0 22px 70px rgba(0,0,0,.35)}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:.12em;color:#93c5fd;padding:12px;border-bottom:1px solid rgba(147,197,253,.2)}
        td{padding:13px 12px;border-bottom:1px solid rgba(147,197,253,.12);font-size:14px;vertical-align:top;color:#e5e7eb}
        tr.critical{background:rgba(127,29,29,.22)}
        tr.warning{background:rgba(120,53,15,.18)}
        .ticket-link{font-weight:950;color:#93c5fd;text-decoration:none}
        .muted{color:#94a3b8;font-size:12px;margin-top:4px}
        .pill{display:inline-flex;align-items:center;min-height:28px;padding:0 10px;border-radius:999px;font-size:12px;font-weight:950}
        .red{background:#7f1d1d;color:#fecaca;border:1px solid #ef4444}
        .yellow{background:#78350f;color:#fde68a;border:1px solid #f59e0b}
        .green{background:#064e3b;color:#bbf7d0;border:1px solid #22c55e}
        .blue{background:#1e3a8a;color:#dbeafe;border:1px solid #60a5fa}
        .footer{margin-top:14px;color:#93c5fd;font-size:12px;text-align:right}
        @media(max-width:1000px){.stats{grid-template-columns:1fr 1fr}.panel{overflow:auto}h1{font-size:32px}}
    </style>
</head>
<body>
<div class="page">
    <div class="top">
        <div>
            <h1>SLA Command Center</h1>
            <div class="sub">Live operational monitoring • Auto-refresh every 20 seconds</div>
        </div>
        <div>
            <div class="clock">Last refresh: {{ now()->format('d M Y H:i:s') }}</div>
            <div style="margin-top:10px;text-align:right"><a class="btn" href="/problem-logs">Back to Tickets</a></div>
        </div>
    </div>

    <div class="stats">
        <div class="stat"><div class="label">Active Tickets</div><div class="value">{{ $stats['open'] }}</div></div>
        <div class="stat"><div class="label">Near Breach</div><div class="value yellowval">{{ $stats['near_breach'] }}</div></div>
        <div class="stat"><div class="label">Response Breach</div><div class="value redval">{{ $stats['response_breached'] }}</div></div>
        <div class="stat"><div class="label">Resolution Breach</div><div class="value redval">{{ $stats['resolution_breached'] }}</div></div>
    </div>

    @php
        $criticalTickets = $tickets->filter(fn($t) =>
            ($t->response_due_at && $t->response_due_at->lt($now)) ||
            ($t->resolution_due_at && $t->resolution_due_at->lt($now))
        )->take(5);
    @endphp

    @if($criticalTickets->count())
        <div class="ticker">
            <strong>Critical:</strong>
            @foreach($criticalTickets as $ct)
                {{ $ct->ticket_number }} — {{ $ct->title }}@if(!$loop->last) &nbsp; • &nbsp; @endif
            @endforeach
        </div>
    @endif

    <div class="panel">
        <table>
            <thead>
            <tr>
                <th>Ticket</th>
                <th>Customer</th>
                <th>Device / Location</th>
                <th>Status</th>
                <th>Response SLA</th>
                <th>Resolution SLA</th>
                <th>Engineer</th>
            </tr>
            </thead>
            <tbody>
            @forelse($tickets as $ticket)
                @php
                    $responseBreached = $ticket->response_due_at && $ticket->response_due_at->lt($now);
                    $resolutionBreached = $ticket->resolution_due_at && $ticket->resolution_due_at->lt($now);
                    $nearResolution = $ticket->resolution_due_at && $ticket->resolution_due_at->between($now, $now->copy()->addMinutes(60));
                    $rowClass = ($responseBreached || $resolutionBreached) ? 'critical' : ($nearResolution ? 'warning' : '');
                    $responseClass = $responseBreached ? 'red' : 'green';
                    $resolutionClass = $resolutionBreached ? 'red' : ($nearResolution ? 'yellow' : 'green');
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>
                        <a class="ticket-link" href="/problem-logs/{{ $ticket->id }}">{{ $ticket->ticket_number }}</a>
                        <div class="muted">{{ $ticket->title }}</div>
                    </td>
                    <td>{{ optional($ticket->company)->name ?: '-' }}</td>
                    <td>
                        {{ optional($ticket->device)->device_code ?: '-' }} — {{ optional($ticket->device)->name ?: '-' }}
                        <div class="muted">{{ optional($ticket->device)->site ?: '-' }} / {{ optional($ticket->device)->location ?: '-' }}</div>
                    </td>
                    <td><span class="pill blue">{{ strtoupper($ticket->status) }}</span></td>
                    <td><span class="pill {{ $responseClass }}">{{ $ticket->response_due_at ? $ticket->response_due_at->format('d M H:i') : '-' }}</span></td>
                    <td><span class="pill {{ $resolutionClass }}">{{ $ticket->resolution_due_at ? $ticket->resolution_due_at->format('d M H:i') : '-' }}</span></td>
                    <td>{{ optional($ticket->assignedEngineer)->name ?: '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:34px;">No active tickets.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">Xion1 Support Intelligence • SLA Command Center</div>
</div>
</body>
</html>
