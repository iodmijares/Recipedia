@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50  font-sans">
    
    <!-- Top Navigation / Header -->
    <div class="bg-white  border-b border-gray-200  sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900  tracking-tight">
                        Admin<span class="text-indigo-600 ">Dashboard</span>
                    </h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('recipes.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50     transition-all shadow-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-500 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View Live
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Pending Card -->
            <div class="bg-white  rounded-xl p-6 border border-gray-100  shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 h-full w-1 bg-amber-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 ">Pending Review</p>
                        <h3 class="text-3xl font-bold text-gray-900  mt-1">{{ $pendingRecipes->count() }}</h3>
                    </div>
                    <div class="p-3 bg-amber-50  rounded-lg text-amber-600  group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Approved Card -->
            <div class="bg-white  rounded-xl p-6 border border-gray-100  shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 h-full w-1 bg-emerald-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 ">Approved Recipes</p>
                        <h3 class="text-3xl font-bold text-gray-900  mt-1">{{ $approvedRecipes->count() }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-50  rounded-lg text-emerald-600  group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Recipes Card -->
            <div class="bg-white  rounded-xl p-6 border border-gray-100  shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 h-full w-1 bg-indigo-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 ">Total Recipes</p>
                        <h3 class="text-3xl font-bold text-gray-900  mt-1">{{ $pendingRecipes->count() + $approvedRecipes->count() }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-50  rounded-lg text-indigo-600  group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Users Card -->
            <div class="bg-white  rounded-xl p-6 border border-gray-100  shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 h-full w-1 bg-purple-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 ">Total Users</p>
                        <h3 class="text-3xl font-bold text-gray-900  mt-1">{{ $totalUsers }}</h3>
                    </div>
                    <div class="p-3 bg-purple-50  rounded-lg text-purple-600  group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2m0 0l4-4m-4 4l-4-4m4 4V7m0 13a2 2 0 002 2h2a2 2 0 002-2m-8 0h.01"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Review Section -->
        @if($pendingRecipes->count() > 0)
            <div class="mb-10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900  flex items-center gap-2">
                        <span class="w-2 h-8 bg-amber-500 rounded-full"></span>
                        Pending Review
                        <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800  ">
                            {{ $pendingRecipes->count() }}
                        </span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($pendingRecipes as $recipe)
                        <div class="group bg-white  rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100  flex flex-col h-full overflow-hidden">
                            <!-- Image -->
                            <div class="relative h-48 overflow-hidden bg-gray-100 ">
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
                                    <span class="px-2 py-1 text-xs font-bold bg-white/90  backdrop-blur text-amber-600  rounded-lg shadow-sm">
                                        Pending
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-900  line-clamp-1 mb-1" title="{{ $recipe->recipe_name }}">
                                    {{ $recipe->recipe_name }}
                                </h3>
                                <div class="flex items-center text-sm text-gray-500  mb-4">
                                    <span class="truncate">by {{ $recipe->submitter_name }}</span>
                                    <span class="mx-2">•</span>
                                    <span class="whitespace-nowrap">{{ $recipe->created_at->diffForHumans(null, true) }}</span>
                                </div>

                                <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2 justify-center w-full">
                                    <a href="{{ route('admin.recipe.show', $recipe) }}"
                                       class="inline-flex justify-center items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-100 transition-colors shadow-sm">
                                        Review details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

                    <!-- Approved Section -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-bold text-gray-900  flex items-center gap-2">
                                <span class="w-2 h-8 bg-emerald-500 rounded-full"></span>
                                Approved Recipes
                            </h2>
                        </div>
        
                        <div class="bg-white  rounded-xl shadow-sm border border-gray-200  overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 ">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Recipe</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Author</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date Approved</th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200  bg-white ">
                                        @foreach($approvedRecipes as $recipe)
                                            <tr class="hover:bg-gray-50  transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="h-10 w-10 flex-shrink-0">
                                                            @php $images = json_decode($recipe->recipe_images, true); @endphp
                                                            @if($images && count($images) > 0)
                                                                <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $images[0]) }}" alt="{{ $recipe->recipe_name }}">
                                                            @else
                                                                <div class="h-10 w-10 rounded-lg bg-gray-100  flex items-center justify-center text-gray-400">
                                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900 ">{{ $recipe->recipe_name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500 ">{{ $recipe->submitter_name }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800  ">
                                                        {{ $recipe->updated_at->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('recipes.show', $recipe) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View Public</a>
        
                                                    <form action="{{ route('admin.toggle', $recipe) }}" method="POST" class="inline-block mr-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-amber-600 hover:text-amber-800">Unpublish</button>
                                                    </form>
        
                                                    <form action="{{ route('admin.reject', $recipe) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to reject and delete this recipe?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="bg-gray-50  px-6 py-3 border-t border-gray-200  text-center">
                                {{ $approvedRecipes->links() }}
                            </div>
                        </div>
                    </div>
    </div>
</div>
@endsection