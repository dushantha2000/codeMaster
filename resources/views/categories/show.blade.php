{{-- 
    =================================================================
    Category Show Page
    ================================================================= 
    Route: /categories/{id}
    View: categories.show
    =================================================================
--}}

@extends('layouts.app')

@section('title', $category->name . ' - codeMaster')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </a>
            </li>
            <li class="text-gray-400">/</li>
            <li class="text-gray-900 text-sm font-medium">{{ $category->name }}</li>
        </ol>
    </nav>
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
            @if($category->description)
                <p class="mt-2 text-gray-600">{{ $category->description }}</p>
            @endif
            <p class="mt-2 text-sm text-gray-500">{{ $category->snippets->count() }} snippets in this category</p>
        </div>
    </div>
    
    <!-- Snippets in this Category -->
    @php
    $category = $category ?? null;
@endphp

@if($category && $category->snippets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($category->snippets as $snippet)
                @include('snippets.components.snippet-card', ['snippet' => $snippet, 'viewMode' => 'grid'])
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No snippets in this category</h3>
            <p class="mt-2 text-sm text-gray-500">Add snippets to this category to see them here.</p>
        </div>
    @endif
</div>
@endsection
