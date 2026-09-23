<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Verification | Gliders India</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            color: #eef5ff;
            font-family: Inter, Arial, sans-serif;
            background: radial-gradient(circle at 20% 10%, #173d72 0, #071a36 42%, #030b18 100%);
        }
        .otp-card {
            width: min(460px, 100%);
            padding: 34px;
            border: 1px solid rgba(126, 175, 232, .38);
            border-radius: 18px;
            background: rgba(5, 22, 50, .94);
            box-shadow: 0 28px 80px rgba(0, 0, 0, .42);
        }
        .brand { display: flex; align-items: center; gap: 14px; margin-bottom: 26px; }
        .brand img { width: 66px; height: 66px; object-fit: contain; background: #fff; border-radius: 12px; padding: 6px; }
        h1 { margin: 0; font-size: 25px; }
        .subtitle { color: #9eb8d7; font-size: 13px; margin-top: 4px; }
        .notice { margin: 0 0 22px; color: #c7d8ec; line-height: 1.6; }
        label { display: block; margin-bottom: 8px; font-weight: 700; }
        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #50749e;
            border-radius: 10px;
            background: #071a36;
            color: #fff;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: .32em;
            text-align: center;
        }
        button {
            width: 100%;
            margin-top: 18px;
            padding: 13px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, #f27b22, #ff9f43);
            color: #071a36;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
        }
        .alert { margin-bottom: 16px; padding: 12px; border-radius: 9px; line-height: 1.45; }
        .alert-success { background: rgba(47, 180, 112, .16); border: 1px solid #2fb470; }
        .alert-error { background: rgba(232, 76, 76, .15); border: 1px solid #e84c4c; }
        .back { display: block; margin-top: 18px; text-align: center; color: #9fc8ff; text-decoration: none; }
    </style>
</head>
<body>
    <main class="otp-card">
        <div class="brand">
            <img src="{{ url('backend/assets/images/logo/gliders.png') }}" alt="Gliders India">
            <div>
                <h1>Two-step verification</h1>
                <div class="subtitle">Admin Command Portal</div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <p class="notice">
            Enter the 6-digit code sent to <strong>{{ $recipientHint }}</strong>.
            The code expires in 10 minutes and can be used only once.
        </p>

        <form method="POST" action="{{ url('admin/login/otp') }}">
            @csrf
            <label for="otp">Verification code</label>
            <input id="otp" name="otp" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" autocomplete="one-time-code" required autofocus>
            <button type="submit">Verify and open dashboard</button>
        </form>

        <a class="back" href="{{ route('admin.login') }}">Return to secure login</a>
    </main>
</body>
</html>
