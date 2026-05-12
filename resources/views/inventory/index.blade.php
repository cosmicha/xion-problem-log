<!DOCTYPE html>
<html>
<head>
    <title>Inventory & Device Movement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    *{box-sizing:border-box}
    body{
        margin:0;
        font-family:Inter,Arial,sans-serif;
        background:
            radial-gradient(circle at top left,rgba(37,99,235,.18),transparent 28%),
            linear-gradient(180deg,#eef4ff 0%,#f8fafc 48%,#eef2f7 100%);
        color:#0f172a;
    }
    .page{padding:28px;max-width:1680px;margin:0 auto}
    .hero{
        background:linear-gradient(135deg,#07132f 0%,#17337d 48%,#2563eb 100%);
        color:white;
        padding:34px;
        border-radius:30px;
        box-shadow:0 28px 80px rgba(15,23,42,.26);
        position:relative;
        overflow:hidden;
    }
    .hero:after{
        content:"";
        position:absolute;
        width:420px;height:420px;
        right:-140px;top:-170px;
        border-radius:999px;
        background:rgba(255,255,255,.12);
    }
    .hero h1{margin:0;font-size:38px;letter-spacing:-.035em}
    .hero p{color:#dbeafe;margin:10px 0 0;font-size:16px}
    .actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:22px;position:relative;z-index:2}
    .btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border:0;
        border-radius:14px;
        padding:11px 16px;
        background:#2563eb;
        color:white;
        font-weight:900;
        text-decoration:none;
        cursor:pointer;
        box-shadow:0 12px 28px rgba(37,99,235,.22);
        white-space:nowrap;
    }
    .btn.secondary{
        background:rgba(255,255,255,.14);
        border:1px solid rgba(255,255,255,.22);
        box-shadow:none;
    }
    .btn.danger{
        background:#fee2e2;
        color:#991b1b;
        box-shadow:none;
    }
    .grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-top:20px}
    .card{
        background:rgba(255,255,255,.94);
        border:1px solid #dbe4f0;
        border-radius:24px;
        padding:22px;
        box-shadow:0 16px 44px rgba(15,23,42,.08);
        overflow:visible;
    }
    .label{font-size:12px;text-transform:uppercase;letter-spacing:.09em;color:#64748b;font-weight:950}
    .value{font-size:36px;font-weight:950;margin-top:6px;letter-spacing:-.04em}
    .section{margin-top:22px}
    .section-grid{display:grid;grid-template-columns:1fr;gap:18px;margin-top:22px}
    input,select,textarea{
        width:100%;
        max-width:100%;
        padding:11px 12px;
        border:1px solid #cbd5e1;
        border-radius:13px;
        font-weight:700;
        background:#fff;
        color:#0f172a;
    }
    textarea{min-height:84px;resize:vertical}
    .form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
    .table-wrap{
        width:100%;
        overflow-x:auto;
        overflow-y:hidden;
        border:1px solid #e2e8f0;
        border-radius:18px;
        background:white;
    }
    table{
        width:100%;
        min-width:980px;
        border-collapse:collapse;
        table-layout:auto;
    }
    th,td{
        padding:12px;
        border-bottom:1px solid #e2e8f0;
        text-align:left;
        font-size:14px;
        vertical-align:middle;
    }
    th{
        font-size:12px;
        text-transform:uppercase;
        letter-spacing:.08em;
        color:#64748b;
        background:#f8fafc;
        font-weight:950;
    }
    td input,td select{
        min-width:160px!important;
        width:100%!important;
        padding:9px 10px;
        border-radius:11px;
    }
    .badge{
        display:inline-flex;
        padding:6px 10px;
        border-radius:999px;
        background:#eff6ff;
        color:#1d4ed8;
        font-weight:900;
        font-size:12px;
        white-space:nowrap;
    }
    .low{background:#fee2e2;color:#991b1b}
    .action-cell{
        display:flex;
        gap:8px;
        align-items:center;
        flex-wrap:nowrap;
        white-space:nowrap;
    }
    .small-btn{
        border:0;
        border-radius:12px;
        padding:8px 12px;
        font-weight:900;
        cursor:pointer;
        font-size:13px;
    }
    .save-btn{background:#2563eb;color:white}
    .delete-btn{background:#fee2e2;color:#991b1b}
    h2{margin:0 0 16px;font-size:22px;letter-spacing:-.02em}
    tr:hover td{background:#f8fafc}
    @media(max-width:1100px){
        .grid{grid-template-columns:repeat(2,1fr)}
        .section-grid{grid-template-columns:1fr}
        .form-grid{grid-template-columns:1fr}
    }
    @media(max-width:720px){
        .page{padding:14px}
        .hero{padding:24px;border-radius:24px}
        .hero h1{font-size:28px}
        .grid{grid-template-columns:1fr}
    }
</style>
</head>
<body>
<div class="page">
    <div class="hero">
        <h1>Inventory & Device Movement</h1>
        <p>Track spare parts, device locations, warehouse movement, vendor custody, and customer site placement.</p>
        <div class="actions">
            <a href="/problem-logs" class="btn secondary">← Back to Dashboard</a>
            <a href="/devices" class="btn secondary">Devices</a>
            <a href="/vendors" class="btn secondary">Vendors</a>
<a href="{{ route('inventory.export') }}" class="btn">Export CSV</a>
        </div>
    </div>

    @if(session('error'))
        <div class="card" style="margin-top:18px;border-color:#fecaca;color:#991b1b;font-weight:900;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="card" style="margin-top:18px;border-color:#86efac;color:#166534;font-weight:900;">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid">
        <div class="card"><div class="label">Locations</div><div class="value">{{ $locations->count() }}</div></div>
        <div class="card"><div class="label">Spare Parts</div><div class="value">{{ $spareParts->count() }}</div></div>
        <div class="card"><div class="label">Total Stock</div><div class="value">{{ $spareParts->sum('stock_qty') }}</div></div>
        <div class="card"><div class="label">Low Stock</div><div class="value">{{ $spareParts->filter(fn($p)=>$p->stock_qty <= $p->minimum_stock)->count() }}</div></div>
    </div>

    
    <div class="card section">
        <h2>Spare Part Stock Movement</h2>
        <form method="POST" action="{{ route('inventory.spare-parts.move') }}">
            @csrf
            <div class="form-grid" style="grid-template-columns:2fr 1fr 1fr 2fr;">
                <select name="spare_part_id" required>
                    <option value="">Select Spare Part</option>
                    @foreach($spareParts as $part)
                        <option value="{{ $part->id }}">{{ $part->sku ?: '-' }} - {{ $part->name }} (Stock: {{ $part->stock_qty }})</option>
                    @endforeach
                </select>

                <select name="movement_type" required>
                    <option value="in">Stock In</option>
                    <option value="out">Stock Out</option>
                    <option value="adjustment">Adjustment</option>
                    <option value="return">Return</option>
                    <option value="damaged">Damaged</option>
                </select>

                <input type="number" name="qty" value="1" min="1" required>

                <select name="to_location_id">
                    <option value="">To Location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }} ({{ $location->type }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-top:12px;">
                <textarea name="note" placeholder="Movement note"></textarea>
            </div>

            <div style="margin-top:12px;">
                <button class="btn" type="submit">Record Stock Movement</button>
            </div>
        </form>
    </div>


    <div class="section-grid">
        <div class="card">
            <h2>Create Location</h2>
            <form method="POST" action="{{ route('inventory.locations.store') }}">
                @csrf
                <div class="form-grid">
                    <select name="type">
                        <option value="">Location Type</option>
                        <option value="xion1">Xion1 Warehouse</option>
                        <option value="vendor">Vendor Warehouse</option>
                        <option value="customer">Customer Location</option>
                        <option value="customer_consignment">Customer Consignment</option>
                        <option value="transit">In Transit</option>
                        <option value="repair">In Repair</option>
                    </select>
                    <input name="name" placeholder="Location Name" required>
                </div>
                <div style="margin-top:12px;"><textarea name="address" placeholder="Address"></textarea></div>
                <div style="margin-top:12px;"><textarea name="notes" placeholder="Notes"></textarea></div>
                <div style="margin-top:12px;"><button class="btn" type="submit">Add Location</button></div>
            </form>
        </div>

        <div class="card">
            <h2>Add Spare Part</h2>
            <form method="POST" action="{{ route('inventory.spare-parts.store') }}">
                @csrf
                <div class="form-grid">
                    <input name="sku" placeholder="SKU">
                    <input name="name" placeholder="Part Name" required>
                    <input name="category" placeholder="Category">
                    <input name="brand" placeholder="Brand">
                    <select name="location_id">
                        <option value="">Location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    <input name="stock_qty" type="number" placeholder="Stock Qty" value="0">
                    <input name="minimum_stock" type="number" placeholder="Minimum Stock" value="0">
                    <input name="unit_cost" type="number" placeholder="Unit Cost">
                </div>
                <div style="margin-top:12px;"><textarea name="notes" placeholder="Notes"></textarea></div>
                <div style="margin-top:12px;"><button class="btn" type="submit">Add Spare Part</button></div>
            </form>
        </div>
    </div>

    <div class="card section">
        <h2>Move Device</h2>
        <form method="POST" action="{{ route('inventory.devices.move') }}">
            @csrf
            <div class="form-grid" style="grid-template-columns:2fr 2fr 1fr;">
                <select name="device_id" required>
                    <option value="">Select Device</option>
                    @foreach($devices as $device)
                        <option value="{{ $device->id }}">
                            {{ $device->device_code ?? '-' }} - {{ $device->name ?? '-' }}
                        </option>
                    @endforeach
                </select>

                <select name="to_location_id" required>
                    <option value="">Move To Location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }} ({{ $location->type }})</option>
                    @endforeach
                </select>

                <select name="movement_type">
                    <option value="transfer">Transfer</option>
                    <option value="install">Install</option>
                    <option value="repair">Repair</option>
                    <option value="return">Return</option>
                    <option value="lost">Lost</option>
                    <option value="damaged">Damaged</option>
                </select>
            </div>
            <div style="margin-top:12px;"><textarea name="note" placeholder="Movement note"></textarea></div>
            <div style="margin-top:12px;"><button class="btn" type="submit">Record Device Movement</button></div>
        </form>
    </div>

    <div class="section-grid">
        <div class="card">
            <h2>Spare Parts</h2>
            <div class="table-wrap"><table>
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($spareParts as $part)
                    <tr>
                        <form method="POST" action="{{ route('inventory.spare-parts.update', $part) }}">
                            @csrf
                            @method('PUT')

                            <td>
                                <input name="sku" value="{{ $part->sku }}" style="min-width:110px;">
                            </td>

                            <td>
                                <input name="name" value="{{ $part->name }}" required style="min-width:180px;">
                                <input type="hidden" name="category" value="{{ $part->category }}">
                                <input type="hidden" name="brand" value="{{ $part->brand }}">
                                <input type="hidden" name="minimum_stock" value="{{ $part->minimum_stock }}">
                                <input type="hidden" name="unit_cost" value="{{ $part->unit_cost }}">
                                <input type="hidden" name="status" value="{{ $part->status }}">
                                <input type="hidden" name="notes" value="{{ $part->notes }}">
                            </td>

                            <td>
                                <select name="location_id" style="min-width:180px;">
                                    <option value="">No Location</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" @selected($part->location_id == $location->id)>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <span class="badge {{ $part->stock_qty <= $part->minimum_stock ? 'low' : '' }}">
                                    {{ $part->stock_qty }}
                                </span>
                            </td>

                            <td><div class="action-cell">
                                <button class="small-btn save-btn" type="submit">Save</button>
                        </form>

                                <form method="POST"
                                      action="{{ route('inventory.spare-parts.delete', $part) }}"
                                      style="display:inline;"
                                      onsubmit="return confirm('Delete this spare part?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="small-btn delete-btn">
                                        Delete
                                    </button>
                                </form>
                            </div></td>
                    </tr>
                @endforeach
                </tbody>
            </table></div>
        </div>

        <div class="card">
            <h2>Locations</h2>
            <div class="table-wrap"><table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($locations as $location)
                    <tr>
                        <form method="POST" action="{{ route('inventory.locations.update', $location) }}">
                            @csrf
                            @method('PUT')

                            <td>
                                <select name="type" style="min-width:170px;">
                                    @foreach([
                                        'xion1' => 'Xion1 Warehouse',
                                        'vendor' => 'Vendor Warehouse',
                                        'customer' => 'Customer Location',
                                        'customer_consignment' => 'Customer Consignment',
                                        'transit' => 'In Transit',
                                        'repair' => 'In Repair',
                                    ] as $key => $label)
                                        <option value="{{ $key }}" @selected($location->type === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input name="name" value="{{ $location->name }}" required style="min-width:180px;">
                                <input type="hidden" name="address" value="{{ $location->address }}">
                            </td>

                            <td>
                                <input name="notes" value="{{ $location->notes }}" style="min-width:220px;">
                            </td>

                            <td><div class="action-cell">
                                <button class="small-btn save-btn" type="submit">Save</button>
                        </form>

                                <form method="POST"
                                      action="{{ route('inventory.locations.delete', $location) }}"
                                      style="display:inline;"
                                      onsubmit="return confirm('Delete this location?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="small-btn delete-btn">
                                        Delete
                                    </button>
                                </form>
                            </div></td>
                    </tr>
                @endforeach
                </tbody>
            </table></div>
        </div>
    </div>

    <div class="card section">
        <h2>Recent Device Movements</h2>
        <div class="table-wrap"><table>
            <thead>
                <tr><th>Date</th><th>Device</th><th>From</th><th>To</th><th>Type</th><th>Note</th></tr>
            </thead>
            <tbody>
            @foreach($movements as $movement)
                <tr>
                    <td>{{ $movement->created_at }}</td>
                    <td>{{ optional($movement->device)->device_code ?? $movement->device_id }}</td>
                    <td>{{ optional($movement->fromLocation)->name ?? '-' }}</td>
                    <td>{{ optional($movement->toLocation)->name ?? '-' }}</td>
                    <td><span class="badge">{{ $movement->movement_type }}</span></td>
                    <td>{{ $movement->note ?: '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table></div>
    </div>
</div>
</body>
</html>
