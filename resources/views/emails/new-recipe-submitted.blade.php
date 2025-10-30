<!DOCTYPE html>
<html>
<head>
    <title>New Recipe Submitted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .recipe-details {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #495057;
        }
        .field-value {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Recipe Submitted</h1>
            <p>A new recipe has been submitted to the Community Recipe Book and is awaiting approval.</p>
        </div>

        <div class="recipe-details">
            <div class="field">
                <div class="field-label">Recipe Name:</div>
                <div class="field-value">{{ $recipe->recipe_name }}</div>
            </div>

            <div class="field">
                <div class="field-label">Submitted By:</div>
                <div class="field-value">{{ $recipe->submitter_name }} ({{ $recipe->submitter_email }})</div>
            </div>

            @if($recipe->prep_time)
            <div class="field">
                <div class="field-label">Prep Time:</div>
                <div class="field-value">{{ $recipe->prep_time }}</div>
            </div>
            @endif

            <div class="field">
                <div class="field-label">Ingredients:</div>
                <div class="field-value">{{ $recipe->ingredients }}</div>
            </div>

            <div class="field">
                <div class="field-label">Instructions:</div>
                <div class="field-value">{{ $recipe->instructions }}</div>
            </div>

            <div class="field">
                <div class="field-label">Submitted On:</div>
                <div class="field-value">{{ $recipe->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>

        <p style="margin-top: 20px; color: #6c757d; font-size: 14px;">
            Please review this recipe and approve it if it meets your guidelines.
        </p>
    </div>
</body>
</html>