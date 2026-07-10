<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Password Reset OTP</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background:#f5f5f5;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">

                <table width="400" cellpadding="0" cellspacing="0" 
                       style="background:#ffffff; padding:30px; border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">

                    <!-- Logo -->
                    <tr>
                        <td align="center">
                            <img src="{{ url('backend/assets/images/logo/gliders.png') }}" width="180">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td align="center" style="padding:20px 0;">
                            <h2 style="margin:0; color:#2A538E;">Password Reset Verification</h2>
                        </td>
                    </tr>

                    <!-- Message -->
                    <tr>
                        <td style="font-size:14px; color:#333; line-height: 1.5;">
                            Hello {{ $admin->name ?? 'User' }},<br><br>

                            You are receiving this email because a password reset request was initiated for your account. Please use the following One-Time Password (OTP) to complete the reset process:
                        </td>
                    </tr>

                    <!-- OTP Code Box -->
                    <tr>
                        <td align="center" style="padding:25px 0;">
                            <div style="background:#f8fafc; border: 1px dashed #cbd5e1; color:#2A538E; padding:15px; 
                                       font-size: 28px; font-weight: bold; letter-spacing: 5px; border-radius:8px; display:inline-block; width: 80%;">
                                {{ $otp }}
                            </div>
                        </td>
                    </tr>

                    <!-- Warning -->
                    <tr>
                        <td style="font-size:13px; color:#64748b; padding-bottom: 20px;">
                            This OTP is valid for <strong>60 minutes</strong>. Do not share this OTP code with anyone.
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="font-size:12px; color:#94a3b8; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                            If you did not request this, please ignore this email.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
