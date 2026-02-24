{{-- 
    =================================================================
    Category Edit Page
    ================================================================ 
    Route: /categories/{category}/edit
    View: categories.edit
    =================================================================
--}}

@extends('layouts.app')

@section('title', 'Edit Category - codeMaster')

@php
    $category = $category ?? null;
@endphp

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('dashboard.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>
            </li>
            <li>
                <span class="text-gray-400">/</span>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700">Categories</a>
            </li>
            <li>
                <span class="text-gray-400">/</span>
            </li>
            <li>
                <span class="text-gray-900 font-medium">Edit Category</span>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Category</h1>

        @if($category)
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Category Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $category->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="e.g., JavaScript, Python, Laravel"
                    required
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Describe what this category is for..."
                >{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color Picker -->
            <div class="mb-6">
                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                    Color
                </label>
                <div class="flex items-center space-x-4">
                    <input 
                        type="color" 
                        name="color" 
                        id="color" 
                        value="{{ old('color', $category->color ?? '#6366f1') }}"
                        class="h-10 w-20 border border-gray-300 rounded-lg cursor-pointer"
                    >
                    <span class="text-sm text-gray-500">Choose a color for this category</span>
                </div>
                @error('color')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4">
                <a 
                    href="{{ route('categories.index') }}" 
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
                >
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
                >
                    Update Category
                </button>
            </div>
        </form>
        @else
        <div class="text-center py-8">
            <p class="text-gray-500">Category not found.</p>
            <a href="{{ route('categories.index') }}" class="text-indigo-600 hover:text-indigo-700 mt-2 inline-block">
                Back to Categories
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
