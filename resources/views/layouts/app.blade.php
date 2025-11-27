<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" data-bs-theme="light">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="/images/favicon.png"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Community Recipe Book')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
    <!-- Remove Alpine.js, use vanilla JS for dropdown -->

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/ajax.min.css') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <style>
            body {
                font-family: 'figtree', sans-serif;
            }
            a {
                text-decoration: none !important;
            }
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
        <!-- Bootstrap JS Bundle -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
        <script src="{{ asset('js/ajax.bundle.min.js') }}"></script>

        <!-- Dynamically load Font Awesome via AJAX -->
        <script>
            function loadFontAwesome() {
                if (!document.querySelector('link[href*="font-awesome"]')) {
                    var faLink = document.createElement('link');
                    faLink.rel = 'stylesheet';
                    faLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
                    faLink.onload = function() {
                        // Font Awesome loaded, trigger any UI updates if needed
                        document.dispatchEvent(new CustomEvent('fa-loaded'));
                    };
                    document.head.appendChild(faLink);
                }
            }
            // Load Font Awesome on demand, e.g. when an icon is about to be shown
            document.addEventListener('DOMContentLoaded', loadFontAwesome);
            // Example: If you want to load it when a button is clicked
            // document.getElementById('show-fa-icons-btn').addEventListener('click', loadFontAwesome);
        </script>
    </head>
    <body class="bg-gray-50 min-h-screen">
        <x-flash-messages />
        <div class="min-h-screen flex flex-col">
            <!-- Navigation -->
            <nav class="bg-white shadow-lg sticky top-0 z-50 rounded-b-2xl border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">
                    <div class="flex justify-between items-center h-20 gap-6">
                        <!-- Logo/Brand -->
                        <div class="flex items-center gap-4">
                            <a href="{{ route('recipes.index') }}" class="flex items-center">
                                <img src="/images/recipedia-logo.png" alt="Recipedia Logo" class="h-16 w-auto mr-3 drop-shadow-lg">
                        </div>
                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="{{ route('recipes.index') }}" 
                               class="px-4 py-2 text-base font-semibold {{ request()->routeIs('recipes.index') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-blue-600' }} rounded-xl transition-all duration-200 shadow-sm">
                                Browse Recipes
                            </a>
                            @auth
                                @if(auth()->user()->hasVerifiedEmail())
                                    <a href="{{ route('recipes.create') }}" 
                                       class="px-4 py-2 text-base font-semibold {{ request()->routeIs('recipes.create') ? 'bg-emerald-100 text-emerald-700' : 'bg-emerald-500 hover:bg-emerald-600 text-white' }} rounded-xl transition-all duration-200 shadow-sm"
                                       style="color: white !important;">
                                        Submit Recipe
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="px-4 py-2 text-base font-semibold {{ request()->routeIs('admin.*') ? 'bg-purple-100 text-purple-700' : 'bg-purple-500 hover:bg-purple-600 text-white' }} rounded-xl transition-all duration-200 shadow-sm"
                                       style="color: white !important;">
                                        Admin
                                    </a>
                                    @endif
                                    <!-- Settings/Profile Dropdown -->
                                    <div class="relative" x-data="{ open: false }">
                                        <div class="relative">
                                            <button type="button" id="profileDropdownBtn" class="px-4 py-2 text-base font-semibold rounded-xl flex items-center gap-2 bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-200 shadow-sm">
                                                <i class="fa fa-user"></i>
                                                <span>Profile</span>
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                            </button>
                                            <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-3 z-50 border border-gray-100" style="display: none;">
                                                <a href="{{ route('profile.picture') }}" class="block px-5 py-3 text-base text-gray-700 hover:bg-gray-50 rounded-xl">Update Profile Picture</a>
                                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger w-100">Logout</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- User Menu -->
                               
                            @else
                                <a href="{{ route('login') }}" 
                                   class="px-4 py-2 text-base font-semibold {{ request()->routeIs('login') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-blue-600' }} rounded-xl transition-all duration-200 shadow-sm">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="px-4 py-2 text-base font-semibold {{ request()->routeIs('register') ? 'bg-emerald-100 text-emerald-700' : 'bg-emerald-500 hover:bg-emerald-600 text-white' }} rounded-xl transition-all duration-200 shadow-sm"
                                   style="color: white !important;">
                                    Register
                                </a>
                            @endauth
                        </div>
                        <!-- Mobile menu button -->
                        <div class="md:hidden flex items-center">
                            <button type="button" 
                                    class="bg-gray-50 inline-flex items-center justify-center p-3 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-all duration-200 shadow-sm"
                                    aria-controls="mobile-menu" 
                                    aria-expanded="false"
                                    onclick="toggleMobileMenu()">
                                <span class="sr-only">Open main menu</span>
                                <!-- Hamburger icon -->
                                <svg class="block h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
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
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="block px-4 py-3 text-lg font-semibold {{ request()->routeIs('admin.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-purple-50' }} rounded-xl transition-all duration-200 shadow-sm">
                                    Admin Dashboard
                                </a>
                                <a href="#" class="block px-4 py-3 text-lg font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-200 shadow-sm">View Profile</a>
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

            <!-- Footer -->
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

        <!-- Mobile menu script -->
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
                        menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
                    });
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