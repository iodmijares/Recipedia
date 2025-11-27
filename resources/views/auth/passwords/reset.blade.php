@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-50 via-pink-50 to-violet-100    py-12">
    <div class="max-w-md w-full bg-white  rounded-xl shadow-lg overflow-hidden p-8 border-2 border-violet-100 ">
        <h1 class="text-2xl font-bold text-center mb-2 text-violet-700 ">Reset Your Password</h1>
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label for="email" class="block text-sm font-semibold text-pink-700  mb-2">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" required autofocus class="w-full px-4 py-3 rounded-lg border border-sky-200  bg-white  text-gray-900  placeholder-pink-400  focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200" placeholder="Enter your email">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 ">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-semibold text-cyan-700  mb-2">New Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-cyan-200  bg-white  text-gray-900  placeholder-cyan-400  focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200" placeholder="Enter new password">
                @error('password')
                    <p class="mt-2 text-sm text-red-600 ">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-lime-700  mb-2">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-3 rounded-lg border border-lime-200  bg-white  text-gray-900  placeholder-lime-400  focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200" placeholder="Confirm new password">
            </div>
            <button type="submit" class="w-full bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm transition-all duration-200">Reset Password</button>
        </form>
        <div class="mt-8 text-center text-xs text-gray-400 ">
            <a href="{{ route('login') }}" class="hover:underline text-sky-600 ">Back to Login</a>
        </div>
    </div>
</div>
@endsection
