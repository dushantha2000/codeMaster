{{-- 
    =================================================================
    Categories Index Page
    ================================================================
    Route: /categories
    View: categories.index
    =================================================================
--}}

@extends('layouts.app')

@section('title', 'Categories - codeMaster')

@php
    $categories = $categories ?? collect();
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
            <p class="mt-2 text-gray-600">Organize your snippets into categories</p>
        </div>
        @auth
            <a 
                href="{{ route('categories.create') }}" 
                class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors"
            >
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Category
            </a>
        @endauth
    </div>
    
    <!-- Categories Grid -->
    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->id) }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="h-12 w-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-500">{{ $category->snippets_count ?? 0 }} snippets</span>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                    @if($category->description)
                        <p class="mt-2 text-sm text-gray-600">{{ $category->description }}</p>
                    @endif
                </a>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No categories yet</h3>
            <p class="mt-2 text-sm text-gray-500">Create your first category to organize your snippets.</p>
            @auth
                <div class="mt-6">
                    <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                        Create Category
                    </a>
                </div>
            @endauth
        </div>
    @endif
</div>
@endsection
