@extends('layouts.app')

@section('title', 'Verify Your Email')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700 py-12">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8 text-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Check Your Email</h1>
                <p class="text-blue-100 mt-2">We've sent a verification code to your email</p>
            </div>

            <div class="p-6">
                <!-- User Info -->
                <div class="text-center mb-6">
                    <p class="text-gray-600 dark:text-gray-300">
                        Enter the 6-digit code we sent to:
                    </p>
                    <p class="font-semibold text-gray-900 dark:text-white mt-1">
                        {{ $user->email }}
                    </p>
                </div>

                <!-- Status Messages -->
                @if (session('status') === 'verification-otp-sent')
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <p class="text-sm text-green-700">A new verification code has been sent to your email.</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p class="text-sm text-red-700">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- OTP Form -->
                <form method="POST" action="{{ route('verification.verify') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Verification Code
                        </label>
                        <input type="text" 
                               id="otp" 
                               name="otp" 
                               class="w-full px-4 py-3 text-center text-2xl font-mono tracking-widest border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="000000"
                               maxlength="6"
                               pattern="[0-9]{6}"
                               required
                               autocomplete="one-time-code"
                               inputmode="numeric">
                        <p class="text-xs text-gray-500 mt-2">Enter the 6-digit code from your email</p>
                    </div>

                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium py-3 px-4 rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                        Verify Email
                    </button>
                </form>

                <!-- Resend Section -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                            Didn't receive the code?
                        </p>
                        
                        <form method="POST" action="{{ route('verification.send') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm underline">
                                Send New Code
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Need Help?
                    </h3>
                    <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                        <li>• Check your spam/junk folder</li>
                        <li>• Make sure you entered the correct email address</li>
                        <li>• Codes expire after 10 minutes</li>
                        <li>• <a href="{{ route('verification.notice') }}" class="text-blue-600 hover:underline">Back to verification form</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-focus on OTP input and format input
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');
    
    // Auto-focus
    otpInput.focus();
    
    // Format input - only allow numbers
    otpInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 6) {
            value = value.slice(0, 6); // Limit to 6 digits
        }
        e.target.value = value;
        
        // Auto-submit when 6 digits are entered
        if (value.length === 6) {
            e.target.form.submit();
        }
    });
    
    // Prevent pasting non-numeric content
    otpInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text');
        const numbers = paste.replace(/\D/g, '').slice(0, 6);
        e.target.value = numbers;
        
        if (numbers.length === 6) {
            e.target.form.submit();
        }
    });
});
</script>
@endsection