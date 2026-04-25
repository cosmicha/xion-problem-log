<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Devices</title>
    
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
                <div class="eyebrow"><span class="eyebrow-dot"></span> Device Management</div>
                <h1>Devices</h1>
                <p>Manage your device master data as the foundation for incident tracking, QR flow, and vendor linkage.</p>
            </div>
            <div class="hero-actions">
                <a href="/problem-logs" class="btn btn-secondary">Back to Tickets</a>
                <a href="{{ route('devices.bulk-label') }}" class="btn btn-secondary" target="_blank">Bulk Print Labels</a>
                <a href="{{ route('devices.create') }}" class="btn btn-primary">+ Add Device</a>
            </div>
        </div>
    </div>

    <div class="panel">
        <h2 class="panel-title">Filters</h2>
        <p class="panel-subtitle">Search and narrow down devices by company, category, and status.</p>
        <form method="GET" action="{{ route('devices.index') }}" class="filters">
            <div class="field">
                <label class="label">Search</label>
                <input type="text" name="search" class="input" value="{{ request('search') }}" placeholder="Code, name, brand, model, serial, site, location">
            </div>
            <div class="field">
                <label class="label">Company</label>
                <select name="company_id" class="select">
                    <option value="">All Companies</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" @selected((string)request('company_id') === (string)$company->id)>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label class="label">Category</label>
                <select name="category" class="select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" @selected(request('category') === $category)>{{ ucfirst($category) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label class="label">Status</label>
                <select name="status" class="select">
                    <option value="">All Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <button type="submit" class="btn btn-primary">Apply</button>
            </div>
        </form>
    </div>

    <div class="panel">
        <h2 class="panel-title">Device List</h2>
        <p class="panel-subtitle">A complete list of registered devices for your current environment.</p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Device Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Company</th>
                        <th>Site / Location</th>
                        <th>Status</th>
                        <th>Tickets</th>
                        <th style="width:220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devices as $device)
                        <tr>
                            <td style="width:110px;">
                                @if($device->images->count())
                                    <img src="{{ asset('storage/' . $device->images->first()->path) }}" alt="Device Photo" style="width:78px; height:58px; object-fit:cover; border-radius:12px; border:1px solid #dbe7f5; display:block;">
                                @else
                                    <div style="width:78px; height:58px; border-radius:12px; border:1px dashed #cbd5e1; background:#f8fafc; color:#94a3b8; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700;">
                                        No Photo
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $device->device_code }}</strong></td>
                            <td>
                                <div><strong>{{ $device->name }}</strong></div>
                                <div class="sub">
                                    @if($device->brand || $device->model)
                                        {{ trim(($device->brand ?? '') . ' ' . ($device->model ?? '')) }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td>{{ ucfirst($device->category) }}</td>
                            <td>{{ optional($device->company)->name ?? '-' }}</td>
                            <td>
                                <div>{{ $device->site ?? '-' }}</div>
                                <div class="sub">{{ $device->location ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $device->status }}">{{ ucfirst($device->status) }}</span>
                            </td>
                            <td>
                                <div style="display:inline-flex; min-width:44px; justify-content:center; align-items:center; padding:6px 10px; border-radius:999px; background:#eff6ff; color:#1d4ed8; font-size:12px; font-weight:800;">
                                    {{ $device->problem_logs_count ?? 0 }}
                                </div>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('devices.show', $device) }}" class="btn">View</a>
                                    <a href="{{ route('devices.edit', $device) }}" class="btn">Edit</a>
                                    <form method="POST" action="{{ route('devices.destroy', $device) }}" onsubmit="return confirm('Delete this device?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center; color:#64748b; padding:28px;">No devices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $devices->links() }}
        </div>
    </div>
</div>
</body>
</html>
