@extends('layout.app')

@section('title', 'Laravel - Category')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4 space-y-8">
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
                    <span class="text-blue-400 font-medium">Create new</span>
                </li>
            </ol>
        </nav>

        {{-- Category Header --}}
        <div class="glass-card rounded-3xl p-8 border border-white/10">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-6">
                    <div
                        class="w-20 h-20 rounded-2xl bg-blue-500/20 border-2 border-blue-500/30 flex items-center justify-center">
                        <span class="text-4xl">🟦</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-4xl font-black text-white tracking-tight">Laravel</h1>
                            <span
                                class="px-3 py-1 bg-blue-500/10 text-blue-400 text-xs rounded-full border border-blue-500/20">13
                                snippets</span>
                        </div>
                        <p class="text-gray-400 text-lg">Laravel development snippets, Eloquent models, controllers, and
                            blade templates for your projects.</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="p-3 bg-white/5 hover:bg-white/10 rounded-xl border border-white/10 transition-all">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                    <button class="p-3 bg-white/5 hover:bg-red-500/10 rounded-xl border border-white/10 transition-all">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Filters Bar --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500 font-medium">Filter by:</span>
                <button
                    class="px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg text-xs font-medium border border-blue-500/30">All</button>
                <button
                    class="px-4 py-2 bg-white/5 text-gray-400 hover:text-white rounded-lg text-xs font-medium border border-white/10 transition-all">PHP</button>
                <button
                    class="px-4 py-2 bg-white/5 text-gray-400 hover:text-white rounded-lg text-xs font-medium border border-white/10 transition-all">JavaScript</button>
                <button
                    class="px-4 py-2 bg-white/5 text-gray-400 hover:text-white rounded-lg text-xs font-medium border border-white/10 transition-all">Blade</button>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500">Sort by:</span>
                <select class="bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-xs text-white">
                    <option>Recently Added</option>
                    <option>Most Viewed</option>
                    <option>Title A-Z</option>
                </select>
            </div>
        </div>

        {{-- Snippets Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Snippet Card 1 --}}
            <div
                class="group glass-card rounded-2xl p-5 border border-white/10 hover:border-blue-500/30 transition-all cursor-pointer">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-bold text-white group-hover:text-blue-400 transition-colors">Login System</h3>
                    <span class="text-[10px] px-2 py-1 bg-blue-500/10 text-blue-400 rounded-md">php</span>
                </div>
                <p class="text-gray-500 text-xs mb-3">Complete authentication system with login, registration, and password
                    reset functionality.</p>
                <div class="flex items-center gap-2 text-[10px] text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        2 days ago
                    </span>
                    <span>•</span>
                    <span>3 files</span>
                </div>
            </div>

            {{-- Snippet Card 2 --}}
            <div
                class="group glass-card rounded-2xl p-5 border border-white/10 hover:border-blue-500/30 transition-all cursor-pointer">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-bold text-white group-hover:text-blue-400 transition-colors">Eloquent
                        Relationships</h3>
                    <span class="text-[10px] px-2 py-1 bg-blue-500/10 text-blue-400 rounded-md">php</span>
                </div>
                <p class="text-gray-500 text-xs mb-3">Examples of one-to-one, one-to-many, and many-to-many relationships in
                    Laravel.</p>
                <div class="flex items-center gap-2 text-[10px] text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        5 days ago
                    </span>
                    <span>•</span>
                    <span>5 files</span>
                </div>
            </div>

            {{-- Snippet Card 3 --}}
            <div
                class="group glass-card rounded-2xl p-5 border border-white/10 hover:border-blue-500/30 transition-all cursor-pointer">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-bold text-white group-hover:text-blue-400 transition-colors">Middleware Examples
                    </h3>
                    <span class="text-[10px] px-2 py-1 bg-blue-500/10 text-blue-400 rounded-md">php</span>
                </div>
                <p class="text-gray-500 text-xs mb-3">Custom middleware for authentication, logging, and request filtering.
                </p>
                <div class="flex items-center gap-2 text-[10px] text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        1 week ago
                    </span>
                    <span>•</span>
                    <span>2 files</span>
                </div>
            </div>

            {{-- Snippet Card 4 --}}
            <div
                class="group glass-card rounded-2xl p-5 border border-white/10 hover:border-blue-500/30 transition-all cursor-pointer">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-bold text-white group-hover:text-blue-400 transition-colors">Blade Components
                    </h3>
                    <span class="text-[10px] px-2 py-1 bg-yellow-500/10 text-yellow-400 rounded-md">blade</span>
                </div>
                <p class="text-gray-500 text-xs mb-3">Reusable Blade components with slots, attributes, and custom logic.
                </p>
                <div class="flex items-center gap-2 text-[10px] text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        2 weeks ago
                    </span>
                    <span>•</span>
                    <span>4 files</span>
                </div>
            </div>
        </div>
    </div>
@endsection
