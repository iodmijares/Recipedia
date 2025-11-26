@extends('layouts.app')

@section('title', 'Verify Your Email')

@section('content')
<div class="py-6 sm:py-12">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-100 dark:from-gray-800 dark:via-gray-900 dark:to-amber-900">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-amber-100 dark:bg-amber-900/30 mb-6">
                    <svg class="h-8 w-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-amber-600 via-orange-600 to-yellow-600 bg-clip-text text-transparent mb-4">
                    Verify Your Email
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    We've sent a verification link to your email address
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <!-- Verification Notice -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="p-6 sm:p-8 bg-gradient-to-b from-white to-amber-50 dark:from-gray-800 dark:to-gray-900">
                
                @if (session('status'))
                    <script>
                        window.addEventListener('DOMContentLoaded', function() {
                            var statusMsg = "{{ addslashes(session('status')) }}";
                            window.dispatchEvent(new CustomEvent('show-toast', {
                                detail: {
                                    type: 'success',
                                    message: statusMsg
                                }
                            }));
                        });
                    </script>
                @endif

                <div class="text-center mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        Check Your Email
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Before continuing, please check your email for a verification link. If you didn't receive the email, we can send you another one.
                    </p>
                    
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-amber-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div class="text-left">
                                <p class="text-sm font-medium text-amber-800 dark:text-amber-200">Email sent to:</p>
                                <p class="text-sm text-amber-700 dark:text-amber-300">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resend Email Form -->
                <form method="POST" action="{{ route('verification.send') }}" class="mb-6">
                    @csrf
                    <div class="text-center">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Resend Verification Email
                        </button>
                    </div>
                </form>

                <!-- Navigation Links -->
                <div class="text-center space-y-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('recipes.index') }}" 
                           class="inline-flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-800 text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Browse Recipes
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-800 text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        Need Help?
                    </h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Check your spam/junk folder if you don't see the email</li>
                            <li>Make sure {{ auth()->user()->email }} is correct</li>
                            <li>You can browse recipes while waiting for verification</li>
                            <li>Email verification is required to submit recipes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection