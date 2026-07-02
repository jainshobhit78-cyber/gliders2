<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
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
            right: 10px;
            top: 35px;
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

<body style="font-family:Arial; display:flex; justify-content:center; align-items:center; height:100vh;">

    <div class="login-container">
        <a href="{{ url('admin/login') }}">
            <img src="{{ url('backend/assets/images/logo/gliders.png') }}" width="100%">
        </a>
        <h2>Forgot Password</h2>

        @if(session('success'))
            <div style="color:green;">{!! session('success') !!}</div>
        @endif

        <form method="POST">
            @csrf

            <input type="email" name="email" placeholder="Enter email" style="width:100%; padding:10px;">

            @error('email')
                <div style="color:red;">{{ $message }}</div>
            @enderror

            <br><br>

            <button type="submit" class="btn-login">Send Reset Link</button>
        </form>
    </div>

</body>

</html>