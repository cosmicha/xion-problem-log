<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $mailTitle }}</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f6f8fb; margin:0; padding:24px;">
    <div style="max-width:720px; margin:0 auto; background:#ffffff; border-radius:16px; padding:28px; border:1px solid #e5e7eb;">
        <div style="font-size:12px; letter-spacing:.08em; text-transform:uppercase; color:#64748b; font-weight:700; margin-bottom:10px;">
            X1 Event Flow
        </div>

        <h2 style="margin:0 0 10px; color:#0f172a;">{{ $mailTitle }}</h2>

        <p style="margin:0 0 18px; color:#475569; line-height:1.7;">
            {{ $mailMessage }}
        </p>

        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; padding:18px; margin-bottom:18px;">
            <div style="margin-bottom:8px;"><strong>Ticket Number:</strong> {{ $problemLog->ticket_number ?? '-' }}</div>
            <div style="margin-bottom:8px;"><strong>Title:</strong> {{ $problemLog->title ?? '-' }}</div>
            <div style="margin-bottom:8px;"><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $problemLog->status ?? '-')) }}</div>
            <div style="margin-bottom:8px;"><strong>Priority:</strong> {{ ucfirst($problemLog->priority ?? '-') }}</div>
            <div style="margin-bottom:8px;"><strong>Company:</strong> {{ optional($problemLog->company)->name ?? '-' }}</div>
            <div style="margin-bottom:8px;"><strong>Engineer:</strong> {{ optional($problemLog->assignedEngineer)->name ?? ($problemLog->engineer_name ?? '-') }}</div>
            <div><strong>Description:</strong> {{ $problemLog->description ?? '-' }}</div>
        </div>

        <div style="font-size:13px; color:#64748b;">
            Generated automatically by X1 Event Flow.
        </div>
    </div>
</body>
</html>
