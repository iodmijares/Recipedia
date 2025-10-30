<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification - {{ $appName }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            line-height: 1.6;
            color: #4a5568;
            margin-bottom: 30px;
        }
        .otp-container {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border: 2px dashed #cbd5e0;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-label {
            font-size: 14px;
            font-weight: 600;
            color: #718096;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 700;
            color: #2d3748;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            background: #ffffff;
            padding: 15px 25px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            display: inline-block;
            margin: 0;
        }
        .otp-validity {
            font-size: 14px;
            color: #e53e3e;
            margin-top: 15px;
            font-weight: 500;
        }
        .instructions {
            background: #f0fff4;
            border-left: 4px solid #48bb78;
            padding: 20px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }
        .instructions h3 {
            margin: 0 0 10px 0;
            color: #2f855a;
            font-size: 16px;
        }
        .instructions p {
            margin: 0;
            color: #276749;
            font-size: 14px;
        }
        .security-notice {
            background: #fefcbf;
            border: 1px solid #f6e05e;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
        }
        .security-notice h3 {
            margin: 0 0 10px 0;
            color: #d69e2e;
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        .security-notice p {
            margin: 0;
            color: #744210;
            font-size: 14px;
        }
        .footer {
            background: #f7fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            margin: 0;
            color: #718096;
            font-size: 14px;
        }
        .company-info {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }
        @media (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .header, .content, .footer {
                padding: 30px 20px;
            }
            .otp-code {
                font-size: 28px;
                letter-spacing: 4px;
            }
        }
    </style>
</head>
<body>
    <div style="padding: 20px 0;">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <h1>{{ $appName }}</h1>
                <p>Email Verification Required</p>
            </div>

            <!-- Content -->
            <div class="content">
                <div class="greeting">Hello {{ $user->name }},</div>
                
                <div class="message">
                    Thank you for registering with {{ $appName }}! To complete your account setup and ensure the security of your account, please verify your email address using the verification code below.
                </div>

                <!-- OTP Container -->
                <div class="otp-container">
                    <div class="otp-label">Your Verification Code</div>
                    <div class="otp-code">{{ $otp }}</div>
                    <div class="otp-validity">⏰ This code expires in 10 minutes</div>
                </div>

                <!-- Instructions -->
                <div class="instructions">
                    <h3>📋 How to verify your email:</h3>
                    <p>1. Return to the {{ $appName }} verification page<br>
                    2. Enter the 6-digit code shown above<br>
                    3. Click "Verify Email" to complete the process</p>
                </div>

                <!-- Security Notice -->
                <div class="security-notice">
                    <h3>🔒 Security Notice</h3>
                    <p>This verification code is unique to your account and should not be shared with anyone. If you didn't request this verification, please ignore this email or contact our support team if you have concerns.</p>
                </div>

                <div class="message">
                    If you're having trouble with verification, you can request a new code from the verification page.
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>This email was sent to <strong>{{ $user->email }}</strong> as part of the account verification process.</p>
                
                <div class="company-info">
                    <p>&copy; {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
                    <p>Community Recipe Book - Share Your Culinary Creations</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>