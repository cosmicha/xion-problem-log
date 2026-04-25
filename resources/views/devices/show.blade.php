<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Device Detail</title>
    
<style>
    :root{
        --bg-1:#071a52;
        --bg-2:#0b245f;
        --bg-3:#173a88;
        --panel:#ffffff;
        --panel-soft:#f8fbff;
        --line:#dbe7f5;
        --text:#0f172a;
        --muted:#64748b;
        --primary:#2563eb;
        --primary-2:#3b82f6;
        --success-bg:#dcfce7;
        --success-tx:#166534;
        --warn-bg:#fef3c7;
        --warn-tx:#92400e;
        --neutral-bg:#e2e8f0;
        --neutral-tx:#334155;
        --shadow:0 18px 48px rgba(15, 23, 42, 0.10);
        --radius-xl:24px;
        --radius-lg:18px;
        --radius-md:14px;
    }

    * { box-sizing: border-box; }

    body{
        margin:0;
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        color:var(--text);
        background:
            radial-gradient(circle at top left, rgba(30,94,255,.22), transparent 26%),
            radial-gradient(circle at bottom right, rgba(59,130,246,.18), transparent 22%),
            linear-gradient(120deg, var(--bg-1) 0%, var(--bg-2) 45%, var(--bg-3) 100%);
        min-height:100vh;
    }

    .page{
        max-width:1200px;
        margin:0 auto;
        padding:26px;
    }

    .hero{
        background:linear-gradient(135deg, rgba(8,28,84,.92), rgba(23,58,136,.88));
        border:1px solid rgba(255,255,255,.10);
        border-radius:30px;
        padding:28px 30px;
        color:white;
        box-shadow:0 24px 60px rgba(0,0,0,.20);
        margin-bottom:20px;
    }

    .hero-top{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:18px;
        flex-wrap:wrap;
    }

    .eyebrow{
        display:inline-flex;
        align-items:center;
        gap:10px;
        font-size:12px;
        font-weight:800;
        letter-spacing:.12em;
        text-transform:uppercase;
        color:rgba(255,255,255,.76);
        margin-bottom:10px;
    }

    .eyebrow-dot{
        width:10px;
        height:10px;
        border-radius:999px;
        background:linear-gradient(135deg, #7dd3fc, #3b82f6);
        box-shadow:0 0 18px rgba(125,211,252,.65);
    }

    .hero h1{
        margin:0;
        font-size:34px;
        line-height:1.05;
        font-weight:800;
        letter-spacing:-.03em;
    }

    .hero p{
        margin:10px 0 0;
        max-width:720px;
        color:rgba(255,255,255,.80);
        line-height:1.55;
    }

    .hero-actions{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    }

    .btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        min-height:42px;
        padding:0 16px;
        border-radius:12px;
        text-decoration:none;
        border:1px solid #cdd9e8;
        background:#fff;
        color:var(--text);
        font-size:14px;
        font-weight:700;
        cursor:pointer;
        transition:.18s ease;
    }

    .btn:hover{ transform:translateY(-1px); }

    .btn-primary{
        border:none;
        color:white;
        background:linear-gradient(90deg, var(--primary-2), var(--primary));
        box-shadow:0 10px 24px rgba(37,99,235,.24);
    }

    .btn-secondary{
        background:rgba(255,255,255,.08);
        color:#fff;
        border:1px solid rgba(255,255,255,.16);
        backdrop-filter:blur(6px);
    }

    .btn-danger{
        background:#fff1f2;
        color:#be123c;
        border:1px solid #fecdd3;
    }

    .panel{
        background:var(--panel);
        border:1px solid rgba(219,231,245,.95);
        border-radius:var(--radius-xl);
        box-shadow:var(--shadow);
        padding:22px;
        margin-bottom:18px;
    }

    .panel-title{
        margin:0 0 4px;
        font-size:20px;
        font-weight:800;
        letter-spacing:-.02em;
    }

    .panel-subtitle{
        margin:0 0 18px;
        color:var(--muted);
    }

    .flash{
        margin-bottom:16px;
        border-radius:14px;
        padding:14px 16px;
        background:#ecfdf3;
        color:#166534;
        border:1px solid #bbf7d0;
    }

    .error-box{
        margin-bottom:16px;
        border-radius:16px;
        padding:14px 16px;
        background:#fef2f2;
        color:#991b1b;
        border:1px solid #fecaca;
    }

    .error-box ul{ margin:0; padding-left:18px; }

    .filters{
        display:grid;
        grid-template-columns:2fr 1fr 1fr 1fr auto;
        gap:12px;
        align-items:end;
    }

    .grid{
        display:grid;
        grid-template-columns:repeat(2, minmax(0,1fr));
        gap:16px;
    }

    .field.full{ grid-column:1 / -1; }

    .label{
        display:block;
        margin-bottom:8px;
        font-size:12px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.04em;
        color:#334155;
    }

    .input, .select, .textarea{
        width:100%;
        border:1px solid #cfdced;
        border-radius:14px;
        background:#fff;
        padding:12px 14px;
        font-size:14px;
        color:var(--text);
        outline:none;
        transition:.18s ease;
    }

    .input:focus, .select:focus, .textarea:focus{
        border-color:#60a5fa;
        box-shadow:0 0 0 4px rgba(96,165,250,.14);
    }

    .textarea{
        min-height:130px;
        resize:vertical;
    }

    .actions{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    }

    .table-wrap{
        overflow:auto;
        border:1px solid #e7eef7;
        border-radius:18px;
    }

    table{
        width:100%;
        border-collapse:collapse;
        background:#fff;
    }

    th, td{
        padding:14px 14px;
        border-bottom:1px solid #edf2f7;
        text-align:left;
        vertical-align:top;
        font-size:14px;
    }

    th{
        background:#f8fbff;
        font-size:11px;
        text-transform:uppercase;
        letter-spacing:.08em;
        color:#64748b;
        font-weight:800;
    }

    tr:hover td{
        background:#fbfdff;
    }

    .sub{
        color:var(--muted);
        font-size:13px;
        margin-top:4px;
    }

    .badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-height:28px;
        padding:0 10px;
        border-radius:999px;
        font-size:12px;
        font-weight:800;
    }

    .badge-active{ background:var(--success-bg); color:var(--success-tx); }
    .badge-inactive{ background:var(--neutral-bg); color:var(--neutral-tx); }
    .badge-maintenance{ background:var(--warn-bg); color:var(--warn-tx); }

    .meta-grid{
        display:grid;
        grid-template-columns:repeat(2, minmax(0,1fr));
        gap:14px;
    }

    .meta{
        background:linear-gradient(180deg, #fbfdff 0%, #f8fbff 100%);
        border:1px solid #e5edf7;
        border-radius:18px;
        padding:16px;
    }

    .meta-label{
        font-size:11px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.08em;
        color:#64748b;
        margin-bottom:8px;
    }

    .meta-value{
        font-size:15px;
        font-weight:700;
        color:#0f172a;
        line-height:1.4;
        word-break:break-word;
    }

    .split{
        display:grid;
        grid-template-columns:1fr;
        gap:18px;
    }

    .table-actions{
        display:flex;
        gap:8px;
        flex-wrap:wrap;
    }

    .pagination-wrap{
        margin-top:16px;
    }

    @media (max-width: 920px){
        .device-photo-layout{
            grid-template-columns:1fr !important;
        }

        .filters,
        .grid,
        .meta-grid{
            grid-template-columns:1fr;
        }

        .page{ padding:16px; }
        .hero{ padding:22px 18px; border-radius:24px; }
        .hero h1{ font-size:28px; }
        .panel{ padding:16px; border-radius:20px; }
    }
</style>

</head>
<body>
<div class="page">
    @if(session('success'))
        <div class="flash">{{ session('success') }}</div>
    @endif

    <div class="hero">
        <div class="hero-top">
            <div>
                <div class="eyebrow"><span class="eyebrow-dot"></span> Device Detail</div>
                <h1>{{ $device->name }}</h1>
                <p>{{ $device->device_code }} • {{ ucfirst($device->category) }} • {{ optional($device->company)->name ?? '-' }}</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('devices.index') }}" class="btn btn-secondary">Back to Devices</a>
                <a href="/problem-logs/create?device_id={{ $device->id }}" class="btn btn-secondary">Create Ticket</a>
                <a href="/problem-logs?device_id={{ $device->id }}&status=open" class="btn btn-primary">Open Tickets Only</a>
                <a href="{{ route('devices.thermal-label', $device) }}" class="btn btn-primary" target="_blank">Print Thermal 50x50</a>
                <a href="{{ route('devices.print-label', $device) }}" class="btn btn-secondary" target="_blank">Print A4 Label</a>
                <a href="{{ route('devices.qr', $device) }}" class="btn btn-secondary">View QR</a>
                <a href="{{ $device->qrImageUrl() }}" class="btn btn-secondary" target="_blank" download>Download QR PNG</a>
                <a href="{{ route('devices.bulk-label', ['company_id' => $device->company_id, 'site' => $device->site]) }}" class="btn btn-secondary" target="_blank">Bulk Print</a>
                <a href="{{ route('devices.edit', $device) }}" class="btn btn-secondary">Edit Device</a>
            </div>
        </div>
    </div>

    <div class="panel">
        <h2 class="panel-title">Device Information</h2>
        <p class="panel-subtitle">Core asset data for incident tracking and future QR flow.</p>

        <div class="meta-grid">
            <div class="meta"><div class="meta-label">Company</div><div class="meta-value">{{ optional($device->company)->name ?? '-' }}</div></div>
            <div class="meta"><div class="meta-label">Status</div><div class="meta-value">{{ ucfirst($device->status) }}</div></div>
            <div class="meta"><div class="meta-label">Brand</div><div class="meta-value">{{ $device->brand ?: '-' }}</div></div>
            <div class="meta"><div class="meta-label">Model</div><div class="meta-value">{{ $device->model ?: '-' }}</div></div>
            <div class="meta"><div class="meta-label">Serial Number</div><div class="meta-value">{{ $device->serial_number ?: '-' }}</div></div>
            <div class="meta"><div class="meta-label">Site / Branch</div><div class="meta-value">{{ $device->site ?: '-' }}</div></div>
            <div class="meta"><div class="meta-label">Location</div><div class="meta-value">{{ $device->location ?: '-' }}</div></div>
            <div class="meta"><div class="meta-label">Notes</div><div class="meta-value">{{ $device->notes ?: '-' }}</div></div>
        </div>
    </div>

    
    <div class="panel">
        <h2 class="panel-title">Device Photos</h2>
        <p class="panel-subtitle">Visual reference for this asset.</p>

        @if($device->images->count())
            @php($cover = $device->images->first())
            <div class="device-photo-layout" style="display:grid; grid-template-columns:1.4fr .8fr; gap:16px; align-items:start;">
                <div style="background:#fff; border:1px solid #e5edf7; border-radius:22px; overflow:hidden; box-shadow:0 8px 24px rgba(15, 23, 42, 0.06);">
                    <img src="{{ asset('storage/' . $cover->path) }}" alt="Device Cover Photo" style="width:100%; height:380px; object-fit:cover; display:block;">
                </div>

                <div>
                    <div style="font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:#64748b; margin-bottom:10px;">
                        Gallery
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:12px;">
                        @foreach($device->images as $image)
                            <div style="background:#fff; border:1px solid #e5edf7; border-radius:16px; overflow:hidden; box-shadow:0 8px 24px rgba(15, 23, 42, 0.06);">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Device Photo" style="width:100%; height:120px; object-fit:cover; display:block;">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="sub">No photos uploaded yet.</div>
        @endif
    </div>


    <div class="panel">
        <h2 class="panel-title">Ticket Summary</h2>
        <p class="panel-subtitle">Quick overview of incidents linked to this device.</p>

        <div class="meta-grid">
            <a href="/problem-logs?device_id={{ $device->id }}" class="meta" style="text-decoration:none;">
                <div class="meta-label">Total Tickets</div>
                <div class="meta-value">{{ $ticketStats['total'] ?? 0 }}</div>
            </a>
            <a href="/problem-logs?device_id={{ $device->id }}&status=open" class="meta" style="text-decoration:none;">
                <div class="meta-label">Open</div>
                <div class="meta-value">{{ $ticketStats['open'] ?? 0 }}</div>
            </a>
            <a href="/problem-logs?device_id={{ $device->id }}&status=in_progress" class="meta" style="text-decoration:none;">
                <div class="meta-label">In Progress</div>
                <div class="meta-value">{{ $ticketStats['in_progress'] ?? 0 }}</div>
            </a>
            <a href="/problem-logs?device_id={{ $device->id }}&status=closed" class="meta" style="text-decoration:none;">
                <div class="meta-label">Closed</div>
                <div class="meta-value">{{ $ticketStats['closed'] ?? 0 }}</div>
            </a>
        </div>
    </div>

<div class="panel">
        <h2 class="panel-title">Related Tickets</h2>
        <p class="panel-subtitle">Incident history already linked to this device.</p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Title</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($relatedTickets as $ticket)
                        <tr>
                            <td><a href="/problem-logs/{{ $ticket->id }}"><strong>{{ $ticket->ticket_number }}</strong></a></td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ optional($ticket->company)->name ?? '-' }}</td>
                            <td>{{ ucfirst($ticket->status ?? 'open') }}</td>
                            <td>{{ ucfirst($ticket->priority ?? 'medium') }}</td>
                            <td>{{ optional($ticket->created_at)->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color:#64748b; padding:28px;">No tickets linked to this device yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $relatedTickets->links() }}
        </div>
    </div>
</div>
</body>
</html>
