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
                <h1 class="text-4xl font-black text-white tracking-tight">Categories</h1>
                <p class="text-gray-400 text-sm font-medium mt-1">Organize your snippets into categories</p>
            </div>
            <a href="{{ url('/categories/create') }}"
                class="btn-primary px-6 py-3 rounded-xl font-bold text-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Category
            </a>
        </div>

        {{-- Categories Grid - File/Folder Design with 5-6 per row --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            {{-- Category Card 1 - Folder Style --}}
            <div
                class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-blue-500/30 hover:bg-blue-500/5 transition-all cursor-pointer">
                <div class="absolute -top-2 -right-2 z-10">
                    <span
                        class="text-[10px] px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full border border-blue-500/30">13</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-3 relative">
                        {{-- Folder Icon --}}
                        <svg class="w-16 h-16 text-blue-500/70 group-hover:text-blue-400 transition-colors"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                        </svg>
                        {{-- Color Dot --}}
                        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-blue-500 border-2 border-black"></div>
                    </div>
                    <h3
                        class="text-sm font-bold text-white mb-1 group-hover:text-blue-400 transition-colors truncate w-full">
                        Laravel</h3>
                    <p class="text-[10px] text-gray-500 line-clamp-2">Eloquent, Controllers, Blade</p>
                </div>
            </div>

            {{-- Category Card 2 --}}
            <div
                class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-purple-500/30 hover:bg-purple-500/5 transition-all cursor-pointer">
                <div class="absolute -top-2 -right-2 z-10">
                    <span
                        class="text-[10px] px-2 py-1 bg-purple-500/20 text-purple-400 rounded-full border border-purple-500/30">8</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-3 relative">
                        <svg class="w-16 h-16 text-purple-500/70 group-hover:text-purple-400 transition-colors"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                        </svg>
                        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-purple-500 border-2 border-black">
                        </div>
                    </div>
                    <h3
                        class="text-sm font-bold text-white mb-1 group-hover:text-purple-400 transition-colors truncate w-full">
                        JavaScript</h3>
                    <p class="text-[10px] text-gray-500 line-clamp-2">ES6+, DOM, Async</p>
                </div>
            </div>

            {{-- Category Card 3 --}}
            <div
                class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-green-500/30 hover:bg-green-500/5 transition-all cursor-pointer">
                <div class="absolute -top-2 -right-2 z-10">
                    <span
                        class="text-[10px] px-2 py-1 bg-green-500/20 text-green-400 rounded-full border border-green-500/30">21</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-3 relative">
                        <svg class="w-16 h-16 text-green-500/70 group-hover:text-green-400 transition-colors"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                        </svg>
                        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-green-500 border-2 border-black">
                        </div>
                    </div>
                    <h3
                        class="text-sm font-bold text-white mb-1 group-hover:text-green-400 transition-colors truncate w-full">
                        Python</h3>
                    <p class="text-[10px] text-gray-500 line-clamp-2">Django, Flask, Pandas</p>
                </div>
            </div>

            {{-- Category Card 4 --}}
            <div
                class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-yellow-500/30 hover:bg-yellow-500/5 transition-all cursor-pointer">
                <div class="absolute -top-2 -right-2 z-10">
                    <span
                        class="text-[10px] px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded-full border border-yellow-500/30">5</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-3 relative">
                        <svg class="w-16 h-16 text-yellow-500/70 group-hover:text-yellow-400 transition-colors"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                        </svg>
                        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-yellow-500 border-2 border-black">
                        </div>
                    </div>
                    <h3
                        class="text-sm font-bold text-white mb-1 group-hover:text-yellow-400 transition-colors truncate w-full">
                        React</h3>
                    <p class="text-[10px] text-gray-500 line-clamp-2">Hooks, Context, JSX</p>
                </div>
            </div>

            {{-- Category Card 5 --}}
            <div
                class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-red-500/30 hover:bg-red-500/5 transition-all cursor-pointer">
                <div class="absolute -top-2 -right-2 z-10">
                    <span
                        class="text-[10px] px-2 py-1 bg-red-500/20 text-red-400 rounded-full border border-red-500/30">17</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-3 relative">
                        <svg class="w-16 h-16 text-red-500/70 group-hover:text-red-400 transition-colors"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                        </svg>
                        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-red-500 border-2 border-black"></div>
                    </div>
                    <h3
                        class="text-sm font-bold text-white mb-1 group-hover:text-red-400 transition-colors truncate w-full">
                        DevOps</h3>
                    <p class="text-[10px] text-gray-500 line-clamp-2">Docker, K8s, CI/CD</p>
                </div>
            </div>

            {{-- Category Card 6 --}}
            <div
                class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-pink-500/30 hover:bg-pink-500/5 transition-all cursor-pointer">
                <div class="absolute -top-2 -right-2 z-10">
                    <span
                        class="text-[10px] px-2 py-1 bg-pink-500/20 text-pink-400 rounded-full border border-pink-500/30">11</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-3 relative">
                        <svg class="w-16 h-16 text-pink-500/70 group-hover:text-pink-400 transition-colors"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                        </svg>
                        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-pink-500 border-2 border-black"></div>
                    </div>
                    <h3
                        class="text-sm font-bold text-white mb-1 group-hover:text-pink-400 transition-colors truncate w-full">
                        Database</h3>
                    <p class="text-[10px] text-gray-500 line-clamp-2">MySQL, PostgreSQL</p>
                </div>
            </div>

            {{-- Category Card 7 --}}
            <div
                class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-indigo-500/30 hover:bg-indigo-500/5 transition-all cursor-pointer">
                <div class="absolute -top-2 -right-2 z-10">
                    <span
                        class="text-[10px] px-2 py-1 bg-indigo-500/20 text-indigo-400 rounded-full border border-indigo-500/30">9</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-3 relative">
                        <svg class="w-16 h-16 text-indigo-500/70 group-hover:text-indigo-400 transition-colors"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                        </svg>
                        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-indigo-500 border-2 border-black">
                        </div>
                    </div>
                    <h3
                        class="text-sm font-bold text-white mb-1 group-hover:text-indigo-400 transition-colors truncate w-full">
                        TypeScript</h3>
                    <p class="text-[10px] text-gray-500 line-clamp-2">Types, Interfaces, Generics</p>
                </div>
            </div>

            {{-- Category Card 8 --}}
            <div
                class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-orange-500/30 hover:bg-orange-500/5 transition-all cursor-pointer">
                <div class="absolute -top-2 -right-2 z-10">
                    <span
                        class="text-[10px] px-2 py-1 bg-orange-500/20 text-orange-400 rounded-full border border-orange-500/30">15</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-3 relative">
                        <svg class="w-16 h-16 text-orange-500/70 group-hover:text-orange-400 transition-colors"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                        </svg>
                        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-orange-500 border-2 border-black">
                        </div>
                    </div>
                    <h3
                        class="text-sm font-bold text-white mb-1 group-hover:text-orange-400 transition-colors truncate w-full">
                        HTML/CSS</h3>
                    <p class="text-[10px] text-gray-500 line-clamp-2">Flexbox, Grid, Animations</p>
                </div>
            </div>

            {{-- Category Card 9 --}}
            <div
                class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-teal-500/30 hover:bg-teal-500/5 transition-all cursor-pointer">
                <div class="absolute -top-2 -right-2 z-10">
                    <span
                        class="text-[10px] px-2 py-1 bg-teal-500/20 text-teal-400 rounded-full border border-teal-500/30">6</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-3 relative">
                        <svg class="w-16 h-16 text-teal-500/70 group-hover:text-teal-400 transition-colors"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                        </svg>
                        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-teal-500 border-2 border-black">
                        </div>
                    </div>
                    <h3
                        class="text-sm font-bold text-white mb-1 group-hover:text-teal-400 transition-colors truncate w-full">
                        Go</h3>
                    <p class="text-[10px] text-gray-500 line-clamp-2">Concurrency, APIs</p>
                </div>
            </div>

            {{-- Category Card 10 --}}
            <div
                class="group relative glass-card rounded-xl p-4 border border-white/10 hover:border-cyan-500/30 hover:bg-cyan-500/5 transition-all cursor-pointer">
                <div class="absolute -top-2 -right-2 z-10">
                    <span
                        class="text-[10px] px-2 py-1 bg-cyan-500/20 text-cyan-400 rounded-full border border-cyan-500/30">12</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-3 relative">
                        <svg class="w-16 h-16 text-cyan-500/70 group-hover:text-cyan-400 transition-colors"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                        </svg>
                        <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-cyan-500 border-2 border-black">
                        </div>
                    </div>
                    <h3
                        class="text-sm font-bold text-white mb-1 group-hover:text-cyan-400 transition-colors truncate w-full">
                        Rust</h3>
                    <p class="text-[10px] text-gray-500 line-clamp-2">Memory Safety</p>
                </div>
            </div>
        </div>

        {{-- Stats Bar --}}
        <div class="glass-card rounded-xl p-4 border border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-400">Total Categories:</span>
                <span class="text-lg font-bold text-white">10</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-400">Total Snippets:</span>
                <span class="text-lg font-bold text-white">117</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-[10px] text-gray-500">Organized</span>
            </div>
        </div>
    </div>
@endsection
