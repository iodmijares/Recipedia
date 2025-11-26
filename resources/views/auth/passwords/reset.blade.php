@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-50 via-pink-50 to-violet-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700 py-12">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden p-8 border-2 border-violet-100 dark:border-violet-900">
        <h1 class="text-2xl font-bold text-center mb-2 text-violet-700 dark:text-violet-300">Reset Your Password</h1>
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label for="email" class="block text-sm font-semibold text-pink-700 dark:text-pink-300 mb-2">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" required autofocus class="w-full px-4 py-3 rounded-lg border border-sky-200 dark:border-sky-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-pink-400 dark:placeholder-pink-300 focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200" placeholder="Enter your email">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-semibold text-cyan-700 dark:text-cyan-300 mb-2">New Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-cyan-200 dark:border-cyan-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-cyan-400 dark:placeholder-cyan-300 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200" placeholder="Enter new password">
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-lime-700 dark:text-lime-300 mb-2">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-3 rounded-lg border border-lime-200 dark:border-lime-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-lime-400 dark:placeholder-lime-300 focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200" placeholder="Confirm new password">
            </div>
            <button type="submit" class="w-full bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm transition-all duration-200">Reset Password</button>
        </form>
        <div class="mt-8 text-center text-xs text-gray-400 dark:text-gray-500">
            <a href="{{ route('login') }}" class="hover:underline text-sky-600 dark:text-sky-400">Back to Login</a>
        </div>
    </div>
</div>
@endsection
