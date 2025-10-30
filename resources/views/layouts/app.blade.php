<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Community Recipe Book')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <style>
            body {
                font-family: 'figtree', sans-serif;
            }
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="min-h-screen flex flex-col">
            <!-- Navigation -->
            <nav class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Logo/Brand -->
                        <div class="flex items-center">
                            <a href="{{ route('recipes.index') }}" class="flex items-center">
                                <svg class="w-8 h-8 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span class="text-xl font-bold text-gray-800 dark:text-white hidden sm:block">
                                    Community Recipe Book
                                </span>
                                <span class="text-xl font-bold text-gray-800 dark:text-white sm:hidden">
                                    Recipes
                                </span>
                            </a>
                        </div>
                        
                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex items-center space-x-2">
                            <a href="{{ route('recipes.index') }}" 
                               class="px-3 py-2 text-sm font-medium {{ request()->routeIs('recipes.index') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400' }} rounded-md transition-colors">
                                Browse Recipes
                            </a>
                            
                            @auth
                                @if(auth()->user()->hasVerifiedEmail())
                                    <a href="{{ route('recipes.create') }}" 
                                       class="px-3 py-2 text-sm font-medium {{ request()->routeIs('recipes.create') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-emerald-500 hover:bg-emerald-600 text-white' }} rounded-md transition-colors"
                                       style="color: white !important;">
                                        Submit Recipe
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.*') ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : 'bg-purple-500 hover:bg-purple-600 text-white' }} rounded-md transition-colors"
                                       style="color: white !important;">
                                        Admin
                                    </a>
                                    @endif
                                @endif
                                
                                <!-- User Menu -->
                                <div class="relative ml-3">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ auth()->user()->name }}</span>
                                        <form method="POST" action="{{ route('logout') }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 rounded-md transition-colors">
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="px-3 py-2 text-sm font-medium {{ request()->routeIs('login') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400' }} rounded-md transition-colors">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="px-3 py-2 text-sm font-medium {{ request()->routeIs('register') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-emerald-500 hover:bg-emerald-600 text-white' }} rounded-md transition-colors"
                                   style="color: white !important;">
                                    Register
                                </a>
                            @endauth
                        </div>

                        <!-- Mobile menu button -->
                        <div class="md:hidden flex items-center">
                            <button type="button" 
                                    class="bg-gray-50 dark:bg-gray-700 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors"
                                    aria-controls="mobile-menu" 
                                    aria-expanded="false"
                                    onclick="toggleMobileMenu()">
                                <span class="sr-only">Open main menu</span>
                                <!-- Hamburger icon -->
                                <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-gray-50 dark:bg-gray-700">
                        <a href="{{ route('recipes.index') }}" 
                           class="block px-3 py-2 text-base font-medium {{ request()->routeIs('recipes.index') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600' }} rounded-md transition-colors">
                            Browse Recipes
                        </a>
                        
                        @auth
                            @if(auth()->user()->hasVerifiedEmail())
                                <a href="{{ route('recipes.create') }}" 
                                   class="block px-3 py-2 text-base font-medium {{ request()->routeIs('recipes.create') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600' }} rounded-md transition-colors">
                                    Submit Recipe
                                </a>
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="block px-3 py-2 text-base font-medium {{ request()->routeIs('admin.*') ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600' }} rounded-md transition-colors">
                                    Admin Dashboard
                                </a>
                            @else
                                <a href="{{ route('verification.notice') }}" 
                                   class="block px-3 py-2 text-base font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300 rounded-md transition-colors">
                                    Verify Email
                                </a>
                            @endif
                            
                            <div class="border-t border-gray-200 dark:border-gray-600 mt-3 pt-3">
                                <div class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">
                                    Signed in as {{ auth()->user()->name }}
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="block w-full text-left px-3 py-2 text-base font-medium text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 rounded-md transition-colors">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" 
                               class="block px-3 py-2 text-base font-medium {{ request()->routeIs('login') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600' }} rounded-md transition-colors">
                                Login
                            </a>
                            <a href="{{ route('register') }}" 
                               class="block px-3 py-2 text-base font-medium {{ request()->routeIs('register') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600' }} rounded-md transition-colors">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="flex-1">
                @yield('content')
            </main>

            <!-- Flash Messages Component -->
            @include('components.flash-messages')

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-center items-center">
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            &copy; {{ date('Y') }} Community Recipe Book. I.M
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }
        </script>
    </body>
</html>