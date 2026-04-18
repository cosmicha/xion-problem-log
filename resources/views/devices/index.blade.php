<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Device Master</title>
<style>
body { font-family: Inter; background:#f8fafc; margin:0; }
.page { max-width:1200px; margin:auto; padding:24px; }
.card { background:white; padding:20px; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,.05); }
.btn {
    padding:8px 12px;
    border-radius:10px;
    font-weight:700;
    text-decoration:none;
    font-size:13px;
}
.btn-edit { background:#2563eb; color:white; }
.btn-view { background:#0f172a; color:white; }
table { width:100%; border-collapse:collapse; }
th, td { padding:12px; border-bottom:1px solid #e2e8f0; }
.muted { color:#64748b; font-size:12px; }
</style>
</head>
<body>

<div class="page">
    
            <div class="actions">
                <a href="/vendors" class="btn btn-secondary">Vendors</a>
                <a href="/problem-logs" class="btn btn-secondary">Tickets</a>
                <a href="/" class="btn btn-secondary">Dashboard</a>
            </div>


        <div class="card">

        <h2>Device Master</h2>

        <table>
            <thead>
                <tr>
                    <th>Device</th>
                    <th>Customer</th>
                    <th>Location</th>
                    <th>Vendor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                <tr>
                    <td>
                        <b>{{ $device->device_code }}</b><br>
                        <span class="muted">{{ $device->cms_device_name }}</span>
                    </td>
                    <td>{{ optional($device->company)->name }}</td>
                    <td>{{ $device->location_name }}</td>
                    <td>{{ optional($device->vendor)->name }}</td>
                    <td>
                        <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-edit">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
