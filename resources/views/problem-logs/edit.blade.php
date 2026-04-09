<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xion1 Edit Problem Log</title>
    <style>
        * {
            box-sizing: border-box;
        }

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
            max-width: 980px;
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

        .hero-top {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: flex-start;
            flex-wrap: wrap;
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
            transition: 0.2s ease;
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
            backdrop-filter: blur(8px);
        }

        .card {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 26px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .section-title {
            margin: 0 0 8px;
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 22px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .full {
            grid-column: 1 / -1;
        }

        .label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #334155;
        }

        .input,
        .select,
        .textarea,
        .file {
            width: 100%;
            padding: 13px 14px;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: white;
            font-size: 14px;
            color: #0f172a;
            outline: none;
        }

        .textarea {
            min-height: 140px;
            resize: vertical;
        }

        .input:focus,
        .select:focus,
        .textarea:focus,
        .file:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96,165,250,0.18);
        }

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .btn-outline {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe;
        }

        .helper-box {
            margin-top: 22px;
            padding: 18px;
            border-radius: 18px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
        }

        .helper-title {
            font-size: 13px;
            font-weight: 800;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
        }

        .helper-text {
            color: #475569;
            font-size: 14px;
            line-height: 1.7;
        }

        .preview-img {
            margin-top: 10px;
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid #dbeafe;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.10);
        }

        @media (max-width: 760px) {
            .page {
                padding: 18px 14px 40px;
            }

            .hero,
            .card {
                border-radius: 18px;
                padding: 18px;
            }

            .hero h1 {
                font-size: 28px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="hero">
            <div class="brand">
                <span class="brand-dot"></span>
                Xion1 Operations Console
            </div>

            <div class="hero-top">
                <div>
                    <h1>Edit Problem Log</h1>
                    <p>
                        Update issue details, adjust priority or status, and replace the supporting problem photo when needed.
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs/{{ $problemLog->id }}" class="btn btn-secondary">View Detail</a>
                    <a href="/problem-logs" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 class="section-title">Update Incident Form</h2>
            <div class="muted">Edit the main incident information below.</div>

            <form method="POST" action="/problem-logs/{{ $problemLog->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid">
                    <div class="form-group full">
                        <label class="label">Problem Title</label>
                        <input type="text" name="title" class="input" value="{{ $problemLog->title }}">
                    </div>

                    <div class="form-group">
                        <label class="label">Status</label>
                        <select name="status" class="select">
                            <option value="open" @selected($problemLog->status === 'open')>Open</option>
                            <option value="in_progress" @selected($problemLog->status === 'in_progress')>In Progress</option>
                            <option value="closed" @selected($problemLog->status === 'closed')>Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label">Priority</label>
                        <select name="priority" class="select">
                            <option value="low" @selected($problemLog->priority === 'low')>Low</option>
                            <option value="medium" @selected($problemLog->priority === 'medium')>Medium</option>
                            <option value="high" @selected($problemLog->priority === 'high')>High</option>
                        </select>
                    </div>

                    <div class="form-group full">
                        <label class="label">Description</label>
                        <textarea name="description" class="textarea">{{ $problemLog->description }}</textarea>
                    </div>

                    <div class="form-group full">
                        <label class="label">Replace Problem Photo</label>
                        <input type="file" name="photo" class="file">

                        @if($problemLog->photo)
                            <img src="{{ asset('storage/' . $problemLog->photo) }}" alt="Current Photo" class="preview-img">
                        @endif
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn btn-primary">Update Problem Log</button>
                    <a href="/problem-logs/{{ $problemLog->id }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>

            <div class="helper-box">
                <div class="helper-title">Xion1 Workflow</div>
                <div class="helper-text">
                    Editing here updates only the core issue record. Acknowledge and Close actions remain available on the detail page for cleaner operational flow.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
