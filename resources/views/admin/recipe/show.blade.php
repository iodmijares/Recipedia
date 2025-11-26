@extends('layouts.app')

@section('title', 'Recipe Details')

@section('content')
<div x-data="{
    dark: localStorage.getItem('darkMode') === 'true',
    toggle() {
        this.dark = !this.dark;
        localStorage.setItem('darkMode', this.dark);
        document.documentElement.classList.toggle('dark', this.dark);
    }
}"
    x-init="document.documentElement.classList.toggle('dark', dark)"
    class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="absolute top-4 right-8 z-40">
        <button @click="toggle" type="button"
            class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg shadow bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            <svg x-show="!dark" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-8.66l-.71.71M4.05 4.05l-.71.71M21 12h-1M4 12H3m16.66 4.95l-.71-.71M4.05 19.95l-.71-.71" />
            </svg>
            <svg x-show="dark" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
            </svg>
            <span x-text="dark ? 'Light Mode' : 'Dark Mode'"></span>
        </button>
    </div>
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-8">
        @if(session('status'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var statusMsg = "{{ addslashes(session('status')) }}";
                    window.dispatchEvent(new CustomEvent('show-toast', {
                        detail: {
                            type: 'info',
                            message: statusMsg
                        }
                    }));
                });
            </script>
        @endif
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $recipe->recipe_name }}</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Submitted by {{ $recipe->submitter_name }} on {{ $recipe->created_at->format('M j, Y g:i A') }}</p>
        <div class="mb-6">
            @if($images && count($images) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($images as $img)
                        <div class="aspect-w-1 aspect-h-1 w-full">
                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $recipe->recipe_name }}" class="object-cover rounded-lg shadow w-full h-full" style="min-height: 120px; max-height: 180px;">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="h-32 w-32 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                    <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
        </div>
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Ingredients</h2>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $recipe->ingredients }}</p>
            </div>
        </div>
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Instructions</h2>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $recipe->instructions }}</p>
            </div>
        </div>
        <div class="flex gap-3 justify-end mt-8">
            <form action="{{ route('admin.approve', $recipe) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all shadow-sm">
                    Approve
               </button>
            </form>
            <form action="{{ route('admin.reject', $recipe) }}" method="POST" x-data="{ showToast: false }" @submit.prevent="showToast = true; $nextTick(() => $refs.rejectForm.submit())" x-ref="rejectForm">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-lg text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all shadow-sm">
                    Reject
                </button>
                <template x-if="showToast">
                    <div class="fixed top-20 right-8 z-50">
                        <div class="bg-amber-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01" /></svg>
                            <span>Recipe rejected and deleted.</span>
                        </div>
                    </div>
                </template>
            </form>
        </div>
    </div>
</div>
@endsection
