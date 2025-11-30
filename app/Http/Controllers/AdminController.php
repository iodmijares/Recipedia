<?php

namespace App\Http\Controllers;

use App\Mail\RecipeApproved;
use App\Mail\RecipeRejected;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with pending recipes.
     */
    public function dashboard()
    {
        $pendingRecipes = Recipe::with('user')
            ->where('is_approved', false)
            ->latest()
            ->paginate(10);

        $approvedRecipes = Recipe::with('user')
            ->where('is_approved', true)
            ->latest()
            ->paginate(10);

        $totalUsers = \App\Models\User::count();

        return view('admin.dashboard', compact('pendingRecipes', 'approvedRecipes', 'totalUsers'));
    }

    /**
     * Approve a recipe.
     */
    public function approve(Recipe $recipe)
    {
        $recipe->update(['is_approved' => true]);

        // Send approval email to submitter
        try {
            Mail::to($recipe->submitter_email)->send(new RecipeApproved($recipe));
        } catch (\Throwable $e) {
            Log::warning('Failed to send recipe approval email: ' . $e->getMessage());
        }

        return redirect()->route('admin.dashboard')->with('toast_success', "✅ Recipe '{$recipe->recipe_name}' approved and published!");
    }

    /**
     * Reject (delete) a recipe.
     */
    public function reject(Recipe $recipe)
    {
        $recipeName = $recipe->recipe_name;
        $submitterEmail = $recipe->submitter_email;
        
        // Send rejection email to submitter before deleting
        try {
            Mail::to($submitterEmail)->send(new RecipeRejected($recipe));
        } catch (\Throwable $e) {
            Log::warning('Failed to send recipe rejection email: ' . $e->getMessage());
        }
        
        // Delete the image file if it exists
        if ($recipe->recipe_image) {
            Storage::disk('public')->delete($recipe->recipe_image);
        }

        $recipe->delete();

        return redirect()->route('admin.dashboard')->with('toast_warning', "⚠️ Recipe '{$recipeName}' rejected and permanently deleted!");
    }

    /**
     * Toggle recipe approval status.
     */
    public function toggle(Recipe $recipe)
    {
        $recipe->update(['is_approved' => !$recipe->is_approved]);

        $status = $recipe->is_approved ? 'approved and published' : 'unapproved and hidden';
        $icon = $recipe->is_approved ? '✅' : '📝';
        
        return redirect()->back()->with('toast_info', "{$icon} Recipe '{$recipe->recipe_name}' {$status}!");
    }

    /**
     * Show the details of a recipe for admin review.
     */
    public function show(Recipe $recipe)
    {
        $images = is_array($recipe->recipe_images) ? $recipe->recipe_images : (array) $recipe->recipe_images;
        return view('admin.recipe.show', compact('recipe', 'images'));
    }
}
