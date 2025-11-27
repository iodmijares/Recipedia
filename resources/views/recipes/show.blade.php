@extends('layouts.app')

@section('title', $recipe->recipe_name . ' - Community Recipe Book')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        @if(session('status'))
            <script>
                window.addEventListener('DOMContentLoaded', function() {
                    window.dispatchEvent(new CustomEvent('show-toast', {
                        detail: {
                            type: 'info',
                            message: @json(session('status'))
                        }
                    }));
                });
            </script>
        @endif

        <div class="mb-6">
            <div class="flex gap-4 flex-wrap">
                <a href="{{ route('recipes.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Recipes
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <div class="relative h-64 md:h-80 bg-gray-200 group">
                @php $images = is_array($recipe->recipe_images) ? $recipe->recipe_images : json_decode($recipe->recipe_images, true); @endphp
                @if($images && count($images) > 0)
                    <img src="{{ asset('storage/' . $images[0]) }}" 
                         alt="{{ $recipe->recipe_name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center h-full bg-gradient-to-r from-blue-500 to-purple-600">
                        <div class="text-center text-white p-6">
                            <svg class="h-20 w-20 mx-auto mb-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                @endif
                
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent z-10 pointer-events-none"></div>
                
                <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 text-white z-10 pointer-events-none">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2 shadow-sm drop-shadow-lg">{{ $recipe->recipe_name }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-sm md:text-base text-white/90">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $recipe->submitter_name }}
                        </div>
                        @if($recipe->prep_time)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $recipe->prep_time }}
                            </div>
                        @endif
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span id="header-rating-value">{{ $averageRating ? number_format($averageRating, 1) : 'New' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <span class="p-2 bg-emerald-100 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </span>
                            Ingredients
                        </h2>
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <ul class="space-y-3">
                                @foreach(explode("\n", $recipe->ingredients) as $ingredient)
                                    @if(trim($ingredient))
                                        <li class="flex items-start text-gray-700">
                                            <svg class="w-5 h-5 mt-0.5 mr-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="leading-relaxed">{{ trim($ingredient) }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <span class="p-2 bg-blue-100 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </span>
                            Instructions
                        </h2>
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <ol class="space-y-6">
                                @foreach(explode("\n", $recipe->instructions) as $index => $instruction)
                                    @if(trim($instruction))
                                        <li class="flex gap-4 text-gray-700">
                                            <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 font-bold rounded-full text-sm">
                                                {{ $index + 1 }}
                                            </span>
                                            <div class="flex-1 pt-1 leading-relaxed">
                                                {{ trim(preg_replace('/^\d+\.\s*/', '', $instruction)) }}
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-200">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                        
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Ratings & Reviews
                            </h3>
                            
                            <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-6">
                                <div class="flex items-end gap-3 mb-4">
                                    <span id="avg-rating-value" class="text-4xl font-extrabold text-gray-900">
                                        {{ $averageRating ? number_format($averageRating, 1) : '0.0' }}
                                    </span>
                                    <div class="mb-1.5">
                                        <div class="flex text-yellow-400 text-lg">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="avg-star-display">
                                                    @if($averageRating >= $i) ★ @else <span class="text-gray-300">★</span> @endif
                                                </span>
                                            @endfor
                                        </div>
                                        <p class="text-xs text-gray-500 font-medium mt-0.5">
                                            Based on <span id="rating-count">{{ $ratingsCount }}</span> reviews
                                        </p>
                                    </div>
                                </div>

                                @auth
                                    <div class="pt-4 border-t border-yellow-200">
                                        @php
                                            $userRating = $recipe->ratings()->where('user_id', auth()->id())->first();
                                            $currentRating = $userRating ? $userRating->rating : 0;
                                        @endphp
                                        
                                        <p class="text-sm font-semibold text-gray-700 mb-3">
                                            {{ $userRating ? 'Update your rating:' : 'Rate this recipe:' }}
                                        </p>

                                        <form id="rating-form" action="{{ route('recipes.rateAjax', $recipe) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="rating" id="rating-input" value="{{ $currentRating }}">
                                            
                                            <div class="flex flex-wrap items-center gap-4">
                                                <div class="flex gap-1" id="star-container">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <button type="button" 
                                                                class="star-btn p-1 focus:outline-none focus:ring-2 focus:ring-yellow-400 rounded-full transition-transform hover:scale-110" 
                                                                data-value="{{ $i }}"
                                                                aria-label="Rate {{ $i }} stars">
                                                            <svg class="w-8 h-8 transition-colors duration-200 {{ $currentRating >= $i ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                                 fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        </button>
                                                    @endfor
                                                </div>
                                                
                                                <button type="submit" 
                                                        id="submit-rating-btn"
                                                        class="px-4 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold rounded-lg shadow-sm transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                                    {{ $userRating ? 'Update' : 'Submit' }}
                                                </button>
                                            </div>
                                            <div id="user-rating-feedback" class="mt-2 text-xs font-medium text-emerald-600 h-4">
                                                @if($userRating) You rated this {{ $currentRating }} stars. @endif
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <div class="pt-4 border-t border-yellow-200">
                                        <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center">
                                            Log in to rate this recipe
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Recipe Tools
                            </h3>
                            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 h-full">
                                <p class="text-sm text-gray-600 mb-6">
                                    Love this recipe? Download it as a PDF to save it to your device or print it out for your kitchen.
                                </p>
                                <a href="{{ route('recipes.download', $recipe) }}" 
                                   class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 w-full">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download PDF
                                </a>
                            </div>
                        </div>

                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            
                            /**
                             * Local AJAX Helper
                             */
                            function ajax(options) {
                                const defaults = {
                                    method: 'GET',
                                    headers: {},
                                    success: () => {},
                                    error: () => {},
                                    complete: () => {},
                                    responseType: 'text'
                                };
                                
                                const config = { ...defaults, ...options };

                                fetch(config.url, {
                                    method: config.method,
                                    headers: config.headers,
                                    body: config.data
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        return response.json().then(err => { throw { message: err.message || 'Error' } });
                                    }
                                    return config.responseType === 'json' ? response.json() : response.text();
                                })
                                .then(data => config.success(data))
                                .catch(err => config.error(err))
                                .finally(() => config.complete());
                            }

                            // --- Star Logic (Visual) ---
                            const starContainer = document.getElementById('star-container');
                            if (!starContainer) return;

                            const stars = starContainer.querySelectorAll('.star-btn');
                            const ratingInput = document.getElementById('rating-input');
                            const feedback = document.getElementById('user-rating-feedback');
                            const form = document.getElementById('rating-form');
            
                            let currentRating = parseInt(ratingInput.value) || 0;
                            let hoverRating = 0;

                            function updateStarVisuals(rating) {
                                stars.forEach(btn => {
                                    const starVal = parseInt(btn.dataset.value);
                                    const svg = btn.querySelector('svg');
                                    // FIXED SYNTAX HERE: Closed strings properly
                                    if (rating >= starVal) {
                                        svg.classList.remove('text-gray-300');
                                        svg.classList.add('text-yellow-400');
                                    } else {
                                        svg.classList.add('text-gray-300');
                                        svg.classList.remove('text-yellow-400');
                                    }
                                });
                            }

                            // Initialize
                            updateStarVisuals(currentRating);

                            // Hover Effects
                            stars.forEach(star => {
                                star.addEventListener('mouseenter', () => {
                                    hoverRating = parseInt(star.dataset.value);
                                    updateStarVisuals(hoverRating);
                                });
                            });

                            starContainer.addEventListener('mouseleave', () => {
                                hoverRating = 0;
                                updateStarVisuals(currentRating);
                            });

                            // Click/Selection Logic
                            stars.forEach(star => {
                                star.addEventListener('click', () => {
                                    currentRating = parseInt(star.dataset.value);
                                    ratingInput.value = currentRating;
                                    updateStarVisuals(currentRating);
                                    
                                    // Little animation pop
                                    star.style.transform = 'scale(1.2)';
                                    setTimeout(() => star.style.transform = 'scale(1)', 150);
                                });
                            });

                            // --- AJAX Submission Logic ---
                            form.addEventListener('submit', function(e) {
                                e.preventDefault();

                                if (currentRating === 0) {
                                    window.dispatchEvent(new CustomEvent('show-toast', {
                                        detail: { type: 'error', message: 'Please select a star rating first.' }
                                    }));
                                    return;
                                }

                                const submitBtn = document.getElementById('submit-rating-btn');
                                const originalBtnText = submitBtn.innerText;
                                
                                // UI Loading State
                                submitBtn.disabled = true;
                                submitBtn.innerHTML = `<span class='spinner-border spinner-border-sm text-success align-middle mr-2' role='status' aria-hidden='true'></span> <span class='align-middle'>loading...</span>`;

                                const formData = new FormData(form);

                                // Using the local ajax helper defined above
                                ajax({
                                    url: form.action,
                                    method: 'POST',
                                    data: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                    },
                                    responseType: 'json',
                                    success: function(data) {
                                        if (data.error) {
                                            window.dispatchEvent(new CustomEvent('show-toast', {
                                                detail: { type: 'error', message: data.error }
                                            }));
                                            return;
                                        }

                                        // Update Global Average Text
                                        document.getElementById('avg-rating-value').textContent = parseFloat(data.averageRating).toFixed(1);
                                        document.getElementById('header-rating-value').textContent = parseFloat(data.averageRating).toFixed(1);
                                        document.getElementById('rating-count').textContent = data.ratingsCount;
                                        
                                        // Update User Feedback Text
                                        feedback.textContent = `You rated this ${data.userRating} stars.`;
                                        
                                        // Update Global Average Stars Visuals
                                        const avgStarsContainer = document.querySelectorAll('.avg-star-display');
                                        const newAvg = parseFloat(data.averageRating);
                                        avgStarsContainer.forEach((starSpan, index) => {
                                            const starValue = index + 1;
                                            starSpan.innerHTML = newAvg >= starValue 
                                                ? '★' 
                                                : '<span class="text-gray-300">★</span>';
                                        });

                                        // Success Toast
                                        window.dispatchEvent(new CustomEvent('show-toast', {
                                            detail: { type: 'success', message: data.message || 'Rating submitted successfully!' }
                                        }));
                                        
                                        submitBtn.innerText = 'Update';
                                    },
                                    error: function(error) {
                                        console.error('Error:', error);
                                        window.dispatchEvent(new CustomEvent('show-toast', {
                                            detail: { type: 'error', message: error.message || 'Failed to submit rating.' }
                                        }));
                                    },
                                    complete: function() {
                                        submitBtn.disabled = false;
                                        if(submitBtn.innerHTML.includes('spinner-border')) {
                                            submitBtn.innerText = originalBtnText;
                                        }
                                    }
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection