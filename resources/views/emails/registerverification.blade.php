<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Account</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #f1f1f1; padding-bottom: 20px; }
        .logo { color: #2563eb; font-size: 24px; font-weight: bold; text-decoration: none; }
        .content { padding: 30px 0; line-height: 1.6; }
        .code-box { background-color: #f8f9fa; border: 2px dashed #2563eb; padding: 20px; text-align: center; margin: 20px 0; border-radius: 6px; }
        .verification-code { font-size: 32px; font-weight: bold; color: #2563eb; letter-spacing: 8px; font-family: 'Courier New', monospace; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ config('app.url') }}" class="logo">CODEVAULT</a>
        </div>
        <div class="content">
            <h2>Hello!</h2>
            <p>Thank you for registering with CodeVault. To complete your registration, please verify your email address using the code below:</p>
            
            <div class="code-box">
                <div class="verification-code">{{ $verificationCode }}</div>
            </div>

            <p>Enter this code on the verification page to activate your account.</p>
            <p><strong>This code will expire in 10 minutes.</strong></p>
            <p>If you did not create an account with CodeVault, please ignore this email.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} CodeVault. All rights reserved.
        </div>
    </div>
</body>
</html>
