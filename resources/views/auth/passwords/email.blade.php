@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-50 via-pink-50 to-violet-100    py-12">
    <div class="max-w-md w-full bg-white  rounded-xl shadow-lg overflow-hidden p-8 border-2 border-pink-100 ">
        <h1 class="text-2xl font-bold text-center mb-2 text-pink-700 ">Forgot Your Password?</h1>
        <p class="mb-6 text-gray-600  text-center">Enter your email address and we'll send you a link to reset your password.</p>
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold text-sky-700  mb-2">Email Address</label>
                <input type="email" id="email" name="email" required autofocus class="w-full px-4 py-3 rounded-lg border border-violet-200  bg-white  text-gray-900  placeholder-pink-400  focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200" placeholder="Enter your email">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 ">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm transition-all duration-200">Send Password Reset Link</button>
        </form>
        <div class="mt-8 text-center text-xs text-gray-400 ">
            <a href="{{ route('login') }}" class="hover:underline text-sky-600 ">Back to Login</a>
        </div>
    </div>
</div>
@endsection
