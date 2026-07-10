<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP - Gliders India Limited</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Helvetica, Arial, sans-serif; background-color: #f1f5f9; color: #1e293b;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; padding: 45px 0;">
        <tr>
            <td align="center">
                <table width="100%" max-width="540" cellpadding="0" cellspacing="0" style="max-width: 540px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(19, 35, 91, 0.06); border: 1px solid #e2e8f0;">
                    
                    <!-- Header Accent Bar -->
                    <tr>
                        <td height="6" style="background: linear-gradient(90deg, #13235b 0%, #f5821f 100%); line-height: 6px; font-size: 6px;">&nbsp;</td>
                    </tr>

                    <!-- Main Padding Box -->
                    <tr>
                        <td style="padding: 40px 35px 35px 35px;">
                            
                            <!-- Logo and Brand Header -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 25px;">
                                        <!-- Gliders Logo -->
                                        <img src="{{ $message->embed(public_path('backend/assets/images/logo/gliders.png')) }}" alt="Gliders India Limited" width="160" style="display: block; border: 0; outline: none; margin-bottom: 10px;">
                                        <div style="font-size: 11px; font-weight: 700; color: #13235b; letter-spacing: 2px; text-transform: uppercase; margin-top: 5px;">
                                            Gliders India Limited
                                        </div>
                                        <div style="font-size: 9px; color: #64748b; margin-top: 2px;">
                                            A Government of India Enterprise | Ministry of Defence
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Separator -->
                            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 0 0 25px 0;">

                            <!-- Email Body Content -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="font-size: 15px; line-height: 1.6; color: #334155;">
                                        Hello <strong>{{ $admin->name ?? 'Administrator' }}</strong>,
                                        <br><br>
                                        We received a request to reset the password for your Gliders India administrative account. Please use the following One-Time Password (OTP) code to authenticate your request:
                                    </td>
                                </tr>
                                
                                <!-- OTP Display Block -->
                                <tr>
                                    <td align="center" style="padding: 30px 0;">
                                        <table cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; width: 85%;">
                                            <tr>
                                                <td align="center" style="padding: 20px 10px; font-family: 'Courier New', Courier, monospace; font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #13235b;">
                                                    {{ $otp }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-size: 13.5px; line-height: 1.5; color: #64748b; padding-bottom: 25px;">
                                        👉 This security code is strictly valid for **60 minutes**. For security reasons, please do not share this email or OTP code with anyone.
                                    </td>
                                </tr>
                            </table>

                            <!-- Footer Signature -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-top: 1px solid #e2e8f0; padding-top: 20px;">
                                <tr>
                                    <td style="font-size: 12px; line-height: 1.5; color: #94a3b8; text-align: center;">
                                        If you did not initiate this request, you can safely ignore this email. Your account remains secure.
                                        <br><br>
                                        &copy; {{ date('Y') }} Gliders India Limited. All rights reserved.
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
