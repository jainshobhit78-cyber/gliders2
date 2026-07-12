<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tactical Command - Reset Credentials</title>
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
            color: #ff9f0a;
        }

        .hud-header-center {
            font-size: 13px;
            color: #ff9f0a;
            text-align: center;
            letter-spacing: 2px;
            text-shadow: 0 0 8px rgba(255, 159, 10, 0.4);
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
            color: #ff9f0a;
            opacity: 0.8;
            letter-spacing: 1px;
        }

        /* Tactical Side Panels */
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
            border: 2px solid #2563eb;
            z-index: 20;
            pointer-events: none;
        }
        .top-left { top: 0; left: 0; border-right: none; border-bottom: none; }
        .top-right { top: 0; right: 0; border-left: none; border-bottom: none; }
        .bottom-left { bottom: 0; left: 0; border-right: none; border-top: none; }
        .bottom-right { bottom: 0; right: 0; border-left: none; border-top: none; }

        .login-container {
            background: rgba(10, 16, 28, 0.92);
            border: 1px solid rgba(37, 99, 235, 0.25);
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
            border-color: rgba(37, 99, 235, 0.45);
        }

        /* Inner Header */
        .inner-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .inner-logo {
            width: 130px;
            height: auto;
            margin-bottom: 12px;
            image-rendering: -webkit-optimize-contrast;
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
            color: #ff9f0a;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 4px 0 0 0;
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

        .form-control {
            width: 100%;
            padding: 12px 15px;
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
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 10px rgba(37, 99, 235, 0.2);
            background: rgba(8, 14, 25, 0.95);
        }

        .btn-login {
            width: 100%;
            background: rgba(37, 99, 235, 0.08);
            border: 1px solid #2563eb;
            color: #ffffff;
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
            background: rgba(37, 99, 235, 0.18);
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.4);
        }

        .extra {
            display: flex;
            justify-content: center;
            font-size: 12px;
            margin-top: 20px;
            color: #8a99ad;
        }

        .extra a {
            color: #2563eb;
            text-decoration: none;
            transition: color 0.2s;
            font-family: 'Share Tech Mono', monospace;
        }

        .extra a:hover {
            color: #ffffff;
            text-shadow: 0 0 5px rgba(37, 99, 235, 0.5);
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

        .eye-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #2563eb;
            font-size: 15px;
            opacity: 0.7;
            transition: opacity 0.2s;
            user-select: none;
        }

        .eye-btn:hover {
            opacity: 1;
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
            <a href="{{ url('admin/login') }}">
                <img src="{{ url('backend/assets/images/logo/gliders.png') }}" alt="Gliders India Logo">
            </a>
        </div>
        <div class="hud-header-right">
            <span>SECURE LINK ENCRYPTED</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#5f728c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        </div>
    </div>

    <!-- HUD Left Side Panel -->
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

    <!-- HUD Right Side Panel -->
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
            <div class="specs-value" style="color: #ff9f0a;">
                AUTHENTICATION IN PROGRESS<br>
                PENDING SIGNAL VALIDATION
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
                <div class="inner-subtitle">Key Reset</div>
            </div>

            <form method="POST" action="{{ url('admin/reset-password') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="password">New Key Signature (Password)</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••••••" required>
                        <span class="eye-btn" onclick="togglePassword('password')">👁</span>
                    </div>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Key Signature</label>
                    <div class="input-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••••••" required>
                        <span class="eye-btn" onclick="togglePassword('password_confirmation')">👁</span>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    Execute Key Reset
                </button>
            </form>

            <div class="extra">
                <a href="{{ url('admin/login') }}">◄ Back to Secure Terminal</a>
            </div>

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
        <div id="live-datetime">
            18 JUN 2025 | 14:52:31 IST
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