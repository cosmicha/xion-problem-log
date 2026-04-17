<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center - Incident Portal Ticketing System</title>
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
            max-width: 1350px;
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
            max-width: 800px;
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
            padding: 12px 18px;
            border-radius: 16px;
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

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .card {
            background: rgba(255,255,255,0.92);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .full {
            grid-column: 1 / -1;
        }

        .section-title {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 8px;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 18px;
            line-height: 1.7;
        }

        .item {
            padding: 16px 18px;
            border-radius: 18px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
            margin-bottom: 14px;
        }

        .item:last-child {
            margin-bottom: 0;
        }

        .item h3 {
            margin: 0 0 8px;
            font-size: 16px;
            color: #0f172a;
        }

        .item p, .item li {
            margin: 0;
            color: #475569;
            font-size: 14px;
            line-height: 1.7;
        }

        .item ul {
            margin: 8px 0 0 18px;
            padding: 0;
        }

        .pill-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
        }

        .pill {
            padding: 10px 14px;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 700;
            font-size: 13px;
            border: 1px solid #dbeafe;
        }

        .status-open { background: #fee2e2; color: #b91c1c; border-color: #fecaca; }
        .status-progress { background: #fef3c7; color: #b45309; border-color: #fde68a; }
        .status-closed { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }

        .mini-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .mini-box {
            background: #f8fbff;
            border: 1px solid #dbeafe;
            border-radius: 18px;
            padding: 16px;
        }

        .mini-box h4 {
            margin: 0 0 6px;
            font-size: 14px;
            color: #0f172a;
        }

        .mini-box p {
            margin: 0;
            font-size: 13px;
            line-height: 1.7;
            color: #475569;
        }

        @media (max-width: 980px) {
            .grid, .mini-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .page {
                padding: 14px 14px 40px;
            }

            .hero, .card {
                border-radius: 20px;
            }

            .hero h1 {
                font-size: 28px;
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
                        <span class="brand-mark">HP</span>
                        HELP CENTER
                    </div>
                    <h1>Incident Portal Ticketing System Help Center</h1>
                    <p>
                        This guide covers the latest capabilities of the platform, including incident reporting,
                        engineer workflow, progress timeline, SLA tracking in hours, email notifications,
                        analytics, executive dashboards, and operational administration.
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Back to Dashboard</a>
                    <a href="/analytics" class="btn btn-primary">Open Analytics</a>
                </div>
            </div>
        </div>

        <div class="grid">
            <div class="card">
                <div class="section-title">Create and Track Tickets</div>
                <div class="muted">Customers and users can submit incidents and monitor progress end to end.</div>

                <div class="item">
                    <h3>How to create a ticket</h3>
                    <ul>
                        <li>Click <strong>Add New Log</strong></li>
                        <li>Fill title, description, and priority</li>
                        <li>Upload a supporting photo if available</li>
                        <li>Submit the ticket</li>
                    </ul>
                </div>

                <div class="item">
                    <h3>What users can monitor</h3>
                    <ul>
                        <li>Ticket number and title</li>
                        <li>Status and assigned engineer</li>
                        <li>Response SLA and resolution SLA</li>
                        <li>Timeline updates and closure notes</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="section-title">Ticket Status Lifecycle</div>
                <div class="muted">Tickets follow a structured lifecycle from creation until completion.</div>

                <div class="pill-row">
                    <div class="pill status-open">Open</div>
                    <div class="pill status-progress">In Progress</div>
                    <div class="pill status-closed">Closed</div>
                </div>

                <div class="item" style="margin-top:14px;">
                    <h3>Status meaning</h3>
                    <ul>
                        <li><strong>Open</strong> → newly created and waiting for action</li>
                        <li><strong>In Progress</strong> → acknowledged and actively handled</li>
                        <li><strong>Closed</strong> → resolved and completed</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="section-title">Engineer Workflow</div>
                <div class="muted">Engineers can take ownership of tickets and maintain handling visibility.</div>

                <div class="item">
                    <h3>Main actions</h3>
                    <ul>
                        <li>Take Ticket</li>
                        <li>Acknowledge ticket</li>
                        <li>Add progress updates</li>
                        <li>Upload closing evidence if required</li>
                        <li>Close ticket after issue is resolved</li>
                    </ul>
                </div>

                <div class="item">
                    <h3>Progress timeline</h3>
                    <p>
                        Every important action can be logged as a progress update, such as onsite checking,
                        waiting for spare parts, temporary fix, retesting, or final resolution.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="section-title">SLA Settings in Hours</div>
                <div class="muted">Each company can configure SLA targets using hours, not minutes.</div>

                <div class="item">
                    <h3>Response Time</h3>
                    <p>Maximum time allowed for first acknowledgement or start of handling since ticket creation.</p>
                </div>

                <div class="item">
                    <h3>Resolution Time</h3>
                    <p>Maximum time allowed until the ticket is fully resolved and closed.</p>
                </div>

                <div class="item">
                    <h3>SLA status</h3>
                    <ul>
                        <li><strong>On Time</strong> → still within target</li>
                        <li><strong>Breached</strong> → exceeded target</li>
                        <li><strong>N/A</strong> → SLA not active or not yet applicable</li>
                    </ul>
                </div>
            </div>

            <div class="card full">
                <div class="section-title">Email Notifications</div>
                <div class="muted">Automatic email notifications can be sent to keep all stakeholders informed.</div>

                <div class="mini-grid">
                    <div class="mini-box">
                        <h4>Events</h4>
                        <p>Ticket created, assigned, acknowledged, progress updated, and closed.</p>
                    </div>
                    <div class="mini-box">
                        <h4>Recipients</h4>
                        <p>Company notification emails, ticket creator, assigned engineer, and administrators.</p>
                    </div>
                    <div class="mini-box">
                        <h4>Delivery</h4>
                        <p>Emails are processed through background queue workers for stable delivery.</p>
                    </div>
                </div>
            </div>

            <div class="card full">
                <div class="section-title">Analytics Dashboard</div>
                <div class="muted">The system includes analytics and executive operational insights.</div>

                <div class="mini-grid">
                    <div class="mini-box">
                        <h4>Core KPI</h4>
                        <p>Total tickets, open, in progress, closed, closure rate, average response time, and average resolution time.</p>
                    </div>
                    <div class="mini-box">
                        <h4>SLA Insight</h4>
                        <p>Response breach count, resolution breach count, overdue now, and aging buckets.</p>
                    </div>
                    <div class="mini-box">
                        <h4>Operational Load</h4>
                        <p>Tickets by company, tickets by engineer, top breached companies, and top loaded engineers.</p>
                    </div>
                </div>

                <div class="item" style="margin-top:14px;">
                    <h3>Executive analytics features</h3>
                    <ul>
                        <li>Monthly ticket trend</li>
                        <li>Monthly closure trend</li>
                        <li>Monthly SLA breach trend</li>
                        <li>Most critical tickets</li>
                        <li>Top issue categories inferred from ticket titles</li>
                        <li>Executive summary cards</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="section-title">Administrator Capabilities</div>
                <div class="muted">Admins have full operational and configuration access.</div>

                <div class="item">
                    <h3>Admin can manage</h3>
                    <ul>
                        <li>Users and approval status</li>
                        <li>Roles and password reset</li>
                        <li>Companies and SLA settings</li>
                        <li>Notification email list per company</li>
                        <li>Engineer assignment</li>
                        <li>Export data and view analytics</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="section-title">Filtering and Reporting</div>
                <div class="muted">The main dashboard supports search and operational filtering.</div>

                <div class="item">
                    <h3>Available filters</h3>
                    <ul>
                        <li>Keyword search</li>
                        <li>Status</li>
                        <li>Priority</li>
                        <li>Company</li>
                        <li>Engineer</li>
                        <li>Response SLA status</li>
                        <li>Resolution SLA status</li>
                        <li>Date range</li>
                    </ul>
                </div>

                <div class="item">
                    <h3>Export</h3>
                    <p>Ticket data can be exported for operational review and management reporting.</p>
                </div>
            </div>

            <div class="card full">
                <div class="section-title">Best Practice</div>
                <div class="muted">Recommended usage to keep incident handling efficient and auditable.</div>

                <div class="mini-grid">
                    <div class="mini-box">
                        <h4>For Users</h4>
                        <p>Submit clear ticket titles, complete descriptions, and supporting photos whenever possible.</p>
                    </div>
                    <div class="mini-box">
                        <h4>For Engineers</h4>
                        <p>Acknowledge quickly, add timeline updates for non-instant work, and close only after resolution is confirmed.</p>
                    </div>
                    <div class="mini-box">
                        <h4>For Admins</h4>
                        <p>Monitor overdue tickets, review analytics regularly, and keep company SLA settings aligned with contract commitments.</p>
                    </div>
                </div>
            </div>

            <div class="card full">
                <div class="section-title">Need More Assistance?</div>
                <div class="muted">For help regarding account access, registration approval, SLA setup, or notification issues, contact support.</div>

                <div class="item">
                    <h3>Support Contact</h3>
                    <p><strong>Email:</strong> support@x1eventflow.com</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
