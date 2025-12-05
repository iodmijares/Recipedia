<?php

namespace App\Http\Controllers;

use App\Mail\RecipeApproved;
use App\Mail\RecipeRejected;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        // Cache dashboard data for 2 minutes
        $pendingRecipes = Cache::remember('admin_pending_recipes', now()->addMinutes(2), function () {
            return Recipe::with('user')
                ->where('is_approved', false)
                ->latest()
                ->paginate(10);
        });

        $approvedRecipes = Cache::remember('admin_approved_recipes', now()->addMinutes(2), function () {
            return Recipe::with('user')
                ->where('is_approved', true)
                ->latest()
                ->paginate(10);
        });

        $totalUsers = Cache::remember('admin_total_users', now()->addMinutes(5), function () {
            return \App\Models\User::count();
        });

        return view('admin.dashboard', compact('pendingRecipes', 'approvedRecipes', 'totalUsers'));
    }

    /**
     * Approve a recipe.
     */
    public function approve(Recipe $recipe)
    {
        $recipe->update(['is_approved' => true]);

        // Clear relevant caches
        $this->clearRecipeCaches();

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
        
        // Delete the image files if they exist
        if ($recipe->recipe_images) {
            foreach ($recipe->recipe_images as $image) {
                Storage::delete($image);
            }
        }

        $recipe->delete();

        // Clear relevant caches
        $this->clearRecipeCaches();

        return redirect()->route('admin.dashboard')->with('toast_warning', "⚠️ Recipe '{$recipeName}' rejected and permanently deleted!");
    }

    /**
     * Toggle recipe approval status.
     */
    public function toggle(Recipe $recipe)
    {
        $recipe->update(['is_approved' => !$recipe->is_approved]);

        // Clear relevant caches
        $this->clearRecipeCaches();

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

    /**
     * Clear all recipe-related caches.
     */
    protected function clearRecipeCaches(): void
    {
        // Clear admin dashboard caches
        Cache::forget('admin_pending_recipes');
        Cache::forget('admin_approved_recipes');

        // Clear paginated recipe caches (first 10 pages)
        for ($i = 1; $i <= 10; $i++) {
            Cache::forget("recipes_index_page_{$i}");
            Cache::forget("recipes_ajax_page_{$i}");
        }
    }
}
