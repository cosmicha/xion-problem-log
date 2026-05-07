<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Device QR Label</title>
    <style>
        @page {
            size: 62mm 62mm;
            margin: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 62mm;
            height: 62mm;
            overflow: hidden;
            background: #fff;
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .label {
            width: 62mm;
            height: 62mm;
            padding: 2.2mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            page-break-after: avoid;
            break-after: avoid;
        }

        .qr {
            width: 42mm;
            height: 42mm;
            object-fit: contain;
            display: block;
        }

        .meta {
            margin-top: 1.2mm;
            width: 100%;
            line-height: 1.05;
        }

        .label-title {
            font-size: 5.8pt;
            font-weight: 900;
            letter-spacing: .04em;
            color: #111;
        }

        .label-value {
            font-size: 6.8pt;
            font-weight: 900;
            color: #000;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .row {
            margin-top: .7mm;
        }

        .actions {
            position: fixed;
            left: 56mm;
            top: 8mm;
            width: 260px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 0 14px;
            border-radius: 10px;
            border: 0;
            background: #3158d4;
            color: white;
            font-weight: 900;
            text-decoration: none;
            cursor: pointer;
            margin-right: 8px;
        }

        .btn.secondary {
            background: #64748b;
        }

        .hint {
            margin-top: 12px;
            font-size: 13px;
            line-height: 1.45;
            color: #475569;
        }

        @media print {
            .actions {
                display: none !important;
            }

            html, body {
                width: 62mm;
                height: 62mm;
            }

            .label {
                page-break-after: avoid;
                break-after: avoid;
            }
        }
    </style>
</head>
<body>
@php
    $qrValue = url('/problem-logs/create?device_id=' . $device->id);
    $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&margin=0&data=' . urlencode($qrValue);

    $sn = $device->serial_number ?: ($device->device_code ?: 'N/A');
    $type = $device->category ?: 'Device';
@endphp

<div class="label">
    <img class="qr" src="{{ $qrUrl }}" alt="QR">
    <div class="meta">
        <div class="row">
            <div class="label-title">SN</div>
            <div class="label-value">{{ $sn }}</div>
        </div>
        <div class="row">
            <div class="label-title">TYPE</div>
            <div class="label-value">{{ $type }}</div>
        </div>
    </div>
</div>

<div class="actions">
    <button class="btn" onclick="window.print()">Print Label</button>
    <a class="btn secondary" href="{{ route('devices.show', $device) }}">Back</a>
    <div class="hint">
        Brother QL-800 setting:<br>
        Paper Size: <b>62mm</b><br>
        Scale: <b>100%</b><br>
        Pages: <b>1 to 1</b><br>
        Orientation: <b>Portrait</b>
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        setTimeout(function () {
            window.print();
        }, 400);
    });
</script>
</body>
</html>
