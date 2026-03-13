@extends('layout.app')

@section('title', 'Dashboard')

{{-- This will show the search bar in header --}}
@section('show-search')
    true
@endsection

@section('content')
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6" x-data="snippetManager()" x-init="fetchSnippets()">
        <!-- Main Content - Snippets List (takes 3 columns on xl screens) -->
        <div class="col-span-1 xl:col-span-3 space-y-4">
            {{-- Filters Bar --}}
            <div class="flex flex-col-1 lg:flex-row lg:items-center justify-between gap-4 mb-6 ">
                {{-- Search Input & Filters Group --}}
                <div class="flex flex-col md:flex-row flex-1 items-center gap-2">
                    {{-- Search Input --}}
                    <div class="relative group w-full md:w-80">
                        <input type="text" id="searchInput" placeholder="Find a snippet..." x-model="searchQuery"
                            @input.debounce.300ms="fetchSnippets()"
                            class="bg-[#0d1117] border border-[#30363d] text-gray-300 text-sm rounded-lg pl-10 pr-4 py-1.5 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all w-full">
                        <svg class="w-4 h-4 text-gray-500 absolute left-3.5 top-1/2 -translate-y-1/2 group-focus-within:text-blue-400 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    {{-- Filters --}}
                    <div class="flex items-center gap-2 w-full md:w-auto">
                        {{-- Language Filter --}}
                        <select id="languageFilter" x-model="selectedLanguage" @change="fetchSnippets()"
                            class="bg-[#21262d] border border-[#30363d] rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-300 hover:bg-[#30363d] hover:border-[#8b949e] focus:outline-none cursor-pointer transition-all">
                            <option value="all">Language</option>
                            {{-- @foreach ($languages as $language)
                            <option value="{{ $language }}">{{ $language }}</option>
                        @endforeach --}}
                        </select>

                        {{-- Status/Type Filter --}}
                        <select id="statusFilter" x-model="selectedStatus" @change="fetchSnippets()"
                            class="bg-[#21262d] border border-[#30363d] rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-300 hover:bg-[#30363d] hover:border-[#8b949e] focus:outline-none cursor-pointer transition-all">
                            <option value="all">Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>

                        {{-- Sort Filter --}}
                        <select id="sortFilter" x-model="sortBy" @change="fetchSnippets()"
                            class="bg-[#21262d] border border-[#30363d] rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-300 hover:bg-[#30363d] hover:border-[#8b949e] focus:outline-none cursor-pointer transition-all">
                            <option value="latest">Sort</option>
                            <option value="oldest">Oldest</option>
                            <option value="az">A-Z</option>
                            <option value="za">Z-A</option>
                        </select>

                        <button
                            class="flex items-center gap-1 bg-[#21262d] border border-[#30363d] rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-300 hover:bg-[#30363d] hover:border-[#8b949e] focus:outline-none cursor-pointer transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                </path>
                            </svg>
                            Star
                        </button>
                    </div>
                </div>

                {{-- New Snippet Button --}}
                {{-- <div class="w-full lg:w-auto">
                    <a href="{{ url('/snippets/create') }}"
                        class="flex items-center justify-center gap-2 btn-primary text-white text-sm px-3 py-2 rounded-xl font-bold transition-all duration-200 shadow-lg shadow-blue-900/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        New
                    </a>
                </div> --}}
            </div>

            <!-- Snippets List -->
            <div class="flex-1 min-w-0">
                <div x-show="loading" x-transition:enter="transition opacity-ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition opacity-ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-black backdrop-blur-md">

                    <div class="absolute w-32 h-32 bg-black rounded-full blur-3xl animate-pulse"></div>

                    <div class="relative">
                        <div class="w-12 h-12 rounded-full border-4 border-white/10 border-t-white-500 animate-spin"></div>
                    </div>

                    <p class="mt-4 text-white font-medium tracking-wide animate-pulse">
                        Loading snippets...
                    </p>
                </div>

                <div x-show="!loading" class="flex flex-col gap-4">
                    <template x-for="snippet in snippets" :key="snippet.id">
                        <div class="snippet-card group border-b border-white/10 p-5 hover:bg-white/[0.02] transition-all cursor-pointer"
                            @click="openSnippet(snippet.id)">
                            <div class="flex items-center gap-5">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-1 flex-wrap">
                                        <span
                                            class="text-white-400 text-xl font-semibold hover:underline decoration-2 transition-colors"
                                            x-text="snippet.title"></span>
                                        <template x-if="snippet.language">
                                            <span
                                                class="px-2 py-0.5 bg-blue-500/10 text-blue-400 text-[10px] uppercase tracking-widest font-black rounded-md border border-blue-500/20"
                                                x-text="snippet.language"></span>
                                        </template>
                                    </div>
                                    <p class="text-gray-400 text-[14px] leading-snug whitespace-pre-line mb-4 max-w-4xl"
                                        x-text="snippet.description || '// No documentation attached...'"></p>
                                    <div class="flex items-center gap-4 text-gray-400 text-[11px] font-bold">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                                </path>
                                            </svg>
                                            <span
                                                x-text="snippet.files ? snippet.files.length + ' files' : '0 files'"></span>
                                        </span>
                                        <span>•</span>
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-1.5 h-1.5 rounded-full"
                                                :class="snippet.user_id == {{ Auth::id() }} ? 'bg-green-500' :
                                                    'bg-purple-500'">
                                            </div>
                                            <span
                                                x-text="snippet.user_id == {{ Auth::id() }} ? 'You' : (snippet.user ? snippet.user.name : 'Partner')"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div
                                        class="p-2.5 bg-white/5 hover:bg-blue-500/20 hover:text-blue-400 rounded-xl border border-white/5 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>


                {{-- No Results Message --}}
                <div x-show="!loading && snippets.length === 0"
                    class=" glass-card rounded-[3rem] p-16 text-center border-dashed border-white/10 shadow-inner bg-white/[0.02]">
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
                        @click="selectedLanguage = 'all'; selectedStatus = 'all'; sortBy = 'latest'; searchQuery = ''; fetchSnippets();
                        class="px-6
                        py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition-all"
                        class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-bold transition-all">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Sidebar-->
        <aside class="col-span-1 xl:col-span-1 mt-8 xl:mt-0">
            <div class="glass-card rounded-2xl p-6 border border-white/10 sticky top-8 text-left">
                <h2 class="text-sm font-bold text-white mb-6">Latest from our changelog</h2>

                <div class="relative space-y-6">
                    <div class="absolute left-[5px] top-2 bottom-2 w-0.5 bg-white/10"></div>

                    <div class="relative pl-6">
                        <div
                            class="absolute left-0 top-1.5 w-2.5 h-2.5 rounded-full bg-gray-600 border-2 border-[#0d1117]">
                        </div>
                        <p class="text-[11px] text-gray-500 font-medium mb-1">Yesterday</p>
                        <h3 class="text-sm text-gray-200 font-semibold leading-tight">REST API version 2026-03-10 is now
                            available</h3>
                    </div>

                    <div class="relative pl-6">
                        <div
                            class="absolute left-0 top-1.5 w-2.5 h-2.5 rounded-full bg-gray-600 border-2 border-[#0d1117]">
                        </div>
                        <p class="text-[11px] text-gray-500 font-medium mb-1">Yesterday</p>
                        <h3 class="text-sm text-gray-200 font-semibold leading-tight">Copilot auto model selection is
                            generally...</h3>
                    </div>

                    <div class="relative pl-6">
                        <div
                            class="absolute left-0 top-1.5 w-2.5 h-2.5 rounded-full bg-gray-600 border-2 border-[#0d1117]">
                        </div>
                        <p class="text-[11px] text-gray-500 font-medium mb-1">Yesterday</p>
                        <h3 class="text-sm text-gray-200 font-semibold leading-tight">Actions OIDC tokens now support
                            repository custo...</h3>
                    </div>

                    <div class="relative pl-6">
                        <div
                            class="absolute left-0 top-1.5 w-2.5 h-2.5 rounded-full bg-gray-600 border-2 border-[#0d1117]">
                        </div>
                        <p class="text-[11px] text-gray-500 font-medium mb-1">Yesterday</p>
                        <h3 class="text-sm text-gray-200 font-semibold leading-tight">Issue fields: Structured issue
                            metadata is in publ...</h3>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-white/5">
                    <a href="#"
                        class="text-xs text-gray-400 hover:text-white flex items-center gap-1 transition-colors">
                        View changelog
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </aside>
    </div>
@endsection
