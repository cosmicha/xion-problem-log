<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Detail</title>

    <style>
        body {
            font-family: Inter, Arial, sans-serif;
            margin: 0;
            background: #f8fafc;
            color: #0f172a;
        }

        .page {
            max-width: 1000px;
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

        .hero h1 {
            margin: 0 0 8px;
        }

        .hero p {
            margin: 0;
            color: rgba(255,255,255,.84);
        }

        .actions {
            margin-top: 16px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: white;
            color: #0f172a;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(15,23,42,.06);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .field {
            padding: 16px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #fff;
        }

        .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .value {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.5;
            word-break: break-word;
        }

        .full {
            grid-column: 1 / -1;
        }

        .pill {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .pill-active {
            background: #dcfce7;
            color: #166534;
        }

        .pill-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>

<div class="page">
    <div class="hero">
        <h1>{{ $vendor->name }}</h1>
        <p>Vendor profile, support information, and service notes.</p>

        <div class="actions">
            @if((auth()->user()->role ?? null) === 'admin')
                <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-secondary">Edit Vendor</a>
            @endif
            <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Back to Vendor List</a>
        </div>
    </div>

    <div class="card">
        <div class="grid">
            <div class="field">
                <div class="label">Vendor Name</div>
                <div class="value">{{ $vendor->name ?: '-' }}</div>
            </div>

            <div class="field">
                <div class="label">Status</div>
                <div class="value">
                    @if($vendor->is_active ?? true)
                        <span class="pill pill-active">Active</span>
                    @else
                        <span class="pill pill-inactive">Inactive</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="label">Contact Person</div>
                <div class="value">{{ $vendor->contact ?: '-' }}</div>
            </div>

            <div class="field">
                <div class="label">Support Phone</div>
                <div class="value">{{ $vendor->support_phone ?: '-' }}</div>
            </div>

            <div class="field full">
                <div class="label">Notes</div>
                <div class="value">{{ $vendor->notes ?: '-' }}</div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
