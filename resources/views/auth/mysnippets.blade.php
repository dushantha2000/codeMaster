@extends('layout.app')

@section('title', 'My Snippets')

@section('content')
    <div x-data="snippetBrowser()" x-init="init()">

        <div class="w-full max-w-6xl mx-auto px-4  animate-in fade-in slide-in-from-bottom-4 duration-500">

            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-3">
                    <li>
                        <a href="{{ url('/') }}" class="text-[#71717A] hover:text-white transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-[#3F3F46] text-xs">/</span>
                        <a href="{{ url('/') }}" class="text-2xs font-bold tracking-normal text-[#71717A] hover:text-white transition-colors nocaps">workspace</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-[#3F3F46] text-xs">/</span>
                        <span class="text-2xs font-bold tracking-normal text-purple-400 nocaps">personal vault</span>
                    </li>
                </ol>
            </nav>

            {{-- Global Page Header --}}
            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-16">
                <div>
                    <h1 class="text-6xl font-black text-white tracking-tighter mb-3 nocaps">vaulted <span class="text-purple-500">logic</span></h1>
                    <p class="text-[#3F3F46] text-2xs font-bold tracking-normal flex items-center gap-3 nocaps">
                        collective index <span class="w-1.5 h-1.5 rounded-full bg-purple-500 shadow-[0_0_10px_rgba(168,85,247,0.5)]"></span> 
                        <span id="totalCount" class="text-[#EDEDED] font-black text-xs">{{ count($snippets) }}</span>
                        nodes archived
                    </p>
                </div>
            </div>


            {{-- Hidden Languages Dropdown --}}
            <div id="moreLanguagesDropdown"
                class="hidden absolute z-50 mt-2 p-4 bg-zinc-900 border border-white/10 rounded-2xl shadow-2xl backdrop-blur-xl"
                style="min-width: 200px;">
                <div class="text-xs text-gray-500 font-medium mb-3 px-2">All Languages</div>
                <div class="flex flex-col gap-2 max-h-60 overflow-y-auto custom-scrollbar">
                    @php
                        $allLanguages = $snippets->pluck('language')->filter()->unique()->sort()->values();
                    @endphp
                    @foreach ($allLanguages as $language)
                        <button onclick="setLanguageFilter('{{ strtolower($language) }}', this)"
                            class="dropdown-lang-btn text-left px-4 py-2.5 bg-white/5 hover:bg-blue-600/20 text-gray-400 hover:text-blue-400 rounded-xl text-xs font-medium border border-white/10 hover:border-blue-500/30 transition-all w-full">
                            {{ $language }}
                        </button>
                    @endforeach
                </div>
            </div>


            {{-- Main Layout Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                {{-- profile  --}}
                <div class="md:col-span-1">
                    <div class="sticky top-20 space-y-6">
                        <div class="glass-card bg-[#050505]/40 backdrop-blur-3xl rounded-[2.5rem] p-10 text-center relative overflow-hidden shadow-2xl group border-white/5">
                            {{-- Decorative Background Glow --}}
                            <div class="absolute -top-24 -left-24 w-48 h-48 bg-purple-500/10 blur-3xl rounded-full group-hover:bg-purple-500/20 transition-colors"></div>

                            {{-- Profile Image Section --}}
                            <div class="relative inline-block mb-8">
                                <div class="w-32 h-32 rounded-[2.5rem] bg-purple-500/5 border border-purple-500/20 flex items-center justify-center mx-auto shadow-2xl overflow-hidden group-hover:border-purple-500/40 transition-all duration-500">
                                    @if (Auth::user()->profile_image)
                                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                            src="{{ asset('profileImages/' . Auth::user()->profile_image) }}"
                                            alt="{{ Auth::user()->name }}">
                                    @else
                                        <span class="text-6xl font-black text-purple-500/80">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                {{-- Level Badge --}}
                                <div class="absolute -bottom-2 -right-2 bg-purple-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl border-4 border-[#030303] shadow-2xl tracking-normal">
                                    Lvl 1
                                </div>
                            </div>

                            {{-- Name & Email --}}
                            <h2 class="text-2xl font-black text-[#EDEDED] tracking-tighter mb-1 nocaps">{{ Auth::user()->name }}</h2>
                            <p class="text-[#3F3F46] text-2xs font-bold mb-6 tracking-normal nocaps">{{ Auth::user()->email }}</p>

                            {{-- Stats Section --}}
                            <div class="pt-8 border-t border-white/5 grid grid-cols-1 gap-4">
                                <div class="flex flex-col items-center p-4 bg-white/[0.02] rounded-2xl border border-white/5">
                                    <span class="text-[#3F3F46] text-3xs font-bold tracking-normal mb-1 nocaps">index density</span>
                                    <span class="text-white font-black text-xl" id="sidebarCount">{{ count($snippets) }}</span>
                                </div>
                            </div>

                            {{-- Action Button --}}
                            <div class="mt-8">
                                <a href="{{ url('/profile') }}"
                                    class="btn-primary inline-flex items-center justify-center w-full py-4 text-2xs nocaps">
                                    modify profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Snippets Vault --}}
                <div class="md:col-span-3 space-y-4">

                    {{-- Loading Skeleton --}}
                    <div x-show="loading" class="space-y-4" style="display: none;">
                        <template x-for="i in 3">
                            <div class="glass-card p-5 animate-pulse mb-3 border-white/5 bg-white/[0.01]">
                                <div class="h-5 bg-white/5 rounded-lg w-1/3 mb-4"></div>
                                <div class="h-3.5 bg-white/5 rounded-lg w-full mb-2"></div>
                                <div class="h-3.5 bg-white/5 rounded-lg w-2/3"></div>
                                <div class="flex gap-4 mt-6">
                                    <div class="h-3 bg-white/5 rounded w-16"></div>
                                    <div class="h-3 bg-white/5 rounded w-16"></div>
                                    <div class="h-3 bg-white/5 rounded w-16"></div>
                                </div>
                            </div>
                        </template>
                    </div>

                        {{-- DASHBOARD-STYLE Filters Bar --}}
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                            {{-- Search Input & Filters Group --}}
                            <div class="flex flex-col md:flex-row flex-1 items-center gap-2">
                                {{-- Search Input --}}
                                <div class="relative group w-full md:w-96">
                                    <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchSnippets()"
                                        placeholder="Find indexed logic..."
                                        class="bg-[#050505] border border-white/5 text-[#EDEDED] text-sm rounded-2xl pl-11 pr-4 py-3.5 focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/40 transition-all w-full placeholder-[#3F3F46] shadow-2xl">
                                    <svg class="w-4 h-4 text-[#3F3F46] absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-purple-400 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>

                                {{-- Filters --}}
                                <div class="flex items-center gap-2 w-full md:w-auto">
                                    {{-- Language Filter --}}
                                    <label for="mysnippets-lang" class="sr-only">Filter by Language</label>
                                    <select id="mysnippets-lang" x-model="selectedLanguage" @change="fetchSnippets()"
                                        class="bg-[#050505] border border-white/5 rounded-2xl px-5 py-3.5 text-2xs font-black uppercase tracking-widest text-[#71717A] hover:bg-white/5 hover:border-white/10 focus:outline-none focus:ring-4 focus:ring-purple-500/10 cursor-pointer transition-all appearance-none shadow-2xl nocaps">
                                        <option value="all">language</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language }}">{{ $language }}</option>
                                        @endforeach
                                    </select>

                                    {{-- Status/Type Filter --}}
                                    <label for="mysnippets-status" class="sr-only">Filter by Status</label>
                                    <select id="mysnippets-status" x-model="selectedStatus" @change="fetchSnippets()"
                                        class="bg-[#050505] border border-white/5 rounded-2xl px-5 py-3.5 text-2xs font-black uppercase tracking-widest text-[#71717A] hover:bg-white/5 hover:border-white/10 focus:outline-none focus:ring-4 focus:ring-purple-500/10 cursor-pointer transition-all appearance-none shadow-2xl nocaps">
                                        <option value="all">status</option>
                                        <option value="1">verified</option>
                                        <option value="0">draft</option>
                                    </select>

                                    {{-- Sort Filter --}}
                                    <label for="mysnippets-sort" class="sr-only">Sort snippets</label>
                                    <select id="mysnippets-sort" x-model="selectedSort" @change="fetchSnippets()"
                                        class="bg-[#050505] border border-white/5 rounded-2xl px-5 py-3.5 text-2xs font-black uppercase tracking-widest text-[#71717A] hover:bg-white/5 hover:border-white/10 focus:outline-none focus:ring-4 focus:ring-purple-500/10 cursor-pointer transition-all appearance-none shadow-2xl nocaps">
                                        <option value="latest">newest first</option>
                                        <option value="oldest">oldest first</option>
                                        <option value="az">a-z</option>
                                        <option value="za">z-a</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                    {{-- Loading Spinner --}}
                    <div id="loadingSpinner" class="hidden flex items-center justify-center py-12">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-12 h-12 rounded-full border-4 border-white/5 border-t-purple-500 animate-spin">
                            </div>
                            <p class="text-[#71717A] text-sm font-medium">Loading snippets...</p>
                        </div>
                    </div>



                    {{-- Snippets Container --}}
                    <div class="grid grid-cols-1 gap-4 mt-2" x-show="!loading" style="display: none;">
                        <template x-for="snippet in snippets" :key="snippet.id">
                            <div class="glass-card group p-6 hover:border-purple-500/30 transition-all duration-500 cursor-pointer relative overflow-hidden"
                                @click="openSnippet(snippet.id)">
                                
                                {{-- Subtle Card Glow on Hover --}}
                                <div class="absolute -top-12 -right-12 w-24 h-24 bg-purple-500/5 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>

                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 relative">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 mb-3 flex-wrap">
                                            <h3 class="text-white text-xl font-black group-hover:text-purple-400 transition-colors tracking-tight nocaps" x-text="snippet.title"></h3>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 bg-purple-500/10 border border-purple-500/20 text-purple-400 text-3xs rounded-md font-black uppercase tracking-widest nocaps">vaulted</span>
                                                <template x-if="snippet.isMark == 1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 shadow-[0_0_8px_rgba(234,179,8,0.5)]"></span>
                                                </template>
                                            </div>
                                        </div>

                                        <p class="text-[#71717A] text-xs font-medium leading-relaxed mb-6 line-clamp-2 nocaps" x-text="snippet.description || 'no description provided.'"></p>

                                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-[#71717A] text-3xs font-black uppercase tracking-widest nocaps">
                                            <template x-if="snippet.language">
                                                <div class="flex items-center gap-2 group/lang px-2 py-1 bg-white/5 rounded-lg border border-white/5 transition-colors group-hover:border-purple-500/20">
                                                    <span class="text-xs" x-text="getFileIcon(snippet.language)">📂</span>
                                                    <span class="text-[#EDEDED] group-hover:text-purple-400 transition-colors" x-text="snippet.language"></span>
                                                </div>
                                            </template>

                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-[#3F3F46]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span x-text="new Date(snippet.updated_at || snippet.created_at).toLocaleDateString()"></span>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-[#3F3F46]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                                </svg>
                                                <span class="text-white" x-text="snippet.files ? snippet.files.length + ' Files' : '0 Files'"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 mt-4 md:mt-0 self-end md:self-start opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                        <a :href="`/snippets/${snippet.id}/edit`"
                                            class="p-2.5 bg-[#0A0A0A] hover:bg-purple-500/10 text-[#71717A] hover:text-purple-400 border border-white/5 hover:border-purple-500/30 rounded-xl transition-all shadow-inner"
                                            :aria-label="'Edit snippet: ' + snippet.title">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        <button @click.stop="openDeleteModal(snippet.id)"
                                            class="p-2.5 bg-[#0A0A0A] hover:bg-red-500/10 text-[#71717A] hover:text-red-400 border border-white/5 hover:border-red-500/30 rounded-xl transition-all shadow-inner"
                                            :aria-label="'Delete snippet: ' + snippet.title">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>


                    {{-- Premium Pagination --}}
                    <div x-show="lastPage > 1 && !loading" class="flex flex-col sm:flex-row items-center justify-between mt-12 pt-8 border-t border-white/5 gap-4">
                        <div class="flex items-center gap-3 text-sm font-medium text-[#71717A] nocaps">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white/5 border border-white/10 text-[#EDEDED]" x-text="currentPage"></span>
                            <span>of</span>
                            <span class="text-[#EDEDED]" x-text="lastPage"></span>
                            <span class="ml-2 text-2xs uppercase tracking-widest opacity-50 nocaps">pages</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <button @click="fetchSnippets(currentPage - 1)" 
                                :disabled="currentPage === 1"
                                class="group flex items-center gap-2 px-5 py-2.5 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 disabled:opacity-30 disabled:cursor-not-allowed transition-all text-sm font-bold text-[#EDEDED]">
                                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                <span>Previous</span>
                            </button>
                            
                            <button @click="fetchSnippets(currentPage + 1)" 
                                :disabled="currentPage === lastPage"
                                class="group flex items-center gap-2 px-5 py-2.5 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 disabled:opacity-30 disabled:cursor-not-allowed transition-all text-sm font-bold text-[#EDEDED]">
                                <span>Next</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>

                        <div class="hidden lg:block text-xs font-medium text-[#71717A] tracking-tight">
                            Showing <span class="text-purple-400 font-bold" x-text="snippets.length"></span> of <span class="text-[#EDEDED] font-bold" x-text="total"></span> results
                        </div>
                    </div>
                    </div>


                    {{-- No Results Message --}}
                    <div id="noResults"
                        class="hidden glass-card rounded-[3rem] p-16 text-center border-dashed border-white/10 shadow-inner bg-[#0A0A0A]/50 backdrop-blur-3xl relative overflow-hidden">
                        {{-- Decorative background sparkle --}}
                        <div class="absolute -top-12 -left-12 w-24 h-24 bg-purple-500/5 blur-2xl rounded-full"></div>

                        <div
                            class="w-24 h-24 bg-purple-500/5 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-purple-500/10 shadow-2xl">
                            <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-3 tracking-tighter nocaps">vault empty</h3>
                        <p class="text-[#71717A] mb-10 max-w-xs mx-auto text-xs font-medium leading-relaxed nocaps">the logic you are searching for is not indexed in the current archive stream.</p>
                        <button onclick="window.location.reload()"
                            class="btn-primary text-white px-8 py-3 rounded-2xl text-2xs font-black uppercase tracking-widest transition-all nocaps">
                            refresh index
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- Delete Modal --}}
        <div id="deleteModal"
            class="fixed inset-0 bg-black/95 backdrop-blur-2xl hidden z-[100] items-center justify-center p-6 transition-all duration-500 opacity-0">
            <div class="glass-card bg-[#0A0A0A] rounded-[3rem] p-12 max-w-md w-full border border-white/5 shadow-[0_0_50px_rgba(0,0,0,0.5)] transform transition-all scale-95 relative overflow-hidden"
                id="modalContainer">
                
                <div class="absolute -top-24 -left-24 w-48 h-48 bg-red-500/5 blur-3xl rounded-full"></div>

                <div
                    class="w-24 h-24 bg-red-500/10 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-red-500/20 shadow-2xl">
                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-3xl font-black text-white text-center mb-4 tracking-tighter nocaps">erase logic?</h3>
                <p class="text-[#71717A] text-center text-xs font-medium mb-12 leading-relaxed px-4 nocaps" id="deleteMessage">this operation will permanently purge the selected logic from your secure vault. this action is irreversible.</p>
                <div class="flex flex-col gap-4">
                    <form id="deleteForm" action="{{ url('snippet-delete') }}" method="POST">
                        @csrf
                        <input type="hidden" name="snippet_id" id="modalSnippetId" value="">
                        <button type="submit"
                            class="w-full bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white py-4 rounded-2xl text-2xs font-black uppercase tracking-widest border border-red-500/30 transition-all shadow-xl mb-2 nocaps">
                            purge permanent memory
                        </button>
                        <button type="button" onclick="closeDeleteModal()"
                            class="w-full py-4 bg-white/5 hover:bg-white/10 text-[#71717A] hover:text-white rounded-2xl text-2xs font-black uppercase tracking-widest border border-white/5 transition-all nocaps">
                            abort command
                        </button>
                    </form>
                </div>
            </div>
        </div>



    </div>

    <script>
        function snippetBrowser() {
            return {
                // Data properties
                snippets: [],
                currentPage: 1,
                lastPage: 1,
                total: 0,
                searchQuery: '',
                selectedLanguage: '',
                selectedLanguageName: 'All Languages',
                sortBy: 'recent',
                statusFilter: 'all',
                mobileFiltersOpen: false,
                loading: false,
                showPreview: false,
                selectedSnippet: null,
                activeFileTab: 0,
                mobileMenuOpen: false,
                mobileFileListOpen: false,
                copyDone: false,
                searchTimeout: null,

                languageList: [{
                        id: '',
                        name: 'All Languages',
                        icon: '🌐'
                    },
                    {
                        id: 'Laravel',
                        name: 'Laravel',
                        icon: '🟠'
                    },
                    {
                        id: 'React',
                        name: 'React',
                        icon: '⚛️'
                    },
                    {
                        id: 'Tailwind',
                        name: 'Tailwind',
                        icon: '🍃'
                    },
                    {
                        id: 'Javascript',
                        name: 'Javascript',
                        icon: '🟨'
                    },
                    {
                        id: 'Python',
                        name: 'Python',
                        icon: '🐍'
                    },
                    {
                        id: 'PHP',
                        name: 'PHP',
                        icon: '🐘'
                    },
                ],

                // Methods
                fetchSnippets(page = 1) {
                    this.currentPage = page;
                    this.loading = true;
                    const url =
                        `/api/search/my-snippets?q=${encodeURIComponent(this.searchQuery)}&lang=${this.selectedLanguage}&status=${this.statusFilter}&page=${this.currentPage}`;

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            let snippets = data.data || data;

                            if (this.sortBy === 'title') {
                                snippets.sort((a, b) => a.title.localeCompare(b.title));
                            } else if (this.sortBy === 'files') {
                                snippets.sort((a, b) => (b.files?.length || 0) - (a.files?.length || 0));
                            }

                            this.snippets = snippets;
                            this.lastPage = data.last_page || 1;
                            this.total = data.total || 0;
                            this.loading = false;
                        })
                        .catch(err => {
                            console.error("Fetch Error:", err);
                            this.loading = false;
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
                        // Fallback
                        const textarea = document.createElement('textarea');
                        textarea.value = text;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);

                        this.copyDone = true;
                    });
                },

                openDeleteModal(id) {
                    const modal = document.getElementById('deleteModal');
                    const input = document.getElementById('modalSnippetId');
                    if (modal && input) {
                        input.value = id;
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        setTimeout(() => {
                            modal.classList.add('opacity-100');
                            document.getElementById('modalContainer').classList.remove('scale-95');
                            document.getElementById('modalContainer').classList.add('scale-100');
                        }, 50);
                    }
                },

                closeDeleteModal() {
                    const modal = document.getElementById('deleteModal');
                    if (modal) {
                        modal.classList.remove('opacity-100');
                        document.getElementById('modalContainer').classList.remove('scale-100');
                        document.getElementById('modalContainer').classList.add('scale-95');
                        setTimeout(() => {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                        }, 500);
                    }
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
                },

                // Mobile handlers
                handleResize() {
                    if (window.innerWidth > 768) {
                        this.mobileFileListOpen = false;
                        this.mobileMenuOpen = false;
                        this.mobileFiltersOpen = false;
                    }
                },

                toggleMobileFileList() {
                    this.mobileFileListOpen = !this.mobileFileListOpen;
                },

                init() {
                    // Resize listener
                    window.addEventListener('resize', () => this.handleResize());

                    // Click outside handler for mobile file list
                    document.addEventListener('click', (e) => {
                        if (window.innerWidth <= 768 && this.mobileFileListOpen) {
                            if (!e.target.closest('aside') && !e.target.closest('button[class*="md:hidden"]')) {
                                this.mobileFileListOpen = false;
                            }
                        }
                    });

                    // Initial fetch
                    this.fetchSnippets();
                }
            }
        }
    </script>





@endsection
