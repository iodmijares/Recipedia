<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this area.');
        }
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if user is verified
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')->with('error', 'Please verify your email first.');
        }

        // Check if user is admin
        if (!$user->isAdmin()) {
            return redirect()->route('recipes.index')->with('error', 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
