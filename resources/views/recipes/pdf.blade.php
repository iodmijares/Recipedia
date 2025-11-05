<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $recipe->recipe_name }} - Recipe</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #333; margin: 28px; }
        .header { display: flex; align-items: center; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px; margin-bottom: 18px; }
        .logo { width: 72px; height: 72px; display: inline-block; margin-right: 12px; }
        .title { font-size: 22px; font-weight: 700; }
        .meta { color: #555; font-size: 12px; margin-top: 4px; }
        .section { margin-top: 16px; }
        .section h3 { font-size: 14px; margin-bottom: 8px; border-bottom: 1px solid #f3f4f6; padding-bottom: 6px; }
        .ingredients { margin-left: 12px; }
        .instructions { margin-left: 6px; }
        .footer { position: fixed; bottom: 12px; left: 28px; right: 28px; font-size: 11px; color: #888; border-top: 1px solid #eee; padding-top: 6px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <!-- Simple inline logo (keep in-PDF so it always renders) -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="72" height="72">
                <rect width="100" height="100" rx="12" fill="#10B981" />
                <path d="M50 22c-8 0-14 6-14 14 0 18 14 26 14 42 0-16 14-24 14-42 0-8-6-14-14-14z" fill="#fff"/>
            </svg>
        </div>
        <div>
            <div class="title">{{ $recipe->recipe_name }}</div>
            <div class="meta">Submitted by: {{ $recipe->submitter_name }} @if($recipe->submitter_email) &middot; {{ $recipe->submitter_email }} @endif</div>
            @if($recipe->prep_time)
                <div class="meta">Prep Time: {{ $recipe->prep_time }}</div>
            @endif
            <div class="meta">Date Added: {{ $recipe->created_at->format('F j, Y') }}</div>
        </div>
    </div>

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

    @if($recipe->recipe_image)
        <div class="section">
            <h3>Photo</h3>
            <div>
                @php
                    // Try to embed the image. DomPDF requires absolute path or data URI.
                    $path = public_path('storage/' . $recipe->recipe_image);
                @endphp
                @if(file_exists($path))
                    <img src="{{ $path }}" style="max-width:100%; height:auto; border:1px solid #eee; padding:4px;" alt="Recipe Image">
                @endif
            </div>
        </div>
    @endif

    <div class="footer">
        Downloaded from Community Recipe Book — {{ url('/') }}
    </div>
</body>
</html>
