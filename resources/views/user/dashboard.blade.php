@extends('layout.app')

@section('title', 'Dashboard')

{{-- This will show the search bar in header --}}
@section('show-search')
    true
@endsection

@section('content')
    <div x-data="snippetBrowser()" x-init="init()" class="w-full">
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <!-- Main Content - Snippets List (takes 3 columns on xl screens) -->
            <div class="col-span-1 xl:col-span-3 space-y-6">
                
                {{-- Global Page Header --}}
                {{-- <div class="mb-10">
                    <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight">Logic Stream</h1>
                    <p class="text-gray-400 text-base font-medium mt-2">Discover and retrieve globally indexed code patterns.</p>
                </div> --}}

                {{-- Modern Discovery Bar --}}
                <div class="glass-container mb-8">
                    <div class=" p-1.5 md:p-2  shadow-2xl overflow-hidden">
                        <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-2">
                            
                            {{-- Search Input Group --}}
                            <div class="relative flex-1 group">
                                <div class="absolute left-5 top-1/2 -translate-y-1/2 flex items-center gap-3">
                                    <svg class="w-4 h-4 text-gray-500 group-focus-within:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <div class="h-4 w-px bg-white/10"></div>
                                </div>
                                <input type="text" x-model="searchQuery" @input.debounce.500ms="fetchSnippets()"
                                    placeholder="Execute logic discovery..."
                                    class="w-full bg-white/[0.02] hover:bg-white/[0.04] border-none text-white text-sm rounded-2xl pl-16 pr-4 py-4 focus:ring-0 transition-all font-medium placeholder-gray-600">
                            </div>

                            {{-- Filters Group --}}
                            <div class="flex flex-wrap items-center gap-2 bg-black/40 p-1.5 rounded-2xl border border-white/5">
                                {{-- Language Filter --}}
                                <div class="relative">
                                    <select x-model="selectedLanguage" @change="fetchSnippets()"
                                        class="bg-transparent text-gray-400 hover:text-white text-xs font-medium px-3 py-2 pr-8 focus:outline-none cursor-pointer transition-all appearance-none border-r border-white/5">
                                        <option value="all">Language</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language }}">{{ $language }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="w-3 h-3 text-gray-600 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                {{-- Status Filter --}}
                                <div class="relative">
                                    <select x-model="selectedStatus" @change="fetchSnippets()"
                                        class="bg-transparent text-gray-400 hover:text-white text-xs font-medium px-3 py-2 pr-8 focus:outline-none cursor-pointer transition-all appearance-none border-r border-white/5">
                                        <option value="all">Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Archived</option>
                                    </select>
                                    <svg class="w-3 h-3 text-gray-600 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                {{-- Sort Filter --}}
                                <div class="relative">
                                    <select x-model="sortBy" @change="fetchSnippets()"
                                        class="bg-transparent text-gray-400 hover:text-white text-xs font-medium px-3 py-2 pr-8 focus:outline-none cursor-pointer transition-all appearance-none">
                                        <option value="latest">Latest</option>
                                        <option value="oldest">Oldest</option>
                                        <option value="az">A-Z Name</option>
                                    </select>
                                    <svg class="w-3 h-3 text-gray-600 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading State -->
                <div x-show="loading" class="space-y-3 py-4">
                    <template x-for="i in 3">
                        <div class="glass-card px-5 py-4 animate-pulse border border-white/5">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="h-4 bg-white/5 rounded w-1/3 mb-2"></div>
                                    <div class="h-3 bg-white/5 rounded w-2/3"></div>
                                </div>
                                <div class="h-3 bg-white/5 rounded w-16"></div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Snippets Stream -->
                <div x-show="!loading" class="space-y-3">
                    <template x-for="snippet in snippets" :key="snippet.id">
                        <div class="glass-card group px-5 py-4 border border-white/5 hover:border-blue-500/30 transition-all duration-300 cursor-pointer relative overflow-hidden"
                            @click="openSnippet(snippet.id)">
                            
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 relative z-10">
                                <div class="flex-1 min-w-0">
                                    {{-- Title + Language inline --}}
                                    <div class="flex items-center gap-2.5 mb-1">
                                        <h3 class="text-white text-base font-bold group-hover:text-blue-400 transition-colors truncate" x-text="snippet.title"></h3>
                                        <template x-if="snippet.language">
                                            <span class="shrink-0 px-2 py-0.5 bg-blue-500/10 text-blue-400 text-[11px] rounded-md font-medium capitalize" x-text="snippet.language"></span>
                                        </template>
                                    </div>

                                    {{-- Description (single line) --}}
                                    <p class="text-gray-500 text-sm truncate" x-text="snippet.description"></p>
                                </div>

                                {{-- Metadata row --}}
                                <div class="flex items-center gap-4 shrink-0">
                                    <span class="text-gray-600 text-xs hidden md:flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                                        <span x-text="(snippet.files ? snippet.files.length : 0) + ' files'"></span>
                                    </span>
                                    <span class="text-gray-600 text-xs hidden md:inline" x-text="formatDate(snippet.created_at)"></span>
                                    {{-- View arrow (always visible on mobile, hover on desktop) --}}
                                    <div class="text-gray-600 group-hover:text-blue-400 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Pagination --}}
                <div x-show="lastPage > 1 && !loading" x-cloak class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-6 border-t border-white/5 gap-4">
                    <div class="flex items-center gap-3 text-sm text-gray-500">
                        <span class="font-semibold text-white" x-text="currentPage"></span>
                        <span>of</span>
                        <span x-text="lastPage"></span>
                        <span class="opacity-50">pages</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button @click="fetchSnippets(currentPage - 1)" 
                            :disabled="currentPage === 1"
                            class="group flex items-center gap-2 px-5 py-2.5 bg-white/5 border border-white/5 rounded-xl hover:bg-white/10 disabled:opacity-20 disabled:cursor-not-allowed transition-all text-sm font-medium text-gray-300">
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Prev</span>
                        </button>
                        
                        <button @click="fetchSnippets(currentPage + 1)" 
                            :disabled="currentPage === lastPage"
                            class="group flex items-center gap-2 px-5 py-2.5 bg-white/5 border border-white/5 rounded-xl hover:bg-white/10 disabled:opacity-20 disabled:cursor-not-allowed transition-all text-sm font-medium text-gray-300">
                            <span>Next</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Empty State --}}
                <div x-show="initialized && !loading && snippets.length === 0" x-cloak class="py-12">
                    <div class="glass-card p-12 text-center border border-white/5">
                        <div class="w-16 h-16 bg-blue-500/5 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-blue-500/10">
                            <svg class="w-8 h-8 text-blue-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-1">No snippets found</h3>
                        <p class="text-gray-500 mb-6 max-w-sm mx-auto text-sm">Try adjusting your search or filters to find what you're looking for.</p>
                        <button @click="resetFilters()"
                            class="btn-primary px-5 py-2 rounded-lg text-sm font-semibold">
                            Clear filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar-->
            <aside class="col-span-1 xl:col-span-1 space-y-6">
                <div class=" sticky top-24 text-left  overflow-hidden group">
                   
                    
                    <h2 class="text-xs font-black text-gray-500  tracking-widest mb-8 flex items-center gap-2">
                        
                        Recent Changes
                    </h2>

                    <div class="relative space-y-6">
                        <div class="absolute left-[2.5px] top-2 bottom-0 w-px bg-white/5 z-0"></div>

                        @forelse($recentActivity as $activity)
                            <div class="relative pl-6 group/item cursor-pointer">
                                <!-- Simple Dot -->
                                <div class="absolute left-0 top-2 w-1.5 h-1.5 rounded-full bg-blue-500/40 group-hover/item:bg-blue-400 transition-colors z-10"></div>
                                
                                <!-- Title -->
                                <h3 class="text-sm text-gray-200 font-medium group-hover/item:text-white transition-colors line-clamp-1">
                                    {{ $activity->title }}
                                </h3>
                                
                                <!-- Action & Time Subtext -->
                                <p class="text-[11px] text-gray-500 mt-1 font-medium flex items-center gap-1.5">
                                    <span>{{ $activity->is_new ? 'Created a new' : 'Updated' }} {{ strtolower($activity->type) }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                                    <span>{{ \Carbon\Carbon::parse($activity->action_time)->diffForHumans() }}</span>
                                </p>
                            </div>
                        @empty
                            <div class="relative pl-6 group/item">
                                <div class="absolute left-0 top-2 w-1.5 h-1.5 rounded-full bg-gray-700 z-10"></div>
                                <p class="text-xs text-gray-500 font-medium">No recent changes.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-10 pt-6 border-t border-white/5">
                        <a href="{{ route('logs') }}" class="text-[10px] font-black text-gray-500 hover:text-blue-400 uppercase tracking-widest flex items-center gap-2 transition-colors group/link">
                            View Logs
                            <svg class="w-3 h-3 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        {{-- Global Preview Modal --}}
        @include('common.preview-modal')
    </div>

    <!-- Alpine.js Script  -->
    <script>
        window.snippetBrowser = function() {
            return {
                currentPage: 1,
                lastPage: 1,
                total: 0,
                loading: false,
                initialized: false,

                // Discovery state
                searchQuery: '',
                selectedLanguage: 'all',
                selectedStatus: 'all',
                sortBy: 'latest',
                snippets: [],

                // Preview Modal state
                showPreview: false,
                selectedSnippet: null,
                activeFileTab: 0,
                mobileFileListOpen: false,
                copyDone: false,
                mobileMenuOpen: false,
                initialized: false,

                init() {
                    this.fetchSnippets();
                },

                fetchSnippets(page = 1) {
                    this.currentPage = page;
                    this.loading = true;
                    const params = new URLSearchParams({
                        page: this.currentPage,
                        q: this.searchQuery,
                        lang: this.selectedLanguage === 'all' ? '' : this.selectedLanguage,
                        status: this.selectedStatus === 'all' ? '' : this.selectedStatus,
                        sort: this.sortBy
                    });

                    fetch(`/api/search?${params.toString()}`)
                        .then(res => res.json())
                        .then(data => {
                            // Extract data correctly based on standard response
                            this.snippets = data.data || data;
                            this.lastPage = data.last_page || 1;
                            this.total = data.total || 0;
                            this.loading = false;
                            this.initialized = true;
                        })
                        .catch(err => {
                            console.error("Discovery Error:", err);
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
                            console.error("Transmission Error:", err);
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
                    this.selectedStatus = 'all';
                    this.sortBy = 'latest';
                    this.fetchSnippets();
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
