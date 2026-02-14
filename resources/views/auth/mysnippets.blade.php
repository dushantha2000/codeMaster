@extends('auth.master')

@section('title', 'My Snippets')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4 py-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

        {{-- Global Page Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div class="flex items-center gap-5">
                {{-- Back Button --}}
                <a href="{{ url('/dashboard') }}"
                    class="group p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 text-gray-400 hover:text-white transition-all shadow-xl">
                    <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>

                {{-- Title & Count --}}
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tight">My Vault</h1>
                    <p class="text-gray-400 text-sm font-medium">
                        Managing <span id="totalCount" class="text-blue-400 font-bold">{{ $snippets->total() }}</span> saved
                        snippets
                    </p>
                </div>
            </div>

            {{-- Top Right Actions --}}
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative group">
                    <input type="text" id="searchInput" placeholder="Search snippets..."
                        class="bg-white/5 border border-white/10 text-white text-sm rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all w-full sm:w-64">
                    <svg class="w-4 h-4 text-gray-500 absolute left-3.5 top-1/2 -translate-y-1/2 group-focus-within:text-blue-400 transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <a href="{{ route('snippets-create') }}"
                    class="inline-flex items-center gap-2 btn-primary text-white text-sm px-6 py-3 rounded-xl font-bold transition-all duration-200 shadow-lg shadow-blue-900/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create
                </a>
            </div>
        </div>

        {{-- Main Layout Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            {{-- Left Sidebar: Filtering Card --}}
            <div class="md:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <div
                        class="glass-card bg-white/5 backdrop-blur-xl rounded-3xl p-6 border border-white/10 relative overflow-hidden shadow-2xl">
                        {{-- Top Accent Line --}}


                        {{-- <h3 class="text-white font-black text-lg mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L4.293 7.293A1 1 0 014 6.586V4z" />
                            </svg>
                            Filter Vault
                        </h3> --}}


                        {{-- Filter Group: Language --}}
                        <div class="space-y-4 mb-8">
                            <div class="flex items-center justify-between">
                                <label
                                    class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-black">Language</label>
                                <span class="text-[10px] text-blue-500 font-bold bg-blue-500/10 px-2 py-0.5 rounded-full"
                                    id="activeCount">All</span>
                            </div>

                            <div class="flex flex-wrap gap-2" id="languageFilters">
                                @forelse($languages as $lang)
                                    <label class="relative cursor-pointer group">
                                        <input type="checkbox" name="languages[]" value="{{ strtolower($lang) }}"
                                            class="language-checkbox sr-only peer">

                                        <div
                                            class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-gray-400 text-xs font-bold transition-all
                            peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-500 peer-checked:shadow-[0_0_15px_rgba(37,99,235,0.4)]
                            group-hover:bg-white/10 group-hover:border-white/20">
                                            <span class="capitalize">{{ $lang }}</span>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-xs text-gray-500 italic">No languages detected</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Filter Group: Sorting --}}
                        <div class="space-y-4 mb-8">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-black">Sort By</label>
                            <select id="sortSelect"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-blue-500/50 transition-all appearance-none cursor-pointer">
                                <option value="latest">Recently Added</option>
                                <option value="oldest">Oldest First</option>
                                <option value="az">Alphabetical (A-Z)</option>
                                <option value="za">Alphabetical (Z-A)</option>
                            </select>
                        </div>

                        {{-- Filter Group: Status --}}
                        <div class="space-y-4">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-black">Status</label>
                            <div class="flex items-center gap-2 p-1 bg-black/20 rounded-xl border border-white/5">
                                <button type="button" data-status="all"
                                    class="status-btn flex-1 py-2 text-xs font-bold rounded-lg btn-primary text-white shadow-lg transition-all">All</button>
                                <button type="button" data-status="1"
                                    class="status-btn flex-1 py-2 text-xs font-bold rounded-lg text-gray-500 hover:text-gray-300 transition-colors">Active</button>
                                <button type="button" data-status="0"
                                    class="status-btn flex-1 py-2 text-xs font-bold rounded-lg text-gray-500 hover:text-gray-300 transition-colors">Inactive</button>
                            </div>
                        </div>

                        {{-- Clear Filters --}}
                        <div class="pt-6 mt-6 border-t border-white/5">
                            <button type="button" id="clearFilters"
                                class="w-full py-3 text-xs font-bold text-gray-500 hover:text-red-400 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1 1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Clear All Filters
                            </button>
                        </div>

                        {{-- Active Filters Badge --}}
                        <div id="activeFiltersBadge"
                            class="hidden mt-4 p-3 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-blue-400 font-bold flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span id="filterCount">0</span> filters active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Content: Snippets Vault --}}
            <div class="md:col-span-2 space-y-4">
                {{-- Loading Spinner --}}
                <div id="loadingSpinner" class="hidden flex items-center justify-center py-12">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-12 h-12 rounded-full border-4 border-white/20 border-t-blue-500 animate-spin"></div>
                        <p class="text-gray-400 text-sm font-medium">Loading snippets...</p>
                    </div>
                </div>

                {{-- Snippets Container --}}
                <div id="snippetsContainer">
                    @if ($snippets->count() > 0)
                        <div id="snippetsGrid" class="flex flex-col gap-4">
                            @foreach ($snippets as $snippet)
                                <div class="snippet-card group rounded-2xl   hover:border-white/20 shadow-xl transition-all duration-300"
                                    data-language="{{ strtolower($snippet->language ?? '') }}"
                                    data-status="{{ $snippet->isActive }}" data-title="{{ strtolower($snippet->title) }}"
                                    data-description="{{ strtolower($snippet->description ?? '') }}">
                                    <div class="p-5 flex items-center gap-5">

                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-3 mb-1 flex-wrap">
                                                <a href="{{ url('snippets/' . $snippet->id . '/edit') }}"
                                                    class="text-white font-bold group-hover:text-blue-400 truncate transition-colors">
                                                    {{ $snippet->title }}
                                                </a>
                                                @if ($snippet->language)
                                                    <span
                                                        class="px-2 py-0.5 bg-blue-500/10 text-blue-400 text-[10px] uppercase tracking-widest font-black rounded-md border border-blue-500/20">
                                                        {{ $snippet->language }}
                                                    </span>
                                                @endif
                                                @if ($snippet->isActive == 0)
                                                    <span
                                                        class="px-2 py-0.5 bg-red-500/10 text-red-400 text-[10px] uppercase tracking-widest font-black rounded-md border border-red-500/20">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-gray-500 text-xs line-clamp-1 mb-2">{{ $snippet->description }}
                                            </p>
                                            <div class="flex items-center gap-4 text-gray-400 text-[11px] font-bold">
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-width="2"
                                                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                                        </path>
                                                    </svg>
                                                    {{ $snippet->files->count() }} files
                                                </span>
                                                <span>• {{ $snippet->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ url('snippets/' . $snippet->id . '/edit') }}"
                                                class="p-2.5 bg-white/5 hover:bg-yellow-500/20 hover:text-yellow-400 rounded-xl border border-white/5 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <button
                                                onclick="deleteSnippet({{ $snippet->id }}, '{{ addslashes($snippet->title) }}')"
                                                class="p-2.5 bg-white/5 hover:bg-red-500/20 hover:text-red-400 rounded-xl border border-white/5 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1 1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8" id="paginationContainer">
                            {{ $snippets->links('pagination::tailwind') }}
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div
                            class=" rounded-[3rem] p-5 text-center border-dashed border-white/10 shadow-inner ">
                            <div
                                class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/10 animate-pulse">
                                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold text-white mb-3 tracking-tight">The Vault is Silent</h3>
                            <p class="text-gray-500 mb-10 max-w-sm mx-auto leading-relaxed">No code fragments detected in
                                your collection. Start your legacy by adding your first snippet.</p>
                            <a href="{{ route('snippets-create') }}"
                                class="inline-flex items-center gap-2 btn-primary text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-lg">
                                Create Your First Snippet
                            </a>
                        </div>
                    @endif
                </div>

                {{-- No Results Message --}}
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
                    <button onclick="resetAllFilters()"
                        class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-bold transition-all">
                        Clear Filters
                    </button>
                </div>
            </div>

            {{-- Right Sidebar: User Profile Card --}}
            <div class="md:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <div
                        class="glass-card bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 text-center relative overflow-hidden shadow-2xl">
                        <div class="relative inline-block mb-4">
                            <div
                                class="w-24 h-24 rounded-3xl bg-blue-600/20 border-2 border-blue-500/50 flex items-center justify-center mx-auto shadow-2xl shadow-blue-500/20">
                                <span
                                    class="text-4xl font-bold text-blue-500">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>

                        <h2 class="text-xl font-bold text-white">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-500 text-sm mb-6">{{ Auth::user()->email }}</p>

                        <div class="pt-6 border-t border-white/5">
                            <div class="flex justify-between text-xs mb-4">
                                <span class="text-gray-500 uppercase tracking-widest font-bold">Total Snippets</span>
                                <span class="text-gray-300" id="sidebarCount">{{ $snippets->total() }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500 uppercase tracking-widest font-bold">Member Since</span>
                                <span class="text-gray-300">{{ Auth::user()->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 transition-all duration-300 opacity-0">
        <div class="glass-card bg-zinc-900 rounded-[2.5rem] p-10 max-w-sm w-full border border-white/10 shadow-2xl transform transition-all scale-90"
            id="modalContainer">
            <div
                class="w-20 h-20 bg-red-500/10 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-red-500/20">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-white text-center mb-3 tracking-tight">Erase Snippet?</h3>
            <p class="text-gray-400 text-center text-sm mb-10 leading-relaxed" id="deleteMessage">This operation will
                permanently delete the code from your vault.</p>
            <div class="flex flex-col gap-3">
                <form id="deleteForm" action="{{ url('snippet-delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="snippet_id" id="modalSnippetId" value="">
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-500 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-red-900/40 mb-3">Yes,
                        Delete Permanently</button>
                    <button type="button" onclick="closeDeleteModal()"
                        class="w-full py-4 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white rounded-2xl font-bold transition-colors">Keep
                        Snippet</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Global state
        let filterState = {
            search: '',
            languages: [],
            sort: 'latest',
            status: 'all'
        };

        // Delete Modal Functions
        function deleteSnippet(id, title) {
            document.getElementById('modalSnippetId').value = id;
            document.getElementById('deleteMessage').innerHTML =
                `Are you sure you want to delete "<strong>${title}</strong>"? This action cannot be undone.`;

            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                document.getElementById('modalContainer').classList.remove('scale-90');
            }, 10);
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('opacity-0');
            document.getElementById('modalContainer').classList.add('scale-90');
            setTimeout(() => {
                document.getElementById('deleteModal').classList.add('hidden');
                document.getElementById('deleteModal').classList.remove('flex');
            }, 300);
        }

        // Filter Functions
        function applyFilters() {
            const snippets = document.querySelectorAll('.snippet-card');
            const searchTerm = filterState.search.toLowerCase();
            const selectedLanguages = filterState.languages;
            const selectedStatus = filterState.status;

            let visibleCount = 0;

            snippets.forEach(snippet => {
                const title = snippet.getAttribute('data-title') || '';
                const description = snippet.getAttribute('data-description') || '';
                const language = snippet.getAttribute('data-language') || '';
                const status = snippet.getAttribute('data-status') || '1';

                // Search filter
                const matchesSearch = searchTerm === '' ||
                    title.includes(searchTerm) ||
                    description.includes(searchTerm);

                // Language filter
                const matchesLanguage = selectedLanguages.length === 0 ||
                    selectedLanguages.includes(language);

                // Status filter
                const matchesStatus = selectedStatus === 'all' ||
                    status === selectedStatus;

                if (matchesSearch && matchesLanguage && matchesStatus) {
                    snippet.style.display = 'block';
                    visibleCount++;
                } else {
                    snippet.style.display = 'none';
                }
            });

            // Apply sorting
            applySorting();

            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            const snippetsGrid = document.getElementById('snippetsGrid');

            if (visibleCount === 0) {
                if (snippetsGrid) snippetsGrid.style.display = 'none';
                noResults.classList.remove('hidden');
            } else {
                if (snippetsGrid) snippetsGrid.style.display = 'flex';
                noResults.classList.add('hidden');
            }

            // Update filter count
            updateFilterCount();

            // Update counts
            document.getElementById('totalCount').textContent = visibleCount;
            document.getElementById('sidebarCount').textContent = visibleCount;
        }

        function applySorting() {
            const grid = document.getElementById('snippetsGrid');
            if (!grid) return;

            const snippets = Array.from(grid.querySelectorAll('.snippet-card'));
            const visibleSnippets = snippets.filter(s => s.style.display !== 'none');

            visibleSnippets.sort((a, b) => {
                const titleA = a.getAttribute('data-title') || '';
                const titleB = b.getAttribute('data-title') || '';

                switch (filterState.sort) {
                    case 'az':
                        return titleA.localeCompare(titleB);
                    case 'za':
                        return titleB.localeCompare(titleA);
                    case 'oldest':
                    case 'latest':
                        // Keep original order from server
                        return 0;
                    default:
                        return 0;
                }
            });

            // Reorder in DOM
            visibleSnippets.forEach(snippet => {
                grid.appendChild(snippet);
            });
        }

        function updateFilterCount() {
            const count = filterState.languages.length +
                (filterState.search ? 1 : 0) +
                (filterState.status !== 'all' ? 1 : 0);

            const badge = document.getElementById('activeFiltersBadge');
            const countElement = document.getElementById('filterCount');

            if (count > 0) {
                badge.classList.remove('hidden');
                countElement.textContent = count;
            } else {
                badge.classList.add('hidden');
            }
        }

        function resetAllFilters() {
            // Clear search
            document.getElementById('searchInput').value = '';
            filterState.search = '';

            // Clear language checkboxes
            document.querySelectorAll('.language-checkbox').forEach(cb => cb.checked = false);
            filterState.languages = [];

            // Reset sort
            document.getElementById('sortSelect').value = 'latest';
            filterState.sort = 'latest';

            // Reset status
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                btn.classList.add('text-gray-500');
            });
            document.querySelector('[data-status="all"]').classList.add('bg-blue-600', 'text-white', 'shadow-lg');
            document.querySelector('[data-status="all"]').classList.remove('text-gray-500');
            filterState.status = 'all';

            applyFilters();
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', () => {
            // Search input with debounce
            let searchTimeout;
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        filterState.search = e.target.value;
                        applyFilters();
                    }, 300);
                });
            }

            // Language checkboxes
            document.querySelectorAll('.language-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', (e) => {
                    const value = e.target.value;
                    if (e.target.checked) {
                        filterState.languages.push(value);
                    } else {
                        filterState.languages = filterState.languages.filter(lang => lang !==
                        value);
                    }
                    applyFilters();
                });
            });

            // Sort select
            const sortSelect = document.getElementById('sortSelect');
            if (sortSelect) {
                sortSelect.addEventListener('change', (e) => {
                    filterState.sort = e.target.value;
                    applyFilters();
                });
            }

            // Status buttons
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const status = e.target.getAttribute('data-status');
                    filterState.status = status;

                    // Update button styles
                    document.querySelectorAll('.status-btn').forEach(b => {
                        b.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                        b.classList.add('text-gray-500');
                    });
                    e.target.classList.add('bg-blue-600', 'text-white', 'shadow-lg');
                    e.target.classList.remove('text-gray-500');

                    applyFilters();
                });
            });

            // Clear filters button
            const clearFiltersBtn = document.getElementById('clearFilters');
            if (clearFiltersBtn) {
                clearFiltersBtn.addEventListener('click', resetAllFilters);
            }
        });
    </script>
@endsection
