@extends('layout.app')

@section('title', 'My Snippets')

@section('content')
    <div x-init="init()" class="w-full">
        <div id="main-page-content" class="w-full max-w-6xl mx-auto px-4" x-cloak>

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
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">Snippets</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><span class="text-blue-400 font-medium">Terminal</span></li>
            </ol>
        </nav>


            {{-- Global Page Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                <div>
                    <div class="flex items-center gap-4">
                        <h1 class="text-4xl font-black text-white tracking-tight">Developer Terminal</h1>
                        <span
                            class="bg-blue-500/10 text-blue-400 text-sm font-black px-3 py-1 rounded-xl border border-blue-500/20 shadow-lg shadow-blue-500/5 mt-1"
                            x-text="total">
                            {{ $snippets->total() }}
                        </span>
                    </div>
                    <p class="text-gray-400 text-base font-medium mt-2">A secure environment for your reusable architecture.</p>
                </div>

                <a href="{{ route('snippets-create') }}"
                    class="btn-primary px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add New Logic</span>
                </a>
            </div>

            {{-- Main Layout Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 pb-20">

                {{-- Sidebar: Profile --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        <div
                            class="  p-8 relative overflow-hidden text-center group">

                            {{-- Profile Image Section --}}
                            <div class="relative inline-block mb-6">
                                <div
                                    class="w-28 h-28 rounded-3xl bg-blue-500/5 border border-blue-500/10 flex items-center justify-center mx-auto shadow-2xl overflow-hidden transition-all duration-500 group-hover:border-blue-500/30">
                                    @if (Auth::user()->profile_image)
                                        <img src="{{ asset('profileImages/' . Auth::user()->profile_image) }}"
                                            alt="{{ Auth::user()->name }}"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <span
                                            class="text-5xl font-black text-blue-500/40">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div
                                    class="absolute -bottom-2 -right-2 bg-blue-600 text-white text-[10px] font-black px-3 py-1.5 rounded-xl border-4 border-[#0a0a0a] shadow-xl uppercase tracking-widest">
                                    lvl 1
                                </div>
                            </div>

                            <h2 class="text-2xl font-black text-white tracking-tight mb-1">{{ Auth::user()->name }}</h2>
                            <p class="text-gray-500 text-xs font-bold mb-8 italic">
                                "{{ Auth::user()->bio ?? 'Security Architect' }}"</p>

                            <div class="space-y-3">
                                <div
                                    class="flex flex-col items-center p-5 bg-[#050505] rounded-2xl border border-white/5 shadow-inner">
                                    <span class="text-gray-500 text-[10px] font-black tracking-widest uppercase mb-1">Index
                                        Density</span>
                                    <span class="text-white font-black text-3xl"
                                        x-text="total">{{ $snippets->total() }}</span>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Snippets Archive Section --}}
                <div class="lg:col-span-3 space-y-6">

                    {{-- Modern Discovery Bar --}}
                    <div class="glass-container mb-8">
                        <div class=" p-1.5 md:p-2 shadow-2lx overflow-hidden">
                            <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-2">

                                {{-- Search Input Group --}}
                                <div class="relative flex-1 group">
                                    <div class="absolute left-5 top-1/2 -translate-y-1/2 flex items-center gap-3">
                                        <svg class="w-4 h-4 text-gray-500 group-focus-within:text-blue-400 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <div class="h-4 w-px bg-white/10"></div>
                                    </div>
                                    <input type="text" x-model="searchQuery" @input.debounce.500ms="fetchSnippets()"
                                        placeholder="Scan personal vault..."
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
                                            @foreach ($languages as $language)
                                                <option value="{{ $language }}">{{ $language }}</option>
                                            @endforeach
                                        </select>
                                        <svg class="w-3 h-3 text-gray-600 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>

                                    {{-- Status --}}
                                    <div class="relative">
                                        <div
                                            class="bg-transparent text-blue-500/50 text-[11px] font-bold uppercase tracking-widest px-4 py-2.5 border-r border-white/5">
                                            Vaulted
                                        </div>
                                    </div>

                                    {{-- Sort Filter --}}
                                    <div class="relative">
                                        <select x-model="selectedSort" @change="fetchSnippets()"
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

                    {{-- Loading Indicator --}}
                    <div x-show="loading" class="space-y-4 py-8">
                        <template x-for="i in 2">
                            <div class="glass-card p-10 animate-pulse rounded-[2.5rem] border border-white/5">
                                <div class="h-6 bg-white/5 rounded-xl w-1/4 mb-4"></div>
                                <div class="h-3.5 bg-white/5 rounded-xl w-full mb-2"></div>
                                <div class="h-3.5 bg-white/5 rounded-xl w-3/4"></div>
                            </div>
                        </template>
                    </div>

                    {{-- Logic Stream Items --}}
                    <div class="space-y-4" x-show="!loading">
                        <template x-for="snippet in snippets" :key="snippet.id">
                            <div class="glass-card group p-6 border border-white/5 rounded-[2rem] hover:border-blue-500/30 transition-all duration-500 cursor-pointer relative overflow-hidden shadow-lg"
                                @click="openSnippet(snippet.id)">

                                <div
                                    class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 relative z-10">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                                            <h3 class="text-white text-xl font-black group-hover:text-blue-400 transition-colors tracking-tight"
                                                x-text="snippet.title"></h3>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="px-2.5 py-1 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[9px] rounded-lg font-black uppercase tracking-widest">Archived</span>
                                                <template x-if="snippet.isMark == 1">
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full bg-yellow-400 shadow-[0_0_10px_rgba(250,204,21,0.4)]"></span>
                                                </template>
                                            </div>
                                        </div>

                                        <p class="text-gray-400 text-sm font-medium mb-6 line-clamp-2 leading-relaxed"
                                            x-text="snippet.description || 'No specialized description provided.'"></p>

                                        <div
                                            class="flex flex-wrap items-center gap-6 text-gray-500 text-[10px] font-black uppercase tracking-widest">
                                            <template x-if="snippet.language">
                                                <div
                                                    class="flex items-center gap-2 px-3 py-1.5 bg-[#030303] rounded-xl border border-white/5 group-hover:border-blue-500/20 transition-colors shadow-inner">
                                                    <span class="text-xs" x-text="getFileIcon(snippet.language)"></span>
                                                    <span class="text-gray-300 group-hover:text-blue-400 transition-colors"
                                                        x-text="snippet.language"></span>
                                                </div>
                                            </template>

                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span x-text="formatDate(snippet.created_at)"></span>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                                </svg>
                                                <span
                                                    x-text="(snippet.files ? snippet.files.length : 0) + ' Resources'"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-center gap-3 mt-4 md:mt-0 opacity-0 group-hover:opacity-100 transition-all transform translate-x-4 group-hover:translate-x-0">
                                        <a :href="`/snippets/${snippet.id}/edit`" @click.stop
                                            class="p-3 bg-[#0a0a0a] hover:bg-blue-500/10 text-gray-500 hover:text-blue-400 border border-white/5 hover:border-blue-500/30 rounded-2xl transition-all shadow-inner">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <button @click.stop="openEraseModal(snippet.id)"
                                            class="p-3 bg-[#0a0a0a] hover:bg-red-500/10 text-gray-500 hover:text-red-400 border border-white/5 hover:border-red-500/30 rounded-2xl transition-all shadow-inner">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Empty Stream --}}
                    <div x-show="initialized && !loading && snippets.length === 0" x-cloak class="py-12">
                        <div
                            class="glass-card rounded-[3rem] p-16 text-center border-dashed border-white/10 bg-[#050505]/30">
                            <div
                                class="w-20 h-20 bg-blue-500/5 rounded-[2.2rem] flex items-center justify-center mx-auto mb-6 border border-blue-500/10 shadow-lg">
                                <svg class="w-10 h-10 text-blue-400/30" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black text-white mb-2 tracking-tight">Stream Empty</h3>
                            <p class="text-gray-500 mb-8 max-w-sm mx-auto text-sm font-medium leading-relaxed">The archived
                                search parameters returned no active logic nodes in your vault.</p>
                            <button @click="resetFilters()"
                                class="btn-primary  items-center gap-x-2 py-2 px-6 rounded-xl btn-primary  font-bold">
                                  Clear Discovery
                            </button>
                        </div>
                    </div>

                    {{-- Data Stream Pagination --}}
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
            </div>
        </div>

        {{-- Centered Erase Logic Modal --}}
        <div id="deleteModal" class="hidden fixed inset-0 z-[100] items-center justify-center p-6"
            @click.self="closeEraseModal()">
            <div class="fixed inset-0 bg-black/90 backdrop-blur-2xl animate-in fade-in duration-500"></div>

            <div
                class="relative w-full max-w-md glass-card rounded-[3rem] p-10 border border-white/10 shadow-[0_0_100px_rgba(0,0,0,0.8)] animate-in zoom-in-95 duration-300">
                <button @click="closeEraseModal()"
                    class="absolute top-6 right-6 text-gray-500 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-red-600/10 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6 border border-red-500/20 shadow-2xl">
                        <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>

                    <h3 class="text-3xl font-black text-white tracking-tighter mb-2">Purge Logic?</h3>
                    <p class="text-gray-400 text-sm font-medium mb-10 leading-relaxed px-4">Permanent erasure of the
                        selected data node. Recovery is technically impossible after execution.</p>

                    <form action="{{ url('snippet-delete') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="hidden" name="snippet_id" id="modalSnippetId">
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-500 text-white py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-xl shadow-red-900/10">
                            Execute Purge
                        </button>
                        <button type="button" @click="closeEraseModal()"
                            class="w-full py-4 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all border border-white/5">
                            Abort
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Preview Modal Integrated --}}
        @include('common.preview-modal')

    </div>

    <script>
        // Define snippetBrowser globally
        window.snippetBrowser = function() {
            return {
                snippets: [],
                currentPage: 1,
                lastPage: 1,
                total: {{ $snippets->total() }},
                searchQuery: '',
                selectedLanguage: 'all',
                selectedSort: 'latest',
                loading: false,

                // Preview Modal state
                showPreview: false,
                selectedSnippet: null,
                activeFileTab: 0,
                mobileFileListOpen: false,
                copyDone: false,
                mobileMenuOpen: false,
                initialized: false,

                init() {
                    // Initial load from server-side Blade data
                    this.snippets = @json($snippets->items());
                    this.currentPage = {{ $snippets->currentPage() }};
                    this.lastPage = {{ $snippets->lastPage() }};

                    // Set initialized flag
                    this.initialized = true;
                    console.log("Vault initialized");
                },

                fetchSnippets(page = 1) {
                    this.currentPage = page;
                    this.loading = true;

                    const params = new URLSearchParams({
                        page: this.currentPage,
                        q: this.searchQuery,
                        sort: this.selectedSort
                    });

                    if (this.selectedLanguage !== 'all' && this.selectedLanguage !== '') {
                        params.append('lang', this.selectedLanguage);
                    }

                    fetch(`/api/search/my-snippets?${params.toString()}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.data) {
                                this.snippets = data.data;
                                this.lastPage = data.last_page || 1;
                                this.total = data.total || 0;
                            } else {
                                this.snippets = Array.isArray(data) ? data : [];
                            }
                            this.loading = false;
                            this.initialized = true;
                        })
                        .catch(err => {
                            console.error("Logic Stream Error:", err);
                            this.loading = false;
                            this.initialized = true;
                        });
                },

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
                            console.error("Detail Error:", err);
                            this.loading = false;
                        });
                },

                copyCode(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.copyDone = true;
                        setTimeout(() => this.copyDone = false, 2000);
                    }).catch(() => {
                        const textarea = document.createElement('textarea');
                        textarea.value = text;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                        this.copyDone = true;
                        setTimeout(() => this.copyDone = false, 2000);
                    });
                },

                resetFilters() {
                    this.searchQuery = '';
                    this.selectedLanguage = 'all';
                    this.fetchSnippets();
                },

                openEraseModal(id) {
                    const modalInput = document.getElementById('modalSnippetId');
                    const modal = document.getElementById('deleteModal');
                    if (modalInput && modal) {
                        modalInput.value = id;
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    }
                },

                closeEraseModal() {
                    const modal = document.getElementById('deleteModal');
                    if (modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                },

                formatDate(dateStr) {
                    if (!dateStr) return 'N/A';
                    return new Date(dateStr).toLocaleDateString(undefined, {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                },

                getFileIcon(filename) {
                    if (!filename) return '📄';
                    const name = filename.toLowerCase();
                    if (name.includes('php') || name.includes('laravel')) return '🐘';
                    if (name.includes('js') || name.includes('javascript')) return '🟨';
                    if (name.includes('py')) return '🐍';
                    if (name.includes('react')) return '⚛️';
                    if (name.includes('html')) return '🌐';
                    if (name.includes('css')) return '🎨';
                    if (name.includes('tailwind')) return '🍃';
                    return '📄';
                }
            }
        }
    </script>
@endsection
