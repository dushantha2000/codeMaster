<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #f1f1f1; padding-bottom: 20px; }
        .logo { color: #2563eb; font-size: 24px; font-weight: bold; text-decoration: none; }
        .content { padding: 30px 0; line-height: 1.6; }
        .button { display: block; width: 200px; margin: 20px auto; background-color: #2563eb; color: #ffffff !important; text-align: center; padding: 12px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; }
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
            <p>We received a request to reset the password for your CodeVault account. No changes have been made yet.</p>
            <p>You can reset your password by clicking the button below:</p>
            
            <a href="{{ url('/reset-password/'.$token) }}" class="button">Reset My Password</a>

            <p>If you did not request this, please ignore this email. This link will automatically expire in 60 minutes.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} CodeVault. All rights reserved.
        </div>
    </div>
</body>
</html>