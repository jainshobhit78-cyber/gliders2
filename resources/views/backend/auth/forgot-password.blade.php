<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gliders India Limited - Reset Credentials</title>
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
            background-color: #f4f6f9;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Light Tactical HUD Grid Overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                linear-gradient(rgba(42, 83, 142, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(42, 83, 142, 0.04) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 1;
        }

        /* Large Faded Watermark Text in Background */
        .bg-watermark {
            position: absolute;
            font-family: 'Share Tech Mono', monospace;
            font-size: 6.5vw;
            font-weight: 900;
            color: rgba(42, 83, 142, 0.03);
            text-transform: uppercase;
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
            user-select: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-12deg);
        }

        /* Top Header Area outside the card */
        .portal-header {
            position: relative;
            z-index: 10;
            text-align: center;
            margin-bottom: 25px;
        }

        .portal-logo {
            width: 140px;
            height: auto;
            display: block;
            margin: 0 auto 12px auto;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }

        .portal-header h1 {
            color: #1e293b;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 5px 0;
            letter-spacing: 0.5px;
        }

        .portal-subtitle {
            font-family: 'Share Tech Mono', monospace;
            color: #ff9f0a;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 0;
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
            border: 2px solid #2563eb;
            z-index: 15;
            pointer-events: none;
        }
        .top-left { top: 0; left: 0; border-right: none; border-bottom: none; }
        .top-right { top: 0; right: 0; border-left: none; border-bottom: none; }
        .bottom-left { bottom: 0; left: 0; border-right: none; border-top: none; }
        .bottom-right { bottom: 0; right: 0; border-left: none; border-top: none; }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(37, 99, 235, 0.2);
            padding: 30px 30px;
            border-radius: 4px;
            box-shadow: 
                0 15px 35px rgba(30, 41, 59, 0.1),
                0 0 30px rgba(37, 99, 235, 0.02);
            transition: border-color 0.3s;
        }

        .login-container:hover {
            border-color: rgba(37, 99, 235, 0.45);
        }

        /* Top Security Bar */
        .security-header {
            font-family: 'Share Tech Mono', monospace;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: #64748b;
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(37, 99, 235, 0.15);
            padding-bottom: 8px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            background-color: #ff9f0a;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
            box-shadow: 0 0 6px #ff9f0a;
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
            color: #1e293b;
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
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            color: #1e293b;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 8px rgba(37, 99, 235, 0.15);
            background: #ffffff;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
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
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.35);
            transform: translateY(-1px);
        }

        .extra {
            display: flex;
            justify-content: center;
            font-size: 12px;
            margin-top: 20px;
            color: #64748b;
        }

        .extra a {
            color: #2563eb;
            text-decoration: none;
            transition: color 0.2s;
            font-family: 'Share Tech Mono', monospace;
        }

        .extra a:hover {
            color: #1d4ed8;
            text-shadow: 0 0 2px rgba(37, 99, 235, 0.2);
        }

        .error {
            color: #dc2626;
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

        .success-msg {
            color: #34c759;
            font-family: 'Share Tech Mono', monospace;
            font-size: 13px;
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(52, 199, 89, 0.1);
            border-left: 3px solid #34c759;
            letter-spacing: 0.5px;
        }

        /* Warning Banner at Bottom */
        .system-warning {
            font-family: 'Share Tech Mono', monospace;
            font-size: 9px;
            color: #d97706;
            text-align: center;
            margin-top: 25px;
            border-top: 1px solid rgba(217, 119, 6, 0.15);
            padding-top: 12px;
            letter-spacing: 1px;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <!-- Faded watermark background text -->
    <div class="bg-watermark">GLIDERS INDIA LIMITED</div>

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

            <h2>Key Recovery</h2>

            @if(session('success'))
                <div class="success-msg">[✓] {{ session('success') }}</div>
            @endif

            <form method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Registered Email Signature</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" required>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Request Decryption Key</button>
            </form>

            <div class="extra">
                <a href="{{ url('admin/login') }}">◄ Back to Secure Terminal</a>
            </div>

            <div class="system-warning">
                WARNING: YOU ARE ACCESSING A SECURE SYSTEM. UNSANCTIONED ACCESS OR ATTEMPTS ARE LOGGED AND SUBJECT TO IMMEDIATE TERMINATION AND PROSECUTION.
            </div>
        </div>
    </div>

</body>
</html>
