<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
    /**
     * Show the email verification form.
     */
    public function show(Request $request)
    {
        // If user is already authenticated and verified, redirect to dashboard
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('success', 'Your email is already verified!');
        }
        
        // If user is authenticated but not verified, show verification form
        if ($request->user()) {
            return view('auth.verify-email-otp', ['user' => $request->user()]);
        }
        
        // Check if we have a user ID in session (from registration)
        $userId = session('verification_user_id');
        
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }
        
        $user = User::find($userId);
        
        if (!$user) {
            session()->forget('verification_user_id');
            return redirect()->route('login')->with('error', 'User not found. Please try logging in.');
        }
        
        if ($user->hasVerifiedEmail()) {
            session()->forget('verification_user_id');
            // If user is already verified, log them in and redirect to dashboard
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Email already verified! Welcome to your dashboard.');
        }

        return view('auth.verify-email-otp', compact('user'));
    }

    /**
     * Verify the OTP provided by the user.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        // Get user from authentication or session
        $user = $request->user();
        if (!$user) {
            $userId = session('verification_user_id');
            
            if (!$userId) {
                return redirect()->route('login')->with('error', 'Session expired. Please log in.');
            }
            
            $user = User::find($userId);
            
            if (!$user) {
                session()->forget('verification_user_id');
                return redirect()->route('login')->with('error', 'User not found. Please try logging in.');
            }
        }
        
        if ($user->hasVerifiedEmail()) {
            if (session('verification_user_id')) {
                session()->forget('verification_user_id');
                return redirect()->route('login')->with('success', 'Email already verified! You can now log in.');
            } else {
                return redirect()->route('dashboard')->with('success', 'Email already verified!');
            }
        }

        $result = $user->verifyOtp($request->otp);

        if ($result['success']) {
            event(new Verified($user));
            
            if (session('verification_user_id')) {
                // User came from registration - log them in automatically
                session()->forget('verification_user_id');
                Auth::login($user);
                return redirect()->route('dashboard')->with('success', 'Email verified successfully! Welcome to your dashboard.');
            } else {
                // User was already logged in during verification
                return redirect()->route('dashboard')->with('success', 'Email verified successfully!');
            }
        } else {
            return back()->withErrors(['otp' => $result['message']])->with('user', $user);
        }
    }

    /**
     * Resend the OTP to the user.
     */
    public function resend(Request $request)
    {
        // Get user from authentication or session
        $user = $request->user();
        if (!$user) {
            $userId = session('verification_user_id');
            
            if (!$userId) {
                return redirect()->route('login')->with('error', 'Session expired. Please log in.');
            }
            
            $user = User::find($userId);
            
            if (!$user) {
                session()->forget('verification_user_id');
                return redirect()->route('login')->with('error', 'User not found. Please try logging in.');
            }
        }

        if ($user->hasVerifiedEmail()) {
            if (session('verification_user_id')) {
                session()->forget('verification_user_id');
                Auth::login($user);
                return redirect()->route('dashboard')->with('success', 'Email already verified! Welcome to your dashboard.');
            } else {
                return redirect()->route('dashboard')->with('success', 'Email already verified!');
            }
        }

        if (!$user->canRequestNewOtp()) {
            return back()->withErrors(['otp' => 'Please wait before requesting a new OTP.'])->with('user', $user);
        }

        try {
            $user->sendEmailVerificationOtp();
            return back()->with('success', 'A new OTP has been sent to your email!')->with('user', $user);
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP: ' . $e->getMessage());
            return back()->withErrors(['otp' => 'Failed to send OTP. Please try again later.'])->with('user', $user);
        }
    }
}