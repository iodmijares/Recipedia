@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans">
    
    <!-- Top Navigation / Header -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                        Admin<span class="text-indigo-600 dark:text-indigo-400">Dashboard</span>
                    </h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('recipes.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-all shadow-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View Live Site
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Pending Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 h-full w-1 bg-amber-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Review</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $pendingRecipes->count() }}</h3>
                    </div>
                    <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Approved Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 h-full w-1 bg-emerald-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Approved Recipes</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $approvedRecipes->count() }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 h-full w-1 bg-indigo-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Submissions</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $pendingRecipes->count() + $approvedRecipes->count() }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Review Section -->
        @if($pendingRecipes->count() > 0)
            <div class="mb-10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="w-2 h-8 bg-amber-500 rounded-full"></span>
                        Pending Review
                        <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                            {{ $pendingRecipes->count() }}
                        </span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($pendingRecipes as $recipe)
                        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-gray-700 flex flex-col h-full overflow-hidden">
                            <!-- Image -->
                            <div class="relative h-48 overflow-hidden bg-gray-100 dark:bg-gray-700">
                                @php $images = json_decode($recipe->recipe_images, true); @endphp
                                @if($images && count($images) > 0)
                                    <img src="{{ asset('storage/' . $images[0]) }}" 
                                         alt="{{ $recipe->recipe_name }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3">
                                    <span class="px-2 py-1 text-xs font-bold bg-white/90 dark:bg-gray-900/90 backdrop-blur text-amber-600 dark:text-amber-400 rounded-lg shadow-sm">
                                        Pending
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1 mb-1" title="{{ $recipe->recipe_name }}">
                                    {{ $recipe->recipe_name }}
                                </h3>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <span class="truncate">by {{ $recipe->submitter_name }}</span>
                                    <span class="mx-2">•</span>
                                    <span class="whitespace-nowrap">{{ $recipe->created_at->diffForHumans(null, true) }}</span>
                                </div>

                                <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex gap-2">
                                    <a href="{{ route('admin.recipe.show', $recipe) }}" 
                                       class="flex-1 inline-flex justify-center items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-100 dark:focus:ring-indigo-900 transition-colors shadow-sm">
                                        Review Recipe
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Approved Section -->
        @if($approvedRecipes->count() > 0)
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="w-2 h-8 bg-emerald-500 rounded-full"></span>
                        Recently Approved
                    </h2>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 transition-colors">View All History &rarr;</a>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Recipe</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Author</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date Approved</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @foreach($approvedRecipes->take(5) as $recipe)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    @php $images = json_decode($recipe->recipe_images, true); @endphp
                                                    @if($images && count($images) > 0)
                                                        <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $images[0]) }}" alt="">
                                                    @else
                                                        <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $recipe->recipe_name }}</div>
                                                    <div class="text-xs text-gray-500">ID: #{{ $recipe->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $recipe->submitter_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                                {{ $recipe->updated_at->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('recipes.show', $recipe) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($approvedRecipes->count() > 5)
                    <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-3 border-t border-gray-200 dark:border-gray-700 text-center">
                        <a href="#" class="text-xs font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 transition-colors">Show all {{ $approvedRecipes->count() }} approved recipes</a>
                    </div>
                    @endif
                </div>
            </div>
        @endif

    </div>
</div>
@endsection