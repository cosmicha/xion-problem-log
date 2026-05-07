<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Vendor</title>
    <style>
        *{box-sizing:border-box} body{margin:0;font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:linear-gradient(135deg,#071737,#0d255f 45%,#173a88);color:#0f172a}
        .page{max-width:1180px;margin:0 auto;padding:38px}
        .hero{background:linear-gradient(135deg,#10245f,#2f5df3);color:white;border-radius:30px;padding:34px 38px;margin-bottom:26px;box-shadow:0 24px 70px rgba(0,0,0,.24)}
        .hero-kicker{font-size:13px;font-weight:900;letter-spacing:.16em;text-transform:uppercase;opacity:.75}
        h1{font-size:42px;line-height:1.05;margin:10px 0 10px}.hero p{margin:0;color:#dbeafe;font-size:17px}
        .card{background:rgba(255,255,255,.96);border:1px solid rgba(203,213,225,.9);border-radius:30px;padding:32px;box-shadow:0 26px 70px rgba(15,23,42,.22)}
        .grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}.full{grid-column:1/-1}
        label{display:block;font-size:13px;font-weight:900;color:#475569;text-transform:uppercase;letter-spacing:.04em;margin-bottom:8px}
        input,select,textarea{width:100%;border:1px solid #cbd5e1;border-radius:16px;background:#fff;padding:14px 16px;font-size:16px;color:#0f172a;outline:none;transition:.18s}
        input:focus,select:focus,textarea:focus{border-color:#3b82f6;box-shadow:0 0 0 4px rgba(59,130,246,.14)}
        textarea{resize:vertical;min-height:120px}.hint{font-size:13px;color:#64748b;margin-top:8px;line-height:1.5}
        .section-title{grid-column:1/-1;margin-top:8px;padding-top:18px;border-top:1px solid #e2e8f0;font-size:18px;font-weight:950;color:#0f172a}
        .inline{display:flex;gap:10px}.inline input,.inline select{flex:1}
        .btn{border:0;border-radius:16px;padding:14px 20px;font-weight:950;font-size:15px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:8px}
        .btn-primary{background:linear-gradient(135deg,#2563eb,#3b82f6);color:white;box-shadow:0 14px 30px rgba(37,99,235,.28)}
        .btn-secondary{background:#e2e8f0;color:#334155}.btn-danger{background:#dc2626;color:white}
        .actions{display:flex;justify-content:space-between;align-items:center;margin-top:28px;gap:12px;flex-wrap:wrap}
        .chip-wrap{display:flex;flex-wrap:wrap;gap:10px;margin-top:14px}
        .chip{display:inline-flex;align-items:center;gap:8px;background:#eef2ff;color:#1e3a8a;border:1px solid #c7d2fe;border-radius:999px;padding:9px 12px;font-weight:900}
        .chip button{border:0;background:#dc2626;color:white;border-radius:999px;padding:4px 8px;font-weight:900;cursor:pointer}
        @media(max-width:800px){.grid{grid-template-columns:1fr}.page{padding:18px}h1{font-size:32px}}
    </style>
</head>
<body>
<div class="page">
    <div class="hero">
        <div class="hero-kicker">Vendor Management</div>
        <h1>Edit Vendor</h1>
        <p>{{ $vendor->name }} — update scope, coverage, issue/action category, and Telegram escalation destination.</p>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('vendors.update', $vendor) }}">
            @method('PUT')
            @include('vendors.form')
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('vendors.index') }}">← Back to Vendors</a>
                <button class="btn btn-primary" type="submit">Update Vendor</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
