<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Master</title>

    <style>
        body {
            font-family: Inter, Arial, sans-serif;
            margin: 0;
            background: #f8fafc;
            color: #0f172a;
        }

        .page {
            max-width: 1200px;
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
            padding: 20px;
            box-shadow: 0 10px 30px rgba(15,23,42,.06);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            vertical-align: top;
        }

        th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
        }

        .muted {
            color: #64748b;
            font-size: 13px;
        }

        .link-btn {
            color: #2563eb;
            text-decoration: none;
            font-weight: 700;
            margin-right: 10px;
        }

        .success {
            margin-bottom: 14px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #dcfce7;
            color: #166534;
            font-weight: 700;
        }

        .vendor-name {
            font-weight: 800;
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
        <h1 style="margin:0 0 8px;">Vendor Master</h1>
        <p style="margin:0; color:rgba(255,255,255,.84);">
            Manage vendor support, warranty contacts, and service references.
        </p>

        <div class="actions">
            @if((auth()->user()->role ?? null) === 'admin')
                <a href="{{ route('vendors.create') }}" class="btn btn-secondary">Add Vendor</a>
            @endif
            <a href="{{ url('/devices') }}" class="btn btn-secondary">Devices</a>
            <a href="{{ url('/problem-logs') }}" class="btn btn-secondary">Tickets</a>
        </div>
    </div>

    <div class="card">

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
            <tr>
                <th>Vendor</th>
                <th>Contact</th>
                <th>Support</th>
                <th>Status</th>
                <th style="width:200px;">Action</th>
            </tr>
            </thead>

            <tbody>
            @forelse($vendors as $vendor)
                <tr>
                    <td>
                        <div class="vendor-name">{{ $vendor->name }}</div>
                        <div class="muted">{{ $vendor->notes ?? '-' }}</div>
                    </td>

                    <td>{{ $vendor->contact ?? '-' }}</td>

                    <td>{{ $vendor->support_phone ?? '-' }}</td>

                    <td>
                        @if($vendor->is_active ?? true)
                            <span class="pill pill-active">Active</span>
                        @else
                            <span class="pill pill-inactive">Inactive</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('vendors.show', $vendor) }}" class="link-btn">View</a>

                        @if((auth()->user()->role ?? null) === 'admin')
                            <a href="{{ route('vendors.edit', $vendor) }}" class="link-btn">Edit</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="muted" style="padding:24px 0;">
                        No vendors found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

</div>

</body>
</html>
