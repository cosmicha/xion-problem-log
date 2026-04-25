<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Device QR</title>
    <style>
        body{
            margin:0;
            font-family:Inter, ui-sans-serif, system-ui, sans-serif;
            background:linear-gradient(120deg, #071a52 0%, #0b245f 45%, #173a88 100%);
            min-height:100vh;
            color:#0f172a;
        }
        .page{
            max-width:860px;
            margin:0 auto;
            padding:28px 20px;
        }
        .card{
            background:#fff;
            border-radius:28px;
            padding:28px;
            box-shadow:0 20px 50px rgba(0,0,0,.22);
        }
        .top{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:18px;
            flex-wrap:wrap;
            margin-bottom:20px;
        }
        .title h1{
            margin:0;
            font-size:30px;
            font-weight:800;
            letter-spacing:-.03em;
        }
        .title p{
            margin:10px 0 0;
            color:#64748b;
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
        }
        .btn-primary{
            background:linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            border:none;
            color:#fff;
        }
        .layout{
            display:grid;
            grid-template-columns:320px 1fr;
            gap:24px;
            align-items:start;
        }
        .qr-box{
            border:1px solid #e2e8f0;
            border-radius:24px;
            background:#f8fbff;
            padding:18px;
            text-align:center;
        }
        .qr-box img{
            width:100%;
            max-width:280px;
            display:block;
            margin:0 auto;
            background:#fff;
            border-radius:18px;
            padding:12px;
            border:1px solid #dbe7f5;
        }
        .meta{
            display:grid;
            grid-template-columns:1fr;
            gap:14px;
        }
        .meta-item{
            background:#f8fafc;
            border:1px solid #e2e8f0;
            border-radius:18px;
            padding:16px;
        }
        .label{
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:.08em;
            color:#64748b;
            font-weight:800;
            margin-bottom:8px;
        }
        .value{
            font-size:15px;
            font-weight:700;
            color:#0f172a;
            word-break:break-word;
        }
        .linkbox{
            margin-top:18px;
            padding:14px;
            border-radius:16px;
            background:#eff6ff;
            border:1px solid #bfdbfe;
            color:#1e3a8a;
            word-break:break-all;
            font-size:13px;
        }
        @media (max-width: 820px){
            .layout{ grid-template-columns:1fr; }
        }
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        <div class="top">
            <div class="title">
                <h1>Device QR</h1>
                <p>{{ $device->device_code }} — {{ $device->name }}</p>
            </div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('devices.show', $device) }}" class="btn">Back to Device</a>
                <a href="{{ route('devices.print-label', $device) }}" class="btn btn-primary" target="_blank">Print QR Label</a>
            </div>
        </div>

        <div class="layout">
            <div class="qr-box">
                <img src="{{ $device->qrImageUrl() }}" alt="QR Code" referrerpolicy="no-referrer">
                <div style="margin-top:12px; font-size:12px; color:#64748b; font-weight:700;">
                    Scan to create ticket for this device
                </div>
            </div>

            <div>
                <div class="meta">
                    <div class="meta-item">
                        <div class="label">Device Code</div>
                        <div class="value">{{ $device->device_code }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="label">Device Name</div>
                        <div class="value">{{ $device->name }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="label">Company</div>
                        <div class="value">{{ optional($device->company)->name ?? '-' }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="label">Category</div>
                        <div class="value">{{ ucfirst($device->category) }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="label">Site / Location</div>
                        <div class="value">{{ $device->site ?: '-' }} @if($device->location) — {{ $device->location }} @endif</div>
                    </div>
                </div>

                <div class="linkbox">
                    <strong>QR URL:</strong><br>
                    {{ $device->ticketCreateUrl() }}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
