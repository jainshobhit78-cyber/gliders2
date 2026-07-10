<!DOCTYPE html>
<html>

<head>
    <title>Verify OTP</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;

            /* 🔥 SU-30 Background */
            background: url('{{ url('backend/assets/images/su-30.jpg') }}') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Dark Overlay */
        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            max-width: 380px;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2A538E;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #2A538E;
            outline: none;
        }

        .btn-login {
            width: 100%;
            background: #2A538E;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-login:hover {
            background: #1d3f6f;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <a href="{{ url('admin/login') }}">
            <img src="{{ url('backend/assets/images/logo/gliders.png') }}" width="100%">
        </a>
        <h2>Verify OTP</h2>

        @if(session('success'))
            <div style="color:green; font-size:14px; margin-bottom:15px; text-align:center;">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div style="color:red; font-size:14px; margin-bottom:15px; text-align:center;">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ url('admin/verify-otp') }}">
            @csrf

            <!-- Hidden input for Email, pre-filled from session if available -->
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', session('reset_email')) }}" placeholder="Enter email" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>OTP Verification Code</label>
                <input type="text" name="otp" class="form-control" placeholder="Enter 6-digit OTP" maxlength="6" required style="font-weight: bold; letter-spacing: 2px; text-align: center;">
                @error('otp')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter new password" required>
                <small style="color: #64748b; font-size: 11px; display: block; margin-top: 5px; line-height: 1.4;">
                    <strong>Requirements:</strong> At least 10 characters, including 1 uppercase, 1 lowercase, 1 number, and 1 special character (e.g., @$!%*?&#).
                </small>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required>
            </div>

            <button type="submit" class="btn-login">Verify & Reset Password</button>
        </form>
    </div>

</body>

</html>
