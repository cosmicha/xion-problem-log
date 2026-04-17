<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Ticketing System</title>
    <style>
        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), transparent 35%),
                radial-gradient(circle at bottom right, rgba(34, 211, 238, 0.18), transparent 35%),
                linear-gradient(135deg, #020617, #0f172a 45%, #1e3a8a 100%);
        }

        .card {
            width: 100%;
            max-width: 520px;
            background: rgba(255,255,255,0.97);
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        }

        h1 {
            margin: 0 0 10px;
            font-size: 28px;
            color: #0f172a;
        }

        p {
            margin: 0 0 20px;
            color: #64748b;
            line-height: 1.6;
            font-size: 14px;
        }

        .label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }

        .input {
            width: 100%;
            padding: 13px 14px;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            outline: none;
            font-size: 14px;
            margin-bottom: 16px;
            background: white;
            box-sizing: border-box;
        }

        .input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96,165,250,0.16);
        }

        .btn {
            width: 100%;
            padding: 14px 18px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }

        .error {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Reset password</h1>
        <p>Enter your email and your new password below.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <label class="label">Email</label>
            <input class="input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>

            <label class="label">New Password</label>
            <input class="input" type="password" name="password" required>

            <label class="label">Confirm Password</label>
            <input class="input" type="password" name="password_confirmation" required>

            <button class="btn" type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
