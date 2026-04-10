<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Xion1</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            color: white;
        }

        .shell {
            width: 100%;
            max-width: 1120px;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 28px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.30);
        }

        .left {
            padding: 56px 48px;
            background: linear-gradient(135deg, rgba(15,23,42,0.88), rgba(30,58,138,0.72));
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.82);
            margin-bottom: 28px;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #60a5fa, #22d3ee);
            color: #020617;
            font-weight: 900;
            box-shadow: 0 0 24px rgba(96,165,250,0.35);
        }

        .left h1 {
            margin: 0 0 14px;
            font-size: 38px;
            line-height: 1.08;
        }

        .left p {
            margin: 0;
            color: rgba(255,255,255,0.76);
            line-height: 1.7;
            max-width: 500px;
            font-size: 15px;
        }

        .feature-box {
            margin-top: 28px;
            padding: 18px 20px;
            border-radius: 18px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.82);
            font-size: 14px;
            line-height: 1.7;
        }

        .right {
            padding: 48px 42px;
            background: rgba(255,255,255,0.96);
            color: #0f172a;
            display: flex;
            align-items: center;
        }

        .form-wrap {
            width: 100%;
        }

        .form-wrap h2 {
            margin: 0 0 8px;
            font-size: 28px;
            color: #0f172a;
        }

        .sub {
            margin-bottom: 24px;
            color: #64748b;
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
            box-shadow: 0 12px 24px rgba(37,99,235,0.24);
            margin-top: 4px;
        }

        .login-box {
            margin-top: 18px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        .link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
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

        @media (max-width: 900px) {
            .shell {
                grid-template-columns: 1fr;
                max-width: 560px;
            }

            .left, .right {
                padding: 32px 24px;
            }

            .left h1 {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        <div class="left">
            <div class="brand">
                <span class="brand-mark">X1</span>
                Xion1 Portal
            </div>

            <h1>Create your customer access</h1>
            <p>
                Register to submit incidents, track ticket progress, and access your company dashboard after approval.
            </p>

            <div class="feature-box">
                New accounts require admin approval before they can access the full portal.
            </div>
        </div>

        <div class="right">
            <div class="form-wrap">
                <h2>Create account</h2>
                <div class="sub">Register your access for the Xion1 support portal.</div>

                @if ($errors->any())
                    <div class="error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <label class="label">Full Name</label>
                    <input class="input" type="text" name="name" value="{{ old('name') }}" required autofocus>

                    <label class="label">Email</label>
                    <input class="input" type="email" name="email" value="{{ old('email') }}" required>

                    <label class="label">Password</label>
                    <input class="input" type="password" name="password" required>

                    <label class="label">Confirm Password</label>
                    <input class="input" type="password" name="password_confirmation" required>

                    <button class="btn" type="submit">Create Account</button>
                </form>

                <div class="login-box">
                    Already have an account?
                    <a class="link" href="{{ route('login') }}">Login here</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
