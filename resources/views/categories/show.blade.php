@extends('layout.app')

@section('title', 'Laravel - Category')

@section('content')
    <div x-init="init()" x-cloak
        class="w-full max-w-6xl mx-auto px-4 animate-in fade-in slide-in-from-bottom-4 duration-500">

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


                <div>
                    <div class="flex items-center gap-4">
                        <h1 class="text-4xl font-black text-{{ $categories->color_name }}-400 tracking-tight">
                            {{ $categories->category_name }}</h1>
                        <span
                            class="bg-blue-500/10 text-{{ $categories->color_name }}-400 text-sm font-black px-3 py-1 rounded-xl border border-{{ $categories->color_name }}-500/20 shadow-lg shadow-blue-500/5 mt-1"
                            x-text="total">
                            {{ $snippets->total() }}
                        </span>
                    </div>
                    <p class="text-gray-400 text-base font-medium mt-2"> {{ $categories->category_description }}</p>
                </div>


            </div>
        </div>

        {{-- Main Layout Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            {{-- Category Info Card --}}
            <div class="md:col-span-1">
                <div class="sticky top-20 space-y-6">
                    <div
                        class="glass-card bg-[#0A0A0A]/50 backdrop-blur-xl rounded-[2.5rem] p-10 border border-white/5 text-center relative overflow-hidden shadow-2xl group">
                        {{-- Decorative Background Glow --}}
                        <div
                            class="absolute -top-24 -left-24 w-48 h-48 bg-{{ $categories->color_name }}-500/10 blur-3xl rounded-full group-hover:bg-{{ $categories->color_name }}-500/20 transition-colors">
                        </div>

                        {{-- Category Icon Section --}}
                        <div class="relative inline-block mb-6">
                            <div
                                class="w-24 h-24 rounded-[2rem] bg-{{ $categories->color_name }}-500/10 border-2 border-{{ $categories->color_name }}-500/20 flex items-center justify-center mx-auto shadow-2xl shadow-{{ $categories->color_name }}-500/10 group-hover:scale-105 transition-transform duration-500">
                                <svg class="w-12 h-12 text-{{ $categories->color_name }}-500/70 group-hover:text-{{ $categories->color_name }}-400 transition-colors"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                                </svg>
                                <div
                                    class="absolute bottom-1 right-1 w-4 h-4 rounded-full bg-{{ $categories->color_name }}-500 border-2 border-[#0A0A0A]">
                                </div>
                            </div>
                        </div>

                        {{-- Category Name & Description --}}
                        <h2 class="text-2xl font-black text-[#EDEDED] tracking-tighter mb-2">
                            {{ $categories->category_name }}
                        </h2>
                        <p class="text-[#71717A] text-xs font-medium leading-relaxed mb-8 px-2">
                            {{ $categories->category_description ?: 'No description provided for this directory.' }}
                        </p>

                        {{-- Stats Section --}}
                        <div class="pt-8 border-t border-white/5 space-y-5">
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="text-[#71717A] uppercase tracking-[0.15em] font-black">Total Archived</span>
                                <span class="text-{{ $categories->color_name }}-400 font-black text-xs"
                                    id="sidebarCount">{{ $totalSnippets }}</span>
                            </div>
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="text-[#71717A] uppercase tracking-[0.15em] font-black">Unique Stacks</span>
                                <span class="text-[#EDEDED] font-black text-xs">{{ $uniqueLanguages }}</span>
                            </div>
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="text-[#71717A] uppercase tracking-[0.15em] font-black">Last Sync</span>
                                <span class="text-[#EDEDED] font-black text-[11px]">
                                    {{ $categories->updated_at ? \Carbon\Carbon::parse($categories->updated_at)->diffForHumans() : 'Never' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Content: Snippets List --}}
            <div class="md:col-span-3 space-y-4">

                {{-- Unified Discovery Bar --}}
                <div class="glass-container mb-10">
                    <div class=" p-1.5 md:p-2 shadow-2lx overflow-hidden">
                        <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-2">

                            {{-- Search Input Group --}}
                            <div class="relative flex-1 group">
                                <div class="absolute left-5 top-1/2 -translate-y-1/2 flex items-center gap-3">
                                    <svg class="w-4 h-4 text-gray-500 group-focus-within:text-{{ $categories->color_name }}-400 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <div class="h-4 w-px bg-white/10"></div>
                                </div>
                                <input type="text" x-model="searchQuery" @input.debounce.500ms="fetchSnippets()"
                                    placeholder="Search in {{ $categories->category_name }}..."
                                    class="w-full bg-white/[0.02] hover:bg-white/[0.04] border-none text-white text-sm rounded-2xl pl-16 pr-4 py-4 focus:ring-0 transition-all font-medium placeholder-gray-600">
                            </div>

                            {{-- Filters Group --}}
                            <div
                                class="flex flex-wrap items-center gap-2 bg-black/40 p-1.5 rounded-2xl border border-white/5">
                                {{-- Language Filter --}}
                                <div class="relative">
                                    <select x-model="selectedLanguage" @change="fetchSnippets()"
                                        class="bg-transparent text-gray-400 hover:text-white text-[11px] font-bold uppercase tracking-widest px-4 py-2.5 pr-8 focus:outline-none cursor-pointer transition-all appearance-none border-r border-white/5">
                                        <option value="all">Language</option>
                                        <option value="php">PHP</option>
                                        <option value="blade">Blade</option>
                                        <option value="javascript">JavaScript</option>
                                    </select>
                                    <svg class="w-3 h-3 text-gray-600 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                {{-- Status Filter --}}
                                <div class="relative">
                                    <select x-model="statusFilter" @change="fetchSnippets()"
                                        class="bg-transparent text-gray-400 hover:text-white text-[11px] font-bold uppercase tracking-widest px-4 py-2.5 pr-8 focus:outline-none cursor-pointer transition-all appearance-none border-r border-white/5">
                                        <option value="all">Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Archived</option>
                                    </select>
                                    <svg class="w-3 h-3 text-gray-600 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                {{-- Sort Filter --}}
                                <div class="relative">
                                    <select x-model="sortBy" @change="fetchSnippets()"
                                        class="bg-transparent text-gray-400 hover:text-white text-[11px] font-bold uppercase tracking-widest px-4 py-2.5 pr-8 focus:outline-none cursor-pointer transition-all appearance-none">
                                        <option value="latest">Latest</option>
                                        <option value="oldest">Oldest</option>
                                        <option value="az">A-Z Name</option>
                                        <option value="za">Z-A Name</option>
                                    </select>
                                    <svg class="w-3 h-3 text-gray-600 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Loading Skeleton --}}
                <div x-show="loading" class="space-y-4" style="display: none;">
                    <template x-for="i in 3">
                        <div class="border border-[#30363d] bg-[#161b22] rounded-md p-5 animate-pulse mb-3">
                            <div class="h-4 bg-[#30363d] rounded w-1/3 mb-3"></div>
                            <div class="h-3 bg-[#30363d]/50 rounded w-full mb-2"></div>
                            <div class="h-3 bg-[#30363d]/30 rounded w-2/3"></div>
                        </div>
                    </template>
                </div>

                {{-- Snippets Container --}}
                <div class="grid grid-cols-1 gap-4 mt-2" x-show="!loading" style="display: none;">
                    <template x-for="snippet in snippets" :key="snippet.id">
                        <div class="glass-card group p-6 border border-white/5 rounded-[2rem] hover:border-blue-500/30 transition-all duration-500 cursor-pointer relative overflow-hidden shadow-lg"
                            @click="openSnippet(snippet.id)">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        <h3 class="text-[#EDEDED] text-lg font-semibold group-hover:text-blue-400 transition-colors"
                                            x-text="snippet.title"></h3>
                                        <template x-if="snippet.isActive == 1">
                                            <span
                                                class="px-2 py-0.5 bg-white/5 border border-white/10 text-[#71717A] text-[10px] rounded-md font-medium uppercase tracking-wider">Active</span>
                                        </template>
                                    </div>

                                    <p class="text-[#A1A1AA] text-sm leading-relaxed mb-4 line-clamp-2"
                                        x-text="snippet.description || 'No description provided.'"></p>

                                    <div
                                        class="flex flex-wrap items-center gap-x-4 gap-y-2 text-[#71717A] text-xs font-medium">
                                        <template x-if="snippet.language">
                                            <span class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full" :class="{
                                                        'bg-[#4F5D95]': snippet.language.toLowerCase() === 'php',
                                                        'bg-[#f1e05a]': snippet.language.toLowerCase() === 'javascript' || snippet.language.toLowerCase() === 'js',
                                                        'bg-[#9b4F96]': snippet.language.toLowerCase() === 'css',
                                                        'bg-[#e34c26]': snippet.language.toLowerCase() === 'html',
                                                        'bg-[#41b883]': snippet.language.toLowerCase() === 'vue',
                                                        'bg-[#61dafb]': snippet.language.toLowerCase() === 'react',
                                                        'bg-[#3178c6]': snippet.language.toLowerCase() === 'typescript',
                                                        'bg-[#A1A1AA]': !['php', 'javascript', 'js', 'html', 'css', 'vue', 'react', 'typescript'].includes(snippet.language?.toLowerCase())
                                                    }"></span>
                                                <span x-text="snippet.language"></span>
                                            </span>
                                        </template>

                                        <span
                                            x-text="'Updated ' + new Date(snippet.updated_at || snippet.created_at).toLocaleDateString()"></span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                                </path>
                                            </svg>
                                            <span
                                                x-text="snippet.files ? snippet.files.length + ' files' : '0 files'"></span>
                                        </span>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center gap-2 mt-2 md:mt-0 self-end md:self-start opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click.stop="toggleStar(snippet.id)"
                                        class="p-2 bg-white/5 border border-white/10 rounded-lg transition-all focus:outline-none"
                                        :class="snippet.isMark == 1 ? 'hover:bg-yellow-500/10 text-yellow-500 border-yellow-500/20 bg-yellow-500/5' : 'hover:bg-white/10 text-[#A1A1AA] hover:text-yellow-500'"
                                        title="Star">
                                        <svg class="w-4 h-4" :fill="snippet.isMark == 1 ? 'currentColor' : 'none'"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Unified Vault-Style Pagination --}}
                    <div x-show="lastPage > 1 && !loading" x-cloak
                        class="flex flex-col sm:flex-row items-center justify-between mt-12 pt-8 border-t border-white/5 gap-6">
                        <div class="flex items-center gap-4 text-xs font-black uppercase tracking-widest text-gray-500">
                            <span
                                class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#030303] border border-white/5 text-white shadow-inner"
                                x-text="currentPage"></span>
                            <span>of</span>
                            <span class="text-white" x-text="lastPage"></span>
                            <span class="ml-1 opacity-40">Pages</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <button @click="fetchSnippets(currentPage - 1)" :disabled="currentPage === 1"
                                class="group flex items-center gap-2 px-6 py-3 bg-[#030303] border border-white/5 rounded-2xl hover:bg-white/5 disabled:opacity-20 disabled:cursor-not-allowed transition-all text-[10px] font-black uppercase tracking-widest text-white shadow-xl">
                                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                <span>Previous</span>
                            </button>

                            <button @click="fetchSnippets(currentPage + 1)" :disabled="currentPage === lastPage"
                                class="group flex items-center gap-2 px-6 py-3 bg-[#030303] border border-white/5 rounded-2xl hover:bg-white/5 disabled:opacity-20 disabled:cursor-not-allowed transition-all text-[10px] font-black uppercase tracking-widest text-white shadow-xl">
                                <span>Next</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Premium Pagination --}}
                <div x-show="lastPage > 1 && !loading" x-cloak
                    class="flex flex-col sm:flex-row items-center justify-between mt-12 pt-8 border-t border-white/5 gap-6">
                    <div class="flex items-center gap-4 text-xs font-black uppercase tracking-widest text-gray-500">
                        <span
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#030303] border border-white/5 text-white shadow-inner"
                            x-text="currentPage"></span>
                        <span>of</span>
                        <span class="text-white" x-text="lastPage"></span>
                        <span class="ml-1 opacity-40">Pages</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <button @click="fetchSnippets(currentPage - 1)" :disabled="currentPage === 1"
                            class="group flex items-center gap-2 px-6 py-3 bg-[#030303] border border-white/5 rounded-2xl hover:bg-white/5 disabled:opacity-20 disabled:cursor-not-allowed transition-all text-[10px] font-black uppercase tracking-widest text-white shadow-xl">
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Previous</span>
                        </button>

                        <button @click="fetchSnippets(currentPage + 1)" :disabled="currentPage === lastPage"
                            class="group flex items-center gap-2 px-6 py-3 bg-[#030303] border border-white/5 rounded-2xl hover:bg-white/5 disabled:opacity-20 disabled:cursor-not-allowed transition-all text-[10px] font-black uppercase tracking-widest text-white shadow-xl">
                            <span>Next</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>





                {{-- No Results Message --}}
                <div x-show="initialized && !loading && snippets.length === 0" style="display: none;"
                    class="glass-card rounded-[3rem] p-16 text-center border-dashed border-{{ $categories->color_name }}-500/20 shadow-inner bg-{{ $categories->color_name }}-500/5 transition-all">
                    <div
                        class="w-20 h-20 bg-{{ $categories->color_name }}-500/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-{{ $categories->color_name }}-500/20 shadow-lg shadow-{{ $categories->color_name }}-500/10 animate-[bounce_2s_ease-in-out_infinite]">
                        <svg class="w-10 h-10 text-{{ $categories->color_name }}-500/70" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3 tracking-tight">No Snippets Found</h3>
                    <p class="text-gray-400 mb-8 max-w-sm mx-auto leading-relaxed">Try adjusting your filters or search
                        terms.</p>
                    <button
                        @click="searchQuery = ''; selectedLanguage = 'all'; statusFilter = 'all'; sortBy = 'latest'; fetchSnippets()"
                        class="inline-flex items-center gap-2 bg-{{ $categories->color_name }}-500/10 hover:bg-{{ $categories->color_name }}-500/20 text-white px-6 py-3 rounded-xl font-bold transition-all border border-{{ $categories->color_name }}-500/30">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Snippet Preview Modal --}}
    @include('common.preview-modal')
@endsection

@push('scripts')
    <script>
        window.snippetBrowser = function () {
            return {
                categoryId: '{{ $categories->category_id }}',
                snippets: [],
                currentPage: 1,
                lastPage: 1,
                total: 0,
                searchQuery: '',
                selectedLanguage: 'all',
                statusFilter: 'all',
                sortBy: 'latest',
                loading: false,
                showPreview: false,
                selectedSnippet: null,
                activeFileTab: 0,
                mobileMenuOpen: false,
                mobileFileListOpen: false,
                copyDone: false,
                initialized: false,
                searchTimeout: null,

                init() {
                    // Resize listener
                    window.addEventListener('resize', () => this.handleResize());
                    // Initial fetch
                    this.fetchSnippets();
                },

                handleResize() {
                    if (window.innerWidth > 768) {
                        this.mobileFileListOpen = false;
                        this.mobileMenuOpen = false;
                    }
                },

                fetchSnippets(page = 1) {
                    this.currentPage = page;
                    this.loading = true;
                    const url = `/api/search?category_id=${this.categoryId}&q=${encodeURIComponent(this.searchQuery)}&lang=${this.selectedLanguage}&status=${this.statusFilter}&sort=${this.sortBy}&page=${this.currentPage}`;

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            let snippets = data.data || data;

                            // Local sort fallback
                            if (this.sortBy === 'az') {
                                snippets.sort((a, b) => a.title.localeCompare(b.title));
                            } else if (this.sortBy === 'za') {
                                snippets.sort((a, b) => b.title.localeCompare(a.title));
                            } else if (this.sortBy === 'files') {
                                snippets.sort((a, b) => (b.files?.length || 0) - (a.files?.length || 0));
                            }

                            this.snippets = snippets;
                            this.lastPage = data.last_page || 1;
                            this.total = data.total || 0;
                            this.loading = false;
                            this.initialized = true;
                        })
                        .catch(e => {
                            console.error("Error fetching snippets:", e);
                            this.loading = false;
                            this.initialized = true;
                        });
                },

                toggleStar(id) {
                    const formData = new FormData();
                    formData.append('snippet_id', id);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('/snippet-marked', {
                        method: 'POST',
                        body: formData
                    })
                        .then(() => {
                            this.fetchSnippets();
                        })
                        .catch(err => console.error("Star Error:", err));
                },

                // Modal viewer utilities
                openSnippet(id) {
                    this.loading = true;

                    fetch(`/api/snippets/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            this.selectedSnippet = data;
                            this.activeFileTab = 0;
                            this.showPreview = true;
                            this.mobileFileListOpen = false;
                            this.loading = false;

                            this.$nextTick(() => {
                                if (typeof Prism !== 'undefined') {
                                    Prism.highlightAll();
                                }
                            });
                        })
                        .catch(err => {
                            console.error('Error fetching snippet details:', err);
                            this.loading = false;
                        });
                },

                closePreview() {
                    this.showPreview = false;
                    setTimeout(() => {
                        this.selectedSnippet = null;
                    }, 300);
                },

                toggleMobileFileList() {
                    this.mobileFileListOpen = !this.mobileFileListOpen;
                },

                copyCode(code = null) {
                    const codeToCopy = code || (this.selectedSnippet && this.selectedSnippet.files[this.activeFileTab] ? this.selectedSnippet.files[this.activeFileTab].content : '');
                    if (!codeToCopy) return;

                    navigator.clipboard.writeText(codeToCopy).then(() => {
                        this.copyDone = true;
                        setTimeout(() => this.copyDone = false, 2000);
                    });
                },

                getLangIcon(lang) {
                    if (!lang) return '📄';
                    const icons = {
                        'php': '🐘',
                        'laravel': '🟠',
                        'javascript': '🟨',
                        'js': '🟨',
                        'python': '🐍',
                        'html': '🌐',
                        'css': '🎨',
                        'react': '⚛️',
                        'vue': '🖖',
                        'database': '🗄️',
                        'sql': '💾'
                    };
                    return icons[lang.toLowerCase()] || '📄';
                },

                getFileIcon(filename) {
                    if (!filename) return '📄';
                    const ext = filename.split('.').pop().toLowerCase();
                    const icons = {
                        'js': '📘',
                        'jsx': '⚛️',
                        'ts': '📘',
                        'tsx': '⚛️',
                        'php': '🐘',
                        'py': '🐍',
                        'html': '🌐',
                        'css': '🎨',
                        'json': '📋',
                        'md': '📝',
                        'vue': '💚',
                        'sql': '🗄️'
                    };
                    return icons[ext] || '📄';
                }
            }
        }
    </script>
@endpush