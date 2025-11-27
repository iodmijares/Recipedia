@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="py-6 sm:py-12">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-emerald-50 via-green-50 to-teal-100   ">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 bg-clip-text text-transparent mb-4">
                    Welcome Back
                </h1>
                <p class="text-lg text-gray-600 ">
                    Sign in to your account to continue sharing recipes
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <!-- Login Form -->
        <div class="bg-white  rounded-xl shadow-lg overflow-hidden border border-gray-200 ">
            <div class="p-6 sm:p-8 bg-gradient-to-b from-white to-emerald-50  ">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-sky-700  mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-emerald-700 ">Email Address</span>
                        </label>
                           <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               autofocus
                               class="w-full px-4 py-3 rounded-lg border border-emerald-200  bg-white  text-gray-900  placeholder-emerald-400  focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200"
                               placeholder="Enter your email address">
                        {{-- Error handled by flash-messages component --}}
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-violet-700  mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span class="text-emerald-700 ">Password</span>
                        </label>
                           <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               class="w-full px-4 py-3 rounded-lg border border-emerald-200  bg-white  text-gray-900  placeholder-emerald-400  focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200"
                               placeholder="Enter your password">
                        {{-- Error handled by flash-messages component --}}
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember" 
                               class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500   focus:ring-2  ">
                        <label for="remember" class="ml-2 text-sm text-gray-600 ">
                            Remember me
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium py-3 px-4 rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                            Sign In
                        </button>
                    </div>
                </form>

                <!-- Links -->
                <div class="mt-6 text-center space-y-2">
                    <p class="text-sm text-gray-600 ">
                        <a href="{{ route('password.request') }}" class="text-sky-600 hover:text-sky-500   font-medium">
                            <span class="text-emerald-600 hover:text-emerald-500   font-medium">Forgot password?</span>
                        </a>
                    </p>
                    <p class="text-sm text-gray-600 ">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-violet-600 hover:text-violet-500   font-medium">
                            <span class="text-emerald-600 hover:text-emerald-500   font-medium">Create one here</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="mt-8 bg-gradient-to-r from-emerald-50 to-teal-50   rounded-lg p-6 border border-emerald-200 ">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-cyan-800 ">
                        <span class="text-emerald-800 ">Sign in to access features</span>
                    </h3>
                    <div class="mt-2 text-sm text-cyan-700 ">
                        <ul class="list-disc list-inside space-y-1">
                            <li class="text-emerald-700 ">Submit your favorite recipes</li>
                            <li class="text-emerald-700 ">Access admin dashboard (if authorized)</li>
                            <li class="text-emerald-700 ">Personalized recipe recommendations</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errors = @json($errors->all());
            errors.forEach(error => {
                try {
                    showBootstrapToast('error', error);
                } catch (e) {
                    // Fallback: dispatch event if direct call isn't available yet
                    window.dispatchEvent(new CustomEvent('show-toast', {detail: {type: 'error', message: error}}));
                }
            });
        });
    </script>
@endif