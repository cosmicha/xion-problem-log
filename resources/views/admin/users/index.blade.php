<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xion1 Admin - User & Company Management</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), transparent 30%),
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 30%),
                linear-gradient(180deg, #081120 0%, #0d1728 45%, #f4f7fb 45%, #f4f7fb 100%);
            color: #0f172a;
        }

        .page {
            max-width: 1380px;
            margin: 0 auto;
            padding: 36px 24px 60px;
        }

        .hero {
            color: white;
            padding: 28px 30px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(29, 78, 216, 0.88));
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.28);
            margin-bottom: 24px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: center;
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
            color: rgba(255,255,255,0.8);
            margin-bottom: 14px;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
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
            color: rgba(255,255,255,0.8);
            max-width: 760px;
            font-size: 15px;
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
            padding: 12px 18px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.16);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .stats {
            margin-top: 22px;
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
        }

        .stat-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 18px;
        }

        .stat-label {
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.7);
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 800;
            color: white;
        }

        .grid {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 20px;
            align-items: start;
        }

        .card {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 22px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .section-title {
            margin: 0 0 8px;
            font-size: 20px;
            font-weight: 800;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .success {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            background: #ecfdf5;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-weight: 600;
        }

        .error-box {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            font-weight: 600;
        }

        .label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }

        .input, .select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: white;
            font-size: 14px;
            margin-bottom: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        th {
            background: #eff6ff;
            color: #1e3a8a;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            text-align: left;
            padding: 16px 14px;
            border-bottom: 1px solid #dbeafe;
        }

        td {
            padding: 16px 14px;
            border-bottom: 1px solid #eef2f7;
            vertical-align: top;
            font-size: 14px;
        }

        tr:hover td {
            background: #f8fbff;
        }

        .role-chip, .company-chip, .approved, .pending {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 800;
        }

        .role-chip {
            background: #dbeafe;
            color: #1d4ed8;
            text-transform: uppercase;
        }

        .company-chip {
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
        }

        .approved {
            background: #dcfce7;
            color: #15803d;
        }

        .pending {
            background: #fee2e2;
            color: #b91c1c;
        }

        .stack-form {
            display: grid;
            gap: 8px;
            min-width: 210px;
        }

        .mini-select {
            padding: 9px 10px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: white;
            font-size: 12px;
        }

        .btn-small {
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }

        .btn-save {
            background: #2563eb;
            color: white;
        }

        .btn-approve {
            background: #16a34a;
            color: white;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .inline {
            display: inline-block;
        }

        @media (max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .page {
                padding: 18px 14px 40px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .hero, .card {
                border-radius: 18px;
            }
        }
    </style>
</head>
<body>
    @php
        $totalUsers = $users->count();
        $approvedUsers = $users->where('is_approved', true)->count();
        $pendingUsers = $users->where('is_approved', false)->count();
        $customerUsers = $users->where('role', 'customer')->count();
        $engineerUsers = $users->where('role', 'engineer')->count();
    @endphp

    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">X1</span>
                        Xion1 Admin Console
                    </div>
                    <h1>User, Role & Company Management</h1>
                    <p>
                        Approve portal users, assign them to companies, update roles, and manage tenant access.
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Problem Logs</a>

                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>

            <div class="stats">
                <div class="stat-card">
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Approved</div>
                    <div class="stat-value">{{ $approvedUsers }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value">{{ $pendingUsers }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Customers</div>
                    <div class="stat-value">{{ $customerUsers }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Engineers</div>
                    <div class="stat-value">{{ $engineerUsers }}</div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-box">{{ $errors->first() }}</div>
        @endif

        <div class="grid">
            <div class="card">
                <h2 class="section-title">Create Company</h2>
                <div class="muted">Add a company first so pending users can be assigned.</div>

                <form method="POST" action="/admin/companies">
                    @csrf

                    <label class="label">Company Name</label>
                    <input class="input" type="text" name="name" required>

                    <label class="label">Company Email</label>
                    <input class="input" type="email" name="email">

                    <label class="label">Company Code</label>
                    <input class="input" type="text" name="code" placeholder="ex: ACME01" required>

                    <button type="submit" class="btn btn-primary">Create Company</button>
                </form>

                <h2 class="section-title" style="margin-top:24px;">Companies</h2>
                <div class="muted">Available companies for assignment.</div>

                @forelse($companies as $company)
                    <div style="padding:12px 14px; border:1px solid #e2e8f0; border-radius:14px; margin-bottom:10px; background:#f8fafc;">
                        <div style="font-weight:700;">{{ $company->name }}</div>
                        <div style="font-size:12px; color:#64748b;">{{ $company->code }}{{ $company->email ? ' • '.$company->email : '' }}</div>
                    </div>
                @empty
                    <div class="muted">No companies yet.</div>
                @endforelse
            </div>

            <div class="card">
                <h2 class="section-title">Registered Users</h2>
                <div class="muted">Approve, edit role/company, or delete users.</div>

                <div class="table-wrap">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Approve</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>

                        @foreach($users as $user)
                            <tr>
                                <td>#{{ $user->id }}</td>

                                <td>
                                    <div style="font-weight:700;">{{ $user->name }}</div>
                                    <div style="font-size:12px; color:#64748b;">{{ $user->email }}</div>
                                </td>

                                <td><span class="role-chip">{{ $user->role }}</span></td>

                                <td>
                                    @if($user->company)
                                        <span class="company-chip">{{ $user->company->name }}</span>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @if($user->is_approved)
                                        <span class="approved">Approved</span>
                                    @else
                                        <span class="pending">Pending</span>
                                    @endif
                                </td>

                                <td>
                                    @if(!$user->is_approved)
                                        <form method="POST" action="/admin/users/{{ $user->id }}/approve" class="stack-form">
                                            @csrf
                                            <select name="company_id" class="mini-select" required>
                                                <option value="">Select Company</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn-small btn-approve">Approve</button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <form method="POST" action="/admin/users/{{ $user->id }}" class="stack-form">
                                        @csrf
                                        @method('PUT')

                                        <select name="role" class="mini-select" required>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>admin</option>
                                            <option value="engineer" {{ $user->role === 'engineer' ? 'selected' : '' }}>engineer</option>
                                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>customer</option>
                                        </select>

                                        <select name="company_id" class="mini-select">
                                            <option value="">No Company</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" {{ $user->company_id == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <select name="is_approved" class="mini-select" required>
                                            <option value="1" {{ $user->is_approved ? 'selected' : '' }}>Approved</option>
                                            <option value="0" {{ !$user->is_approved ? 'selected' : '' }}>Pending</option>
                                        </select>

                                        <button type="submit" class="btn-small btn-save">Save</button>
                                    </form>
                                </td>

                                <td>
                                    <form method="POST" action="/admin/users/{{ $user->id }}" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-small btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
