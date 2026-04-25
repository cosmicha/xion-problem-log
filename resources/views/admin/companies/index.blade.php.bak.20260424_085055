<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Settings</title>
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
            max-width: 820px;
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

        .input, .select, .file {
            min-width: 190px;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: white;
            font-size: 14px;
            color: #0f172a;
            outline: none;
            width: 100%;
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

        .create-card {
            background: rgba(255,255,255,0.94);
            border-radius: 24px;
            padding: 22px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 8px;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .create-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.8fr 0.8fr 1.1fr;
            gap: 12px;
            margin-bottom: 14px;
        }

        .help {
            font-size: 12px;
            color: #64748b;
            margin-top: 6px;
            line-height: 1.55;
        }

        .check-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: #334155;
        }

        .companies-wrap {
            display: grid;
            gap: 16px;
        }

        .company-card {
            background: rgba(255,255,255,0.94);
            border-radius: 24px;
            padding: 20px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .company-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 56px rgba(15, 23, 42, 0.12);
        }

        .company-top {
            display: grid;
            grid-template-columns: 92px 1.1fr 1fr;
            gap: 18px;
            align-items: start;
        }

        .company-logo {
            width: 92px;
            height: 92px;
            border-radius: 24px;
            object-fit: cover;
            background: white;
            border: 1px solid #dbeafe;
            box-shadow: 0 12px 24px rgba(2, 6, 23, 0.10);
        }

        .company-logo-empty {
            width: 92px;
            height: 92px;
            border-radius: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e0f2fe, #dbeafe);
            border: 1px dashed #bfdbfe;
            color: #1e3a8a;
            font-weight: 900;
            font-size: 28px;
            box-shadow: 0 12px 24px rgba(2, 6, 23, 0.10);
        }

        .company-name {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .badge-active {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 12px;
        }

        .meta-panel {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
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
            grid-template-columns: 1.1fr 0.8fr 0.8fr 1.1fr;
            gap: 12px;
            margin-bottom: 14px;
        }

        .edit-grid-single {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
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

        @media (max-width: 1150px) {
            .company-top {
                grid-template-columns: 92px 1fr;
            }

            .meta-panel {
                grid-column: 1 / -1;
            }

            .create-grid, .edit-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 780px) {
            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .company-top {
                grid-template-columns: 1fr;
            }

            .create-grid, .edit-grid {
                grid-template-columns: 1fr;
            }

            .meta-panel {
                grid-template-columns: 1fr;
            }

            .input, .select, .file {
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
                        <span class="brand-mark">CP</span>
                        COMPANY SETTINGS
                    </div>
                    <h1>Companies & SLA Settings</h1>
                    <p>Manage company profile, logo, notification emails, and SLA response and resolution targets in a cleaner and more premium operational layout.</p>
                </div>

                <div class="hero-actions">
                    <a href="/admin/users" class="btn btn-primary">User Management</a>
                    <a href="/problem-logs" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-label">Total Companies</div>
                <div class="kpi-value" id="kpiTotalCompanies">{{ $companies->count() }}</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-label">SLA Active</div>
                <div class="kpi-value" id="kpiActiveCompanies">{{ $companies->filter(fn($c) => (bool) $c->sla_active)->count() }}</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-label">With Logo</div>
                <div class="kpi-value" id="kpiLogoCompanies">{{ $companies->filter(fn($c) => !empty($c->logo_path))->count() }}</div>
            </div>
        </div>

        <div class="toolbar-shell">
            <div class="toolbar">
                <div class="toolbar-left">
                    <input id="searchCompany" class="input" type="text" placeholder="Search company or email">
                    <select id="filterCompanySla" class="select">
                        <option value="">All SLA Status</option>
                        <option value="active">SLA Active</option>
                        <option value="inactive">SLA Inactive</option>
                    </select>
                </div>

                <div class="toolbar-right">
                    <span class="chip">Visible Companies: <span id="visibleCompanyCount">{{ $companies->count() }}</span></span>
                    <button type="button" class="btn btn-ghost" id="collapseAllCompaniesBtn">Collapse All</button>
                </div>
            </div>
        </div>

        <div class="create-card">
            <div class="section-title">Create Company</div>
            <div class="muted">Add a new company, upload a logo, and define SLA values in hours.</div>

            <form method="POST" action="/admin/companies" enctype="multipart/form-data">
                @csrf

                <div class="create-grid">
                    <input class="input" type="text" name="name" placeholder="Company name" required>

                    <div>
                        <input class="input" type="number" name="sla_response_minutes" placeholder="Response Time (hours)" value="2" min="1">
                        <div class="help">Response Time: maximum time allowed for first acknowledgement or start of handling since ticket creation.</div>
                    </div>

                    <div>
                        <input class="input" type="number" name="sla_resolution_minutes" placeholder="Resolution Time (hours)" value="8" min="1">
                        <div class="help">Resolution Time: maximum time allowed until the ticket is fully resolved and closed.</div>
                    </div>

                    <div>
                        <input class="input" type="text" name="notification_emails" placeholder="notify1@mail.com, notify2@mail.com">
                        <div class="help">Use comma-separated emails for company-level notifications.</div>
                    </div>
                </div>

                <div class="edit-grid-single">
                    <div>
                        <input class="file" type="file" name="logo" accept="image/*">
                        <div class="help">Optional company logo. Recommended square image for best appearance.</div>
                    </div>
                </div>

                <div class="action-row">
                    <div class="action-left">
                        <label class="check-row">
                            <input type="checkbox" name="sla_active" checked>
                            <span>SLA Active</span>
                        </label>
                    </div>

                    <div class="action-right">
                        <button type="submit" class="btn btn-primary">Create Company</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="companies-wrap" id="companiesWrap">
            @forelse($companies as $company)
                @php
                    $companyName = $company->name ?? 'Company';
                    $logo = $company->logo_path ?? null;
                    $initials = strtoupper(substr($companyName, 0, 2));
                    $isActive = (bool) ($company->sla_active ?? false);
                @endphp

                <div class="company-card"
                     data-name="{{ strtolower($companyName) }}"
                     data-emails="{{ strtolower($company->notification_emails ?? '') }}"
                     data-sla="{{ $isActive ? 'active' : 'inactive' }}">

                    <div class="company-top">
                        <div>
                            @if($logo)
                                <img src="{{ url('/storage/' . $logo) }}" alt="{{ $companyName }}" class="company-logo">
                            @else
                                <div class="company-logo-empty">{{ $initials }}</div>
                            @endif
                        </div>

                        <div>
                            <div class="company-name">{{ $companyName }}</div>

                            <div class="badge-row">
                                @if($isActive)
                                    <span class="badge badge-active">SLA Active</span>
                                @else
                                    <span class="badge badge-inactive">SLA Inactive</span>
                                @endif
                            </div>
                        </div>

                        <div class="meta-panel">
                            <div class="meta-box">
                                <div class="meta-label">Response Time SLA</div>
                                <div class="meta-value">{{ $company->sla_response_minutes }} hour(s)</div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Resolution Time SLA</div>
                                <div class="meta-value">{{ $company->sla_resolution_minutes }} hour(s)</div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Notification Emails</div>
                                <div class="meta-value">{{ $company->notification_emails ?: '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="edit-toggle-row">
                        <button type="button" class="btn btn-ghost companyEditToggleBtn">Edit Company</button>
                    </div>

                    <form class="edit-form" method="POST" action="/admin/companies/{{ $company->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="edit-grid">
                            <input class="input" type="text" name="name" value="{{ $company->name }}" placeholder="Company name" required>

                            <div>
                                <input class="input" type="number" name="sla_response_minutes" value="{{ $company->sla_response_minutes }}" min="1">
                                <div class="help">Response Time in hours.</div>
                            </div>

                            <div>
                                <input class="input" type="number" name="sla_resolution_minutes" value="{{ $company->sla_resolution_minutes }}" min="1">
                                <div class="help">Resolution Time in hours.</div>
                            </div>

                            <div>
                                <input class="input" type="text" name="notification_emails" value="{{ $company->notification_emails }}" placeholder="notify1@mail.com, notify2@mail.com">
                                <div class="help">Comma-separated emails for notifications.</div>
                            </div>
                        </div>

                        <div class="edit-grid-single">
                            <div>
                                <input class="file" type="file" name="logo" accept="image/*">
                                <div class="help">Upload a new logo only if you want to replace the current one.</div>
                            </div>
                        </div>

                        <div class="action-row">
                            <div class="action-left">
                                <label class="check-row">
                                    <input type="checkbox" name="sla_active" {{ $isActive ? 'checked' : '' }}>
                                    <span>SLA Active</span>
                                </label>
                            </div>

                            <div class="action-right">
                                <button type="submit" class="btn btn-success">Update Company</button>
                    </form>

                                <form method="POST" action="/admin/companies/{{ $company->id }}" onsubmit="return confirm('Delete this company?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                </div>
            @empty
                <div class="empty-state">No companies found.</div>
            @endforelse
        </div>
    </div>

    <script>
        const searchCompany = document.getElementById('searchCompany');
        const filterCompanySla = document.getElementById('filterCompanySla');
        const companyCards = Array.from(document.querySelectorAll('.company-card'));
        const visibleCompanyCount = document.getElementById('visibleCompanyCount');
        const collapseAllCompaniesBtn = document.getElementById('collapseAllCompaniesBtn');
        const kpiTotalCompanies = document.getElementById('kpiTotalCompanies');
        const kpiActiveCompanies = document.getElementById('kpiActiveCompanies');
        const kpiLogoCompanies = document.getElementById('kpiLogoCompanies');

        function applyCompanyFilters() {
            const q = (searchCompany.value || '').toLowerCase().trim();
            const sla = filterCompanySla.value;

            let visible = 0;
            let active = 0;
            let withLogo = 0;

            companyCards.forEach(card => {
                const name = card.dataset.name || '';
                const emails = card.dataset.emails || '';
                const cardSla = card.dataset.sla || '';
                const hasLogo = !!card.querySelector('.company-logo');

                const matchSearch = !q || name.includes(q) || emails.includes(q);
                const matchSla = !sla || cardSla === sla;
                const show = matchSearch && matchSla;

                card.style.display = show ? '' : 'none';

                if (show) {
                    visible++;
                    if (cardSla === 'active') active++;
                    if (hasLogo) withLogo++;
                }
            });

            visibleCompanyCount.textContent = visible;
            kpiTotalCompanies.textContent = visible;
            kpiActiveCompanies.textContent = active;
            kpiLogoCompanies.textContent = withLogo;
        }

        searchCompany.addEventListener('input', applyCompanyFilters);
        filterCompanySla.addEventListener('change', applyCompanyFilters);

        document.querySelectorAll('.companyEditToggleBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                const form = btn.closest('.company-card').querySelector('.edit-form');
                const isOpen = form.classList.contains('open');
                form.classList.toggle('open');
                btn.textContent = isOpen ? 'Edit Company' : 'Hide Edit';
            });
        });

        collapseAllCompaniesBtn.addEventListener('click', () => {
            document.querySelectorAll('.edit-form').forEach(f => f.classList.remove('open'));
            document.querySelectorAll('.companyEditToggleBtn').forEach(b => b.textContent = 'Edit Company');
        });
    </script>
</body>
</html>
