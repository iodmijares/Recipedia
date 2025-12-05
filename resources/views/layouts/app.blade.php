<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" data-bs-theme="light">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="/images/favicon.png"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Community Recipe Book')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'figtree', sans-serif; }
            a { text-decoration: none !important; }
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>
        
        <script>
            function loadFontAwesome() {
                if (!document.querySelector('link[href*="font-awesome"]')) {
                    var faLink = document.createElement('link');
                    faLink.rel = 'stylesheet';
                    faLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
                    faLink.onload = function() {
                        document.dispatchEvent(new CustomEvent('fa-loaded'));
                    };
                    document.head.appendChild(faLink);
                }
            }
            document.addEventListener('DOMContentLoaded', loadFontAwesome);
        </script>
    </head>
    <body class="bg-gray-50 min-h-screen">
        <x-flash-messages />
        
        <div class="min-h-screen flex flex-col">
            <nav class="bg-white shadow-lg sticky top-0 z-50 rounded-b-2xl border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">
                    <div class="flex justify-between items-center h-20 gap-6">
                        
                        <div class="flex items-center gap-4">
                            <a href="{{ route('recipes.index') }}" class="flex items-center">
                                <img src="/images/recipedia-logo.png" alt="Recipedia Logo" class="h-16 w-auto mr-3 drop-shadow-lg">
                            </a>
                        </div>

                        <div class="hidden md:flex items-center space-x-4">
                            <a href="{{ route('recipes.index') }}" 
                               class="px-3 py-1.5 text-sm font-medium {{ request()->routeIs('recipes.index') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-blue-600' }} rounded-lg transition-all duration-200">
                                Browse Recipes
                            </a>
                            
                            @auth
                                @if(auth()->user()->hasVerifiedEmail())
                                    <a href="{{ route('recipes.create') }}" 
                                       class="px-3 py-1.5 text-sm font-medium {{ request()->routeIs('recipes.create') ? 'bg-emerald-100 text-emerald-700' : 'bg-emerald-500 hover:bg-emerald-600 text-white' }} rounded-lg transition-all duration-200"
                                       style="color: white !important;">
                                        Submit Recipe
                                    </a>

                                    @if(auth()->user()->hasAdminAccess())
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="px-3 py-1.5 text-sm font-medium {{ request()->routeIs('admin.*') && !request()->routeIs('admin.users.*') ? 'bg-purple-100 text-purple-700' : 'bg-purple-500 hover:bg-purple-600 text-white' }} rounded-lg transition-all duration-200"
                                           style="color: white !important;">
                                            Admin Dashboard
                                        </a>

                                        @if(auth()->user()->isAdmin() && \Illuminate\Support\Facades\Route::has('admin.users.index'))
                                            <a href="{{ route('admin.users.index') }}" 
                                               class="px-3 py-1.5 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-indigo-100 text-indigo-700' : 'bg-indigo-500 hover:bg-indigo-600 text-white' }} rounded-lg transition-all duration-200"
                                               style="color: white !important;">
                                                Manage Users
                                            </a>
                                        @endif
                                    @endif

                                    <div class="relative">
                                        <button type="button" id="profileDropdownBtn" class="px-3 py-1.5 text-sm font-medium rounded-lg flex items-center gap-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-200">
                                            <i class="fa fa-user"></i>
                                            <span>Profile</span>
                                            <svg class="w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        </button>
                                        
                                        <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-100" style="display: none;">
                                            <a href="{{ route('profile.picture') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Update Profile Picture</a>
                                            
                                            <form method="POST" action="{{ route('logout') }}" class="block w-full">
                                                @csrf
                                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors">
                                                    Logout
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            
                            @else
                                <a href="{{ route('login') }}" 
                                   class="px-3 py-1.5 text-sm font-medium {{ request()->routeIs('login') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-blue-600' }} rounded-lg transition-all duration-200">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="px-3 py-1.5 text-sm font-medium {{ request()->routeIs('register') ? 'bg-emerald-100 text-emerald-700' : 'bg-emerald-500 hover:bg-emerald-600 text-white' }} rounded-lg transition-all duration-200"
                                   style="color: white !important;">
                                    Register
                                </a>
                            @endauth
                        </div>

                        <div class="md:hidden flex items-center">
                            <button type="button" 
                                    class="bg-gray-50 inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-all duration-200"
                                    aria-controls="mobile-menu" 
                                    aria-expanded="false"
                                    onclick="toggleMobileMenu()">
                                <span class="sr-only">Open main menu</span>
                                <svg class="block h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-6 pt-4 pb-6 space-y-3 sm:px-6 bg-white rounded-b-2xl shadow-xl border-t border-gray-200">
                        <a href="{{ route('recipes.index') }}" 
                           class="block px-4 py-3 text-lg font-semibold {{ request()->routeIs('recipes.index') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }} rounded-xl transition-all duration-200 shadow-sm">
                            Browse Recipes
                        </a>
                        @auth
                            @if(auth()->user()->hasVerifiedEmail())
                                <a href="{{ route('recipes.create') }}" 
                                   class="block px-4 py-3 text-lg font-semibold {{ request()->routeIs('recipes.create') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-700 hover:bg-emerald-50' }} rounded-xl transition-all duration-200 shadow-sm">
                                    Submit Recipe
                                </a>
                                @if(auth()->user()->hasAdminAccess())
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="block px-4 py-3 text-lg font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-purple-50' }} rounded-xl transition-all duration-200 shadow-sm">
                                        Admin Dashboard
                                    </a>

                                    @if(auth()->user()->isAdmin() && \Illuminate\Support\Facades\Route::has('admin.users.index'))
                                        <a href="{{ route('admin.users.index') }}" 
                                           class="block px-4 py-3 text-lg font-semibold {{ request()->routeIs('admin.users.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50' }} rounded-xl transition-all duration-200 shadow-sm">
                                            Manage Users
                                        </a>
                                    @endif
                                @endif
                                <a href="{{ route('profile.picture') }}" class="block px-4 py-3 text-lg font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-200 shadow-sm">Update Profile Picture</a>
                            @else
                                <a href="{{ route('verification.notice') }}" 
                                   class="block px-4 py-3 text-lg font-semibold bg-amber-100 text-amber-700 rounded-xl transition-all duration-200 shadow-sm">
                                    Verify Email
                                </a>
                            @endif
                            
                            <div class="border-t border-gray-200 mt-4 pt-4">
                                <div class="px-4 py-2 text-base text-gray-500">
                                    Signed in as <span class="font-semibold">{{ auth()->user()->name }}</span>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="block w-full text-left px-4 py-3 text-lg font-semibold text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 shadow-sm">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" 
                               class="block px-4 py-3 text-lg font-semibold {{ request()->routeIs('login') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }} rounded-xl transition-all duration-200 shadow-sm">
                                Login
                            </a>
                            <a href="{{ route('register') }}" 
                               class="block px-4 py-3 text-lg font-semibold {{ request()->routeIs('register') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-700 hover:bg-emerald-50' }} rounded-xl transition-all duration-200 shadow-sm">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>

            <main class="flex-grow">
                @yield('content')
            </main>

            <footer class="bg-gradient-to-r from-emerald-50 via-teal-50 to-blue-50 border-t border-gray-200 shadow-lg mt-12">
                <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 py-10 flex flex-col items-center">
                    <div class="w-full flex flex-col items-center">
                        <p class="text-base text-gray-500 text-center mb-2">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved. <span class="font-semibold text-emerald-600">I.M</span>
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
                menu.classList.toggle('block');
            }
            
            // Profile dropdown logic
            document.addEventListener('DOMContentLoaded', function() {
                var btn = document.getElementById('profileDropdownBtn');
                var menu = document.getElementById('profileDropdownMenu');
                
                if (btn && menu) {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        // Simple toggle logic
                        if (menu.style.display === 'none' || menu.style.display === '') {
                            menu.style.display = 'block';
                        } else {
                            menu.style.display = 'none';
                        }
                    });
                    
                    // Close on click outside
                    document.addEventListener('click', function(e) {
                        if (!btn.contains(e.target) && !menu.contains(e.target)) {
                            menu.style.display = 'none';
                        }
                    });
                }
            });
        </script>
    </body>
</html>