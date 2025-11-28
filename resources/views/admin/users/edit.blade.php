@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Edit User Form Card -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8 border border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-4">Edit User: <span class="text-indigo-600">{{ $user->name }}</span></h1>
            
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Name:</label>
                        <input type="text" name="name" id="name" 
                               class="form-input w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email:</label>
                        <input type="email" name="email" id="email" 
                               class="form-input w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="role" class="block text-gray-700 text-sm font-semibold mb-2">Role:</label>
                    <select name="role" id="role" 
                            class="form-select w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror" required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="moderator" {{ old('role', $user->role) == 'moderator' ? 'selected' : '' }}>Moderator</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <p class="text-gray-500 text-xs mt-1">Admins have full control, Moderators can manage recipes, Users have basic access.</p>
                    @error('role')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Change Password</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">New Password:</label>
                            <input type="password" name="password" id="password" 
                                   class="form-input w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-gray-700 text-sm font-semibold mb-2">Confirm New Password:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-input w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <p class="text-gray-600 text-xs mt-1">Leave password fields blank if you don't want to change the password.</p>
                </div>

                <div class="flex items-center justify-between mt-8">
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 shadow-md">
                        Update User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-2 text-blue-600 hover:text-blue-800 font-medium">Cancel</a>
                </div>
            </form>
        </div>

        <!-- Delete User Section -->
        <div class="bg-red-50 border border-red-200 shadow-lg rounded-lg p-6 mt-8">
            <h2 class="text-xl font-bold text-red-800 mb-4 border-b border-red-200 pb-3">Danger Zone</h2>
            <p class="text-red-700 mb-4">Permanently delete this user. This action cannot be undone.</p>
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete {{ $user->name }}? This action cannot be undone and will permanently remove all associated data.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200 shadow-md">
                    Delete User
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

