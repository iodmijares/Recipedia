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
     * Display the homepage with approved recipes.
     */
    public function index(Request $request)
    {
        $perPage = 9; 

        $recipes = Recipe::where('is_approved', true)
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

        return view('recipes.show', compact('recipe'));
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
            'submitter_name' => 'required|string|max:255',
            'submitter_email' => 'required|email',
            'prep_time' => 'nullable|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'recipe_image' => 'required|image|max:2048',
        ]);

        try {
            // Handle file upload
            $imagePath = $request->file('recipe_image')->store('uploads', 'public');

            // Create new recipe record
            $recipe = new Recipe();
            $recipe->recipe_name = $validated['recipe_name'];
            $recipe->submitter_name = $validated['submitter_name'];
            $recipe->submitter_email = $validated['submitter_email'];
            $recipe->prep_time = $validated['prep_time'];
            $recipe->ingredients = $validated['ingredients'];
            $recipe->instructions = $validated['instructions'];
            $recipe->recipe_image = $imagePath;
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
            } catch (\Exception $e) {
                Log::warning('Failed to send recipe notification email: ' . $e->getMessage());
                // Continue with success response even if email fails
            }

            // Redirect with success message
            return redirect('/')->with('success', "Thank you! Your recipe '{$recipe->recipe_name}' has been submitted for review.");

        } catch (\Exception $e) {
            // Log the error
            Log::error('Recipe submission failed: ' . $e->getMessage());

            // Redirect back with error message
            return back()->with('error', 'An error occurred while submitting your recipe. Please try again.');
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
}
