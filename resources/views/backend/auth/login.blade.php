<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>

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
        }

        .form-control:focus {
            border-color: #2A538E;
            outline: none;
        }

        /* Password eye */
        .password-wrapper {
            position: relative;
        }

        .eye-btn {
            position: absolute;
            right: 0px;
            top: 30px;
            cursor: pointer;
            font-size: 14px;
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
        }

        .btn-login:hover {
            background: #1d3f6f;
        }

        .extra {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
            margin-top: 10px;
        }
    </style>

</head>

<body>

    <div class="login-container">

        <img src="{{ url('backend/assets/images/logo/gliders.png') }}" width="100%">

        <h2>Admin Login</h2>

        {{-- ✅ ERROR MESSAGE --}}
        <!-- @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif -->

        <form method="POST" action="{{ url('admin/login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group password-wrapper">
                <label>Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password"
                    required>
                <span class="eye-btn" onclick="togglePassword()">👁</span>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Security CAPTCHA: {{ $captcha_question }}</label>
                <input type="number" name="captcha" class="form-control" placeholder="Enter answer" required>
                @error('captcha')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="extra">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>

                <a href="{{ url('admin/forgot-password') }}">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-login">Login</button>

        </form>

    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById("password");
            pass.type = pass.type === "password" ? "text" : "password";
        }
    </script>

</body>

</html>