<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                Auth::logout(); // Log them out immediately
                
                // Send new OTP if needed
                try {
                    if ($user->canRequestNewOtp()) {
                        $user->sendEmailVerificationOtp();
                    }
                    
                    session(['verification_user_id' => $user->id]);
                    
                    return redirect()->route('verification.show')->with('warning', 'Please verify your email before logging in. We\'ve sent a verification code to your email.');
                } catch (\Exception $e) {
                    Log::error('Failed to send OTP during login: ' . $e->getMessage());
                    return back()->withErrors(['email' => 'Please verify your email before logging in. Contact support if you need help.']);
                }
            }
            
            $request->session()->regenerate();

            return redirect()->intended(route('recipes.index'))->with('toast_success', 'Welcome back to Recipedia!');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('recipes.index')->with('info', 'You have been logged out successfully.');
    }
}