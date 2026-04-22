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
    width: min(960px, 88%);
    display: grid;
    grid-template-columns: 1.1fr 0.75fr;
    border-radius: 28px;
    overflow: hidden;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 18px 50px rgba(0,0,0,0.28);
    backdrop-filter: blur(8px);
}

        .left {
    min-height: 520px;
    padding: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(6,22,74,0.92), rgba(19,42,109,0.88));
}

        .left-inner {
    max-width: 320px;
    text-align: center;
}

        .logo-wrap {
            margin-bottom: 20px;
        }

        .logo-wrap img {
    max-width: 180px;
    margin: 0 auto;
    display: block;
}

        .headline {
    margin-top: 14px;
    color: #ffffff;
    font-size: 28px;
    font-weight: 600;
    letter-spacing: -0.01em;
}

        .right {
        background: #f4f5f7;
        min-height: 520px;
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

        .auth-card {
        width: 100%;
        max-width: 320px;
        margin: 0 auto;
    }

        .auth-card h1 {
    margin: 0 0 6px;
    font-size: 26px;
    font-weight: 700;
}

        .auth-card p {
    margin: 0 0 18px;
    font-size: 13px;
    color: #64748b;
}

        .field {
    margin-bottom: 12px;
}

        .field label {
    font-size: 12px;
    margin-bottom: 6px;
}

        .field input[type="email"],
.field input[type="password"] {
    width: 100%;
    height: 42px;
    border-radius: 14px;
    border: 1px solid #d6dbe5;
    background: #fff;
    padding: 0 14px;
    font-size: 13px;
    display: block;
}

        .field input[type="email"]:focus,
        .field input[type="password"]:focus {
            border-color: #4f8cff;
            box-shadow: 0 0 0 4px rgba(79, 140, 255, 0.14);
        }

        .row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    margin: 8px 0 16px;
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
    height: 44px;
    border-radius: 14px;
    font-size: 14px;
    display: block;
}

        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.34);
        }

        .bottom-link {
    margin-top: 14px;
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
    width: min(960px, 88%);
    display: grid;
    grid-template-columns: 1.1fr 0.75fr;
    border-radius: 28px;
    overflow: hidden;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 18px 50px rgba(0,0,0,0.28);
    backdrop-filter: blur(8px);
}
            .left, .right {
        background: #f4f5f7;
        min-height: 520px;
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
            .left {
    min-height: 520px;
    padding: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(6,22,74,0.92), rgba(19,42,109,0.88));
}
            .right {
        background: #f4f5f7;
        min-height: 520px;
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
            .auth-card h1 {
    margin: 0 0 6px;
    font-size: 26px;
    font-weight: 700;
}
            .auth-card p {
    margin: 0 0 18px;
    font-size: 13px;
    color: #64748b;
}
            .headline {
    margin-top: 14px;
    color: #ffffff;
    font-size: 28px;
    font-weight: 600;
    letter-spacing: -0.01em;
}
        }
    
        @media (max-width: 768px) {
            body {
                min-height: 100dvh;
            }

            .page {
                min-height: 100dvh;
                padding: 14px;
                align-items: stretch;
            }

            .shell {
                width: 100%;
                min-height: calc(100dvh - 28px);
                grid-template-columns: 1fr;
                border-radius: 22px;
            }

            .left {
                min-height: auto;
                padding: 28px 20px 16px;
            }

            .left-inner {
                max-width: 100%;
            }

            .logo-wrap {
                margin-bottom: 14px;
            }

            .logo-wrap img {
                max-width: 150px;
            }

            .headline {
                margin-top: 8px;
                font-size: 22px;
                line-height: 1.15;
            }

            .right {
                min-height: auto;
                padding: 18px 20px 28px;
                align-items: flex-start;
            }

            .auth-card {
                max-width: 100%;
            }

            .auth-card h1 {
                font-size: 24px;
                margin-bottom: 6px;
            }

            .auth-card p {
                font-size: 13px;
                margin-bottom: 16px;
            }

            .field {
                margin-bottom: 12px;
            }

            .field label {
                font-size: 12px;
                margin-bottom: 6px;
            }

            .field input[type="email"],
            .field input[type="password"] {
                height: 44px;
                font-size: 14px;
                border-radius: 12px;
                padding: 0 14px;
            }

            .row {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 10px;
                margin: 8px 0 14px;
            }

            .remember,
            .forgot,
            .bottom-link {
                font-size: 12px;
            }

            .login-btn {
                height: 46px;
                font-size: 15px;
                border-radius: 12px;
            }
        }

        @media (max-width: 420px) {
            .page {
                padding: 10px;
            }

            .shell {
                min-height: calc(100dvh - 20px);
                border-radius: 18px;
            }

            .left {
                padding: 22px 16px 12px;
            }

            .right {
                padding: 14px 16px 22px;
            }

            .logo-wrap img {
                max-width: 132px;
            }

            .headline {
                font-size: 20px;
            }

            .auth-card h1 {
                font-size: 22px;
            }

            .field input[type="email"],
            .field input[type="password"] {
                height: 42px;
            }

            .login-btn {
                height: 44px;
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
