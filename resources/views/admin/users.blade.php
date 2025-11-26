@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex">
    <aside class="w-64 bg-white dark:bg-gray-800 shadow-lg flex flex-col justify-between min-h-screen hidden md:flex">
        <div>
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-emerald-700 dark:text-emerald-300 mb-2">Admin Panel</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Welcome, {{ auth()->user()->name }}</p>
            </div>
            <nav class="mt-6 flex flex-col gap-2 px-6">
                <a href="{{ route('admin.dashboard') }}" class="py-2 px-4 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition">Dashboard</a>
                <a href="{{ route('admin.users') }}" class="py-2 px-4 rounded-lg font-medium text-gray-700 dark:text-gray-200 bg-emerald-100 dark:bg-emerald-900/30">Users</a>
                <a href="{{ route('recipes.index') }}" class="py-2 px-4 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition">View Site</a>
            </nav>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="p-6 border-t border-gray-200 dark:border-gray-700">
            @csrf
            <button type="submit" class="w-full py-2 px-4 rounded-lg font-medium text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 transition">Logout</button>
        </form>
    </aside>
    <main class="flex-1 p-4 md:p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">User Management</h1>
        <form method="GET" action="{{ route('admin.users') }}" class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="w-64 px-3 py-2 border rounded-lg focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:text-white" />
                <select name="role" class="px-3 py-2 border rounded-lg focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:text-white">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="moderator" {{ request('role') == 'moderator' ? 'selected' : '' }}>Moderator</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium">Filter</button>
            </div>
        </form>
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 border border-emerald-100 dark:border-emerald-900/30 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Name</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Role</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Verified</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $user->name }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td class="px-4 py-2">
                                @if($user->email_verified_at)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">Yes</span>
                                @else
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <!-- Future: Add role management actions here -->
                                <button class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-6">{{ $users->links() }}</div>
        </div>
    </main>
</div>
@endsection
