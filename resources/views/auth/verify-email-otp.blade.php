@extends('layouts.app')

@section('title', 'Verify Your Email')

@section('content')
<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
    
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow-xl shadow-emerald-900/10 sm:rounded-xl sm:px-10 border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            
            <!-- Decorative Top Border -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-emerald-400 to-teal-500"></div>

            <!-- Header Icon & Title (Moved Inside) -->
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 dark:bg-emerald-900/30 mb-4 animate-bounce-slow">
                    <svg class="h-8 w-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Verify Your Identity
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    Check your email for the 6-digit code we sent to <br>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $user->email }}</span>
                </p>
            </div>

            <!-- Status Messages -->
            @if (session('status') === 'verification-otp-sent')
                <div class="mb-6 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 p-4 border border-emerald-100 dark:border-emerald-800">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">
                                A new code has been sent to your email.
                            </p>
                        </div>
                    </div>
                </div>
                <script>
                    window.dispatchEvent(new CustomEvent('show-toast', { detail: { type: 'success', message: 'Code sent successfully!' } }));
                </script>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 dark:bg-red-900/20 p-4 border border-red-100 dark:border-red-800">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800 dark:text-red-200">
                                {{ $errors->first() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- OTP Form -->
            <form method="POST" action="{{ route('verification.verify') }}" class="space-y-6">
                @csrf
                
                <div class="flex flex-col items-center">
                    <label for="otp" class="sr-only">Verification Code</label>
                    <div class="relative w-full max-w-xs">
                        <input type="text" 
                               id="otp" 
                               name="otp" 
                               class="block w-full text-center text-3xl font-mono font-bold tracking-[0.5em] rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white py-4 transition-colors duration-200" 
                               placeholder="000000"
                               maxlength="6"
                               pattern="[0-9]{6}"
                               required
                               autocomplete="one-time-code"
                               inputmode="numeric">
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit" 
                            class="w-full max-w-xs flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transform transition-all duration-200 hover:-translate-y-0.5">
                        Verify Email
                    </button>
                </div>
            </form>

            <!-- Footer / Resend Link -->
            <div class="mt-8 border-t border-gray-100 dark:border-gray-700 pt-6">
                <div class="flex items-center justify-center space-x-1 text-sm text-gray-600 dark:text-gray-400">
                    <span>Didn't receive the code?</span>
                    <form method="POST" action="{{ route('verification.send') }}" class="inline">
                        @csrf
                        <button type="submit" class="font-medium text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors duration-200 focus:outline-none underline">
                            Send new code
                        </button>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        Log out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');
    
    // Auto-focus
    otpInput.focus();
    
    // Format input - only allow numbers
    otpInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 6) value = value.slice(0, 6);
        e.target.value = value;
    });
    
    // Prevent pasting non-numeric content
    otpInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text');
        const numbers = paste.replace(/\D/g, '').slice(0, 6);
        e.target.value = numbers;
    });
});
</script>
@endsection