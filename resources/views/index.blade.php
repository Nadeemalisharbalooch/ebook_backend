<!DOCTYPE html>
<html>
<head>
    <style>
        .email-wrapper {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }

        .email-content {
            background-color: #ffffff;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .email-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .email-header h2 {
            color: #333333;
        }

        .email-body {
            font-size: 16px;
            color: #444444;
            line-height: 1.6;
        }

        .email-button {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 12px 0;
            text-align: center;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .email-footer {
            text-align: center;
            font-size: 14px;
            color: #888888;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="email-header">
                <h2>Welcome to {app_name}!</h2>
            </div>
            <div class="email-body">
                <p>Dear {name},</p>
                <p>Thank you for joining <strong>{app_name}</strong>. To get started, please verify your email address by clicking the button below:</p>
                <a href="{url}" class="email-button">Verify Email</a>
                <p>If the button above doesn't work, please copy and paste the following link into your browser:</p>
                <p><a href="{url}">{url}</a></p>
                <p>We’re excited to have you on board!</p>
                <p>Regards,<br>{app_name} Team</p>
            </div>
            <div class="email-footer">
                © {app_name} - All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
