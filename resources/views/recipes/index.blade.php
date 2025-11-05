@extends('layouts.app')

@section('title', 'Approved Recipes')

@section('content')
<div class="py-6 sm:py-12">
    <!-- Hero Section with Gradient Background -->
    <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 dark:from-gray-800 dark:via-gray-900 dark:to-indigo-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent mb-4">
                    Community Recipe Book
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 mb-6 sm:mb-8 max-w-3xl mx-auto">
                    Discover delicious recipes shared by our community. From quick weeknight dinners to special occasion treats.
                </p>
                <a href="{{ route('recipes.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Share Your Recipe
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
        @if($recipes->count() > 0)
            <!-- Recipe Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recipes as $recipe)
                    <a href="{{ route('recipes.show', $recipe) }}" class="block group">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                            <!-- Image Container -->
                            <div class="relative h-64 overflow-hidden">
                                @if($recipe->recipe_image)
                                    <img src="{{ asset('storage/' . $recipe->recipe_image) }}" 
                                         alt="{{ $recipe->recipe_name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-orange-200 via-pink-200 to-purple-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Prep Time Badge -->
                                @if($recipe->prep_time)
                                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-800 text-sm px-3 py-1 rounded-full font-medium shadow-lg">
                                        <svg class="w-4 h-4 inline mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $recipe->prep_time }}
                                    </div>
                                @endif

                                <!-- Overlay Gradient -->
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent h-24"></div>
                                
                                <!-- Recipe Title on Image -->
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-xl font-bold text-white leading-tight line-clamp-2">
                                        {{ $recipe->recipe_name }}
                                    </h3>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6">
                                <!-- Submitter Info -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $recipe->submitter_name }}</p>
                                            <p class="text-xs">{{ $recipe->created_at->format('M j, Y') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Preview -->
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                            {{ Str::limit(collect(explode("\n", $recipe->ingredients))->filter()->first(), 60) }}...
                                        </p>
                                    </div>
                                </div>

                                <!-- View Recipe Button -->
                                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <span class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">
                                        View Full Recipe
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $recipes->links() }}
            </div>

            <!-- Call to Action (only show for guests or unverified users) -->
            @if (!auth()->check() || !auth()->user()->hasVerifiedEmail())
            <div class="mt-12 sm:mt-16 text-center bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 sm:p-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Have a recipe to share?
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">
                    Join our community of food lovers and share your favorite recipes with others.
                </p>
                <a href="{{ route('recipes.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    Submit Your Recipe
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-16 sm:py-24 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl">
                <div class="max-w-md mx-auto">
                    <div class="mb-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-gray-700 dark:to-gray-600 rounded-full mx-auto flex items-center justify-center mb-4">
                            <svg class="h-12 w-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        No recipes yet
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 text-sm sm:text-base">
                        Be the first to share your favorite recipe with the community! Help us build an amazing collection of delicious dishes.
                    </p>
                   <a href="{{ route('recipes.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                       <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                       </svg>
                       Submit Recipe
                   </a>
                
                </div>
            </div>
        @endif
    </div>
</div>
@endsection