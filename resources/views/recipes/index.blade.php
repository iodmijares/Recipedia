@extends('layouts.app')

@section('title', 'Online Recipes')

@section('content')
<div class="py-6 sm:py-12">
    <!-- Hero Section with Gradient Background -->
    <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100   ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent mb-4">
                    Community Recipe Book
                </h1>
                <p class="text-lg sm:text-xl text-gray-600  mb-6 sm:mb-8 max-w-3xl mx-auto">
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
        @if(session('status'))
            <script>
                window.addEventListener('DOMContentLoaded', function() {
                    var statusMsg = @json(session('status'));
                    window.dispatchEvent(new CustomEvent('show-toast', {
                        detail: {
                            type: 'info',
                            message: statusMsg
                        }
                    }));
                });
            </script>
        @endif
        <script>
        function updateRatings() {
            fetch("{{ route('recipes.indexAjax') }}", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.recipes) {
                    data.recipes.forEach(function(recipe) {
                        var ratingDisplay = document.querySelector('.rating-display[data-recipe-id="' + recipe.id + '"]');
                        if (ratingDisplay) {
                            var stars = ratingDisplay.querySelector('.rating-stars');
                            var value = ratingDisplay.querySelector('.rating-value');
                            if (stars && value) {
                                let starHtml = '';
                                for (let i = 1; i <= 5; i++) {
                                    starHtml += `<svg class="w-4 h-4 ${i <= Math.round(recipe.avg_rating) ? 'text-yellow-400' : 'text-gray-300'}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>`;
                                }
                                stars.innerHTML = starHtml;
                                if (recipe.rating_count > 0) {
                                    value.innerHTML = `${recipe.avg_rating.toFixed(1)} <span class='text-gray-400'>(${recipe.rating_count})</span>`;
                                } else {
                                    value.innerHTML = `<span class='text-gray-400'>No ratings</span>`;
                                }
                            }
                        }
                    });
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            updateRatings();
            setInterval(updateRatings, 10000); // Update every 10 seconds
        });
        </script>
        @if($recipes->count() > 0)
            <!-- Recipe Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recipes as $recipe)
                    <a href="{{ route('recipes.show', $recipe) }}" class="block group">
                        <div class="bg-white  rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-700 opacity-0 translate-y-4 hover:-translate-y-2 overflow-hidden h-full flex flex-col" id="recipe-card-{{ $recipe->id }}">
                            <!-- Image Container -->
                            <div class="relative h-64 overflow-hidden shrink-0">
                                @php $images = is_array($recipe->recipe_images) ? $recipe->recipe_images : json_decode($recipe->recipe_images, true); @endphp
                                @if($images && count($images) > 0)
                                    <img src="{{ asset('storage/' . $images[0]) }}" 
                                         alt="{{ $recipe->recipe_name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-orange-200 via-pink-200 to-purple-300   flex items-center justify-center">
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
                                    <h3 class="text-xl font-bold text-white leading-tight line-clamp-2 drop-shadow-md">
                                        {{ $recipe->recipe_name }}
                                    </h3>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-1">
                                <!-- Submitter Info -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center text-sm text-gray-600 ">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center mr-2 overflow-hidden bg-gradient-to-r from-blue-500 to-purple-600">
                                            @php $profilePic = $recipe->user ? $recipe->user->profile_picture_url : null; @endphp
                                            @if($profilePic)
                                                <img src="{{ $profilePic }}" alt="{{ $recipe->user->name ?? $recipe->submitter_name }}" class="w-12 h-12 object-cover rounded-full">
                                            @else
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="font-medium text-gray-900 ">{{ $recipe->user->name ?? $recipe->submitter_name }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $recipe->created_at->format('M j') }}</p>
                                </div>

                                <!-- Rating Stars -->
                                @php 
                                    $avgRating = $recipe->ratings->avg('rating'); 
                                    $ratingCount = $recipe->ratings->count();
                                @endphp
                                <div class="flex items-center mb-3" title="Average Rating: {{ number_format($avgRating, 1) }}">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-xs font-medium text-gray-500 ">
                                        @if($ratingCount > 0)
                                            {{ number_format($avgRating, 1) }} <span class="text-gray-400">({{ $ratingCount }})</span>
                                        @else
                                            <span class="text-gray-400">No ratings</span>
                                        @endif
                                    </span>
                                </div>

                                <!-- Quick Preview -->
                                <div class="mb-4 flex-1">
                                    <div class="flex items-start">
                                        <p class="text-sm text-gray-600  line-clamp-3">
                                            @if($recipe->ingredients)
                                                {{ Str::limit(collect(explode("\n", $recipe->ingredients))->filter()->first(), 80) }}
                                            @else
                                                No ingredients listed.
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- View Recipe Button -->
                                <div class="pt-4 border-t border-gray-100  mt-auto">
                                    <span class="inline-flex items-center text-sm text-blue-600  font-medium group-hover:text-blue-700  transition-colors">
                                        View Full Recipe
                                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="mt-12 sm:mt-16 text-center bg-gradient-to-r from-emerald-50 to-teal-50   rounded-2xl p-8 sm:p-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900  mb-4">
                    Have a recipe to share?
                </h2>
                <p class="text-gray-600  mb-6 max-w-2xl mx-auto">
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
            <div class="text-center py-16 sm:py-24 bg-gradient-to-br from-slate-50 to-blue-50   rounded-2xl">
                <div class="max-w-md mx-auto">
                    <div class="mb-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-200   rounded-full mx-auto flex items-center justify-center mb-4">
                            <svg class="h-12 w-12 text-blue-600 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900  mb-4">
                        No recipes yet
                    </h3>
                    <p class="text-gray-600  mb-8 text-sm sm:text-base">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('[id^="recipe-card-"]');
    cards.forEach((card, i) => {
        setTimeout(() => {
            card.classList.remove('opacity-0', 'translate-y-4');
            card.classList.add('opacity-100', 'translate-y-0');
        }, 100 + i * 120); // Staggered fade-in
    });
});
</script>
@endsection