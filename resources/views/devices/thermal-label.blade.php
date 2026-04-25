<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Thermal Label</title>

<style>
    @page {
        size: 50mm 50mm;
        margin: 0;
    }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: white;
    }

    .label {
        width: 50mm;
        height: 50mm;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        padding: 2mm;
    }

    .qr {
        width: 32mm;
        height: 32mm;
        object-fit: contain;
        margin-bottom: 2mm;
    }

    .text {
        text-align: center;
        line-height: 1.1;
    }

    .sn {
        font-size: 8pt;
        font-weight: bold;
        margin-bottom: 1mm;
    }

    .type {
        font-size: 7pt;
        color: #333;
    }

    @media screen {
        body {
            display:flex;
            align-items:center;
            justify-content:center;
            height:100vh;
            background:#f3f4f6;
        }

        .label {
            border:1px solid #ccc;
            background:white;
        }
    }
</style>
</head>

<body onload="window.print()">

<div class="label">

    <img class="qr" src="{{ $device->qrImageUrl() }}" alt="QR">

    <div class="text">
        <div class="sn">
            {{ $device->serial_number ?: $device->device_code }}
        </div>

        <div class="type">
            {{ strtoupper($device->category ?? 'DEVICE') }}
        </div>
    </div>

</div>

</body>
</html>
