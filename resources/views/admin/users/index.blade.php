@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">Add New User</a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($users->isEmpty())
            <p class="text-gray-600">No users found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">ID</th>
                            <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Name</th>
                            <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Email</th>
                            <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Role</th>
                            <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-sm text-gray-700">{{ $user->id }}</td>
                                <td class="py-2 px-4 border-b text-sm text-gray-700">{{ $user->name }}</td>
                                <td class="py-2 px-4 border-b text-sm text-gray-700">{{ $user->email }}</td>
                                <td class="py-2 px-4 border-b text-sm text-gray-700">{{ $user->role }}</td>
                                <td class="py-2 px-4 border-b text-sm text-gray-700">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
