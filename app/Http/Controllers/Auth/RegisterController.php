<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Send OTP for email verification (don't log the user in yet)
        try {
            $user->sendEmailVerificationOtp();
            
            // Store user ID in session for verification
            session(['verification_user_id' => $user->id]);
            
            return redirect()->route('verification.notice');
        } catch (\Exception $e) {
            Log::error('Failed to send OTP after registration: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Registration successful, but failed to send verification email. Please try logging in.']);
        }
    }
}