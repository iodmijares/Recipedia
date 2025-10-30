@extends('layouts.app')

@section('title', 'Email Verification Status')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
                <h1 class="text-2xl font-bold text-white">Email Verification Status</h1>
                <p class="text-blue-100 mt-2">Debug and verification information</p>
            </div>

            <div class="p-6">
                <!-- User Info -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">User Information</h2>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Verification Status:</strong> 
                            @if($isVerified)
                                <span class="text-green-600 font-semibold">✅ Verified</span>
                            @else
                                <span class="text-red-600 font-semibold">❌ Not Verified</span>
                            @endif
                        </p>
                        <p><strong>Verified At:</strong> {{ $user->email_verified_at ?? 'Not verified' }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Actions</h2>
                    <div class="flex flex-wrap gap-4">
                        @if(!$isVerified)
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                                    Send Verification Email
                                </button>
                            </form>
                        @else
                            <p class="text-green-600 font-semibold">Your email is already verified!</p>
                        @endif

                        <a href="{{ route('recipes.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                            Back to Recipes
                        </a>

                        <a href="{{ route('test.email') }}" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg" target="_blank">
                            Test SMTP Connection
                        </a>
                    </div>
                </div>

                <!-- Recent Verification Logs -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Recent Verification Attempts</h2>
                    @if(count($logs) > 0)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 max-h-64 overflow-y-auto">
                            <pre class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ implode('', $logs) }}</pre>
                        </div>
                    @else
                        <p class="text-gray-600">No verification logs found.</p>
                    @endif
                </div>

                <!-- Instructions -->
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <h3 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2">📧 Email Configuration Status</h3>
                    <div class="text-yellow-700 dark:text-yellow-300 text-sm space-y-2">
                        <p><strong>Current Mode:</strong> SMTP (Gmail) - Emails will be sent to your inbox</p>
                        <p><strong>Gmail Configuration:</strong></p>
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>Host: smtp.gmail.com</li>
                            <li>Port: 587 (TLS)</li>
                            <li>Username: iodmijares@usm.edu.ph</li>
                            <li>Password: App Password configured</li>
                        </ul>
                        <p><strong>For testing:</strong> Use the "Test SMTP Connection" button above to verify Gmail is working.</p>
                        <p><strong>Troubleshooting:</strong> If emails aren't received, check your Gmail's App Password settings and spam folder.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection