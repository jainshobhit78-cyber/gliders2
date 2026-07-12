<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gliders India Limited - OTP Verification</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at center, #111a2e 0%, #070b12 100%);
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Tactical HUD Grid Overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                linear-gradient(rgba(0, 240, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 240, 255, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 1;
        }

        /* Ambient scanline scan effect */
        body::after {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(to bottom, transparent, rgba(0, 240, 255, 0.1), transparent);
            animation: scan 8s linear infinite;
            z-index: 2;
            pointer-events: none;
        }

        @keyframes scan {
            0% { top: -5%; }
            100% { top: 105%; }
        }

        /* Top Header Area outside the card */
        .portal-header {
            position: relative;
            z-index: 10;
            text-align: center;
            margin-bottom: 25px;
        }

        .portal-logo {
            width: 130px;
            height: auto;
            display: block;
            margin: 0 auto 15px auto;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }

        .portal-header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 5px 0;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .portal-subtitle {
            font-family: 'Share Tech Mono', monospace;
            color: #ff9f0a;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 0;
            text-shadow: 0 0 8px rgba(255, 159, 10, 0.4);
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 10px;
        }

        /* Corner Brackets for Tech Aesthetic */
        .corner-bracket {
            position: absolute;
            width: 16px;
            height: 16px;
            border: 2px solid #00f0ff;
            z-index: 15;
            pointer-events: none;
        }
        .top-left { top: 0; left: 0; border-right: none; border-bottom: none; }
        .top-right { top: 0; right: 0; border-left: none; border-bottom: none; }
        .bottom-left { bottom: 0; left: 0; border-right: none; border-top: none; }
        .bottom-right { bottom: 0; right: 0; border-left: none; border-top: none; }

        .login-container {
            background: rgba(13, 22, 38, 0.85);
            border: 1px solid rgba(0, 240, 255, 0.25);
            padding: 30px 25px;
            border-radius: 4px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.6),
                0 0 30px rgba(0, 240, 255, 0.05),
                inset 0 0 15px rgba(0, 240, 255, 0.05);
            transition: border-color 0.3s;
        }

        .login-container:hover {
            border-color: rgba(0, 240, 255, 0.45);
        }

        /* Top Security Bar */
        .security-header {
            font-family: 'Share Tech Mono', monospace;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: #8a99ad;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(0, 240, 255, 0.15);
            padding-bottom: 8px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            background-color: #ff9f0a;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
            box-shadow: 0 0 8px #ff9f0a;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.4; }
            50% { opacity: 1; }
            100% { opacity: 0.4; }
        }

        h2 {
            font-family: 'Share Tech Mono', monospace;
            text-align: center;
            margin: 0 0 20px 0;
            color: #ffffff;
            font-size: 18px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 11px;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #8a99ad;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            background: rgba(8, 14, 25, 0.9);
            border: 1px solid #2b3e5c;
            border-radius: 4px;
            color: #ffffff;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s;
        }

        .form-control::placeholder {
            color: #4f647f;
        }

        .form-control:focus {
            border-color: #00f0ff;
            outline: none;
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.25);
            background: rgba(8, 14, 25, 1);
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #00bfff 0%, #007acc 100%);
            color: #ffffff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 700;
            font-family: 'Share Tech Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 122, 204, 0.4);
            margin-top: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #00f0ff 0%, #0099ff 100%);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.6);
            transform: translateY(-1px);
        }

        .extra {
            display: flex;
            justify-content: center;
            font-size: 11px;
            margin-top: 15px;
            color: #8a99ad;
        }

        .extra a {
            color: #00f0ff;
            text-decoration: none;
            transition: color 0.2s;
            font-family: 'Share Tech Mono', monospace;
        }

        .extra a:hover {
            color: #ffffff;
            text-shadow: 0 0 5px rgba(0, 240, 255, 0.5);
        }

        .error {
            color: #ff3b30;
            font-family: 'Share Tech Mono', monospace;
            font-size: 11px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            letter-spacing: 0.5px;
        }

        .error::before {
            content: "[!] ";
            margin-right: 4px;
            font-weight: bold;
        }

        .success-msg {
            color: #34c759;
            font-family: 'Share Tech Mono', monospace;
            font-size: 12px;
            margin-bottom: 12px;
            padding: 8px;
            background: rgba(52, 199, 89, 0.1);
            border-left: 3px solid #34c759;
            letter-spacing: 0.5px;
        }

        .error-msg {
            color: #ff3b30;
            font-family: 'Share Tech Mono', monospace;
            font-size: 12px;
            margin-bottom: 12px;
            padding: 8px;
            background: rgba(255, 59, 48, 0.1);
            border-left: 3px solid #ff3b30;
            letter-spacing: 0.5px;
        }

        .requirements-note {
            color: #8a99ad;
            font-size: 10px;
            display: block;
            margin-top: 4px;
            line-height: 1.4;
            background: rgba(0, 240, 255, 0.03);
            border: 1px solid rgba(0, 240, 255, 0.1);
            padding: 6px;
            border-radius: 4px;
        }

        .requirements-note strong {
            color: #00f0ff;
        }

        .eye-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #00f0ff;
            font-size: 14px;
            opacity: 0.7;
            transition: opacity 0.2s;
            user-select: none;
        }

        .eye-btn:hover {
            opacity: 1;
        }

        /* Warning Banner at Bottom */
        .system-warning {
            font-family: 'Share Tech Mono', monospace;
            font-size: 9px;
            color: #ff9f0a;
            text-align: center;
            margin-top: 20px;
            border-top: 1px solid rgba(255, 159, 10, 0.15);
            padding-top: 10px;
            letter-spacing: 1px;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <!-- Header area with logo and title outside the login container -->
    <div class="portal-header">
        <a href="{{ url('admin/login') }}">
            <img src="{{ url('backend/assets/images/logo/gliders.png') }}" class="portal-logo" alt="Gliders India Logo">
        </a>
        <h1>Gliders India Limited</h1>
        <div class="portal-subtitle">Website Management</div>
    </div>

    <div class="login-wrapper">
        <!-- Corner brackets for style -->
        <div class="corner-bracket top-left"></div>
        <div class="corner-bracket top-right"></div>
        <div class="corner-bracket bottom-left"></div>
        <div class="corner-bracket bottom-right"></div>

        <div class="login-container">
            <div class="security-header">
                <div>
                    <span class="status-dot"></span>
                    <span>SECURE NODE: GLD-09</span>
                </div>
                <div>SYS_AUTH_v4.2</div>
            </div>

            <h2>OTP Verification</h2>

            @if(session('success'))
                <div class="success-msg">[✓] {{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="error-msg">[!] {{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ url('admin/verify-otp') }}">
                @csrf

                <div class="form-group">
                    <label for="email">User Signature (Email)</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', session('reset_email')) }}" placeholder="Enter email" required>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="otp">One-Time Decryption Code (OTP)</label>
                    <input type="text" id="otp" name="otp" class="form-control" placeholder="000000" maxlength="6" required style="font-weight: bold; font-family: 'Share Tech Mono', monospace; letter-spacing: 4px; text-align: center; color: #00f0ff; font-size: 16px;">
                    @error('otp')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Key Signature (Password)</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••••••" required>
                        <span class="eye-btn" onclick="togglePassword('password')">👁</span>
                    </div>
                    <div class="requirements-note">
                        <strong>Requirements:</strong> Min 10 chars, 1 uppercase, 1 lowercase, 1 number, and 1 special symbol (@$!%*?&#).
                    </div>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Key Signature</label>
                    <div class="input-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••••••" required>
                        <span class="eye-btn" onclick="togglePassword('password_confirmation')">👁</span>
                    </div>
                </div>

                <button type="submit" class="btn-login">Verify & Reset Credentials</button>
            </form>

            <div class="extra">
                <a href="{{ url('admin/login') }}">◄ Back to Secure Terminal</a>
            </div>

            <div class="system-warning">
                WARNING: YOU ARE ACCESSING A SECURE SYSTEM. UNSANCTIONED ACCESS OR ATTEMPTS ARE LOGGED AND SUBJECT TO IMMEDIATE TERMINATION AND PROSECUTION.
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const pass = document.getElementById(id);
            const wrapper = pass.closest('.input-wrapper');
            const btn = wrapper.querySelector('.eye-btn');
            if (pass.type === "password") {
                pass.type = "text";
                btn.textContent = "🙈";
            } else {
                pass.type = "password";
                btn.textContent = "👁";
            }
        }
    </script>
</body>
</html>
