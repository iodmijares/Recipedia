<!DOCTYPE html>
<html>
<head>
    <title>Recipe Approved</title>
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border: 2px solid #10b981;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .recipe-name {
            font-size: 24px;
            font-weight: bold;
            color: #065f46;
            margin-bottom: 10px;
        }
        .recipe-info {
            color: #047857;
            font-size: 16px;
        }
        .congratulations {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }
        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
            background: linear-gradient(to right, transparent, #10b981, transparent);
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="emoji">🎉</span>
            <h1>Recipe Approved!</h1>
            <p style="margin: 10px 0 0 0; font-size: 18px;">Congratulations! Your recipe is now live!</p>
        </div>

        <div class="content">
            <div class="congratulations">
                <h2 style="color: #065f46; margin-top: 0;">Great News, {{ $recipe->submitter_name }}!</h2>
                <p style="margin-bottom: 0; font-size: 16px;">Your recipe submission has been reviewed and approved by our team. It's now published on the Community Recipe Book for everyone to enjoy!</p>
            </div>

            <div class="recipe-card">
                <div class="recipe-name">📚 {{ $recipe->recipe_name }}</div>
                <div class="recipe-info">
                    <strong>✨ Status:</strong> Published & Live<br>
                    @if($recipe->prep_time)
                    <strong>⏱️ Prep Time:</strong> {{ $recipe->prep_time }}<br>
                    @endif
                    <strong>📅 Published:</strong> {{ now()->format('F j, Y') }}
                </div>
            </div>

            <hr class="divider">

            <p style="font-size: 16px; text-align: center;">
                <strong>🌟 Your recipe is now helping other home cooks create delicious meals!</strong>
            </p>

            <div style="text-align: center;">
                <a href="{{ route('recipes.show', $recipe) }}" class="action-button">
                    👀 View Your Published Recipe
                </a>
            </div>

            <div style="background-color: #eff6ff; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #1e40af; margin-top: 0;">What's Next?</h3>
                <ul style="color: #1e3a8a; margin-bottom: 0;">
                    <li>✅ Your recipe is now visible to all visitors</li>
                    <li>🔗 Share the link with friends and family</li>
                    <li>📝 Consider submitting more recipes</li>
                    <li>💬 Engage with the community</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <p><strong>Thank you for contributing to our Community Recipe Book!</strong></p>
            <p>Keep cooking and sharing your amazing recipes with the world! 👨‍🍳👩‍🍳</p>
            <hr style="margin: 15px 0; border: 0; height: 1px; background-color: #e5e7eb;">
            <p>© {{ date('Y') }} Community Recipe Book | <a href="{{ route('recipes.index') }}" style="color: #3b82f6;">Visit Our Website</a></p>
        </div>
    </div>
</body>
</html>