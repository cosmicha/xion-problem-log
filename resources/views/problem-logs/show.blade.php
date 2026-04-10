<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Detail</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.20), transparent 28%),
                radial-gradient(circle at top right, rgba(14, 165, 233, 0.18), transparent 30%),
                linear-gradient(180deg, #081120 0%, #0d1728 42%, #f4f7fb 42%, #f4f7fb 100%);
            color: #0f172a;
        }

        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 36px 24px 60px;
        }

        .hero {
            color: white;
            padding: 28px 30px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.94), rgba(29, 78, 216, 0.88));
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.28);
            margin-bottom: 24px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.75);
            margin-bottom: 12px;
        }

        .brand-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, #60a5fa, #22d3ee);
            box-shadow: 0 0 16px rgba(96,165,250,0.8);
        }

        .hero h1 {
            margin: 0 0 10px;
            font-size: 32px;
            line-height: 1.1;
        }

        .hero p {
            margin: 0;
            color: rgba(255,255,255,0.82);
            max-width: 680px;
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

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35);
        }

        .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.16);
        }

        .grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 22px;
            align-items: start;
        }

        .card {
            background: rgba(255,255,255,0.92);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
            margin-bottom: 22px;
        }

        .section-title {
            margin: 0 0 18px;
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 16px;
        }

        .meta-box {
            background: #f8fbff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 16px;
        }

        .meta-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .meta-value {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            word-break: break-word;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-open { background: #fee2e2; color: #b91c1c; }
        .badge-progress { background: #fef3c7; color: #b45309; }
        .badge-closed { background: #dcfce7; color: #15803d; }
        .badge-low { background: #e5e7eb; color: #374151; }
        .badge-medium { background: #dbeafe; color: #1d4ed8; }
        .badge-high { background: #fee2e2; color: #b91c1c; }

        .info-block {
            margin-top: 14px;
            padding: 18px;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .img {
            width: 100%;
            max-width: 100%;
            border-radius: 18px;
            border: 1px solid #dbeafe;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.10);
        }

        .placeholder {
            padding: 30px;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            color: #94a3b8;
            text-align: center;
            font-weight: 700;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
        }

        @media (max-width: 980px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .page {
                padding: 18px 14px 40px;
            }

            .hero, .card {
                border-radius: 18px;
                padding: 18px;
            }

            .meta-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="hero">
            <div class="brand">
                <span class="brand-dot"></span>
                TICKETING SYSTEM
            </div>

            <div class="hero-top">
                <div>
                    <h1>{{ $problemLog->title ?? 'Ticket Detail' }}</h1>
                    <p>View full ticket information, image evidence, and status details.</p>
                    <p style="margin-top:10px;">
                        <strong>{{ optional($problemLog->company)->name ?? 'No Company' }}</strong>
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Back to List</a>
                    <a href="/problem-logs/{{ $problemLog->id }}/edit" class="btn btn-primary">Edit Ticket</a>
                </div>
            </div>
        </div>

        <div class="grid">
            <div>
                <div class="card">
                    <h2 class="section-title">Overview</h2>

                    <div class="meta-grid">
                        <div class="meta-box">
                            <div class="meta-label">Ticket Number</div>
                            <div class="meta-value">{{ $problemLog->ticket_number ?: '-' }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Status</div>
                            <div class="meta-value">
                                @if(($problemLog->status ?? '') === 'open')
                                    <span class="badge badge-open">Open</span>
                                @elseif(($problemLog->status ?? '') === 'in_progress')
                                    <span class="badge badge-progress">In Progress</span>
                                @else
                                    <span class="badge badge-closed">Closed</span>
                                @endif
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Priority</div>
                            <div class="meta-value">
                                @if(($problemLog->priority ?? '') === 'high')
                                    <span class="badge badge-high">High</span>
                                @elseif(($problemLog->priority ?? '') === 'medium')
                                    <span class="badge badge-medium">Medium</span>
                                @else
                                    <span class="badge badge-low">Low</span>
                                @endif
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Engineer</div>
                            <div class="meta-value">
                                {{ optional($problemLog->assignedEngineer)->name ?? $problemLog->engineer_name ?? '-' }}
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Created</div>
                            <div class="meta-value">{{ $problemLog->created_at ? $problemLog->created_at->format('d M Y H:i') : '-' }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Closed At</div>
                            <div class="meta-value">{{ $problemLog->closed_at ? $problemLog->closed_at->format('d M Y H:i') : '-' }}</div>
                        </div>
                    </div>

                    <div class="info-block">
                        <div class="meta-label">Description</div>
                        <div class="meta-value" style="font-weight:500; line-height:1.7;">
                            {{ $problemLog->description ?: 'No description provided.' }}
                        </div>
                    </div>

                    @if($problemLog->close_note)
                        <div class="info-block">
                            <div class="meta-label">Close Note</div>
                            <div class="meta-value" style="font-weight:500; line-height:1.7;">
                                {{ $problemLog->close_note }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <div class="card">
                    <h2 class="section-title">Problem Photo</h2>

                    @if($problemLog->photo)
                        <img src="{{ asset('storage/' . $problemLog->photo) }}" alt="Problem Photo" class="img">
                    @else
                        <div class="placeholder">No Photo</div>
                    @endif
                </div>

                @if($problemLog->closed_photo)
                    <div class="card">
                        <h2 class="section-title">Closed Photo</h2>
                        <img src="{{ asset('storage/' . $problemLog->closed_photo) }}" alt="Closed Photo" class="img">
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
