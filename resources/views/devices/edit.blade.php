<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Device</title>
<style>
body { font-family: Inter, sans-serif; background:#f1f5f9; margin:0; }
.page { max-width:900px; margin:auto; padding:24px; }

.header {
    background: linear-gradient(135deg,#0f172a,#2563eb);
    color:white;
    padding:20px;
    border-radius:20px;
    margin-bottom:20px;
}

.card {
    background:white;
    padding:24px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.input, textarea {
    width:100%;
    padding:12px;
    border-radius:12px;
    border:1px solid #cbd5e1;
    font-size:14px;
}

textarea { min-height:80px; }

.btn {
    padding:12px 16px;
    border:none;
    border-radius:12px;
    font-weight:700;
    cursor:pointer;
}

.btn-primary { background:#2563eb; color:white; }

.photo-box {
    border:2px dashed #cbd5e1;
    padding:20px;
    border-radius:16px;
    text-align:center;
    margin-top:10px;
}

.label {
    font-weight:700;
    margin-bottom:6px;
    display:block;
}
</style>
</head>
<body>

<div class="page">

    <div class="header">
        <h2 style="margin:0;">Edit Device</h2>
        <div style="opacity:.8;">Update device info & documentation</div>
    </div>

    
        <div style="margin-bottom:16px; display:flex; gap:12px; flex-wrap:wrap;">
            <a href="/devices" class="btn btn-secondary">Back to Devices</a>
            <a href="/vendors" class="btn btn-secondary">Vendors</a>
            <a href="/problem-logs" class="btn btn-secondary">Tickets</a>
            <a href="/" class="btn btn-secondary">Dashboard</a>
        </div>


    <div class="card">
        <form method="POST" action="{{ route('devices.update',$device->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid">
                <div>
                    <label class="label">Device Code</label>
                    <input name="device_code" class="input" value="{{ $device->device_code }}">
                </div>

                <div>
                    <label class="label">CMS Name</label>
                    <input name="cms_device_name" class="input" value="{{ $device->cms_device_name }}">
                </div>

                <div>
                    <label class="label">Serial Number</label>
                    <input name="serial_number" class="input" value="{{ $device->serial_number }}">
                </div>

                <div>
                    <label class="label">IP Address</label>
                    <input name="ip_address" class="input" value="{{ $device->ip_address }}">
                </div>

                <div>
                    <label class="label">Location</label>
                    <input name="location_name" class="input" value="{{ $device->location_name }}">
                </div>

                <div>
                    <label class="label">Detail</label>
                    <input name="location_detail" class="input" value="{{ $device->location_detail }}">
                </div>
            </div>

            <div style="margin-top:16px;">
                <label class="label">Notes</label>
                <textarea name="notes">{{ $device->notes }}</textarea>
            </div>

            <div style="margin-top:20px;">
                <label class="label">Device Photos</label>
                <div class="photo-box">
                    <input type="file" name="photos[]" multiple>
                    <div style="font-size:12px;color:#64748b;margin-top:6px;">
                        Upload multiple photos (device, wiring, location)
                    </div>
                </div>
            </div>

            <div style="margin-top:20px;">
                <button class="btn btn-primary">Update Device</button>
            </div>

        </form>
    </div>

</div>

</body>
</html>
