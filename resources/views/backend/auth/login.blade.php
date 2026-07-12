<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gliders India Limited - Website Management</title>
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
            color: #00f0ff;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 0;
            text-shadow: 0 0 8px rgba(0, 240, 255, 0.4);
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
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
            padding: 30px 30px;
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
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(0, 240, 255, 0.15);
            padding-bottom: 8px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            background-color: #00f0ff;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
            box-shadow: 0 0 8px #00f0ff;
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
            margin-bottom: 20px;
        }

        label {
            font-size: 12px;
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            color: #8a99ad;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: rgba(8, 14, 25, 0.9);
            border: 1px solid #2b3e5c;
            border-radius: 4px;
            color: #ffffff;
            font-size: 14px;
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

        /* Password eye */
        .eye-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #00f0ff;
            font-size: 16px;
            opacity: 0.7;
            transition: opacity 0.2s;
            user-select: none;
        }

        .eye-btn:hover {
            opacity: 1;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #00bfff 0%, #007acc 100%);
            color: #ffffff;
            padding: 14px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Share Tech Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 122, 204, 0.4);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #00f0ff 0%, #0099ff 100%);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.6);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(1px);
        }

        .extra {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            margin-bottom: 25px;
            color: #8a99ad;
        }

        .extra a {
            color: #00f0ff;
            text-decoration: none;
            transition: color 0.2s;
        }

        .extra a:hover {
            color: #ffffff;
            text-shadow: 0 0 5px rgba(0, 240, 255, 0.5);
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-container input {
            margin-right: 6px;
            accent-color: #00f0ff;
        }

        .error {
            color: #ff3b30;
            font-family: 'Share Tech Mono', monospace;
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            letter-spacing: 0.5px;
        }

        .error::before {
            content: "[!] ";
            margin-right: 4px;
            font-weight: bold;
        }

        /* Warning Banner at Bottom */
        .system-warning {
            font-family: 'Share Tech Mono', monospace;
            font-size: 9px;
            color: #ff9f0a;
            text-align: center;
            margin-top: 25px;
            border-top: 1px solid rgba(255, 159, 10, 0.15);
            padding-top: 12px;
            letter-spacing: 1px;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <!-- Header area with logo and title outside the login container -->
    <div class="portal-header">
        <img src="{{ url('backend/assets/images/logo/gliders.png') }}" class="portal-logo" alt="Gliders India Logo">
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

            <h2>Access Control</h2>

            <form method="POST" action="{{ url('admin/login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">User Signature (Email)</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" class="form-control" placeholder="username@gliders.com" required autocomplete="off">
                    </div>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Authentication Key (Password)</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••••••" required>
                        <span class="eye-btn" onclick="togglePassword()">👁</span>
                    </div>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Decryption Verification: {{ $captcha_question }}</label>
                    <div class="input-wrapper">
                        <input type="number" name="captcha" class="form-control" placeholder="Compute Signature" required>
                    </div>
                    @error('captcha')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="extra">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember"> Keep Session Active
                    </label>

                    <a href="{{ url('admin/forgot-password') }}">Reset Credentials</a>
                </div>

                <button type="submit" class="btn-login">Authorize Entry</button>
            </form>

            <div class="system-warning">
                WARNING: YOU ARE ACCESSING A SECURE SYSTEM. UNSANCTIONED ACCESS OR ATTEMPTS ARE LOGGED AND SUBJECT TO IMMEDIATE TERMINATION AND PROSECUTION.
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById("password");
            const btn = document.querySelector(".eye-btn");
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