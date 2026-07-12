<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tactical Command - Admin Login</title>
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
            background-color: #06090e;
            height: 100vh;
            display: flex;
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
                linear-gradient(rgba(0, 240, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 240, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 2;
        }

        /* Ambient scanline scan effect */
        body::after {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(to bottom, transparent, rgba(0, 240, 255, 0.08), transparent);
            animation: scan 10s linear infinite;
            z-index: 3;
            pointer-events: none;
        }

        @keyframes scan {
            0% { top: -5%; }
            100% { top: 105%; }
        }

        /* Top Header Navigation */
        .hud-header {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            z-index: 20;
            font-family: 'Share Tech Mono', monospace;
            border-bottom: 1px solid rgba(0, 240, 255, 0.1);
            background: rgba(6, 9, 14, 0.65);
            backdrop-filter: blur(5px);
        }

        .hud-header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .hud-header-left img {
            height: 35px;
            image-rendering: -webkit-optimize-contrast;
        }

        .system-meta {
            font-size: 11px;
            color: #5f728c;
            line-height: 1.3;
        }

        .system-meta span {
            display: block;
        }

        .system-meta .active-node {
            color: #00f0ff;
        }

        .hud-header-center {
            font-size: 13px;
            color: #00f0ff;
            text-align: center;
            letter-spacing: 2px;
            text-shadow: 0 0 8px rgba(0, 240, 255, 0.4);
        }

        .hud-header-right {
            font-size: 11px;
            color: #5f728c;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Bottom Footer Navigation */
        .hud-footer {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            z-index: 20;
            font-family: 'Share Tech Mono', monospace;
            border-top: 1px solid rgba(0, 240, 255, 0.1);
            background: rgba(6, 9, 14, 0.65);
            backdrop-filter: blur(5px);
            font-size: 11px;
            color: #5f728c;
        }

        .hud-footer-center {
            color: #00f0ff;
            opacity: 0.8;
            letter-spacing: 1px;
        }

        /* Tactical Side Panels (Visible on Large Desktop Screens) */
        .hud-panel {
            position: absolute;
            top: 60px;
            bottom: 50px;
            width: 28%;
            z-index: 10;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #5f728c;
        }

        .panel-left {
            left: 0;
            border-right: 1px solid rgba(0, 240, 255, 0.05);
            background: 
                linear-gradient(to right, rgba(6, 9, 14, 0.3) 0%, rgba(6, 9, 14, 0.98) 100%),
                url('{{ asset('uploads/products/1778848830_HEAVY DROP  P7.jpg') }}') no-repeat center center/cover;
        }

        .panel-right {
            right: 0;
            border-left: 1px solid rgba(0, 240, 255, 0.05);
            background: 
                linear-gradient(to left, rgba(6, 9, 14, 0.3) 0%, rgba(6, 9, 14, 0.98) 100%),
                url('{{ asset('uploads/products/1778765201_Brake Parachute (HYBRID) for LCA (TEJAS) Aircraft.jpg') }}') no-repeat center center/cover;
        }

        .panel-title {
            font-family: 'Share Tech Mono', monospace;
            font-size: 13px;
            color: #00f0ff;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .panel-desc {
            font-size: 11px;
            line-height: 1.5;
            color: #8a99ad;
        }

        .panel-tech-specs {
            margin-top: auto;
            border-top: 1px solid rgba(0, 240, 255, 0.1);
            padding-top: 15px;
        }

        .specs-label {
            font-family: 'Share Tech Mono', monospace;
            font-size: 11px;
            color: #ff9f0a;
            margin-bottom: 5px;
        }

        .specs-value {
            font-size: 10px;
            color: #5f728c;
            line-height: 1.4;
        }

        /* Responsive Hiding of Side Panels */
        @media (max-width: 1200px) {
            .hud-panel {
                display: none;
            }
        }

        /* Central Login Box Wrapper */
        .login-wrapper {
            position: relative;
            z-index: 15;
            width: 100%;
            max-width: 440px;
            padding: 15px;
        }

        /* Corner Brackets for Tech Aesthetic */
        .corner-bracket {
            position: absolute;
            width: 16px;
            height: 16px;
            border: 2px solid #00f0ff;
            z-index: 20;
            pointer-events: none;
        }
        .top-left { top: 0; left: 0; border-right: none; border-bottom: none; }
        .top-right { top: 0; right: 0; border-left: none; border-bottom: none; }
        .bottom-left { bottom: 0; left: 0; border-right: none; border-top: none; }
        .bottom-right { bottom: 0; right: 0; border-left: none; border-top: none; }

        .login-container {
            background: rgba(10, 16, 28, 0.92);
            border: 1px solid rgba(0, 240, 255, 0.2);
            padding: 35px 30px;
            border-radius: 4px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 
                0 20px 45px rgba(0, 0, 0, 0.8),
                inset 0 0 20px rgba(0, 240, 255, 0.05);
            transition: border-color 0.3s;
        }

        .login-container:hover {
            border-color: rgba(0, 240, 255, 0.45);
        }

        /* Inner Header containing Logo and Title */
        .inner-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .inner-logo {
            width: 130px;
            height: auto;
            margin-bottom: 12px;
            image-rendering: -webkit-optimize-contrast;
            filter: drop-shadow(0 0 10px rgba(0, 240, 255, 0.1));
        }

        .inner-header h1 {
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .inner-subtitle {
            font-family: 'Share Tech Mono', monospace;
            color: #00f0ff;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 4px 0 0 0;
        }

        /* Restricted warning box */
        .restricted-warning {
            background: rgba(0, 240, 255, 0.03);
            border: 1px dashed rgba(0, 240, 255, 0.15);
            border-radius: 4px;
            padding: 12px 15px;
            margin-bottom: 25px;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .restricted-icon {
            flex-shrink: 0;
            color: #ff9f0a;
        }

        .restricted-text {
            font-size: 11px;
            line-height: 1.4;
            color: #8a99ad;
        }

        .restricted-text strong {
            color: #ff9f0a;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-family: 'Share Tech Mono', monospace;
            font-size: 11px;
            display: block;
            margin-bottom: 8px;
            color: #8a99ad;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #00f0ff;
            opacity: 0.8;
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px 12px 42px;
            background: rgba(8, 14, 25, 0.8);
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
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.2);
            background: rgba(8, 14, 25, 0.95);
        }

        /* Password eye */
        .eye-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #00f0ff;
            font-size: 15px;
            opacity: 0.7;
            transition: opacity 0.2s;
            user-select: none;
        }

        .eye-btn:hover {
            opacity: 1;
        }

        .btn-login {
            width: 100%;
            background: rgba(0, 240, 255, 0.08);
            border: 1px solid #00f0ff;
            color: #00f0ff;
            padding: 14px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 700;
            font-family: 'Share Tech Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: rgba(0, 240, 255, 0.18);
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.4);
            text-shadow: 0 0 5px rgba(0, 240, 255, 0.6);
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
            font-family: 'Share Tech Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.5px;
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

        /* Bottom warning */
        .bottom-warning {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            margin-top: 25px;
            border-top: 1px solid rgba(255, 159, 10, 0.15);
            padding-top: 15px;
        }

        .warning-icon {
            flex-shrink: 0;
            color: #ff9f0a;
            margin-top: 2px;
        }

        .warning-text {
            font-family: 'Share Tech Mono', monospace;
            font-size: 9px;
            color: #ff9f0a;
            letter-spacing: 0.5px;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <!-- HUD Header -->
    <div class="hud-header">
        <div class="hud-header-left">
            <img src="{{ url('backend/assets/images/logo/gliders.png') }}" alt="Gliders India Logo">
            <div class="system-meta">
                <span>SYSTEM: DEFENCE GRADE PORTAL</span>
                <span class="active-node">ACCESS NODE: GIL-ADMIN-01</span>
            </div>
        </div>
        <div class="hud-header-center">
            [ CLASSIFIED - DEFCON 3 ]
        </div>
        <div class="hud-header-right">
            <span>SECURE LINK ENCRYPTED</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#5f728c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        </div>
    </div>

    <!-- HUD Left Side Panel (Heavy Drop Parachute) -->
    <div class="hud-panel panel-left">
        <div>
            <div class="panel-title">PARACHUTE SYSTEMS</div>
            <div class="panel-desc">AIRCRAFT • CARGO • PERSONAL</div>
            <div class="panel-desc" style="margin-top: 8px; opacity: 0.8;">Engineered for extreme environments and tactical operations. Trusted by defence forces globally.</div>
        </div>
        
        <div class="panel-tech-specs">
            <div class="specs-label">MIL-STD COMPLIANCE</div>
            <div class="specs-value">MIL-STD-810H / DEF STAN 00-970<br>Tactical Drop Certified</div>
        </div>
    </div>

    <!-- HUD Right Side Panel (Tejas Brake Parachute) -->
    <div class="hud-panel panel-right">
        <div style="text-align: right; width: 100%;">
            <div class="panel-title">FLIGHT TELEMETRY</div>
            <div class="panel-desc" style="font-family: 'Share Tech Mono', monospace; letter-spacing: 1px;">
                ALT: 04500 FT<br>
                SPD: 420 KTS<br>
                HDG: 225°
            </div>
        </div>
        
        <div class="panel-tech-specs" style="text-align: right; width: 100%;">
            <div class="specs-label">ENCRYPTION STATUS</div>
            <div class="specs-value" style="color: #39e09b;">
                AES-256 ENCRYPTED<br>
                CONNECTION SECURE
            </div>
        </div>
    </div>

    <!-- Central Login Box Wrapper -->
    <div class="login-wrapper">
        <!-- Corner brackets for style -->
        <div class="corner-bracket top-left"></div>
        <div class="corner-bracket top-right"></div>
        <div class="corner-bracket bottom-left"></div>
        <div class="corner-bracket bottom-right"></div>

        <div class="login-container">
            <div class="inner-header">
                <img src="{{ url('backend/assets/images/logo/gliders.png') }}" class="inner-logo" alt="Gliders India Logo">
                <h1>Gliders India Limited</h1>
                <div class="inner-subtitle">Admin Command Portal</div>
            </div>

            <!-- Restricted System Banner -->
            <div class="restricted-warning">
                <div class="restricted-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <div class="restricted-text">
                    <strong>Secure Access Required</strong><br>
                    Restricted system for authorized personnel only. All activities are monitored.
                </div>
            </div>

            <form method="POST" action="{{ url('admin/login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">User ID (Email)</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                        <input type="email" id="email" name="email" class="form-control" placeholder="username@gliders.com" required autocomplete="off">
                    </div>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Authentication Key (Password)</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
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
                        <div class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 11 2 2 4-4"></path></svg>
                        </div>
                        <input type="number" name="captcha" class="form-control" placeholder="Enter answer" required>
                    </div>
                    @error('captcha')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="extra">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember"> Keep Session Active
                    </label>

                    <a href="{{ url('admin/forgot-password') }}">Forgot Credentials?</a>
                </div>

                <button type="submit" class="btn-login">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    Authorize & Login
                </button>
            </form>

            <div class="bottom-warning">
                <div class="warning-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                </div>
                <div class="warning-text">
                    UNAUTHORIZED ACCESS OR ATTEMPTS ARE LOGGED AND SUBJECT TO IMMEDIATE TERMINATION AND PROSECUTION.
                </div>
            </div>
        </div>
    </div>

    <!-- HUD Footer -->
    <div class="hud-footer">
        <div>
            IP: 10.89.0.21 | LOCATION: INDIA
        </div>
        <div class="hud-footer-center">
            POWERED & PROTECTED BY GIL DEFENCE NETWORK
        </div>
        <div id="live-datetime">
            18 JUN 2025 | 14:52:31 IST
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

        // Live HUD Clock
        function updateClock() {
            const now = new Date();
            const options = { day: '2-digit', month: 'short', year: 'numeric' };
            const dateStr = now.toLocaleDateString('en-GB', options).toUpperCase();
            const timeStr = now.toLocaleTimeString('en-GB', { hour12: false });
            document.getElementById('live-datetime').textContent = `${dateStr} | ${timeStr} IST`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>