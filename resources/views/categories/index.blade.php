@extends('layout.app')

@section('title', 'Categories')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-4 space-y-8">

        {{-- Breadcrumb --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </a>
                </li>
                <li>
                    <span class="text-gray-400">|</span>
                </li>
                <li>
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">Category</a>
                </li>
                <li>
                    <span class="text-gray-400">|</span>
                </li>
                <li>
                    <span class="text-blue-400 font-medium">Categories</span>
                </li>
            </ol>
        </nav>

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">


            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-4xl font-black text-white tracking-tight">Categories</h1>

                    {{-- Count Badge --}}
                    <span
                        class="bg-blue-500/20 text-blue-400 text-xs font-bold px-2.5 py-1 rounded-lg border border-blue-500/30 mt-1">
                        {{ $categories->count() }}
                    </span>
                </div>
                <p class="text-gray-400 text-sm font-medium mt-1">Organize your snippets into categories</p>
            </div>

          
                <a href="{{ url('/create-new') }}"
                    class="btn-primary px-6 py-3 rounded-xl font-bold text-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Category
                </a>
           

        </div>

        {{-- Categories Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">


            @forelse($categories as $category)
                <a href="{{ url('categories.show', $category->category_id) }}">
                    <div
                        class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-{{ $category->color_name }}-500/30 hover:bg-{{ $category->color_name }}-500/5 transition-all cursor-pointer">

                        <div class="absolute -top-2 -right-2 z-10">
                            <span
                                class="text-[10px] px-2 py-1 bg-{{ $category->color_name }}-500/20 text-{{ $category->color_name }}-400 rounded-full border border-{{ $category->color_name }}-500/30">
                                0
                            </span>
                        </div>

                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 mb-3 relative">
                                {{-- Folder Icon - පාට Dynamic කර ඇත --}}
                                <svg class="w-16 h-16 text-{{ $category->color_name }}-500/70 group-hover:text-{{ $category->color_name }}-400 transition-colors"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                                </svg>

                                {{-- Color Dot --}}
                                <div
                                    class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-{{ $category->color_name }}-500 border-2 border-black">
                                </div>
                            </div>

                            {{-- Category Name --}}
                            <h3
                                class="text-sm font-bold text-white mb-1 group-hover:text-{{ $category->color_name }}-400 transition-colors truncate w-full">
                                {{ $category->category_name }}
                            </h3>

                            {{-- Category Description --}}
                            <p class="text-[10px] text-gray-500 line-clamp-2">
                                {{ $category->category_description }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-2 sm:col-span-3 md:col-span-4 lg:col-span-5 xl:col-span-6 flex flex-col items-center justify-center pt-8 pb-16 w-full text-center">
                    <div class="bg-gray-800/50 p-6 rounded-full mb-4">
                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-white font-bold text-lg">No categories yet</h3>
                    <p class="text-gray-500 text-center mb-10 max-w-lg leading-relaxed mx-auto px-4">Your collection of categories is currently empty. Start organizing your development workflow by creating specialized folders for your snippets. A well-structured library helps you find code faster and boosts your daily productivity.</p>
                    
                </div>
            @endforelse

        </div>
    </div>
@endsection
