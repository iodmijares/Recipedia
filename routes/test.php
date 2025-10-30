<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

Route::get('/test-email', function () {
    $user = User::find(1); // Get the first user
    
    if ($user && !$user->hasVerifiedEmail()) {
        $user->sendEmailVerificationNotification();
        return "Email verification sent! Check storage/logs/laravel.log for the email content.";
    }
    
    return "User not found or already verified.";
});