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
                                        class="bg-transparent text-gray-400 hover:text-white text-[11px] font-bold uppercase tracking-widest px-4 py-2.5 pr-8 focus:outline-none cursor-pointer transition-all appearance-none border-r border-white/5">
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
                                        class="bg-transparent text-gray-400 hover:text-white text-[11px] font-bold uppercase tracking-widest px-4 py-2.5 pr-8 focus:outline-none cursor-pointer transition-all appearance-none border-r border-white/5">
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
                                        class="bg-transparent text-gray-400 hover:text-white text-[11px] font-bold uppercase tracking-widest px-4 py-2.5 pr-8 focus:outline-none cursor-pointer transition-all appearance-none">
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
                <div x-show="loading" class="space-y-4 py-8">
                    <template x-for="i in 3">
                        <div class="glass-card p-10 animate-pulse rounded-[2.5rem] border border-white/5">
                            <div class="h-6 bg-white/5 rounded-xl w-1/4 mb-4"></div>
                            <div class="h-3.5 bg-white/5 rounded-xl w-full mb-2"></div>
                            <div class="h-3.5 bg-white/5 rounded-xl w-3/4"></div>
                        </div>
                    </template>
                </div>

                <!-- Snippets Stream -->
                <div x-show="!loading" class="space-y-4">
                    <template x-for="snippet in snippets" :key="snippet.id">
                        <div class="glass-card group p-6 border border-white/5 rounded-[2rem] hover:border-blue-500/30 transition-all duration-500 cursor-pointer relative overflow-hidden shadow-lg"
                            @click="openSnippet(snippet.id)">
                            
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 relative z-10">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-2 flex-wrap">
                                        <h3 class="text-white text-xl font-black group-hover:text-blue-400 transition-colors tracking-tight" x-text="snippet.title"></h3>
                                        <template x-if="snippet.language">
                                            <span class="px-2.5 py-1 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[9px] rounded-lg font-black uppercase tracking-widest" x-text="snippet.language"></span>
                                        </template>
                                    </div>

                                    <p class="text-gray-400 text-sm font-medium mb-6 line-clamp-2 leading-relaxed" x-text="snippet.description || 'No specialized description provided.'"></p>

                                    <div class="flex flex-wrap items-center gap-6 text-gray-500 text-[10px] font-black uppercase tracking-widest">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                            </svg>
                                            <span x-text="(snippet.files ? snippet.files.length : 0) + ' Resources'"></span>
                                        </div>
                                        
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-lg overflow-hidden bg-blue-500/10 flex items-center justify-center text-[8px] border border-blue-500/20">
                                                <span x-text="snippet.user_id == {{ Auth::id() }} ? 'ME' : (snippet.user ? snippet.user.name.charAt(0).toUpperCase() : 'P')"></span>
                                            </div>
                                            <span x-text="snippet.user_id == {{ Auth::id() }} ? 'Personal Vault' : (snippet.user ? snippet.user.name : 'Partner Logic')"></span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span x-text="formatDate(snippet.created_at)"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-4 group-hover:translate-x-0">
                                    <div class="p-3 bg-[#0a0a0a] hover:bg-blue-500/10 text-gray-500 hover:text-blue-400 border border-white/5 hover:border-blue-500/30 rounded-2xl transition-all shadow-inner">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Premium Pagination --}}
                <div x-show="lastPage > 1 && !loading" x-cloak class="flex flex-col sm:flex-row items-center justify-between mt-12 pt-8 border-t border-white/5 gap-6">
                    <div class="flex items-center gap-4 text-xs font-black uppercase tracking-widest text-gray-500">
                        <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#030303] border border-white/5 text-white shadow-inner" x-text="currentPage"></span>
                        <span>of</span>
                        <span class="text-white" x-text="lastPage"></span>
                        <span class="ml-1 opacity-40">Pages</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <button @click="fetchSnippets(currentPage - 1)" 
                            :disabled="currentPage === 1"
                            class="group flex items-center gap-2 px-6 py-3 bg-[#030303] border border-white/5 rounded-2xl hover:bg-white/5 disabled:opacity-20 disabled:cursor-not-allowed transition-all text-[10px] font-black uppercase tracking-widest text-white shadow-xl">
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Previous</span>
                        </button>
                        
                        <button @click="fetchSnippets(currentPage + 1)" 
                            :disabled="currentPage === lastPage"
                            class="group flex items-center gap-2 px-6 py-3 bg-[#030303] border border-white/5 rounded-2xl hover:bg-white/5 disabled:opacity-20 disabled:cursor-not-allowed transition-all text-[10px] font-black uppercase tracking-widest text-white shadow-xl">
                            <span>Next</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Empty State --}}
                <div x-show="initialized && !loading && snippets.length === 0" x-cloak class="py-12">
                    <div class="glass-card rounded-[3rem] p-16 text-center border-dashed border-white/10 bg-[#050505]/30">
                        <div class="w-20 h-20 bg-blue-500/5 rounded-[2.2rem] flex items-center justify-center mx-auto mb-6 border border-blue-500/10 shadow-lg">
                            <svg class="w-10 h-10 text-blue-400/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-white mb-2 tracking-tight">Stream Empty</h3>
                        <p class="text-gray-500 mb-8 max-w-sm mx-auto text-sm font-medium leading-relaxed">No active logic nodes match your current discovery parameters.</p>
                        <button @click="resetFilters()"
                            class="btn-primary items-center gap-x-2 py-2 px-6 rounded-xl btn-primary  font-bold">
                            Clear Discovery
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar-->
            <aside class="col-span-1 xl:col-span-1 space-y-6">
                <div class="glass-card rounded-[2.5rem] p-8 border border-white/5 sticky top-24 text-left shadow-2xl overflow-hidden group">
                    <div class="absolute -right-16 -top-16 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all duration-500"></div>
                    
                    <h2 class="text-xs font-black text-gray-500  tracking-widest mb-8 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        Recent Changes
                    </h2>

                    <div class="relative space-y-8">
                        <div class="absolute left-[5px] top-2 bottom-2 w-px bg-white/5"></div>

                        <div class="relative pl-8 group/item">
                            <div class="absolute left-0 top-1.5 w-2.5 h-2.5 rounded-full bg-[#111] border border-white/10 group-hover/item:border-blue-500/50 transition-colors"></div>
                            <p class="text-[9px] font-black text-blue-500/50 uppercase tracking-tighter mb-1">New API Release</p>
                            <h3 class="text-xs text-gray-300 font-bold leading-relaxed group-hover/item:text-white transition-colors">REST API v2026.03 is now production ready for all clusters.</h3>
                        </div>

                        <div class="relative pl-8 group/item">
                            <div class="absolute left-0 top-1.5 w-2.5 h-2.5 rounded-full bg-[#111] border border-white/10 group-hover/item:border-blue-500/50 transition-colors"></div>
                            <p class="text-[9px] font-black text-blue-500/50 uppercase tracking-tighter mb-1">Update</p>
                            <h3 class="text-xs text-gray-300 font-bold leading-relaxed group-hover/item:text-white transition-colors">Auto-model selection enabled for enterprise vaults.</h3>
                        </div>

                        <div class="relative pl-8 group/item">
                            <div class="absolute left-0 top-1.5 w-2.5 h-2.5 rounded-full bg-[#111] border border-white/10 group-hover/item:border-blue-500/50 transition-colors"></div>
                            <p class="text-[9px] font-black text-blue-500/50 uppercase tracking-tighter mb-1">System Notice</p>
                            <h3 class="text-xs text-gray-300 font-bold leading-relaxed group-hover/item:text-white transition-colors">Metadata structure update successfully deployed.</h3>
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t border-white/5">
                        <a href="#" class="text-[10px] font-black text-gray-500 hover:text-blue-400 uppercase tracking-widest flex items-center gap-2 transition-colors group/link">
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
