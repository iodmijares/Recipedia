<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $recipe->recipe_name }} - Recipe</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #222;
            margin: 0;
            padding: 32px;
            /* Fallback background for PDF readers that struggle with gradients */
            background-color: #fdf6fd; 
        }

        /* NOTE: Flexbox (display: flex) is NOT supported by dompdf. 
           We use tables and inline-blocks for layout compatibility.
        */
        .header-table {
            width: 100%;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 14px;
            margin-bottom: 32px;
            background-color: #fdf2f8; /* Fallback */
            border-radius: 16px 16px 0 0;
        }

        .logo-cell {
            width: 80px;
            vertical-align: middle;
            padding-left: 16px;
        }

        .content-cell {
            vertical-align: middle;
        }

        .title {
            font-size: 26px;
            font-weight: 700;
            color: #8b5cf6;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .meta {
            color: #666;
            font-size: 13px;
            margin-top: 2px;
            line-height: 1.4;
        }

        .section {
            margin-top: 24px;
            background-color: #f0f9ff; /* Fallback */
            border-radius: 12px;
            padding: 18px 16px;
            border: 1px solid #f3f4f6;
        }

        .section h3 {
            font-size: 16px;
            margin: 0 0 8px 0;
            color: #ec4899;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 4px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .ingredients, .instructions {
            margin: 0;
            font-size: 13px;
            padding-left: 16px;
            line-height: 1.6;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 30px;
            font-size: 12px;
            color: #8b5cf6;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            text-align: center;
            background-color: #f5f3ff;
        }

        .pdf-image {
            display: inline-block;
            max-width: 180px;
            height: auto;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 3px;
            margin-right: 10px;
            margin-bottom: 10px;
            vertical-align: top;
        }

        .ratings {
            margin-top: 6px;
        }

        .star {
            color: #fbbf24;
            font-size: 18px;
            display: inline-block;
        }

        .star-empty {
            color: #e5e7eb;
            font-size: 18px;
            display: inline-block;
        }

        .rating-value {
            color: #f59e42;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
            margin-left: 6px;
            position: relative;
            top: -2px; /* Visual alignment fix */
        }
    </style>
</head>
<body>
    
    <!-- Using Table instead of Flexbox for Header -->
    <table class="header-table" cellspacing="0" cellpadding="0">
        <tr>
            <td class="logo-cell">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="64" height="64">
                    <rect width="100" height="100" rx="12" fill="#10B981" />
                    <path d="M50 22c-8 0-14 6-14 14 0 18 14 26 14 42 0-16 14-24 14-42 0-8-6-14-14-14z" fill="#fff"/>
                </svg>
            </td>
            <td class="content-cell">
                <div class="title">{{ $recipe->recipe_name }}</div>
                <div class="meta">Submitted by: {{ $recipe->submitter_name }} @if($recipe->submitter_email) &middot; {{ $recipe->submitter_email }} @endif</div>
                @if($recipe->prep_time)
                    <div class="meta">Prep Time: {{ $recipe->prep_time }}</div>
                @endif
                <div class="meta">Date Added: {{ $recipe->created_at->format('F j, Y') }}</div>
                
                @if($recipe->ratings->count() > 0)
                    @php $avg = $recipe->ratings->avg('rating'); @endphp
                    <div class="ratings">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($avg))
                                <span class="star">&#9733;</span>
                            @else
                                <span class="star-empty">&#9733;</span>
                            @endif
                        @endfor
                        <span class="rating-value">{{ number_format($avg, 1) }}</span>
                    </div>
                @endif
            </td>
        </tr>
    </table>

    <div class="section">
        <h3>Ingredients</h3>
        <ul class="ingredients">
            @foreach(preg_split('/\r\n|\r|\n/', $recipe->ingredients) as $ingredient)
                @if(trim($ingredient))
                    <li>{{ trim($ingredient) }}</li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="section">
        <h3>Instructions</h3>
        <ol class="instructions">
            @foreach(preg_split('/\r\n|\r|\n/', $recipe->instructions) as $instruction)
                @if(trim($instruction))
                    <li>{{ trim(preg_replace('/^\d+\.\s*/', '', $instruction)) }}</li>
                @endif
            @endforeach
        </ol>
    </div>

    @php
        $images = is_array($recipe->recipe_images) ? $recipe->recipe_images : json_decode($recipe->recipe_images, true);
    @endphp
    @if($images && count($images) > 0)
        <div class="section">
            <h3>Photos</h3>
            <div>
                @foreach($images as $img)
                    @php 
                        // dompdf requires absolute paths for images on the filesystem
                        $imgPath = public_path('storage/' . $img); 
                    @endphp
                    @if(file_exists($imgPath))
                        <img src="{{ $imgPath }}" class="pdf-image" alt="Recipe Image">
                    @endif
                @endforeach
            </div>
            <!-- Clearfix for inline-block/float elements if needed -->
            <div style="clear: both;"></div>
        </div>
    @endif

    <div class="footer">
        Downloaded from Community Recipe Book — {{ url('/') }}
    </div>
</body>
</html>