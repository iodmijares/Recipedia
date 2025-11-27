@extends('layouts.app')

@section('title', 'Submit Recipe')

@section('content')
<div class="py-6 sm:py-12">
    @guest
        <!-- Guest User Message -->
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <div class="bg-blue-50 border border-blue-200 dark:bg-blue-900/20 dark:border-blue-800 rounded-lg p-6">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">Login Required</h3>
                        <p class="text-blue-700 dark:text-blue-300 mt-1">
                            You need to create an account and verify your email to submit recipes.
                        </p>
                        <div class="mt-4 flex gap-3">
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">
                                Login
                            </a>
                            <a href="{{ route('register') }}" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg transition-colors">
                                Create Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if(!auth()->user()->hasVerifiedEmail())
            <!-- Unverified User Message -->
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
                <div class="bg-amber-50 border border-amber-200 dark:bg-amber-900/20 dark:border-amber-800 rounded-lg p-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-amber-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-200">Email Verification Required</h3>
                            <p class="text-amber-700 dark:text-amber-300 mt-1">
                                Please verify your email address before submitting recipes.
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('verification.notice') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                                    Verify Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endguest

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-orange-50 via-red-50 to-pink-100 dark:from-gray-800 dark:via-gray-900 dark:to-red-900">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 bg-clip-text text-transparent mb-4">
                    Share Your Recipe
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Help grow our community recipe collection! Share your favorite dish with fellow food enthusiasts.
                </p>
            </div>
        </div>
    </div>

    @auth
        @if(auth()->user()->hasVerifiedEmail())
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <!-- Recipe Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="p-6 sm:p-8 bg-gradient-to-b from-white to-orange-50 dark:from-gray-800 dark:to-gray-900">
                <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Error Toasts Above Form -->
                    @if ($errors->any() || session('error') || session('success'))
                        <script>
                            window.addEventListener('DOMContentLoaded', function() {
                                const errors = @json($errors->all());
                                const errorSession = @json(session('error'));
                                const successSession = @json(session('success'));

                                if (errors.length > 0) {
                                    errors.forEach(function(error) {
                                        window.dispatchEvent(new CustomEvent('show-toast', {
                                            detail: { type: 'error', message: error }
                                        }));
                                    });
                                }

                                if (errorSession) {
                                    window.dispatchEvent(new CustomEvent('show-toast', {
                                        detail: { type: 'error', message: errorSession }
                                    }));
                                }

                                if (successSession) {
                                    window.dispatchEvent(new CustomEvent('show-toast', {
                                        detail: { type: 'success', message: successSession }
                                    }));
                                }
                            });
                        </script>
                    @endif
                    <!-- Recipe Name -->
                    <div>
                        <label for="recipe_name" class="block text-sm font-semibold text-orange-700 dark:text-orange-300 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Recipe Name *
                        </label>
                        <input type="text" 
                               id="recipe_name" 
                               name="recipe_name" 
                               value="{{ old('recipe_name') }}"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-orange-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                               placeholder="Enter your recipe name">
                    </div>

                    <!-- Submitter Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="submitter_name" class="block text-sm font-semibold text-red-700 dark:text-red-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Your Name *
                            </label>
                            <input type="text" 
                                   id="submitter_name" 
                                   name="submitter_name" 
                                   value="{{ auth()->user()->name ?? '' }}"
                                   required
                                   readonly
                                   class="w-full px-4 py-3 rounded-lg border border-red-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 cursor-not-allowed"
                                   placeholder="Enter your name">
                        </div>

                        <div>
                            <label for="submitter_email" class="block text-sm font-semibold text-pink-700 dark:text-pink-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Your Email *
                            </label>
                            <input type="email" 
                                   id="submitter_email" 
                                   name="submitter_email" 
                                   value="{{ auth()->user()->email ?? '' }}"
                                   required
                                   readonly
                                   class="w-full px-4 py-3 rounded-lg border border-pink-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 cursor-not-allowed"
                                   placeholder="Enter your email address">
                        </div>
                    </div>

                    <!-- Prep Time -->
                    <div>
                        <label class="block text-sm font-semibold text-amber-700 dark:text-amber-300 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Preparation Time
                        </label>
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="number" min="0" id="prep_time_hours" name="prep_time_hours" value="{{ old('prep_time_hours') }}" placeholder="Hours" class="w-full px-4 py-3 rounded-lg border border-amber-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200">
                            </div>
                            <div class="flex-1">
                                <input type="number" min="0" max="59" id="prep_time_minutes" name="prep_time_minutes" value="{{ old('prep_time_minutes') }}" placeholder="Minutes" class="w-full px-4 py-3 rounded-lg border border-amber-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                    </div>

                    <!-- Ingredients -->
                    <div>
                        <label for="ingredients" class="block text-sm font-semibold text-emerald-700 dark:text-emerald-300 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Ingredients *
                        </label>
                        <textarea id="ingredients" 
                                  name="ingredients" 
                                  required
                                  rows="6"
                                  placeholder="List all ingredients with quantities, one per line"
                                  class="w-full px-4 py-3 rounded-lg border border-emerald-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 resize-vertical">{{ old('ingredients') }}</textarea>
                    </div>

                    <!-- Instructions -->
                    <div>
                        <label for="instructions" class="block text-sm font-semibold text-blue-700 dark:text-blue-300 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Instructions *
                        </label>
                        <textarea id="instructions" 
                                  name="instructions" 
                                  required
                                  rows="8"
                                  placeholder="Step-by-step cooking instructions"
                                  class="w-full px-4 py-3 rounded-lg border border-blue-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-vertical">{{ old('instructions') }}</textarea>
                    </div>

                    <!-- Recipe Image Upload -->
                    <div>
                        <label for="recipe_images" class="block text-sm font-semibold text-purple-700 dark:text-purple-300 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Recipe Images * (you can upload multiple)
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-purple-200 dark:border-gray-600 border-dashed rounded-lg hover:border-purple-300 dark:hover:border-gray-500 transition-colors duration-200 bg-purple-50 dark:bg-gray-700">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-purple-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="recipe_images" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500 px-2 py-1">
                                        <span>Upload files</span>
                                        <input id="recipe_images" name="recipe_images[]" type="file" accept="image/*" class="sr-only" multiple required onchange="showImagePreview(event)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, GIF up to 2MB each
                                </p>
                                <div id="image-preview" class="mt-4 flex flex-wrap gap-3 justify-center"></div>
                                <script>
                                    function showImagePreview(event) {
                                        var preview = document.getElementById('image-preview');
                                        preview.innerHTML = '';
                                        var files = event.target.files;
                                        if (files.length > 4) {
                                            alert('You can only upload a maximum of 4 images.');
                                            event.target.value = '';
                                            return;
                                        }
                                        if (files.length > 0) {
                                            Array.from(files).forEach(function(file) {
                                                if (file.type.startsWith('image/')) {
                                                    var reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        var img = document.createElement('img');
                                                        img.src = e.target.result;
                                                        img.className = 'h-20 w-20 object-cover rounded-lg border border-purple-300 shadow';
                                                        preview.appendChild(img);
                                                    };
                                                    reader.readAsDataURL(file);
                                                }
                                            });
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-orange-200 dark:border-gray-700">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                            Submit Recipe
                        </button>
                        <a href="{{ route('recipes.index') }}" 
                           class="flex-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium py-2.5 px-4 rounded-lg text-center transition-all duration-200">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Section -->
        <div class="mt-8 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 rounded-lg p-6 border border-cyan-200 dark:border-cyan-800">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-cyan-800 dark:text-cyan-200">
                        Recipe Submission Guidelines
                    </h3>
                    <div class="mt-2 text-sm text-cyan-700 dark:text-cyan-300">
                        <ul class="list-disc list-inside space-y-1">
                            <li>All recipes will be reviewed before appearing on the site</li>
                            <li>Please ensure your recipe is original or properly attributed</li>
                            <li>Include clear, step-by-step instructions</li>
                            <li>You'll receive an email confirmation when your recipe is submitted</li>
                        </ul>
                    </div>
            </div>
        </div>
        @endif
    @endauth
</div>
@endsection