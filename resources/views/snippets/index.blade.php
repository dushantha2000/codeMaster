{{-- 
    =================================================================
    Snippets Index Page
    =================================================================
    Purpose: List all code snippets with search, filter, and 
    pagination functionality.
    
    Route: /snippets
    View: snippets.index
    =================================================================
--}}

@extends('layouts.app')

@php
    $viewMode = $viewMode ?? 'grid';
    $languages = $languages ?? [];
    $categories = $categories ?? [];
@endphp

@section('title', 'Code Snippets - codeMaster')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Code Snippets</h1>
            <p class="mt-2 text-gray-600">Browse and manage your code snippets</p>
        </div>
        @auth
            <a 
                href="{{ route('snippets.create') }}" 
                class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors"
            >
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Snippet
            </a>
        @endauth
    </div>
    
    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form action="{{ route('snippets.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search snippets by title, description, or code..." 
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    >
                </div>
            </div>
            
            <!-- Language Filter -->
            <div class="w-full lg:w-48">
                <select 
                    name="language" 
                    class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                    <option value="">All Languages</option>
                    @foreach($languages ?? [] as $language)
                        <option value="{{ $language }}" {{ request('language') == $language ? 'selected' : '' }}>
                            {{ $language }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Category Filter -->
            <div class="w-full lg:w-48">
                <select 
                    name="category" 
                    class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter Button -->
            <button 
                type="submit"
                class="px-4 py-2.5 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-900 transition-colors"
            >
                Filter
            </button>
        </form>
    </div>
    
    <!-- View Toggle & Results Count -->
    <div class="flex items-center justify-between mb-4">
        <p class="text-sm text-gray-600">
            Showing <span class="font-medium">{{ $snippets->count() }}</span> snippets
        </p>
        
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-500">View:</span>
            <button 
                onclick="setViewMode('grid')"
                class="p-2 rounded-lg {{ $viewMode === 'grid' ? 'bg-indigo-100 text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}"
                aria-label="Grid view"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </button>
            <button 
                onclick="setViewMode('list')"
                class="p-2 rounded-lg {{ $viewMode === 'list' ? 'bg-indigo-100 text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}"
                aria-label="List view"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Snippets Grid/List -->
    @if($snippets->count() > 0)
        <div class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-4' }}">
            @foreach($snippets as $snippet)
                @include('snippets.components.snippet-card', ['snippet' => $snippet, 'viewMode' => $viewMode])
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No snippets found</h3>
            <p class="mt-2 text-sm text-gray-500">
                @if(request()->anyFilled(['search', 'language', 'category']))
                    Try adjusting your search or filters
                @else
                    Get started by creating your first code snippet
                @endif
            </p>
            @if(!request()->anyFilled(['search', 'language', 'category']))
                @auth
                    <div class="mt-6">
                        <a href="{{ route('snippets.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                            Create Snippet
                        </a>
                    </div>
                @else
                    <div class="mt-6">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                            Sign in to Create
                        </a>
                    </div>
                @endauth
            @endif
        </div>
    @endif
    
    <!-- Pagination -->
    @if($snippets->hasPages())
        <div class="mt-8">
            {{ $snippets->links('components.pagination') }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function setViewMode(mode) {
        const url = new URL(window.location.href);
        url.searchParams.set('view', mode);
        window.location.href = url.toString();
    }
</script>
@endpush
