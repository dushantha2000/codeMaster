@extends('layout.app')

@section('title', 'Laravel - Category')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4 animate-in fade-in slide-in-from-bottom-4 duration-500">

        <!-- Breadcrumb -->
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
                    <span class="text-gray-400">/</span>
                </li>
                <li>
                    <a href="{{ url('/categories') }}" class="text-gray-500 hover:text-gray-700">Categories</a>
                </li>
                <li>
                    <span class="text-gray-400">/</span>
                </li>
                <li>
                    <span class="text-{{ $categories->color_name }}-400 font-medium">{{ $categories->category_name }}</span>
                </li>
            </ol>
        </nav>

        {{-- Global Page Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-10">
            <div class="items-center gap-5">
                {{-- Title & Count --}}
                <div>
                    <h1 class="text-4xl font-black text-{{ $categories->color_name }}-400 tracking-tight">
                        {{ $categories->category_name }}</h1>
                    <p class="text-gray-400 text-sm font-medium">
                        {{ $categories->category_description }}
                    </p>
                    {{-- <p class="text-gray-400 text-sm font-medium">
                        Category with <span id="totalCount" class="text-blue-400 font-bold">13</span> snippets
                    </p> --}}
                </div>
            </div>
        </div>

        {{-- Main Layout Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            {{-- Category Info Card --}}
            <div class="md:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <div
                        class="glass-card backdrop-blur-xl rounded-3xl p-8 border text-center relative overflow-hidden shadow-2xl">

                        {{-- Decorative Background Glow --}}
                        <div
                            class="absolute -top-24 -left-24 w-48 h-48 bg-{{ $categories->color_name }}-500/10 blur-3xl rounded-full">
                        </div>

                        {{-- Category Icon Section --}}
                        <div onclick="triggerActionMenu('{{ $categories->category_id }}', '{{ $categories->category_name }}', '{{ $categories->color_name }}')"
                            class="group relative">

                            <div class="absolute -top-2 -right-2 z-10">

                            </div>

                            <div class="flex flex-col items-center text-center">
                                <div class="w-16 h-16 mb-3 relative">
                                    <svg class="w-16 h-16 text-{{ $categories->color_name }}-500/70 group-hover:text-{{ $categories->color_name }}-400 transition-colors"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                                    </svg>
                                    {{-- <div
                                class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-{{ $categories->color_name }}-500 border-2 border-black">
                            </div> --}}
                                </div>




                            </div>
                        </div>

                        {{-- Category Name & Description --}}
                        <h2 class="text-xl font-bold text-{{ $categories->color_name }}-400 tracking-tight">
                            {{ $categories->category_name }}</h2>
                        <p class="text-gray-500 text-sm mb-3 line-clamp-2"> {{ $categories->category_description }}</p>

                        {{-- Category Stats --}}
                        <div class="mb-6 space-y-2">
                            <div class="flex items-center justify-center gap-2 text-xs text-gray-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Created {{ \Carbon\Carbon::parse($categories->created_at)->diffForHumans() }}
                                </span>
                            </div>
                            <div class="flex items-center justify-center gap-2 text-xs text-gray-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    248 total views
                                </span>
                            </div>
                        </div>

                        {{-- Stats Section --}}
                        <div class="pt-6 border-t border-white/5 space-y-4">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500 uppercase tracking-widest font-bold text-[10px]">Total
                                    Snippets</span>
                                <span class="text-{{ $categories->color_name }}-400 font-bold" id="sidebarCount">13</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500 uppercase tracking-widest font-bold text-[10px]">Languages</span>
                                <span class="text-{{ $categories->color_name }}-400 font-bold">5</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500 uppercase tracking-widest font-bold text-[10px]">Last
                                    Updated</span>

                                <span class="text-{{ $categories->color_name }}-400 font-bold">
                                    @if ($categories->updated_at)
                                        {{ \Carbon\Carbon::parse($categories->updated_at)->diffForHumans() }}
                                    @else
                                        Never
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        {{-- <div class="mt-8 flex gap-2 justify-center">
                            <a href="#" class="inline-flex items-center gap-2 bg-{{ $categories->color_name }}-600/20 hover:bg-{{ $categories->color_name }}-600/30 text-{{ $categories->color_name }}-400 text-sm px-4 py-2 rounded-xl font-bold transition-all duration-200 shadow-lg shadow-{{ $categories->color_name }}-900/20 border border-purple-500/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit
                            </a>
                            <a href="#" class="inline-flex items-center gap-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 text-sm px-4 py-2 rounded-xl font-bold transition-all duration-200 shadow-lg shadow-red-900/20 border border-red-500/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- Right Content: Snippets List --}}
            <div class="md:col-span-3 space-y-4">

                {{-- Filters Bar --}}
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                    <div class="flex flex-col md:flex-row flex-1 items-center gap-2">
                        {{-- Search Input --}}
                        <div class="relative group w-full md:w-80">
                            <input type="text" id="searchInput" placeholder="Find a snippet in this category..."
                                class="bg-[#0d1117] border border-[#30363d] text-gray-300 text-sm rounded-lg pl-10 pr-4 py-1.5 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all w-full">
                            <svg class="w-4 h-4 text-gray-500 absolute left-3.5 top-1/2 -translate-y-1/2 group-focus-within:text-purple-400 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        {{-- Filters --}}
                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <select id="languageFilter"
                                class="bg-[#21262d] border border-[#30363d] rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-300 hover:bg-[#30363d] hover:border-[#8b949e] focus:outline-none cursor-pointer transition-all">
                                <option value="all">Language</option>
                                <option value="php">PHP</option>
                                <option value="blade">Blade</option>
                                <option value="javascript">JavaScript</option>
                            </select>

                            <select id="statusFilter"
                                class="bg-[#21262d] border border-[#30363d] rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-300 hover:bg-[#30363d] hover:border-[#8b949e] focus:outline-none cursor-pointer transition-all">
                                <option value="all">Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                            <select id="sortFilter"
                                class="bg-[#21262d] border border-[#30363d] rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-300 hover:bg-[#30363d] hover:border-[#8b949e] focus:outline-none cursor-pointer transition-all">
                                <option value="latest">Sort</option>
                                <option value="oldest">Oldest</option>
                                <option value="az">A-Z</option>
                                <option value="za">Z-A</option>
                            </select>
                        </div>
                    </div>



                </div>

                {{-- Snippets Container --}}
                <div class="space-y-4">
                    {{-- Snippet Card 1 --}}
                    <div class="snippet-card group border-b border-white/10 p-5 hover:bg-white/[0.02] transition-all">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <a href="#"
                                        class="text-{{ $categories->color_name }}-400 text-lg md:text-xl font-semibold hover:underline decoration-2 truncate max-w-[200px] md:max-w-none">
                                        Login System
                                    </a>
                                    <span
                                        class="px-2 py-0.5 bg-transparent text-gray-500 text-[10px] uppercase tracking-wider rounded-md border border-gray-800 font-bold">
                                        PUBLIC
                                    </span>
                                </div>

                                <p
                                    class="text-{{ $categories-> color_name }}-200 text-sm leading-snug whitespace-pre-line mb-4 line-clamp-2 md:line-clamp-none">
                                    Complete authentication system with login, registration, and password reset
                                    functionality.
                                </p>

                                <div
                                    class="flex flex-wrap items-center gap-x-4 gap-y-2 text-gray-500 text-[11px] md:text-xs">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                                        PHP
                                    </span>
                                    <span>Updated 2 days ago</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-width="2"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                            </path>
                                        </svg>
                                        3 files
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 mt-2 md:mt-0 self-end md:self-start">
                                <button
                                    class="p-2.5 md:p-2 bg-white/5 hover:bg-yellow-500/20 hover:text-yellow-400 border border-white/10 rounded-lg transition-all"
                                    title="Star">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Snippet Card 2 --}}
                    <div class="snippet-card group border-b border-white/10 p-5 hover:bg-white/[0.02] transition-all">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <a href="#"
                                        class="text-{{ $categories->color_name }}-400 text-lg md:text-xl font-semibold hover:underline decoration-2 truncate max-w-[200px] md:max-w-none">
                                        Eloquent Relationships
                                    </a>
                                    <span
                                        class="px-2 py-0.5 bg-transparent text-gray-500 text-[10px] uppercase tracking-wider rounded-md border border-gray-800 font-bold">
                                        PUBLIC
                                    </span>
                                </div>

                                <p
                                    class="text-{{ $categories->color_name }}-200 text-sm leading-snug whitespace-pre-line mb-4 line-clamp-2 md:line-clamp-none">
                                    Examples of one-to-one, one-to-many, and many-to-many relationships in Laravel Eloquent.
                                </p>

                                <div
                                    class="flex flex-wrap items-center gap-x-4 gap-y-2 text-gray-500 text-[11px] md:text-xs">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                                        PHP
                                    </span>
                                    <span>Updated 5 days ago</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-width="2"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                            </path>
                                        </svg>
                                        5 files
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 mt-2 md:mt-0 self-end md:self-start">
                                <button
                                    class="p-2.5 md:p-2 bg-white/5 hover:bg-yellow-500/20 hover:text-yellow-400 border border-white/10 rounded-lg transition-all"
                                    title="Star">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- No Results Message (hidden by default) --}}
                <div id="noResults"
                    class="hidden glass-card rounded-[3rem] p-16 text-center border-dashed border-white/10 shadow-inner bg-white/[0.02]">
                    <div
                        class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/10">
                        <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3 tracking-tight">No Snippets Found</h3>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto leading-relaxed">Try adjusting your filters or search
                        terms.</p>
                    <button
                        class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-bold transition-all">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
