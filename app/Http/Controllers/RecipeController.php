<?php

namespace App\Http\Controllers;

use App\Mail\NewRecipeSubmitted;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
// DomPDF facade (optional - package: barryvdh/laravel-dompdf)

class RecipeController extends Controller
{
    /**
     * Handle AJAX rating submission for a recipe.
     */
    public function rateAjax(Request $request, Recipe $recipe)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'Invalid request'], 400);
        }
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = \Auth::user();
        if (!$user) {
            return response()->json(['error' => 'You must be logged in to rate recipes.'], 401);
        }

        $existing = $recipe->ratings()->where('user_id', $user->id)->first();
        if ($existing) {
            $existing->update(['rating' => $validated['rating']]);
            $msg = 'Your rating has been updated!';
        } else {
            $recipe->ratings()->create([
                'user_id' => $user->id,
                'rating' => $validated['rating'],
            ]);
            $msg = 'Thank you for rating this recipe!';
        }

        $averageRating = $recipe->ratings()->avg('rating');
        $ratingsCount = $recipe->ratings()->count();
        $userRating = $recipe->ratings()->where('user_id', $user->id)->first()->rating;

        return response()->json([
            'message' => $msg,
            'averageRating' => number_format($averageRating, 1),
            'ratingsCount' => $ratingsCount,
            'userRating' => $userRating,
        ]);
    }
    /**
     * Handle rating submission for a recipe.
     */
    public function rate(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = \Auth::user();
        if (!$user) {
            return redirect()->route('recipes.show', $recipe)
                ->with('rating_status', 'You must be logged in to rate recipes.');
        }

        // Find existing rating for this user and recipe
        $existing = $recipe->ratings()->where('user_id', $user->id)->first();
        if ($existing) {
            $existing->update(['rating' => $validated['rating']]);
            $msg = 'Your rating has been updated!';
        } else {
            $recipe->ratings()->create([
                'user_id' => $user->id,
                'rating' => $validated['rating'],
            ]);
            $msg = 'Thank you for rating this recipe!';
        }

        return redirect()->route('recipes.show', $recipe)
            ->with('rating_status', $msg);
    }
    /**
     * Display the homepage with approved recipes.
     */
    public function index(Request $request)
    {
        $perPage = 9; 

        $recipes = Recipe::with(['user', 'ratings'])
            ->where('is_approved', true)
            ->latest()
            ->paginate($perPage)
            ->appends($request->except('page'));

        return view('recipes.index', compact('recipes'));
    }

    /**
     * Display the specified recipe.
     */
    public function show(Recipe $recipe)
    {
        // Only show approved recipes to general public
        if (!$recipe->is_approved) {
            abort(404);
        }

        $averageRating = $recipe->ratings()->avg('rating');
        $ratingsCount = $recipe->ratings()->count();

        return view('recipes.show', compact('recipe', 'averageRating', 'ratingsCount'));
    }

    /**
     * Show the form for creating a new recipe.
     */
    public function create()
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created recipe in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'recipe_name' => 'required|string|max:255',
            'prep_time_hours' => 'nullable|integer|min:0',
            'prep_time_minutes' => 'nullable|integer|min:0|max:59',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'recipe_images' => 'required|array|max:4',
            'recipe_images.*' => 'image|max:2048',
        ], [
            'recipe_images.max' => 'You can only upload a maximum of 4 images.',
        ]);

        // Combine prep time
        $prepTime = '';
        if (!empty($validated['prep_time_hours']) || !empty($validated['prep_time_minutes'])) {
            $hours = (int) ($validated['prep_time_hours'] ?? 0);
            $minutes = (int) ($validated['prep_time_minutes'] ?? 0);
            $parts = [];
            if ($hours > 0) {
                $parts[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
            }
            if ($minutes > 0) {
                $parts[] = $minutes . ' minute' . ($minutes > 1 ? 's' : '');
            }
            $prepTime = implode(' ', $parts);
        }

        // Get the authenticated user
        $user = auth()->user();

        try {
            // Handle multiple file uploads
            $imagePaths = [];
            if ($request->hasFile('recipe_images')) {
                foreach ($request->file('recipe_images') as $image) {
                    // Store the image using the default configured disk (Cloudinary or public)
                    // This returns the relative path/ID which is best for the database.
                    $imagePaths[] = $image->store('uploads');
                }
            }

            // Create new recipe record
            $recipe = new Recipe();
            $recipe->recipe_name = $validated['recipe_name'];
            if ($user) {
                $recipe->submitter_name = $user->name;
                $recipe->submitter_email = $user->email;
            } else {
                $recipe->submitter_name = 'Anonymous';
                $recipe->submitter_email = null;
            }
            $recipe->prep_time = $prepTime;
            $recipe->ingredients = $validated['ingredients'];
            $recipe->instructions = $validated['instructions'];
            $recipe->recipe_images = json_encode($imagePaths);
            $recipe->is_approved = false; // Default to false
            $recipe->save();

            // Send notification email to all admins
            try {
                $adminEmails = User::where('role', 'admin')->pluck('email')->toArray();
                if (!empty($adminEmails)) {
                    Mail::to($adminEmails)->send(new NewRecipeSubmitted($recipe));
                } else {
                    // Fallback to app admin email if no admin users found
                    $fallbackEmail = config('app.admin_email', 'admin@example.com');
                    Mail::to($fallbackEmail)->send(new NewRecipeSubmitted($recipe));
                }
            } catch (\Throwable $e) {
                Log::warning('Failed to send recipe notification email: ' . $e->getMessage());
                // Continue with success response even if email fails
            }

            // Redirect with success message (global toast)
            return redirect('/')->with('toast_success', "Thank you! Your recipe '{$recipe->recipe_name}' has been submitted for review.");

        } catch (\Throwable $e) {
            // Log the error
            Log::error('Recipe submission failed: ' . $e->getMessage());

            // Redirect back with error message (global toast)
            return back()->with('toast_error', 'An error occurred while submitting your recipe. Please try again.');
        }
    }

    /**
     * Download recipe as a text file.
     */
    public function download(Recipe $recipe)
    {
        // Prefer generating a PDF using barryvdh/laravel-dompdf if available.
        // If the package is not installed or PDF creation fails, fall back to a plain text download.

        $safeName = preg_replace('/[^A-Za-z0-9\-]/', '_', $recipe->recipe_name);
        $pdfFilename = $safeName . '_recipe.pdf';

        try {
            // If the DomPDF wrapper is bound (package installed), render the PDF view
            if (app()->bound('dompdf.wrapper')) {
                $pdf = app('dompdf.wrapper')->loadView('recipes.pdf', compact('recipe'))
                    ->setPaper('a4', 'portrait');

                return $pdf->download($pdfFilename);
            }
        } catch (\Exception $e) {
            // Log and fall back to text
            Log::warning('PDF generation failed: ' . $e->getMessage());
        }

        // Fallback: generate a plain text file (previous behavior)
        $content = "=== {$recipe->recipe_name} ===\n\n";
        $content .= "Submitted by: {$recipe->submitter_name}\n";
        if ($recipe->prep_time) {
            $content .= "Prep Time: {$recipe->prep_time}\n";
        }
        $content .= "Date Added: " . $recipe->created_at->format('F j, Y') . "\n\n";

        $content .= "INGREDIENTS:\n";
        $content .= str_repeat("-", 40) . "\n";
        foreach (explode("\n", $recipe->ingredients) as $ingredient) {
            if (trim($ingredient)) {
                $content .= "• " . trim($ingredient) . "\n";
            }
        }

        $content .= "\nINSTRUCTIONS:\n";
        $content .= str_repeat("-", 40) . "\n";
        foreach (explode("\n", $recipe->instructions) as $index => $instruction) {
            if (trim($instruction)) {
                $step = $index + 1;
                $cleanInstruction = trim(preg_replace('/^\d+\.\s*/', '', $instruction));
                $content .= "{$step}. {$cleanInstruction}\n";
            }
        }

        $content .= "\n" . str_repeat("=", 50) . "\n";
        $content .= "Downloaded from Community Recipe Book\n";
        $content .= url('/') . "\n";

        // Return text fallback
        $txtFilename = $safeName . '_recipe.txt';
        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $txtFilename . '"');
    }

    /**
     * AJAX endpoint for paginated recipes (browse).
     */
    public function indexAjax(Request $request)
    {
        $perPage = 9;
        $recipes = Recipe::with(['user', 'ratings'])
            ->where('is_approved', true)
            ->latest()
            ->paginate($perPage)
            ->appends($request->except('page'));
        // Return only the data needed for AJAX rendering
        return response()->json([
            'recipes' => $recipes->items(),
            'pagination' => [
                'current_page' => $recipes->currentPage(),
                'last_page' => $recipes->lastPage(),
                'total' => $recipes->total(),
            ],
        ]);
    }
}
