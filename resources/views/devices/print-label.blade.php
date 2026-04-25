<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Device QR Label</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 5mm;
        }

        body{
            margin:0;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            background:#fff;
            color:#0f172a;
        }

        .sheet{
            width: 200mm;
            min-height: 287mm;
            margin: 0 auto;
            display:grid;
            grid-template-columns: repeat(4, 50mm);
            grid-auto-rows: 50mm;
            justify-content:start;
            align-content:start;
        }

        .label{
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

        .muted{
            color:#64748b;
        }

        @media screen {
            body{
                background:#f3f4f6;
                padding:10px 0;
            }
            .sheet{
                background:#fff;
                box-shadow:0 8px 24px rgba(0,0,0,.08);
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="sheet">
        <div class="label">
            <img class="qr" src="{{ $device->qrImageUrl() }}" alt="QR Code" referrerpolicy="no-referrer">

            <div class="meta">
                <div class="k">SN</div>
                <div class="v">{{ $device->serial_number ?: '-' }}</div>

                <div class="k">Type</div>
                <div class="v">{{ ucfirst($device->category ?: 'Other') }}</div>
            </div>
        </div>
    </div>
</body>
</html>
