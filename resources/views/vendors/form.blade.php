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

    <div class="section-title">Coverage & Scope</div>

    <div class="full">
        <label>Coverage Type List</label>
        <div class="inline">
            <select id="coverageSelect">
                <option value="">Select Coverage</option>
                <option>Screen & Panel</option>
                <option>Electrical</option>
                <option>Network</option>
                <option>Installation</option>
                <option>Maintenance</option>
                <option>Sparepart Replacement</option>
                <option>Onsite Support</option>
                <option>Custom</option>
            </select>
            <input id="customCoverage" type="text" placeholder="Custom coverage...">
            <button type="button" class="btn btn-primary" onclick="addCoverageType()">Add</button>
        </div>

        <input type="hidden" name="coverage_type" id="coverageTypeInput" value="{{ old('coverage_type', $vendor->coverage_type) }}">
        <div id="coverageList" class="chip-wrap"></div>
        <div class="hint">Coverage Type adalah grup besar vendor, misalnya Screen & Panel atau Network.</div>
    </div>

    <div class="full">
        <label>Scope of Work (SOW)</label>
        <textarea name="scope_of_work" rows="6" placeholder="Tuliskan scope vendor ini...">{{ old('scope_of_work', $vendor->scope_of_work) }}</textarea>
    </div>

    <div class="full">
        <label>Issue / Action Category</label>
        <div class="inline">
            <input type="text" id="newCategory" placeholder="Contoh: Screen replacement, PSU replacement, No display">
            <button type="button" class="btn btn-primary" onclick="addCategory()">Add</button>
        </div>

        <div id="categoryList" class="chip-wrap">
            @foreach(old('categories', $vendor->exists ? $vendor->issueCategories->pluck('name')->toArray() : []) as $cat)
                <div class="chip cat-item">
                    <input type="hidden" name="categories[]" value="{{ $cat }}">
                    <span>{{ $cat }}</span>
                    <button type="button" onclick="this.closest('.cat-item').remove()">x</button>
                </div>
            @endforeach
        </div>

        <div class="hint">Kategori ini akan muncul sebagai pilihan engineer saat escalate ticket ke vendor.</div>
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

function renderCoverageList() {
    const hidden = document.getElementById('coverageTypeInput');
    const list = document.getElementById('coverageList');
    if (!hidden || !list) return;

    list.innerHTML = '';

    const items = hidden.value.split(',').map(v => v.trim()).filter(Boolean);

    items.forEach((item, index) => {
        const div = document.createElement('div');
        div.className = 'chip';
        div.innerHTML = `<span>${escapeHtml(item)}</span><button type="button" onclick="removeCoverageType(${index})">x</button>`;
        list.appendChild(div);
    });
}

function addCoverageType() {
    const select = document.getElementById('coverageSelect');
    const custom = document.getElementById('customCoverage');
    const hidden = document.getElementById('coverageTypeInput');

    const value = (custom.value || select.value || '').trim();
    if (!value) return;

    let items = hidden.value.split(',').map(v => v.trim()).filter(Boolean);

    if (!items.includes(value)) {
        items.push(value);
    }

    hidden.value = items.join(', ');
    select.value = '';
    custom.value = '';

    renderCoverageList();
}

function removeCoverageType(index) {
    const hidden = document.getElementById('coverageTypeInput');
    let items = hidden.value.split(',').map(v => v.trim()).filter(Boolean);
    items.splice(index, 1);
    hidden.value = items.join(', ');
    renderCoverageList();
}

function addCategory() {
    const input = document.getElementById('newCategory');
    const value = input.value.trim();
    if (!value) return;

    const div = document.createElement('div');
    div.className = 'chip cat-item';
    div.innerHTML = `
        <input type="hidden" name="categories[]" value="${escapeHtml(value)}">
        <span>${escapeHtml(value)}</span>
        <button type="button" onclick="this.closest('.cat-item').remove()">x</button>
    `;

    document.getElementById('categoryList').appendChild(div);
    input.value = '';
}

document.addEventListener('DOMContentLoaded', renderCoverageList);
</script>
