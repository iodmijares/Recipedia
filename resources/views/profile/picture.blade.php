@extends('layouts.app')

@section('title', 'Update Profile Picture')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6 text-emerald-700 dark:text-emerald-300">Update Profile Picture</h2>
    <form id="profile-picture-form" method="POST" action="{{ route('profile.picture') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="flex flex-col items-center gap-4">
            @if(auth()->user()->profile_picture_url)
                <img src="{{ auth()->user()->profile_picture_url }}" alt="Profile Picture" class="h-24 w-24 rounded-full object-cover border-2 border-emerald-400 dark:border-emerald-600 shadow-md">
            @else
                <div class="h-24 w-24 rounded-full flex items-center justify-center bg-gradient-to-br from-emerald-100 to-teal-200 border-2 border-emerald-400 dark:border-emerald-600 shadow-md">
                    <svg class="w-12 h-12 text-emerald-500 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            @endif
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="w-full px-4 py-2 rounded-lg border border-emerald-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">JPG, PNG, or GIF up to 2MB.</p>
        </div>
        <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium py-3 px-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">Update Picture</button>
    </form>
</div>
<script>
    document.getElementById('profile-picture-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Profile picture updated!', type: 'success' } }));
                if(data.url) {
                    document.querySelector('img[alt="Profile Picture"]').src = data.url;
                }
            } else {
                window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Error updating picture.', type: 'error' } }));
            }
        })
        .catch(() => {
            window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Network error.', type: 'error' } }));
        });
    });
</script>
@endsection