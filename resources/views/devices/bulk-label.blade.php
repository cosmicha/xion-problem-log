<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bulk Print Labels</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 5mm;
        }

        :root{
            --bg-1:#071a52;
            --bg-2:#0b245f;
            --bg-3:#173a88;
            --navy:#0b1538;
            --panel:#ffffff;
            --line:#dbe7f5;
            --text:#0f172a;
            --muted:#64748b;
            --primary:#2563eb;
            --primary-2:#3b82f6;
            --soft:#eff6ff;
            --shadow:0 18px 48px rgba(15,23,42,.10);
            --shadow-soft:0 10px 24px rgba(15,23,42,.06);
        }

        *{ box-sizing:border-box; }

        body{
            margin:0;
            font-family:Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color:var(--text);
            background:
                radial-gradient(circle at top left, rgba(30,94,255,.22), transparent 26%),
                radial-gradient(circle at bottom right, rgba(59,130,246,.18), transparent 22%),
                linear-gradient(120deg, var(--bg-1) 0%, var(--bg-2) 45%, var(--bg-3) 100%);
            min-height:100vh;
        }

        body.thermal-mode{
            background:#eef2f7;
            min-height:auto;
        }

        .page{
            max-width:1240px;
            margin:0 auto;
            padding:24px;
        }

        .hero{
            background:linear-gradient(135deg, rgba(8,28,84,.92), rgba(23,58,136,.88));
            border:1px solid rgba(255,255,255,.10);
            border-radius:28px;
            padding:24px 26px;
            color:white;
            box-shadow:0 24px 60px rgba(0,0,0,.20);
            margin-bottom:18px;
        }

        .hero-top{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:18px;
            flex-wrap:wrap;
        }

        .hero h1{
            margin:0;
            font-size:30px;
            line-height:1.05;
            font-weight:800;
            letter-spacing:-.03em;
        }

        .hero p{
            margin:10px 0 0;
            max-width:760px;
            color:rgba(255,255,255,.82);
            line-height:1.5;
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
            min-height:42px;
            padding:0 16px;
            border-radius:12px;
            text-decoration:none;
            border:1px solid #cbd5e1;
            background:#fff;
            color:#0f172a;
            font-size:14px;
            font-weight:700;
            cursor:pointer;
        }

        .btn-primary{
            background:linear-gradient(90deg, var(--primary-2), var(--primary));
            color:#fff;
            border:none;
        }

        .btn-secondary{
            background:rgba(255,255,255,.08);
            color:#fff;
            border:1px solid rgba(255,255,255,.16);
        }

        .panel{
            background:var(--panel);
            border:1px solid rgba(219,231,245,.95);
            border-radius:24px;
            box-shadow:var(--shadow);
            padding:20px;
            margin-bottom:18px;
        }

        .panel-title{
            margin:0 0 4px;
            font-size:20px;
            font-weight:800;
            letter-spacing:-.02em;
        }

        .panel-subtitle{
            margin:0 0 16px;
            color:var(--muted);
        }

        .filters{
            display:grid;
            grid-template-columns:1fr 1fr 1fr auto auto;
            gap:12px;
            align-items:end;
        }

        .label-text{
            display:block;
            margin-bottom:8px;
            font-size:12px;
            font-weight:800;
            color:#334155;
            text-transform:uppercase;
            letter-spacing:.06em;
        }

        .select{
            width:100%;
            border:1px solid #cfdced;
            border-radius:14px;
            background:#fff;
            padding:12px 14px;
            font-size:14px;
            color:var(--text);
            outline:none;
        }

        .summary{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:16px;
            flex-wrap:wrap;
            margin-bottom:16px;
        }

        .summary-badge{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-height:34px;
            padding:0 14px;
            border-radius:999px;
            background:#eff6ff;
            color:#1d4ed8;
            font-size:13px;
            font-weight:800;
        }

        .sheet-a4{
            width: 200mm;
            min-height: 287mm;
            margin: 0 auto;
            background:#fff;
            box-shadow:0 8px 24px rgba(0,0,0,.08);
            display:grid;
            grid-template-columns: repeat(4, 50mm);
            grid-auto-rows: 50mm;
            justify-content:start;
            align-content:start;
        }

        .sheet-thermal{
            width: 58mm;
            margin: 0 auto;
            background:#fff;
            box-shadow:0 8px 24px rgba(0,0,0,.08);
            display:grid;
            grid-template-columns: 50mm;
            grid-auto-rows: 50mm;
            justify-content:center;
            align-content:start;
            row-gap: 0;
            padding: 4mm;
        }

        .sticker{
            width:50mm;
            height:50mm;
            border:1px solid #111827;
            box-sizing:border-box;
            padding:2.5mm;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:flex-start;
            overflow:hidden;
            background:#fff;
        }

        .qr{
            width:27mm;
            height:27mm;
            object-fit:contain;
            display:block;
            margin:0 auto 2mm;
        }

        .meta{
            width:100%;
            text-align:center;
            line-height:1.15;
        }

        .meta .k{
            font-size:7px;
            font-weight:800;
            letter-spacing:.04em;
            color:#475569;
            text-transform:uppercase;
        }

        .meta .v{
            font-size:8px;
            font-weight:700;
            color:#0f172a;
            word-break:break-word;
            margin-bottom:1.2mm;
        }

        .a4-card{
            background:#fff;
            border:2px solid #0f172a;
            border-radius:16px;
            padding:8px;
            box-sizing:border-box;
            width:50mm;
            height:50mm;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:flex-start;
            overflow:hidden;
        }

        .a4-title{
            font-size:8px;
            font-weight:800;
            margin-bottom:2mm;
            text-align:center;
            line-height:1.1;
            min-height:10px;
        }

        .a4-meta{
            width:100%;
            text-align:center;
            margin-top:2mm;
        }

        .a4-meta .k{
            font-size:6.5px;
            color:#64748b;
            text-transform:uppercase;
            font-weight:800;
        }

        .a4-meta .v{
            font-size:7.5px;
            font-weight:700;
            color:#111827;
            margin-bottom:1mm;
            word-break:break-word;
        }

        .empty{
            background:#fff;
            border:1px dashed #cbd5e1;
            border-radius:22px;
            padding:26px;
            color:#64748b;
            text-align:center;
            box-shadow:var(--shadow);
        }

        .thermal-shell{
            display:grid;
            grid-template-columns:260px 1fr;
            gap:22px;
            align-items:start;
        }

        .thermal-topbar{
            position:sticky;
            top:0;
            z-index:20;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
            background:linear-gradient(90deg, #071433, #10204b);
            color:#fff;
            padding:16px 18px;
            border-radius:20px;
            box-shadow:var(--shadow-soft);
            margin-bottom:16px;
        }

        .thermal-topbar-left,
        .thermal-topbar-right{
            display:flex;
            align-items:center;
            gap:10px;
            flex-wrap:wrap;
        }

        .thermal-title{
            font-size:16px;
            font-weight:800;
            letter-spacing:-.02em;
        }

        .thermal-chip{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-height:38px;
            padding:0 14px;
            border-radius:12px;
            text-decoration:none;
            border:1px solid #dbe7f5;
            background:#fff;
            color:#0f172a;
            font-size:13px;
            font-weight:700;
            cursor:pointer;
        }

        .thermal-chip-primary{
            background:linear-gradient(90deg, #3b82f6, #2563eb);
            border:none;
            color:#fff;
        }

        .thermal-banner{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:14px;
            flex-wrap:wrap;
            background:#eaf2ff;
            border:1px solid #cfe0ff;
            border-radius:18px;
            padding:16px 18px;
            margin-bottom:18px;
        }

        .thermal-banner-title{
            font-size:14px;
            font-weight:800;
            color:#22408f;
            margin-bottom:4px;
        }

        .thermal-banner-sub{
            font-size:13px;
            color:#4b648f;
        }

        .thermal-side{
            display:grid;
            gap:14px;
        }

        .thermal-info-card{
            background:#fff;
            border:1px solid #dde7f5;
            border-radius:18px;
            padding:16px;
            box-shadow:var(--shadow-soft);
        }

        .thermal-info-label{
            font-size:12px;
            font-weight:800;
            color:#64748b;
            margin-bottom:6px;
        }

        .thermal-info-value{
            font-size:28px;
            font-weight:800;
            color:#0f172a;
            line-height:1;
        }

        .thermal-info-sub{
            margin-top:8px;
            font-size:13px;
            color:#64748b;
            line-height:1.4;
        }

        .thermal-roll-stage{
            display:flex;
            justify-content:center;
        }

        .thermal-roll{
            width:58mm;
            padding:10px 0;
            border-radius:18px;
            background:#fff;
            box-shadow:0 10px 30px rgba(15,23,42,.08);
            position:relative;
        }

        .thermal-roll:before{
            content:"";
            position:absolute;
            top:0;
            left:0;
            right:0;
            border-top:2px dashed #e5e7eb;
        }

        .thermal-roll .sticker{
            border:none;
            border-bottom:1px dashed #e5e7eb;
            padding:2mm 2mm 1.5mm 2mm;
            page-break-inside:avoid;
            break-inside:avoid;
        }

        .thermal-roll .qr{
            width:31mm;
            height:31mm;
            margin:0 auto 1.5mm;
        }

        .thermal-roll .meta .k{
            font-size:7px;
        }

        .thermal-roll .meta .v{
            font-size:8px;
            margin-bottom:0.8mm;
        }

        body.thermal-mode .hero,
        body.thermal-mode .panel,
        body.thermal-mode .summary{
            display:none;
        }

        body.thermal-mode .page{
            max-width:none;
            padding:20px;
            margin:0;
        }

        @media print {
            @page {
                size: auto;
                margin: 0;
            }

            .thermal-topbar,
            .thermal-banner,
            .thermal-side{
                display:none !important;
            }

            body{
                background:#fff !important;
            }

            .hero, .panel, .summary{
                display:none !important;
            }

            .page{
                max-width:none;
                padding:0;
                margin:0;
            }

            .sheet-a4{
                box-shadow:none;
                width:200mm;
                min-height:287mm;
            }

            body.thermal-mode{
                background:#fff !important;
            }

            body.thermal-mode .page{
                width:58mm;
                padding:0;
            }

            body.thermal-mode .thermal-shell{
                display:block;
            }

            body.thermal-mode .thermal-roll-stage{
                display:block;
            }

            body.thermal-mode .thermal-roll{
                width:58mm;
                margin:0;
                padding:0;
                background:#fff;
                box-shadow:none;
                border-radius:0;
            }

            body.thermal-mode .sticker{
                width:50mm;
                height:50mm;
                border:none;
                margin:0;
                padding:2mm 2mm 1.5mm 2mm;
            }
        }

        @media (max-width: 980px){
            .page{ padding:16px; }
            .filters{ grid-template-columns:1fr; }
            .thermal-shell{ grid-template-columns:1fr; }
            .thermal-side{ grid-template-columns:repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 720px){
            .sheet-a4{
                width:100%;
                min-height:auto;
                grid-template-columns: repeat(auto-fill, minmax(50mm, 1fr));
                grid-auto-rows: 50mm;
            }

            .thermal-side{
                grid-template-columns:1fr;
            }

            .thermal-roll-stage{
                justify-content:flex-start;
                overflow:auto;
            }
        }
    </style>
</head>
<body class="{{ ($printMode ?? 'a4') === 'thermal' ? 'thermal-mode' : 'a4-mode' }}">
@if(($printMode ?? 'a4') === 'thermal')
    <div class="page">
        <div class="thermal-topbar">
            <div class="thermal-topbar-left">
                <a href="{{ route('devices.index') }}" class="thermal-chip">Back to Devices</a>
                <div class="thermal-title">Thermal Roll 50x50 · Ready to Print</div>
            </div>
            <div class="thermal-topbar-right">
                <a href="{{ route('devices.bulk-label', array_merge(request()->query(), ['print_mode' => 'a4'])) }}" class="thermal-chip">Switch to A4 Mode</a>
                <button type="button" class="thermal-chip thermal-chip-primary" onclick="window.print()">Print Thermal</button>
            </div>
        </div>

        <div class="thermal-banner">
            <div>
                <div class="thermal-banner-title">Thermal Roll Mode (50x50mm)</div>
                <div class="thermal-banner-sub">Single column continuous layout optimized for thermal label printers.</div>
            </div>
        </div>

        <div class="thermal-shell">
            <div class="thermal-side">
                <div class="thermal-info-card">
                    <div class="thermal-info-label">Total Labels</div>
                    <div class="thermal-info-value">{{ $devices->count() }}</div>
                    <div class="thermal-info-sub">Items ready for print</div>
                </div>

                <div class="thermal-info-card">
                    <div class="thermal-info-label">Company</div>
                    <div class="thermal-info-value" style="font-size:20px; line-height:1.15;">
                        @if(request('company_id'))
                            {{ optional($companies->firstWhere('id', request('company_id')))->name ?? 'Filtered' }}
                        @else
                            All Companies
                        @endif
                    </div>
                    <div class="thermal-info-sub">
                        {{ request('site') ? request('site') : 'All Sites' }}
                    </div>
                </div>

                <div class="thermal-info-card">
                    <div class="thermal-info-label">Label Size</div>
                    <div class="thermal-info-value" style="font-size:22px;">50 x 50 mm</div>
                    <div class="thermal-info-sub">Thermal roll format</div>
                </div>

                <div class="thermal-info-card">
                    <div class="thermal-info-label">Printing Tips</div>
                    <div class="thermal-info-sub">
                        Use 50x50mm thermal labels.<br>
                        Darkness/Quality: High.<br>
                        Speed: Medium.<br>
                        Margins: None.
                    </div>
                </div>
            </div>

            <div class="thermal-roll-stage">
                <div class="thermal-roll">
                    @foreach($devices as $device)
                        <div class="sticker">
                            <img class="qr" src="{{ $device->qrImageUrl() }}" alt="QR Code" referrerpolicy="no-referrer">
                            <div class="meta">
                                <div class="k">SN</div>
                                <div class="v">{{ $device->serial_number ?: $device->device_code ?: '-' }}</div>

                                <div class="k">Type</div>
                                <div class="v">{{ strtoupper($device->category ?: 'DEVICE') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@else
<div class="page">
    <div class="hero">
        <div class="hero-top">
            <div>
                <h1>Bulk Print Labels</h1>
                <p>Select print mode A4 or Thermal 50x50, then filter by company or site before printing.</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('devices.index') }}" class="btn btn-secondary">Back to Devices</a>
                <button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
            </div>
        </div>
    </div>

    <div class="panel">
        <h2 class="panel-title">Filter Labels</h2>
        <p class="panel-subtitle">Control which labels are included and which format to print.</p>

        <form method="GET" action="{{ route('devices.bulk-label') }}" class="filters">
            <div>
                <label class="label-text">Print Mode</label>
                <select name="print_mode" class="select">
                    <option value="a4" {{ ($printMode ?? 'a4') === 'a4' ? 'selected' : '' }}>A4 Compact</option>
                    <option value="thermal" {{ ($printMode ?? 'a4') === 'thermal' ? 'selected' : '' }}>Thermal 50x50</option>
                </select>
            </div>

            <div>
                <label class="label-text">Company</label>
                <select name="company_id" class="select">
                    <option value="">All Companies</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ (string)request('company_id') === (string)$company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="label-text">Site</label>
                <select name="site" class="select">
                    <option value="">All Sites</option>
                    @foreach($sites as $site)
                        <option value="{{ $site }}" {{ request('site') === $site ? 'selected' : '' }}>
                            {{ $site }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Apply Filter</button>
            <a href="{{ route('devices.bulk-label') }}" class="btn">Reset</a>
        </form>
    </div>

    <div class="summary">
        <div style="color:white; font-size:22px; font-weight:800;">A4 Compact Sheet</div>
        <div class="summary-badge">{{ $devices->count() }} label(s)</div>
    </div>

    @if($devices->count())
        <div class="sheet-a4">
            @foreach($devices as $device)
                <div class="a4-card">
                    <div class="a4-title">{{ $device->device_code }}</div>
                    <img class="qr" src="{{ $device->qrImageUrl() }}" alt="QR Code" referrerpolicy="no-referrer">
                    <div class="a4-meta">
                        <div class="k">SN</div>
                        <div class="v">{{ $device->serial_number ?: '-' }}</div>
                        <div class="k">Type</div>
                        <div class="v">{{ ucfirst($device->category ?: 'Other') }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty">
            No devices found for the selected filter.
        </div>
    @endif
</div>
@endif
</body>
</html>
