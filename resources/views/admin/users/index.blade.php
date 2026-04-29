<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), transparent 30%),
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 30%),
                linear-gradient(180deg, #081120 0%, #0d1728 42%, #f4f7fb 42%, #f4f7fb 100%);
            color: #0f172a;
        }

        .page {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 16px 60px;
        }

        .hero {
            color: white;
            padding: 30px 32px 38px;
            border-radius: 28px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(29, 78, 216, 0.88));
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.28);
            margin-bottom: 28px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.82);
            margin-bottom: 14px;
        }

        .brand-mark {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #60a5fa, #22d3ee);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: #081120;
            box-shadow: 0 0 20px rgba(96,165,250,0.45);
            font-size: 15px;
        }

        .hero h1 {
            margin: 0 0 10px;
            font-size: 34px;
            line-height: 1.1;
        }

        .hero p {
            margin: 0;
            color: rgba(255,255,255,0.82);
            max-width: 780px;
            font-size: 15px;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background: rgba(255,255,255,0.10);
            color: white;
            border: 1px solid rgba(255,255,255,0.16);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35);
        }

        .btn-success {
            background: #16a34a;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-ghost {
            background: #eef2ff;
            color: #1e40af;
        }

        .success-msg {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            background: #ecfdf5;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-weight: 700;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .kpi-card {
            background: rgba(255,255,255,0.94);
            border-radius: 22px;
            padding: 22px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
            position: relative;
            overflow: hidden;
        }

        .kpi-card::after {
            content: "";
            position: absolute;
            right: -20px;
            top: -20px;
            width: 90px;
            height: 90px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(59,130,246,.16), rgba(34,211,238,.12));
        }

        .kpi-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 800;
            position: relative;
            z-index: 1;
        }

        .kpi-value {
            font-size: 32px;
            font-weight: 900;
            color: #0f172a;
            position: relative;
            z-index: 1;
        }

        .toolbar-shell {
            position: sticky;
            top: 12px;
            z-index: 20;
            margin-bottom: 18px;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            padding: 16px;
            background: rgba(255,255,255,0.82);
            backdrop-filter: blur(14px);
            border-radius: 20px;
            border: 1px solid rgba(148, 163, 184, 0.22);
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        }

        .toolbar-left {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .toolbar-right {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .input, .select {
            min-width: 190px;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: white;
            font-size: 14px;
            color: #0f172a;
            outline: none;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 999px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
            color: #1e3a8a;
            font-size: 13px;
            font-weight: 800;
        }

        .users-wrap {
            display: grid;
            gap: 16px;
        }

        .user-card {
            background: rgba(255,255,255,0.94);
            border-radius: 24px;
            padding: 20px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 56px rgba(15, 23, 42, 0.12);
        }

        .user-top {
            display: grid;
            grid-template-columns: 82px 1.1fr 0.9fr;
            gap: 18px;
            align-items: start;
        }

        .avatar-wrap {
            position: relative;
            width: 82px;
            height: 82px;
        }

        .avatar {
            width: 82px;
            height: 82px;
            border-radius: 22px;
            background: linear-gradient(135deg, #60a5fa, #22d3ee);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #081120;
            font-weight: 900;
            font-size: 24px;
            box-shadow: 0 12px 24px rgba(2, 6, 23, 0.18);
        }

        .company-logo-mini {
            position: absolute;
            right: -8px;
            bottom: -8px;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            object-fit: cover;
            background: white;
            border: 2px solid white;
            box-shadow: 0 8px 18px rgba(15,23,42,.18);
        }

        .company-logo-fallback {
            position: absolute;
            right: -8px;
            bottom: -8px;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 900;
            color: #1e3a8a;
            background: #e0f2fe;
            border: 2px solid white;
            box-shadow: 0 8px 18px rgba(15,23,42,.18);
        }

        .user-name {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .user-email {
            color: #475569;
            font-size: 14px;
            line-height: 1.7;
            word-break: break-word;
        }

        .badge-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 12px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .badge-role-admin { background: #dbeafe; color: #1d4ed8; }
        .badge-role-engineer { background: #fef3c7; color: #b45309; }
        .badge-role-customer { background: #ede9fe; color: #6d28d9; }
        .badge-ok { background: #dcfce7; color: #15803d; }
        .badge-wait { background: #fee2e2; color: #b91c1c; }

        .meta-panel {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .meta-box {
            padding: 14px;
            border-radius: 16px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
        }

        .meta-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            margin-bottom: 6px;
            font-weight: 800;
        }

        .meta-value {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.5;
            word-break: break-word;
        }

        .edit-toggle-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 14px;
        }

        .edit-form {
            display: none;
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid #e2e8f0;
        }

        .edit-form.open {
            display: block;
        }

        .edit-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 14px;
        }

        .check-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 14px;
        }

        .action-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .action-left, .action-right {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .empty-state {
            background: rgba(255,255,255,0.94);
            border-radius: 24px;
            padding: 28px;
            text-align: center;
            color: #64748b;
            border: 1px dashed #cbd5e1;
        }

        @media (max-width: 1100px) {
            .user-top {
                grid-template-columns: 82px 1fr;
            }

            .meta-panel {
                grid-column: 1 / -1;
            }

            .edit-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 780px) {
            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .user-top {
                grid-template-columns: 1fr;
            }

            .edit-grid {
                grid-template-columns: 1fr;
            }

            .meta-panel {
                grid-template-columns: 1fr;
            }

            .input, .select {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">UM</span>
                        USER MANAGEMENT
                    </div>
                    <h1>Admin Users</h1>
                    <p>Manage user approval, roles, company assignments, and password resets in a cleaner and easier operational view.</p>
                </div>

                <div class="hero-actions">
                    <a href="/admin/companies/settings" class="btn btn-primary">Company Settings</a>
                    <a href="/problem-logs" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-label">Total Users</div>
                <div class="kpi-value" id="kpiTotal">{{ $users->count() }}</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-label">Pending Approval</div>
                <div class="kpi-value" id="kpiPending">{{ $users->filter(fn($u) => !($u->is_approved ?? false))->count() }}</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-label">Active Users</div>
                <div class="kpi-value" id="kpiActive">{{ $users->filter(fn($u) => ($u->is_approved ?? false))->count() }}</div>
            </div>
        </div>

        <div class="toolbar-shell">
            <div class="toolbar">
                <div class="toolbar-left">
                    <input id="searchUser" class="input" type="text" placeholder="Search name or email">
                    <select id="filterRole" class="select">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="engineer">Engineer</option>
                        <option value="customer">Customer</option>
                        <option value="user">User</option>
                    </select>
                    <select id="filterApproval" class="select">
                        <option value="">All Status</option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>

                <div class="toolbar-right">
                    <span class="chip">Visible Users: <span id="visibleCount">{{ $users->count() }}</span></span>
                    <button type="button" class="btn btn-ghost" id="collapseAllBtn">Collapse All</button>
                </div>
            </div>
        </div>

        <div class="users-wrap" id="usersWrap">
            @forelse($users as $user)
                @php
                    $role = strtolower($user->role ?? 'user');
                    $approved = (bool) ($user->is_approved ?? false);
                    $companyName = optional($user->company)->name ?? '-';
                    $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
                @endphp

                <div class="user-card"
                     data-name="{{ strtolower($user->name ?? '') }}"
                     data-email="{{ strtolower($user->email ?? '') }}"
                     data-role="{{ $role }}"
                     data-approved="{{ $approved ? 'approved' : 'pending' }}">

                    <div class="user-top">
                        <div class="avatar-wrap">
                            <div class="avatar">{{ $initials }}</div>

                            @if(optional($user->company)->logo_path)
                                <img src="{{ url('/storage/' . $user->company->logo_path) }}" alt="{{ $companyName }}" class="company-logo-mini">
                            @elseif($companyName !== '-')
                                <div class="company-logo-fallback">{{ strtoupper(substr($companyName, 0, 2)) }}</div>
                            @endif
                        </div>

                        <div>
                            <div class="user-name">{{ $user->name }}</div>
                            <div class="user-email">{{ $user->email }}</td>
<td>{{ $user->telegram_chat_id ?? '-' }}</td>
<td>
    @if($user->telegram_chat_id)
        <span style="color:green;font-weight:bold;">Connected</span>
    @else
        <span style="color:red;font-weight:bold;">Not Connected</span>
    @endif
</div>

                            <div class="badge-row">
                                @if($role === 'admin')
                                    <span class="badge badge-role-admin">Admin</span>
                                @elseif($role === 'engineer')
                                    <span class="badge badge-role-engineer">Engineer</span>
                                @else
                                    <span class="badge badge-role-customer">{{ ucfirst($role) }}</span>
                                @endif

                                @if($approved)
                                    <span class="badge badge-ok">Approved</span>
                                @else
                                    <span class="badge badge-wait">Pending Approval</span>
                                @endif
                            </div>
                        </div>

                        <div class="meta-panel">
                            <div class="meta-box">
                                <div class="meta-label">Current Role</div>
                                <div class="meta-value">{{ ucfirst($role) }}</div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Company</div>
                                <div class="meta-value">{{ $companyName }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="edit-toggle-row">
                        <button type="button" class="btn btn-ghost editToggleBtn">Edit User</button>
                    </div>

                    <form method="POST" action="/admin/users/{{ $user->id }}">
                                    @csrf
                                    @method('PUT')
                        @csrf
                        @method('PUT')

                        <div class="edit-grid">
                            <input class="input" type="text" name="name" value="{{ $user->name }}" placeholder="Full name" required>

                            <select class="select" name="role">
                                <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="engineer" {{ $role === 'engineer' ? 'selected' : '' }}>Engineer</option>
                                <option value="customer" {{ $role === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="user" {{ $role === 'user' ? 'selected' : '' }}>User</option>
                            </select>

                            <select class="select" name="company_id">
                                <option value="">No Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ $user->company_id == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>

                            <input class="input" type="password" name="password" placeholder="Reset password (optional)">
                        </div>

                        <div class="action-row">
                            <div class="action-left">
                                <label class="check-row">
                                    <input type="checkbox" name="is_approved" {{ $approved ? 'checked' : '' }}>
                                    <span>Approved</span>
                                </label>
                            </div>

                            <div class="action-right">
                                <button type="submit" class="btn btn-success">Update User</button>
                    </form>
<form method="POST" action="{{ route('admin.users.telegram-test', $user) }}" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-sm" style="background:#229ED9;color:white;border:0;border-radius:8px;padding:6px 10px;">
        Test Telegram
    </button>
</form>

                                <form method="POST" action="/admin/users/{{ $user->id }}" onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                </div>
            @empty
                <div class="empty-state">No users found.</div>
            @endforelse
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchUser');
        const roleFilter = document.getElementById('filterRole');
        const approvalFilter = document.getElementById('filterApproval');
        const cards = Array.from(document.querySelectorAll('.user-card'));
        const visibleCount = document.getElementById('visibleCount');
        const collapseAllBtn = document.getElementById('collapseAllBtn');
        const kpiTotal = document.getElementById('kpiTotal');
        const kpiPending = document.getElementById('kpiPending');
        const kpiActive = document.getElementById('kpiActive');

        function applyFilters() {
            const q = (searchInput.value || '').toLowerCase().trim();
            const role = roleFilter.value;
            const approval = approvalFilter.value;

            let visible = 0;
            let pending = 0;
            let active = 0;

            cards.forEach(card => {
                const name = card.dataset.name || '';
                const email = card.dataset.email || '';
                const cardRole = card.dataset.role || '';
                const cardApproval = card.dataset.approved || '';

                const matchSearch = !q || name.includes(q) || email.includes(q);
                const matchRole = !role || cardRole === role;
                const matchApproval = !approval || cardApproval === approval;
                const show = matchSearch && matchRole && matchApproval;

                card.style.display = show ? '' : 'none';

                if (show) {
                    visible++;
                    if (cardApproval === 'approved') active++;
                    if (cardApproval === 'pending') pending++;
                }
            });

            visibleCount.textContent = visible;
            kpiTotal.textContent = visible;
            kpiPending.textContent = pending;
            kpiActive.textContent = active;
        }

        searchInput.addEventListener('input', applyFilters);
        roleFilter.addEventListener('change', applyFilters);
        approvalFilter.addEventListener('change', applyFilters);

        document.querySelectorAll('.editToggleBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                const form = btn.closest('.user-card').querySelector('.edit-form');
                const isOpen = form.classList.contains('open');
                form.classList.toggle('open');
                btn.textContent = isOpen ? 'Edit User' : 'Hide Edit';
            });
        });

        collapseAllBtn.addEventListener('click', () => {
            document.querySelectorAll('.edit-form').forEach(f => f.classList.remove('open'));
            document.querySelectorAll('.editToggleBtn').forEach(b => b.textContent = 'Edit User');
        });
    </script>
</body>
</html>
