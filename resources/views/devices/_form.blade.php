<div class="grid">
    <div class="field">
        <label class="label">Company</label>
        <select name="company_id" class="select" required>
            <option value="">Select Company</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ old('company_id', $device->company_id ?? '') == $company->id ? 'selected' : '' }}>
                    {{ $company->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label class="label">Device Code</label>
        <input type="text" name="device_code" class="input" value="{{ old('device_code', $device->device_code ?? '') }}" required placeholder="e.g. DV-JKT-001">
    </div>

    <div class="field">
        <label class="label">Device Name</label>
        <input type="text" name="name" class="input" value="{{ old('name', $device->name ?? '') }}" required placeholder="e.g. Main Menu Board">
    </div>

    <div class="field">
        <label class="label">Category</label>
        <select name="category" class="select" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category }}" {{ old('category', $device->category ?? '') === $category ? 'selected' : '' }}>
                    {{ ucfirst($category) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label class="label">Brand</label>
        <input type="text" name="brand" class="input" value="{{ old('brand', $device->brand ?? '') }}" placeholder="Optional">
    </div>

    <div class="field">
        <label class="label">Model</label>
        <input type="text" name="model" class="input" value="{{ old('model', $device->model ?? '') }}" placeholder="Optional">
    </div>

    <div class="field">
        <label class="label">Serial Number</label>
        <input type="text" name="serial_number" class="input" value="{{ old('serial_number', $device->serial_number ?? '') }}" placeholder="Optional">
    </div>

    <div class="field">
        <label class="label">Status</label>
        <select name="status" class="select" required>
            @foreach($statuses as $status)
                <option value="{{ $status }}" {{ old('status', $device->status ?? 'active') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label class="label">Site / Branch</label>
        <input type="text" name="site" class="input" value="{{ old('site', $device->site ?? '') }}" placeholder="e.g. Sudirman Branch">
    </div>

    <div class="field">
        <label class="label">Location</label>
        <input type="text" name="location" class="input" value="{{ old('location', $device->location ?? '') }}" placeholder="e.g. Entrance Area">
    </div>

    
    <div class="field full">
        <label class="label">Device Photos</label>
        <div style="border:1.5px dashed #93c5fd; border-radius:18px; background:linear-gradient(180deg,#f8fbff 0%, #eef6ff 100%); padding:18px;">
            <input type="file" name="photos[]" class="input" multiple accept="image/*" style="background:#fff;">
            <div class="sub" style="margin-top:10px;">
                Upload one or more photos for visual reference. Supported: JPG, PNG, WEBP. Max 8 MB each.
            </div>
        </div>
    </div>

    <div class="field full">
        <label class="label">Notes</label>
        <textarea name="notes" class="textarea" placeholder="Optional notes about device condition, installation, or usage.">{{ old('notes', $device->notes ?? '') }}</textarea>
    </div>
</div>
