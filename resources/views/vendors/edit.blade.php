<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vendor</title>

    <style>
        body {
            font-family: Inter, Arial, sans-serif;
            margin: 0;
            background: #f8fafc;
            color: #0f172a;
        }

        .page {
            max-width: 900px;
            margin: 0 auto;
            padding: 24px;
        }

        .hero {
            background: linear-gradient(135deg, #0f172a, #1d4ed8);
            color: white;
            padding: 24px;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .hero h2 {
            margin: 0;
        }

        .hero p {
            margin: 6px 0 0;
            opacity: .85;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(15,23,42,.06);
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            font-size: 13px;
            font-weight: 700;
            color: #475569;
        }

        input, textarea {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            margin-top: 6px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #0f172a;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .danger-row {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>

<div class="page">
    <div class="hero">
        <h2>Edit Vendor</h2>
        <p>Update vendor support and service information.</p>
    </div>

    
        <div style="margin-bottom:16px; display:flex; gap:12px; flex-wrap:wrap;">
            <a href="/vendors" class="btn btn-secondary">Back to Vendors</a>
            <a href="/devices" class="btn btn-secondary">Devices</a>
            <a href="/problem-logs" class="btn btn-secondary">Tickets</a>
            <a href="/" class="btn btn-secondary">Dashboard</a>
        </div>


    <div class="card">
        <form method="POST" action="{{ route('vendors.update', $vendor) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Vendor Name</label>
                <input type="text" name="name" value="{{ old('name', $vendor->name) }}" required>
            </div>

            <div class="form-group">
                <label>Contact Person</label>
                <input type="text" name="contact" value="{{ old('contact', $vendor->contact) }}">
            </div>

            <div class="form-group">
                <label>Support Phone</label>
                <input type="text" name="support_phone" value="{{ old('support_phone', $vendor->support_phone) }}">
            </div>

            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes">{{ old('notes', $vendor->notes) }}</textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Update Vendor</button>
                <a href="{{ route('vendors.show', $vendor) }}" class="btn btn-secondary">Back</a>
            </div>
        </form>

        <div class="danger-row">
            <form method="POST" action="{{ route('vendors.destroy', $vendor) }}" onsubmit="return confirm('Delete this vendor?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Vendor</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
