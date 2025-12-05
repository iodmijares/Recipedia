@extends('layouts.app')

@section('title', 'Recipe Details')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-8">
        
        {{-- Status Toast Logic --}}
        @if(session('status'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var statusMsg = {!! json_encode(session('status')) !!};
                    // Ensure you have a listener for 'show-toast' elsewhere, or use a library like Alpine/Toastr
                    console.log('Status:', statusMsg); 
                });
            </script>
            {{-- Fallback alert for immediate visibility --}}
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                <p>{{ session('status') }}</p>
            </div>
        @endif

        <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $recipe->recipe_name }}</h1>
        <p class="text-sm text-gray-500 mb-2">Submitted by {{ $recipe->submitter_name }} on {{ $recipe->created_at->format('M j, Y g:i A') }}</p>

        {{-- [FIXED] Image Grid --}}
        <div class="mb-6">
            @if($images && count($images) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($images as $img)
                        <div class="aspect-w-1 aspect-h-1 w-full">
                            {{-- CHANGED: $images[0] to $img --}}
                            <img src="{{ Storage::url($img) }}" 
                                 alt="{{ $recipe->recipe_name }}" 
                                 class="object-cover rounded-lg shadow w-full h-full" 
                                 style="min-height: 120px; max-height: 180px;">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="h-32 w-32 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
        </div>

        {{-- [FIXED] Ingredients List --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Ingredients</h2>
            <div class="bg-gray-50 rounded-lg p-4">
                {{-- CHANGED: Removed direct echo, added loop --}}
                @if(is_array($recipe->ingredients) || is_object($recipe->ingredients))
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach($recipe->ingredients as $ingredient)
                            <li>{{ $ingredient }}</li>
                        @endforeach
                    </ul>
                @else
                    {{-- Fallback if data is somehow a string --}}
                    <p class="text-gray-700 whitespace-pre-line">{{ $recipe->ingredients }}</p>
                @endif
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Instructions</h2>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700 whitespace-pre-line">{{ $recipe->instructions }}</p>
            </div>
        </div>

        {{-- Status Indicator --}}
        <div class="mb-6">
            @if($recipe->is_approved)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-emerald-500" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                    </svg>
                    Approved
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-amber-500" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                    </svg>
                    Pending Approval
                </span>
            @endif
        </div>

        {{-- Action Buttons --}}
        @if(!$recipe->is_approved)
        <div class="flex gap-3 justify-end mt-8">
            <form action="{{ route('admin.approve', $recipe) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all shadow-sm">
                    Approve
               </button>
            </form>

            <form action="{{ route('admin.reject', $recipe) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to reject and delete this recipe?')" class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-lg text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all shadow-sm">
                    Reject
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection