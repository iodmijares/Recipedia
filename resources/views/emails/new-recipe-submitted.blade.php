<!DOCTYPE html>
<html>
<head>
    <title>New Recipe Submitted</title>
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
        .message-box {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px 20px;
            margin-top: 20px;
            color: #065f46;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="emoji">🥗</span>
            <h1>New Recipe Submitted</h1>
            <p>A new recipe has been submitted to the Community Recipe Book and is awaiting approval.</p>
        </div>
        <div class="content">
            <div class="recipe-card">
                <div class="recipe-name">{{ $recipe->recipe_name }}</div>
                <div class="recipe-info"><strong>Submitted By:</strong> {{ $recipe->submitter_name }} ({{ $recipe->submitter_email }})</div>
                @if($recipe->prep_time)
                <div class="recipe-info"><strong>Prep Time:</strong> {{ $recipe->prep_time }}</div>
                @endif
                <div class="recipe-info"><strong>Ingredients:</strong> {{ $recipe->ingredients }}</div>
                <div class="recipe-info"><strong>Instructions:</strong> {{ $recipe->instructions }}</div>
                <div class="recipe-info"><strong>Submitted On:</strong> {{ $recipe->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
        <div class="message-box">
            Please review this recipe and approve it if it meets your guidelines.<br>
            Thank you for helping keep our community delicious!
        </div>
    </div>
</body>
</html>