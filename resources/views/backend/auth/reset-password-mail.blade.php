<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background:#f5f5f5;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">

                <table width="400" cellpadding="0" cellspacing="0" 
                       style="background:#ffffff; padding:30px; border-radius:10px;">

                    <!-- Logo -->
                    <tr>
                        <td align="center">
                            <img src="{{ url('backend/assets/images/logo/gliders.png') }}" width="150">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td align="center" style="padding:20px 0;">
                            <h2 style="margin:0; color:#2A538E;">Reset Password</h2>
                        </td>
                    </tr>

                    <!-- Message -->
                    <tr>
                        <td style="font-size:14px; color:#333;">
                            Hello {{ $admin->name ?? 'User' }},<br><br>

                            You requested to reset your password.<br><br>

                            Click the button below to reset your password:
                        </td>
                    </tr>

                    <!-- Button -->
                    <tr>
                        <td align="center" style="padding:25px 0;">
                            <a href="{{ $link }}" 
                               style="background:#2A538E; color:#ffffff; padding:12px 25px; 
                                      text-decoration:none; border-radius:5px; display:inline-block;">
                                Reset Password
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="font-size:12px; color:#777;">
                            If you did not request this, please ignore this email.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>