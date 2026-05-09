<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $vendor->name }}</title>
    <style>
        body{margin:0;font-family:Inter,system-ui,sans-serif;background:#f1f5f9;color:#0f172a}
        .page{max-width:1000px;margin:0 auto;padding:34px}
        .card{background:white;border-radius:28px;padding:30px;box-shadow:0 16px 50px rgba(15,23,42,.08)}
        h1{margin:0 0 8px;font-size:34px}
        h2{margin-top:28px}
        .row{display:grid;grid-template-columns:220px 1fr;border-bottom:1px solid #e2e8f0;padding:12px 0}
        .label{font-weight:900;color:#64748b}
        .btn{display:inline-flex;align-items:center;justify-content:center;min-height:42px;padding:0 14px;border-radius:12px;border:0;background:#3158d4;color:white;text-decoration:none;font-weight:900;margin-top:18px}
        .btn.gray{background:#64748b}
        .chips{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}
        .chip{background:#e0f2fe;color:#075985;border-radius:999px;padding:8px 12px;font-weight:800;font-size:13px}
        .box{background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:16px;line-height:1.65}
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        <h1>{{ $vendor->name }}</h1>
        <p>{{ $vendor->category ?: 'Vendor' }}</p>

        <div class="row"><div class="label">Code</div><div>{{ $vendor->code ?: '-' }}</div></div>
        <div class="row"><div class="label">Status</div><div>{{ ucfirst($vendor->status ?: '-') }}</div></div>
        <div class="row"><div class="label">Contact Person</div><div>{{ $vendor->contact_person ?: '-' }}</div></div>
        <div class="row"><div class="label">Email</div><div>{{ $vendor->email ?: '-' }}</div></div>
        <div class="row"><div class="label">Phone</div><div>{{ $vendor->phone ?: '-' }}</div></div>
        <div class="row"><div class="label">Telegram Chat ID</div><div>{{ $vendor->telegram_chat_id ?: '-' }}</div></div>
        <div class="row"><div class="label">Coverage Type</div><div>{{ $vendor->coverage_type ?: '-' }}</div></div>
        <div class="row"><div class="label">Address</div><div>{{ $vendor->address ?: '-' }}</div></div>
        <div class="row"><div class="label">Notes</div><div>{{ $vendor->notes ?: '-' }}</div></div>

        <h2>Scope of Work</h2>
        <div class="box">{!! nl2br(e($vendor->scope_of_work ?: '-')) !!}</div>

        <h2>Issue Categories Covered</h2>
        <div class="chips">
            @forelse($vendor->issueCategories as $cat)
                <span class="chip">{{ $cat->name }}</span>
            @empty
                <span>-</span>
            @endforelse
        </div>

        <a class="btn" href="{{ route('vendors.edit', $vendor) }}">Edit</a>
        <a class="btn gray" href="{{ route('vendors.index') }}">Back</a>
    </div>
</div>

@include('partials.attachments-gallery', [
    'uploadType' => 'vendor',
    'attachableType' => \App\Models\Vendor::class,
    'attachableId' => $vendor->id,
])

</body>
</html>
