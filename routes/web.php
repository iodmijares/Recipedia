<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

// Home route - redirect to recipes index
Route::redirect('/', '/recipes')->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
        // Password reset routes
        Route::get('/password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('/password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('/password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset'])->name('password.update');
});
            
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard route for authenticated users
    Route::get('/dashboard', function () {
        return redirect()->route('recipes.index');
    })->name('dashboard');
});

// Email verification routes (no auth required - for registration flow)
Route::get('/email/verify', [EmailVerificationController::class, 'show'])
    ->name('verification.notice');
Route::post('/email/verify', [EmailVerificationController::class, 'verify'])
    ->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
    ->middleware('throttle:6,1')
    ->name('verification.send');

// Test email route (for debugging SMTP)
Route::get('/test-email', function () {
    try {
        Mail::raw('This is a test email to verify SMTP configuration is working correctly.', function ($message) {
            $message->to('iodmijares@usm.edu.ph')
                   ->subject('SMTP Test - Recipe Book App');
        });
        
        return response()->json([
            'status' => 'success',
            'message' => 'Test email sent successfully! Check your inbox at iodmijares@usm.edu.ph'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to send email: ' . $e->getMessage()
        ], 500);
    }
})->name('test.email');

// Recipe routes
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/recipes/{recipe}/download', [RecipeController::class, 'download'])->name('recipes.download');
Route::post('/recipes', [RecipeController::class, 'store'])
    ->middleware(['auth', 'verified', 'throttle:10,1'])
    ->name('recipes.store');

// Rating submission route
Route::post('/recipes/{recipe}/rate', [RecipeController::class, 'rate'])->name('recipes.rate');
Route::post('/recipes/{recipe}/rate-ajax', [RecipeController::class, 'rateAjax'])->name('recipes.rateAjax');

// AJAX endpoint for recipes pagination
Route::get('/recipes-ajax', [RecipeController::class, 'indexAjax'])->name('recipes.indexAjax');

// Profile settings routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/picture', [\App\Http\Controllers\ProfileController::class, 'showPicture'])->name('profile.picture');
    Route::post('/profile/picture', [\App\Http\Controllers\ProfileController::class, 'updatePicture'])->name('profile.picture.update');
});

// Admin routes (protected with authentication, email verification, and admin privileges)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/recipes/{recipe}', [AdminController::class, 'show'])->name('recipe.show');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::patch('/recipes/{recipe}/approve', [AdminController::class, 'approve'])->name('approve');
    Route::delete('/recipes/{recipe}/reject', [AdminController::class, 'reject'])->name('reject');
    Route::patch('/recipes/{recipe}/toggle', [AdminController::class, 'toggle'])->name('toggle');
});
