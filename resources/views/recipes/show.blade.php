@extends('layouts.app')

@section('title', $recipe->recipe_name . ' - Community Recipe Book')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('recipes.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Recipes
            </a>
        </div>

        <!-- Recipe Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
            <!-- Recipe Image -->
            <div class="relative h-96 bg-gradient-to-r from-blue-500 to-purple-600">
                @if($recipe->recipe_image && file_exists(public_path('storage/' . $recipe->recipe_image)))
                    <img src="{{ asset('storage/' . $recipe->recipe_image) }}" 
                         alt="{{ $recipe->recipe_name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center text-white">
                            <svg class="h-24 w-24 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-lg font-medium">{{ $recipe->recipe_name }}</p>
                        </div>
                    </div>
                @endif
                
                <!-- Recipe Title Overlay -->
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                    <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">{{ $recipe->recipe_name }}</h1>
                    <div class="flex items-center text-white/90 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>By {{ $recipe->submitter_name }}</span>
                        @if($recipe->prep_time)
                            <span class="mx-2">•</span>
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $recipe->prep_time }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recipe Content -->
            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Ingredients -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Ingredients
                        </h2>
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-6">
                            <ul class="space-y-2">
                                @foreach(explode("\n", $recipe->ingredients) as $ingredient)
                                    @if(trim($ingredient))
                                        <li class="flex items-start text-gray-700 dark:text-gray-300">
                                            <svg class="w-2 h-2 mt-2 mr-3 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="4"/>
                                            </svg>
                                            <span>{{ trim($ingredient) }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Instructions
                        </h2>
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6">
                            <ol class="space-y-4">
                                @foreach(explode("\n", $recipe->instructions) as $index => $instruction)
                                    @if(trim($instruction))
                                        <li class="flex items-start text-gray-700 dark:text-gray-300">
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full text-sm font-medium mr-3 flex-shrink-0">
                                                {{ $index + 1 }}
                                            </span>
                                            <span class="leading-relaxed">{{ trim(preg_replace('/^\d+\.\s*/', '', $instruction)) }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <p>Recipe submitted by <span class="font-medium text-gray-700 dark:text-gray-300">{{ $recipe->submitter_name }}</span></p>
                            <p>Added on {{ $recipe->created_at->format('F j, Y') }}</p>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <a href="{{ route('recipes.download', $recipe) }}" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Recipe
                            </a>
                            
                            <button onclick="shareRecipe()" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                                Share
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function shareRecipe() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $recipe->recipe_name }}',
            text: 'Check out this delicious recipe: {{ $recipe->recipe_name }}',
            url: window.location.href
        });
    } else {
        // Fallback - copy URL to clipboard
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Recipe URL copied to clipboard!');
        });
    }
}
</script>
@endsection