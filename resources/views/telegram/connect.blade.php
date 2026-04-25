<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Connect Telegram</title>
    <style>
        body{margin:0;font-family:Inter,system-ui,sans-serif;background:linear-gradient(135deg,#071a52,#173a88);min-height:100vh;color:#0f172a;}
        .page{max-width:820px;margin:0 auto;padding:32px;}
        .card{background:#fff;border-radius:28px;padding:28px;box-shadow:0 20px 60px rgba(0,0,0,.22);}
        h1{margin:0 0 8px;font-size:32px;letter-spacing:-.03em;}
        p{color:#64748b;line-height:1.6;}
        .code{font-size:28px;font-weight:900;letter-spacing:.12em;background:#eff6ff;color:#1d4ed8;border-radius:18px;padding:18px;text-align:center;margin:18px 0;}
        .actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:18px;}
        .btn{display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:0 16px;border-radius:12px;border:1px solid #cbd5e1;background:#fff;color:#0f172a;text-decoration:none;font-weight:800;cursor:pointer;}
        .btn-primary{background:#2563eb;color:white;border:none;}
        .alert{padding:12px 14px;border-radius:14px;margin-bottom:14px;font-weight:700;}
        .success{background:#dcfce7;color:#166534;}
        .error{background:#fee2e2;color:#991b1b;}
        .status{margin-top:18px;padding:16px;border-radius:18px;background:#f8fafc;border:1px solid #e2e8f0;}
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert error">{{ session('error') }}</div> @endif

        <h1>Connect Telegram</h1>
        <p>Connect your Telegram account so the support system can send ticket and SLA alerts directly to you.</p>

        <div class="code">{{ $code }}</div>

        <p>Send this command to the Telegram bot:</p>
        <div class="code" style="font-size:18px;letter-spacing:0;">/start {{ $code }}</div>

        <div class="actions">
            @if($botUsername)
                <a class="btn btn-primary" target="_blank" href="https://t.me/{{ $botUsername }}?start={{ $code }}">Open Telegram Bot</a>
            @endif

            <form method="POST" action="{{ route('telegram.connect.sync') }}">
                @csrf
                <button class="btn" type="submit">Sync Telegram</button>
            </form>

            <form method="POST" action="{{ route('telegram.connect.test') }}">
                @csrf
                <button class="btn" type="submit">Send Test Message</button>
            </form>

            <a class="btn" href="/problem-logs">Back</a>
        </div>

        <div class="status">
            <strong>Status:</strong>
            @if($user->telegram_chat_id)
                Connected ✅<br>
                Chat ID: {{ $user->telegram_chat_id }}<br>
                Linked at: {{ $user->telegram_linked_at }}
            @else
                Not connected yet.
            @endif
        </div>
    </div>
</div>
</body>
</html>
