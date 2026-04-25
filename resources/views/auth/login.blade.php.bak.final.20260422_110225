<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(30, 94, 255, 0.22), transparent 28%),
                radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.20), transparent 24%),
                linear-gradient(115deg, #03133f 0%, #020c2c 45%, #173a88 100%);
            color: #0f172a;
        }

        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
        }

        .shell {
            width: min(980px, 90%);
            display: grid;
            grid-template-columns: 1.2fr 0.72fr;
            border-radius: 30px;
            overflow: hidden;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.10);
            box-shadow: 0 24px 60px rgba(0,0,0,0.34);
            backdrop-filter: blur(6px);
        }

        .left {
            min-height: 600px;
            padding: 40px 40px 32px;
            background: linear-gradient(135deg, rgba(6,22,74,0.92) 0%, rgba(19,42,109,0.88) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left-inner {
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        .logo-wrap {
            margin-bottom: 20px;
        }

        .logo-wrap img {
            max-width: 240px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .headline {
            margin-top: 16px;
            color: #ffffff;
            font-size: clamp(28px, 4vw, 40px);
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.02em;
            text-align: center;
        }

        .right {
            background: #f4f5f7;
            min-height: 560px;
            padding: 34px 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 340px;
        }

        .auth-card h1 {
            margin: 0 0 8px;
            font-size: 34px;
            line-height: 1;
            letter-spacing: -0.03em;
            color: #0f172a;
            font-weight: 800;
        }

        .auth-card p {
            margin: 0 0 24px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.45;
        }

        .field {
            margin-bottom: 14px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
        }

        .field input[type="email"],
        .field input[type="password"] {
            width: 100%;
            height: 46px;
            border-radius: 16px;
            border: 1px solid #d6dbe5;
            background: #fff;
            padding: 0 16px;
            font-size: 14px;
            outline: none;
            transition: 0.2s ease;
        }

        .field input[type="email"]:focus,
        .field input[type="password"]:focus {
            border-color: #4f8cff;
            box-shadow: 0 0 0 4px rgba(79, 140, 255, 0.14);
        }

        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 6px 0 18px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 12px;
        }

        .remember input {
            width: 16px;
            height: 16px;
        }

        .forgot {
            color: #2563eb;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
        }

        .login-btn {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            color: #fff;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.22);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.34);
        }

        .bottom-link {
            margin-top: 18px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }

        .bottom-link a {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
        }

        .status, .errors {
            margin-bottom: 18px;
            border-radius: 14px;
            padding: 14px 16px;
            font-size: 15px;
        }

        .status {
            background: #ecfdf3;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .errors {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .errors ul {
            margin: 0;
            padding-left: 18px;
        }

        @media (max-width: 980px) {
            .shell {
            width: min(980px, 90%);
            display: grid;
            grid-template-columns: 1.2fr 0.72fr;
            border-radius: 30px;
            overflow: hidden;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.10);
            box-shadow: 0 24px 60px rgba(0,0,0,0.34);
            backdrop-filter: blur(6px);
        }
            .left, .right {
            background: #f4f5f7;
            min-height: 560px;
            padding: 34px 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
            .left {
            min-height: 600px;
            padding: 40px 40px 32px;
            background: linear-gradient(135deg, rgba(6,22,74,0.92) 0%, rgba(19,42,109,0.88) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
            .right {
            background: #f4f5f7;
            min-height: 560px;
            padding: 34px 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
            .auth-card h1 {
            margin: 0 0 8px;
            font-size: 34px;
            line-height: 1;
            letter-spacing: -0.03em;
            color: #0f172a;
            font-weight: 800;
        }
            .auth-card p {
            margin: 0 0 24px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.45;
        }
            .headline {
            margin-top: 16px;
            color: #ffffff;
            font-size: clamp(28px, 4vw, 40px);
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.02em;
            text-align: center;
        }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="shell">
            <section class="left">
                <div class="left-inner">
                    <div class="logo-wrap">
                        <img src="{{ asset('images/xion1.png') }}" alt="Xion1">
                    </div>
                    <h2 class="headline">Incident Portal</h2>
                </div>
            </section>

            <section class="right">
                <div class="auth-card">
                    <h1>Sign in</h1>
                    <p>Login to continue to the ticketing system.</p>

                    @if (session('status'))
                        <div class="status">{{ session('status') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="errors">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="field">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        </div>

                        <div class="field">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password">
                        </div>

                        <div class="row">
                            <label class="remember" for="remember_me">
                                <input id="remember_me" type="checkbox" name="remember">
                                <span>Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="forgot" href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>

                        <button type="submit" class="login-btn">Login</button>

                        @if (Route::has('register'))
                            <div class="bottom-link">
                                Don’t have an account? <a href="{{ route('register') }}">Register here</a>
                            </div>
                        @endif
                    </form>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
