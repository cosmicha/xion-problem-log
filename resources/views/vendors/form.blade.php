@csrf

<div class="grid">
    <div class="section-title">Basic Information</div>

    <div>
        <label>Vendor Name</label>
        <input type="text" name="name" value="{{ old('name', $vendor->name) }}" required>
    </div>

    <div>
        <label>Vendor Code</label>
        <input type="text" name="code" value="{{ old('code', $vendor->code) }}" placeholder="Auto if empty">
    </div>

    <div>
        <label>Contact Person</label>
        <input type="text" name="contact_person" value="{{ old('contact_person', $vendor->contact_person) }}">
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $vendor->email) }}">
    </div>

    <div>
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $vendor->phone) }}">
    </div>

    <div>
        <label>Status</label>
        <select name="status">
            <option value="active" {{ old('status', $vendor->status ?: 'active') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $vendor->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <div class="section-title">SOW / Escalation Scope</div>

    <div class="full">
        <label>SOW / Action List</label>

        <div class="inline">
            <select id="presetScope">
                <option value="">Select Scope</option>
                <option>Screen & Panel</option>
                <option>Electrical</option>
                <option>Network</option>
                <option>Installation</option>
                <option>Maintenance</option>
                <option>Sparepart Replacement</option>
                <option>Onsite Support</option>
                <option>Screen Replacement</option>
                <option>PSU Replacement</option>
                <option>No Display / Blank Screen</option>
                <option>Power Failure / Unit Not Turning On</option>
                <option>HDMI / Port Issue</option>
                <option>Network Issue</option>
                <option>Onsite Troubleshooting</option>
            </select>

            <input id="customScope" type="text" placeholder="Custom SOW/action...">

            <button type="button" class="btn btn-primary" onclick="addScopeItem()">Add</button>
        </div>

        <input type="hidden" name="coverage_type" id="coverageTypeInput" value="{{ old('coverage_type', $vendor->coverage_type) }}">
        <input type="hidden" name="scope_of_work" id="scopeOfWorkInput" value="{{ old('scope_of_work', $vendor->scope_of_work) }}">

        <div id="scopeList" class="chip-wrap">
            @php
                $items = old('categories');

                if (!$items && $vendor->exists) {
                    $items = $vendor->issueCategories->pluck('name')->toArray();

                    if (empty($items) && $vendor->coverage_type) {
                        $items = collect(explode(',', $vendor->coverage_type))
                            ->map(fn($v) => trim($v))
                            ->filter()
                            ->values()
                            ->toArray();
                    }
                }

                $items = $items ?? [];
            @endphp

            @foreach($items as $item)
                <div class="chip scope-item">
                    <input type="hidden" name="categories[]" value="{{ $item }}">
                    <span>{{ $item }}</span>
                    <button type="button" onclick="removeScopeItem(this)">x</button>
                </div>
            @endforeach
        </div>

        <div class="hint">
            This list is the single source for vendor SOW and engineer escalation dropdown.
        </div>
    </div>

    <div class="section-title">Communication</div>

    <div>
        <label>Telegram Chat ID</label>
        <input type="text" name="telegram_chat_id" value="{{ old('telegram_chat_id', $vendor->telegram_chat_id) }}">
    </div>

    <div>
        <label>Category / Vendor Type</label>
        <input type="text" name="category" value="{{ old('category', $vendor->category) }}" placeholder="Hardware, Network, Principal">
    </div>

    <div class="full">
        <label>Address</label>
        <textarea name="address" rows="3">{{ old('address', $vendor->address) }}</textarea>
    </div>

    <div class="full">
        <label>Notes</label>
        <textarea name="notes" rows="4">{{ old('notes', $vendor->notes) }}</textarea>
    </div>
</div>

<script>
function escapeHtml(value) {
    return value.replace(/[&<>"']/g, function (m) {
        return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'})[m];
    });
}

function getScopeItems() {
    return [...document.querySelectorAll('input[name="categories[]"]')]
        .map(input => input.value.trim())
        .filter(Boolean);
}

function syncScopeFields() {
    const items = getScopeItems();

    document.getElementById('coverageTypeInput').value = items.join(', ');
    document.getElementById('scopeOfWorkInput').value = items.join("\n");
}

function addScopeItem() {
    const preset = document.getElementById('presetScope');
    const custom = document.getElementById('customScope');

    const value = (custom.value || preset.value || '').trim();
    if (!value) return;

    const existing = getScopeItems();

    if (existing.includes(value)) {
        preset.value = '';
        custom.value = '';
        return;
    }

    const div = document.createElement('div');
    div.className = 'chip scope-item';
    div.innerHTML = `
        <input type="hidden" name="categories[]" value="${escapeHtml(value)}">
        <span>${escapeHtml(value)}</span>
        <button type="button" onclick="removeScopeItem(this)">x</button>
    `;

    document.getElementById('scopeList').appendChild(div);

    preset.value = '';
    custom.value = '';

    syncScopeFields();
}

function removeScopeItem(button) {
    button.closest('.scope-item').remove();
    syncScopeFields();
}

document.addEventListener('DOMContentLoaded', function () {
    syncScopeFields();

    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', syncScopeFields);
    }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const scopeInput = document.getElementById('scopeOfWorkInput');
    const coverageInput = document.getElementById('coverageTypeInput');

    function syncVendorChips() {
        const chips = Array.from(document.querySelectorAll('[data-scope-chip], .scope-chip, .sow-chip, .coverage-chip'))
            .map(el => el.textContent.replace('×', '').trim())
            .filter(Boolean);

        if (scopeInput && chips.length) {
            scopeInput.value = chips.join(', ');
        }

        if (coverageInput && chips.length) {
            coverageInput.value = chips.join(', ');
        }
    }

    if (form) {
        form.addEventListener('submit', function () {
            syncVendorChips();
        });
    }
});
</script>
