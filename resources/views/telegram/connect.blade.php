<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Connect Telegram</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        *{box-sizing:border-box}
        body{margin:0;font-family:Inter,system-ui,sans-serif;background:linear-gradient(135deg,#071737,#173a88);color:#0f172a}
        .page{max-width:1100px;margin:0 auto;padding:34px}
        .card{background:white;border-radius:30px;padding:34px;box-shadow:0 22px 70px rgba(0,0,0,.18)}
        h1{margin:0 0 12px;font-size:42px;letter-spacing:-.05em}
        .muted{color:#64748b;font-size:18px;line-height:1.5}
        .notice{padding:16px 18px;border-radius:18px;margin-bottom:20px;font-weight:800}
        .success{background:#dcfce7;color:#166534}
        .error{background:#fee2e2;color:#991b1b}
        .info{background:#dbeafe;color:#1d4ed8}
        .box{background:#eff6ff;border-radius:22px;padding:22px;margin:20px 0;text-align:center}
        .code{font-size:38px;font-weight:950;letter-spacing:.18em;color:#3158d4}
        .cmd{font-size:24px;font-weight:950;color:#3158d4}
        .grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-top:22px}
        .mini{background:#f8fbff;border:1px solid #dbeafe;border-radius:22px;padding:20px}
        .label{font-size:12px;text-transform:uppercase;letter-spacing:.09em;color:#64748b;font-weight:950;margin-bottom:8px}
        input{width:100%;min-height:48px;border:1px solid #cbd5e1;border-radius:14px;padding:0 14px;font-size:16px}
        .actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:16px}
        .btn{display:inline-flex;align-items:center;justify-content:center;min-height:46px;padding:0 18px;border-radius:14px;background:#fff;border:1px solid #cbd5e1;color:#0f172a;text-decoration:none;font-weight:950;cursor:pointer;font-size:15px}
        .primary{background:linear-gradient(90deg,#60a5fa,#3158d4);color:white;border:0}
        .danger{background:#dc2626;color:white;border:0}
        .status{background:#f8fafc;border:1px solid #dbeafe;border-radius:18px;padding:18px;margin-top:20px;font-size:17px}
        code{background:#e0f2fe;padding:3px 7px;border-radius:8px}
        @media(max-width:800px){.grid{grid-template-columns:1fr}h1{font-size:32px}.code{font-size:28px}}
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        @if(session('success')) <div class="notice success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="notice error">{{ session('error') }}</div> @endif
        @if(session('info')) <div class="notice info">{{ session('info') }}</div> @endif

        <h1>Connect Telegram</h1>
        <div class="muted">Connect your Telegram account so the support system can send ticket, SLA, and escalation alerts directly to you.</div>

        <div class="box">
            <div class="label">Your connect code</div>
            <div class="code">{{ $code }}</div>
        </div>

        <div class="grid">
            <div class="mini">
                <div class="label">Option A — Auto connect</div>
                <div class="muted">Open Telegram, search <strong>@xion1bot</strong>, then send this command:</div>
                <div class="box"><div class="cmd">/start {{ $code }}</div></div>
                <form method="POST" action="{{ route('telegram.connect.sync') }}">
                    @csrf
                    <button class="btn primary" type="submit">Sync Telegram</button>
                </form>
            </div>

            <div class="mini">
                <div class="label">Option B — Manual Chat ID</div>
                <div class="muted">If auto connect does not work, open <strong>@xion1bot</strong> and send this command:</div>
                <div class="box"><div class="cmd">/myid</div></div>

                <form method="POST" action="{{ route('telegram.connect.manual') }}">
                    @csrf
                    <input name="telegram_chat_id" placeholder="Paste Chat ID here, e.g. 8263093704" value="{{ old('telegram_chat_id', $user->telegram_chat_id) }}">
                    <div class="actions">
                        <button class="btn primary" type="submit">Save Chat ID</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="actions">
            <form method="POST" action="{{ route('telegram.connect.test') }}">
                @csrf
                <button class="btn" type="submit">Send Test Message</button>
            </form>

            <form method="POST" action="{{ route('telegram.connect.disconnect') }}">
                @csrf
                <button class="btn danger" type="submit">Disconnect</button>
            </form>

            <a class="btn" href="/problem-logs">Back</a>
        </div>

        <div class="status">
            @if($user->telegram_chat_id)
                <strong>Status:</strong> Connected ✅<br>
                <strong>Chat ID:</strong> {{ $user->telegram_chat_id }}<br>
                <strong>Linked at:</strong> {{ $user->telegram_linked_at ?: '-' }}
            @else
                <strong>Status:</strong> Not connected yet.
            @endif
        </div>
    </div>
</div>
</body>
</html>
