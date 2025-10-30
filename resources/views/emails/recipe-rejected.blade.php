<!DOCTYPE html>
<html>
<head>
    <title>Recipe Submission Update</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.8;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header .emoji {
            font-size: 48px;
            margin-bottom: 10px;
            display: block;
        }
        .content {
            padding: 30px 20px;
        }
        .recipe-card {
            background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%);
            border: 2px solid #f59e0b;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .recipe-name {
            font-size: 24px;
            font-weight: bold;
            color: #92400e;
            margin-bottom: 10px;
        }
        .recipe-info {
            color: #b45309;
            font-size: 16px;
        }
        .message-box {
            background-color: #fff7ed;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }
        .encouragement {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1px solid #10b981;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        .action-button:hover {
            transform: translateY(-2px);
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .divider {
            border: 0;
            height: 2px;
            background: linear-gradient(to right, transparent, #f59e0b, transparent);
            margin: 20px 0;
        }
        .tips {
            background-color: #f0f9ff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .tips h3 {
            color: #1e40af;
            margin-top: 0;
        }
        .tips ul {
            color: #1e3a8a;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="emoji">📝</span>
            <h1>Recipe Submission Update</h1>
            <p style="margin: 10px 0 0 0; font-size: 18px;">Thank you for your submission</p>
        </div>

        <div class="content">
            <div class="message-box">
                <h2 style="color: #92400e; margin-top: 0;">Hello {{ $recipe->submitter_name }},</h2>
                <p style="margin-bottom: 0; font-size: 16px;">Thank you for taking the time to submit your recipe to our Community Recipe Book. We appreciate your interest in sharing your culinary creations with our community.</p>
            </div>

            <div class="recipe-card">
                <div class="recipe-name">📚 {{ $recipe->recipe_name }}</div>
                <div class="recipe-info">
                    <strong>📅 Submitted:</strong> {{ $recipe->created_at->format('F j, Y') }}<br>
                    <strong>👤 Submitter:</strong> {{ $recipe->submitter_name }}<br>
                    @if($recipe->prep_time)
                    <strong>⏱️ Prep Time:</strong> {{ $recipe->prep_time }}
                    @endif
                </div>
            </div>

            <hr class="divider">

            <p style="font-size: 16px; text-align: center; margin: 30px 0;">
                After careful review, we're unable to publish your recipe at this time. This doesn't reflect the quality of your cooking - sometimes submissions don't align with our current content guidelines or formatting requirements.
            </p>

            @if($reason)
            <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 15px; margin: 20px 0;">
                <h4 style="color: #dc2626; margin-top: 0;">💬 Feedback:</h4>
                <p style="color: #7f1d1d; margin-bottom: 0;">{{ $reason }}</p>
            </div>
            @endif

            <div class="encouragement">
                <h3 style="color: #065f46; margin-top: 0;">🌟 Don't Give Up!</h3>
                <p style="margin-bottom: 0; color: #047857;">We encourage you to review our guidelines and submit again. Many successful recipes have been revised and resubmitted. Your culinary voice matters to our community!</p>
            </div>

            <div class="tips">
                <h3>📋 Tips for Future Submissions:</h3>
                <ul>
                    <li>✅ Include clear, step-by-step instructions</li>
                    <li>📏 Provide specific measurements and quantities</li>
                    <li>🥄 List ingredients in order of use</li>
                    <li>⏰ Include accurate prep and cooking times</li>
                    <li>📸 Add a high-quality photo if possible</li>
                    <li>🔍 Double-check spelling and formatting</li>
                </ul>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('recipes.create') }}" class="action-button">
                    🚀 Submit Another Recipe
                </a>
            </div>

            <div style="background-color: #f9fafb; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
                <p style="margin: 0; color: #6b7280; font-size: 14px;">
                    <strong>💡 Need help?</strong> Feel free to reach out if you have questions about our submission guidelines.
                </p>
            </div>
        </div>

        <div class="footer">
            <p><strong>Thank you for being part of our Community Recipe Book!</strong></p>
            <p>We look forward to your future submissions and hope to feature your recipes soon! 👨‍🍳👩‍🍳</p>
            <hr style="margin: 15px 0; border: 0; height: 1px; background-color: #e5e7eb;">
            <p>© {{ date('Y') }} Community Recipe Book | <a href="{{ route('recipes.index') }}" style="color: #3b82f6;">Visit Our Website</a></p>
        </div>
    </div>
</body>
</html>