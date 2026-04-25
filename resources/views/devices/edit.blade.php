<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Device</title>
    
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
    <div class="hero">
        <div class="hero-top">
            <div>
                <div class="eyebrow"><span class="eyebrow-dot"></span> Device Management</div>
                <h1>Edit Device</h1>
                <p>Update the device information to keep your asset master accurate and usable in tickets.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('devices.show', $device) }}" class="btn btn-secondary">View Device</a>
                <a href="{{ route('devices.index') }}" class="btn btn-secondary">Back to Devices</a>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="error-box">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel">
        <h2 class="panel-title">Device Form</h2>
        <p class="panel-subtitle">Refine and maintain the device master data below.</p>

        <form method="POST" enctype="multipart/form-data" action="{{ route('devices.update', $device) }}">
            @csrf
            @method('PUT')
            @include('devices._form')

            <div class="actions" style="margin-top:18px;">
                <button type="submit" class="btn btn-primary">Update Device</button>
                <a href="{{ route('devices.show', $device) }}" class="btn">Cancel</a>
            </div>
        </form>
    </div>

        @if($device->images->count())
            <div class="panel" style="margin-top:18px;">
                <h2 class="panel-title">Existing Photos</h2>
                <p class="panel-subtitle">Review uploaded images and remove individual photos if needed.</p>

                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:14px;">
                    @foreach($device->images as $image)
                        <div style="background:#fff; border:1px solid #e5edf7; border-radius:18px; overflow:hidden; box-shadow:0 8px 24px rgba(15, 23, 42, 0.06);">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="Device Photo" style="width:100%; height:180px; object-fit:cover; display:block;">
                            <div style="padding:12px;">
                                <form method="POST" action="{{ route('devices.images.destroy', [$device, $image]) }}" onsubmit="return confirm('Delete this photo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="width:100%;">Delete Photo</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
</div>
</body>
</html>
