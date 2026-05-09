<!DOCTYPE html>
<html>
<head>
    <title>SLA Governance & RCA Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        *{box-sizing:border-box}
        body{
            margin:0;
            font-family:Inter,Arial,sans-serif;
            background:
                radial-gradient(circle at top left, rgba(59,130,246,.20), transparent 30%),
                linear-gradient(180deg,#eef4ff 0%,#f8fafc 42%,#eef2f7 100%);
            color:#0f172a;
        }
        .page{padding:28px;max-width:1680px;margin:0 auto}
        .hero{
            position:relative;
            overflow:hidden;
            background:linear-gradient(135deg,#08142f 0%,#1d2d72 48%,#3157e8 100%);
            color:white;
            padding:34px;
            border-radius:30px;
            box-shadow:0 26px 70px rgba(15,23,42,.28);
        }
        .hero:after{
            content:"";
            position:absolute;
            width:420px;height:420px;
            right:-120px;top:-160px;
            border-radius:999px;
            background:rgba(255,255,255,.13);
            filter:blur(4px);
        }
        .hero h1{margin:0;font-size:38px;letter-spacing:-.03em}
        .hero p{margin:10px 0 0;color:#dbeafe;font-size:16px}
        .top-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:24px;position:relative;z-index:2}
        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:13px 18px;
            border-radius:16px;
            background:#2563eb;
            color:white;
            text-decoration:none;
            font-weight:900;
            border:0;
            cursor:pointer;
            box-shadow:0 12px 26px rgba(37,99,235,.24);
        }
        .btn-secondary{
            background:rgba(255,255,255,.13);
            border:1px solid rgba(255,255,255,.2);
            box-shadow:none;
        }
        .filters{
            margin-top:24px;
            display:grid;
            grid-template-columns:repeat(5,minmax(0,1fr));
            gap:12px;
            background:rgba(255,255,255,.88);
            border:1px solid #dbeafe;
            padding:18px;
            border-radius:24px;
            box-shadow:0 18px 42px rgba(15,23,42,.08);
        }
        input,select{
            width:100%;
            padding:13px 14px;
            border:1px solid #cbd5e1;
            border-radius:14px;
            background:#fff;
            font-weight:700;
            color:#0f172a;
        }
        .kpi-grid{
            margin-top:22px;
            display:grid;
            grid-template-columns:repeat(6,minmax(0,1fr));
            gap:16px;
        }
        .card{
            background:rgba(255,255,255,.92);
            border:1px solid #dbe4f0;
            border-radius:24px;
            padding:22px;
            box-shadow:0 18px 45px rgba(15,23,42,.08);
        }
        .kpi .label{
            font-size:12px;
            text-transform:uppercase;
            letter-spacing:.1em;
            color:#64748b;
            font-weight:950;
        }
        .kpi .value{
            font-size:38px;
            font-weight:950;
            margin-top:8px;
            letter-spacing:-.04em;
        }
        .kpi .hint{
            margin-top:6px;
            color:#64748b;
            font-weight:700;
            font-size:13px;
        }
        .section-grid{
            margin-top:20px;
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:16px;
        }
        .section-title{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:16px;
        }
        .section-title h3{margin:0;font-size:20px}
        .stat-row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:14px;
            padding:12px 0;
            border-bottom:1px solid #e2e8f0;
        }
        .stat-row:last-child{border-bottom:0}
        .pill{
            display:inline-flex;
            padding:7px 10px;
            border-radius:999px;
            background:#eff6ff;
            color:#1d4ed8;
            font-weight:900;
            font-size:12px;
        }
        .bar{
            height:8px;
            background:#e2e8f0;
            border-radius:999px;
            overflow:hidden;
            margin-top:8px;
        }
        .bar > div{
            height:100%;
            background:linear-gradient(90deg,#2563eb,#60a5fa);
            border-radius:999px;
        }
        .table-card{margin-top:20px}
        table{
            width:100%;
            border-collapse:separate;
            border-spacing:0;
            overflow:hidden;
        }
        th{
            background:#f8fafc;
            color:#475569;
            text-align:left;
            padding:14px;
            font-size:12px;
            text-transform:uppercase;
            letter-spacing:.08em;
            font-weight:950;
            border-bottom:1px solid #e2e8f0;
        }
        td{
            padding:14px;
            border-bottom:1px solid #eef2f7;
            font-size:14px;
            vertical-align:top;
        }
        tr:hover td{background:#f8fafc}
        a{color:#1d4ed8;font-weight:900;text-decoration:none}
        .badge{
            display:inline-flex;
            padding:7px 10px;
            border-radius:999px;
            font-size:12px;
            font-weight:950;
            background:#f1f5f9;
            color:#334155;
            white-space:nowrap;
        }
        .badge.red{background:#fee2e2;color:#991b1b}
        .badge.green{background:#dcfce7;color:#166534}
        .badge.amber{background:#fef3c7;color:#92400e}
        .badge.blue{background:#dbeafe;color:#1e40af}
        @media(max-width:1200px){
            .kpi-grid{grid-template-columns:repeat(3,1fr)}
            .section-grid{grid-template-columns:1fr}
            .filters{grid-template-columns:repeat(2,1fr)}
        }
        @media(max-width:720px){
            .page{padding:14px}
            .hero{padding:24px;border-radius:24px}
            .hero h1{font-size:28px}
            .kpi-grid{grid-template-columns:1fr}
            .filters{grid-template-columns:1fr}
        }
    </style>
</head>
<body>
<div class="page">
    <div class="hero">
        <h1>SLA Governance & Root Cause Report</h1>
        <p>Track SLA fairness, excluded incidents, customer misuse, root causes, cost responsibility, and vendor accountability.</p>

        <div class="top-actions">
            <a class="btn btn-secondary" href="/problem-logs">← Back to Dashboard</a>
            <a class="btn" href="{{ route('reports.sla.export', request()->query()) }}">Export CSV</a>
        </div>
    </div>

    <form method="GET" class="filters">
        <input type="date" name="date_from" value="{{ request('date_from') }}">
        <input type="date" name="date_to" value="{{ request('date_to') }}">

        <select name="root_cause_category">
            <option value="">All Root Cause</option>
            @foreach(['user_related'=>'User Related','hardware_related'=>'Hardware Related','software_related'=>'Software Related','external'=>'External','others'=>'Others'] as $k=>$v)
                <option value="{{ $k }}" @selected(request('root_cause_category')===$k)>{{ $v }}</option>
            @endforeach
        </select>

        <select name="sla_responsibility">
            <option value="">All SLA Responsibility</option>
            @foreach(['included'=>'Included','excluded'=>'Excluded','customer_responsibility'=>'Customer Responsibility','vendor_responsibility'=>'Vendor Responsibility','pending_investigation'=>'Pending Investigation'] as $k=>$v)
                <option value="{{ $k }}" @selected(request('sla_responsibility')===$k)>{{ $v }}</option>
            @endforeach
        </select>

        <button class="btn" type="submit">Apply Filter</button>
    </form>

    <div class="kpi-grid">
        @foreach([
            ['Total Tickets',$kpis['total'],'Current filtered tickets','blue'],
            ['Included SLA',$kpis['included_sla'],'Counted in SLA performance','green'],
            ['Excluded SLA',$kpis['excluded_sla'],'Excluded from SLA scoring','amber'],
            ['Customer Misuse',$kpis['customer_misuse'],'User/customer caused incidents','red'],
            ['Vendor Resp.',$kpis['vendor_responsibility'],'Escalated vendor responsibility','blue'],
            ['SLA Breached',$kpis['sla_breached'],'Response or resolution breached','red'],
        ] as $item)
            <div class="card kpi">
                <div class="label">{{ $item[0] }}</div>
                <div class="value">{{ $item[1] }}</div>
                <div class="hint">{{ $item[2] }}</div>
            </div>
        @endforeach
    </div>

    @php $maxRoot = max($rootCauseStats->max() ?: 1, 1); @endphp
    @php $maxSla = max($slaStats->max() ?: 1, 1); @endphp
    @php $maxCost = max($costStats->max() ?: 1, 1); @endphp

    <div class="section-grid">
        <div class="card">
            <div class="section-title"><h3>Root Cause Distribution</h3><span class="pill">{{ $rootCauseStats->sum() }} tickets</span></div>
            @forelse($rootCauseStats as $k=>$v)
                <div class="stat-row">
                    <div style="width:100%;">
                        <b>{{ ucwords(str_replace('_',' ',$k)) }}</b>
                        <div class="bar"><div style="width:{{ round(($v/$maxRoot)*100) }}%"></div></div>
                    </div>
                    <span class="pill">{{ $v }}</span>
                </div>
            @empty
                <p>No data yet.</p>
            @endforelse
        </div>

        <div class="card">
            <div class="section-title"><h3>SLA Responsibility</h3><span class="pill">{{ $slaStats->sum() }} tickets</span></div>
            @forelse($slaStats as $k=>$v)
                <div class="stat-row">
                    <div style="width:100%;">
                        <b>{{ ucwords(str_replace('_',' ',$k)) }}</b>
                        <div class="bar"><div style="width:{{ round(($v/$maxSla)*100) }}%"></div></div>
                    </div>
                    <span class="pill">{{ $v }}</span>
                </div>
            @empty
                <p>No data yet.</p>
            @endforelse
        </div>

        <div class="card">
            <div class="section-title"><h3>Cost Responsibility</h3><span class="pill">{{ $costStats->sum() }} tickets</span></div>
            @forelse($costStats as $k=>$v)
                <div class="stat-row">
                    <div style="width:100%;">
                        <b>{{ ucwords(str_replace('_',' ',$k)) }}</b>
                        <div class="bar"><div style="width:{{ round(($v/$maxCost)*100) }}%"></div></div>
                    </div>
                    <span class="pill">{{ $v }}</span>
                </div>
            @empty
                <p>No data yet.</p>
            @endforelse
        </div>
    </div>

    <div class="card table-card">
        <div class="section-title">
            <h3>Ticket RCA Detail</h3>
            <span class="pill">{{ $tickets->count() }} records</span>
        </div>

        <table>
            <thead>
            <tr>
                <th>Ticket</th>
                <th>Title</th>
                <th>Company</th>
                <th>Device</th>
                <th>Root Cause</th>
                <th>SLA</th>
                <th>Cost</th>
                <th>Misuse</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tickets as $t)
                <tr>
                    <td><a href="/problem-logs/{{ $t->id }}">{{ $t->ticket_number }}</a></td>
                    <td>{{ $t->title }}</td>
                    <td>{{ optional($t->company)->name ?: '-' }}</td>
                    <td>{{ optional($t->device)->device_code ?: '-' }}</td>
                    <td><span class="badge blue">{{ ucwords(str_replace('_',' ',$t->root_cause_category ?: 'Unclassified')) }}</span></td>
                    <td>
                        <span class="badge {{ $t->sla_excluded ? 'amber' : 'green' }}">
                            {{ ucwords(str_replace('_',' ',$t->sla_responsibility ?: 'Unclassified')) }}
                        </span>
                    </td>
                    <td><span class="badge">{{ ucwords(str_replace('_',' ',$t->cost_responsibility ?: 'Unclassified')) }}</span></td>
                    <td>
                        <span class="badge {{ $t->customer_misuse ? 'red' : 'green' }}">
                            {{ $t->customer_misuse ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td><span class="badge">{{ ucwords(str_replace('_',' ',$t->status)) }}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
