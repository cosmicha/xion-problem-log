<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vendor</title>

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
        }

        textarea {
            min-height: 100px;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #0f172a;
        }
    </style>
</head>
<body>

<div class="page">

    <div class="hero">
        <h2 style="margin:0;">Add Vendor</h2>
        <p style="margin:6px 0 0; opacity:.85;">
            Register vendor support and service contact.
        </p>
    </div>

    
    <div style="margin-bottom:16px; display:flex; gap:12px; flex-wrap:wrap;">
        <a href="/vendors" class="btn btn-secondary">Back to Vendors</a>
        <a href="/devices" class="btn btn-secondary">Devices</a>
        <a href="/problem-logs" class="btn btn-secondary">Tickets</a>
        <a href="/" class="btn btn-secondary">Dashboard</a>
    </div>


    <div class="card">

        <form method="POST" action="{{ route('vendors.store') }}">
            @csrf

            <div class="form-group">
                <label>Vendor Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Contact Person</label>
                <input type="text" name="contact">
            </div>

            <div class="form-group">
                <label>Support Phone</label>
                <input type="text" name="support_phone">
            </div>

            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes"></textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Save Vendor</button>
                <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Back</a>
            </div>

        </form>

    </div>

</div>

</body>
</html>
