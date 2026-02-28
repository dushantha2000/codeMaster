@extends('layout.app')

@section('title', 'Dashboard')

{{-- This will show the search bar in header --}}
@section('show-search')
    true
@endsection

@section('content')
    <!-- Mobile Filter Button (FAB) -->
    <button x-cloak @click="mobileFiltersOpen = !mobileFiltersOpen"
        class="lg:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-blue-600 hover:bg-blue-700 rounded-full shadow-lg shadow-blue-900/50 flex items-center justify-center transition-all active:scale-95"
        :class="mobileFiltersOpen ? 'ring-4 ring-blue-500/30' : ''">
        <svg x-show="!mobileFiltersOpen" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
            </path>
        </svg>
        <svg x-show="mobileFiltersOpen" x-cloak class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Mobile Filter Overlay & Panel -->
    <div x-show="mobileFiltersOpen"
        x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="lg:hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50"
        @click="mobileFiltersOpen = false">
    </div>

    <!-- Mobile Filter Panel (slides from bottom) -->
    <div x-show="mobileFiltersOpen"
        x-transition:enter="transition-transform ease-out duration-300"
        x-transition:enter-start="translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transition-transform ease-in duration-200"
        x-transition:leave-start="translate-y-0"
        x-transition:leave-end="translate-y-full"
        class="lg:hidden mobile-filter-panel fixed bottom-0 left-0 right-0 z-50 max-h-[80vh] overflow-y-auto bg-[#0a0a0a] rounded-t-3xl border-t border-white/10 shadow-2xl"
        @click.stop>
        <div class="p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-white">Filters</h3>
                <button @click="mobileFiltersOpen = false" class="p-2 rounded-full bg-white/5 border border-white/10">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Language Filter -->
            <div class="mb-6">
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Language</h4>
                <div class="flex flex-wrap gap-2">
                    <template x-for="lang in languageList">
                        <button
                            @click="selectedLanguage = lang.id; selectedLanguageName = lang.icon + ' ' + lang.name; fetchSnippets(); mobileFiltersOpen = false;"
                            :class="selectedLanguage === lang.id ? 'bg-blue-500/20 text-blue-400 border-blue-500/30' : 'bg-white/5 text-gray-400 border-white/10 hover:bg-white/10'"
                            class="px-3 py-2 rounded-lg border transition-all text-sm flex items-center gap-2">
                            <span x-text="lang.icon"></span>
                            <span x-text="lang.name"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Sort By Filter -->
            <div class="mb-6 pt-6 border-t border-white/5">
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Sort By</h4>
                <div class="flex flex-wrap gap-2">
                    <button @click="sortBy = 'recent'; fetchSnippets(); mobileFiltersOpen = false;"
                        :class="sortBy === 'recent' ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5'"
                        class="px-4 py-2 rounded-lg border border-white/10 transition-all text-sm">Recently Added</button>
                    <button @click="sortBy = 'title'; fetchSnippets(); mobileFiltersOpen = false;"
                        :class="sortBy === 'title' ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5'"
                        class="px-4 py-2 rounded-lg border border-white/10 transition-all text-sm">Title A-Z</button>
                    <button @click="sortBy = 'files'; fetchSnippets(); mobileFiltersOpen = false;"
                        :class="sortBy === 'files' ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5'"
                        class="px-4 py-2 rounded-lg border border-white/10 transition-all text-sm">Most Files</button>
                </div>
            </div>

            <!-- Clear Filters Button -->
            <button
                @click="selectedLanguage = ''; selectedLanguageName = 'All Languages'; sortBy = 'recent'; statusFilter = 'all'; fetchSnippets(); mobileFiltersOpen = false;"
                class="w-full mt-4 px-4 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-sm text-gray-400 hover:text-white transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Clear All Filters
            </button>
        </div>
    </div>

    <!-- Left Sidebar - Filters (desktop) -->
    <aside class="hidden lg:block w-80 shrink-0">
        <div class="glass-card rounded-2xl p-6 border border-white/10 sticky top-8">
            <!-- Filter content (same as before) -->
            <div class="mb-6">
                <h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-4">Language</h3>
                <div class="space-y-2">
                    <template x-for="lang in languageList.slice(1)">
                        <button
                            @click="selectedLanguage = lang.id; selectedLanguageName = lang.icon + ' ' + lang.name; fetchSnippets();"
                            :class="selectedLanguage === lang.id ? 'bg-blue-500/20 text-blue-400 border-blue-500/30' :
                                'bg-white/5 text-gray-400 border-white/10 hover:bg-white/10'"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg border transition-all text-sm">
                            <span x-text="lang.icon + ' ' + lang.name"></span>
                        </button>
                    </template>
                </div>
            </div>

            <div class="mb-6 pt-6 border-t border-white/5">
                <h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-4">Sort By</h3>
                <div class="space-y-2">
                    <button @click="sortBy = 'recent'; fetchSnippets();"
                        :class="sortBy === 'recent' ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5'"
                        class="w-full text-left px-3 py-2 rounded-lg transition-all text-sm">Recently
                        Added</button>
                    <button @click="sortBy = 'title'; fetchSnippets();"
                        :class="sortBy === 'title' ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5'"
                        class="w-full text-left px-3 py-2 rounded-lg transition-all text-sm">Title A-Z</button>
                    <button @click="sortBy = 'files'; fetchSnippets();"
                        :class="sortBy === 'files' ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5'"
                        class="w-full text-left px-3 py-2 rounded-lg transition-all text-sm">Most
                        Files</button>
                </div>
            </div>

            <button
                @click="selectedLanguage = ''; selectedLanguageName = 'All Languages'; sortBy = 'recent'; statusFilter = 'all'; fetchSnippets();"
                class="w-full mt-6 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-xs text-gray-400 hover:text-white transition-all flex items-center justify-center gap-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Clear All Filters
            </button>
        </div>
    </aside>

    <!-- Main Content - Snippets List -->
    <div class="flex-1 min-w-0">
        <div x-show="loading" class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
            <p class="mt-2 text-gray-400">Loading snippets...</p>
        </div>

        <div x-show="!loading" class="flex flex-col gap-4">
            <template x-for="snippet in snippets" :key="snippet.id">
                <div class="snippet-card group rounded-2xl shadow-xl transition-all duration-300 cursor-pointer"
                    @click="openSnippet(snippet.id)">
                    <div class="p-5 flex items-center gap-5">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-1 flex-wrap">
                                <span
                                    class="text-white font-bold group-hover:text-blue-400 truncate transition-colors"
                                    x-text="snippet.title"></span>
                                <template x-if="snippet.language">
                                    <span
                                        class="px-2 py-0.5 bg-blue-500/10 text-blue-400 text-[10px] uppercase tracking-widest font-black rounded-md border border-blue-500/20"
                                        x-text="snippet.language"></span>
                                </template>
                            </div>
                            <p class="text-gray-500 text-xs line-clamp-1 mb-2"
                                x-text="snippet.description || '// No documentation attached...'"></p>
                            <div class="flex items-center gap-4 text-gray-400 text-[11px] font-bold">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-width="2"
                                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                        </path>
                                    </svg>
                                    <span x-text="snippet.files.length + ' files'"></span>
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
                        <div
                            class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <div
                                class="p-2.5 bg-white/5 hover:bg-blue-500/20 hover:text-blue-400 rounded-xl border border-white/5 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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

        <!-- Empty State -->
        <div x-show="!loading && snippets.length === 0">
            <div class="rounded-xl p-12 text-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 border">
                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No snippets yet</h3>
                <p class="text-gray-400 mb-6 max-w-md mx-auto">Your code vault is empty. Start building your
                    collection by creating your first snippet.</p>
                <a href="{{ route('snippets-create') }}"
                    class="load-btn inline-flex items-center gap-2 btn-primary text-sm px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Your First Snippet
                </a>
            </div>
        </div>
    </div>

    <!-- Right Sidebar - User Profile (desktop) -->
    <aside class="hidden xl:block w-64 shrink-0">
        <div class="glass-card rounded-2xl p-6 border border-white/10 text-center sticky top-8">
            <h2 class="text-xl font-bold text-white mb-1">{{ Auth::user()->name }}</h2>
            <p class="text-xs text-gray-500 mb-6">{{ Auth::user()->email }}</p>
            <div class="space-y-3 mb-6">
                <div class="glass-card rounded-xl p-4 border border-white/5">
                    <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Total
                        Snippets</div>
                    <div class="text-2xl font-bold text-white" x-text="snippets.length"></div>
                </div>
            </div>
            <div class="pt-4 border-t border-white/5 space-y-2">
                <a href="{{ url('/my-snippets') }}"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-blue-500/10 hover:bg-blue-500/20 border border-blue-500/20 rounded-lg text-sm text-blue-400 font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    My Snippets
                </a>
                <a href="{{ url('/settings') }}"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-sm text-gray-400 hover:text-white font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z">
                        </path>
                    </svg>
                    Settings
                </a>
            </div>
        </div>
    </aside>
@endsection