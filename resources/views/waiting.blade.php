<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting Approval - Xion1</title>
    <style>
        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), transparent 40%),
                radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.18), transparent 40%),
                linear-gradient(135deg, #020617, #0f172a);
            color: white;
        }

        .card {
            text-align: center;
            padding: 40px;
            border-radius: 24px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.1);
            max-width: 420px;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            border-radius: 16px;
            background: linear-gradient(135deg, #3b82f6, #22d3ee);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: #020617;
        }

        h1 {
            margin: 0 0 12px;
            font-size: 24px;
        }

        p {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
            line-height: 1.6;
        }

        .btn {
            margin-top: 20px;
            padding: 12px 20px;
            border-radius: 12px;
            background: #ef4444;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">X1</div>
        <h1>Waiting for Approval</h1>
        <p>
            Your account has been created successfully.<br><br>
            Please wait for admin approval before accessing the system.
        </p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn">Logout</button>
        </form>
    </div>
</body>
</html>
