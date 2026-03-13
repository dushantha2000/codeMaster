@extends('layout.app')

@section('title', 'My Snippets')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4  animate-in fade-in slide-in-from-bottom-4 duration-500">

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
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">Profile</a>
                </li>
                <li>
                    <span class="text-gray-400">/</span>
                </li>
                <li>
                    <span class="text-blue-400 font-medium"> Vault & Code Library</span>
                </li>
            </ol>
        </nav>

        {{-- Global Page Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between  mb-10">
            <div class=" items-center gap-5">

                {{-- Title & Count --}}
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tight"> Vault & Code Library</h1>
                    <p class="text-gray-400 text-sm font-medium">
                        Managing <span id="totalCount" class="text-blue-400 font-bold">{{ $snippets->total() }}</span> saved
                        snippets
                    </p>
                </div>
            </div>
        </div>


        {{-- Hidden Languages Dropdown (shown when clicking "More") --}}
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
                <div class="sticky top-8 space-y-6">
                    <div
                        class="glass-card  backdrop-blur-xl rounded-3xl p-8 border  text-center relative overflow-hidden shadow-2xl">

                        {{-- Decorative Background Glow --}}
                        <div class="absolute -top-24 -left-24 w-48 h-48 bg-blue-500/10 blur-3xl rounded-full"></div>

                        {{-- Profile Image Section --}}
                        <div class="relative inline-block mb-4">
                            <div
                                class="w-24 h-24 rounded-3xl bg-blue-600/20 border-2 border-blue-500/50 flex items-center justify-center mx-auto shadow-2xl shadow-blue-500/20 overflow-hidden">
                                @if (Auth::user()->profile_image)
                                    <img class="w-full h-full object-cover"
                                        src="{{ asset('profileImages/' . Auth::user()->profile_image) }}"
                                        alt="{{ Auth::user()->name }}">
                                @else
                                    <span
                                        class="text-4xl font-bold text-blue-500">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            {{-- Level Badge --}}
                            <div
                                class="absolute -bottom-2 -right-2 bg-blue-600 text-white text-[10px] font-black px-2 py-1 rounded-lg border-2 border-[#0f172a] shadow-xl">
                                lVl 1
                            </div>
                        </div>

                        {{-- Name & Email --}}
                        <h2 class="text-xl font-bold text-white tracking-tight">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-500 text-sm mb-3">{{ Auth::user()->email }}</p>



                        {{-- Profile Bio --}}
                        <div class="mb-6">
                            @if (Auth::user()->bio)
                                <p class="text-gray-400 text-xs leading-relaxed px-2 italic">
                                    "{{ Auth::user()->bio }}"
                                </p>
                            @else
                                <p class="text-gray-600 text-xs italic">No bio added yet.</p>
                            @endif
                        </div>


                        {{-- Stats Section --}}
                        <div class="pt-6 border-t border-white/5 space-y-4">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500 uppercase tracking-widest font-bold text-[10px]">Total
                                    Snippets</span>
                                <span class="text-blue-400 font-bold" id="sidebarCount">{{ $snippets->total() }}</span>
                            </div>



                        </div>

                        {{-- Action Button --}}
                        <div class="mt-8">
                            <a href="#"
                                class="inline-flex items-center gap-2 btn-primary text-white text-sm px-6 py-2 rounded-xl font-bold transition-all duration-200 shadow-lg shadow-blue-900/20">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Right Content: Snippets Vault --}}
            <div class="md:col-span-3 space-y-4">

                {{-- Filters Bar --}}
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">

                    {{-- Search Input & Filters Group --}}
                    <div class="flex flex-col md:flex-row flex-1 items-center gap-2">

                        {{-- Search Input --}}
                        <div class="relative group w-full md:w-80">
                            <input type="text" id="searchInput" placeholder="Find a snippet..."
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
                            <select id="languageFilter" onchange="setLanguageFilter(this.value)"
                                class="bg-[#21262d] border border-[#30363d] rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-300 hover:bg-[#30363d] hover:border-[#8b949e] focus:outline-none cursor-pointer transition-all">
                                <option value="all">Language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language }}">{{ $language }}</option>
                                @endforeach
                            </select>

                            {{-- Status/Type Filter --}}
                            <select id="statusFilter" onchange="setStatusFilter(this.value)"
                                class="bg-[#21262d] border border-[#30363d] rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-300 hover:bg-[#30363d] hover:border-[#8b949e] focus:outline-none cursor-pointer transition-all">
                                <option value="all">Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                            {{-- Sort Filter --}}
                            <select id="sortFilter" onchange="setSortFilter(this.value)"
                                class="bg-[#21262d] border border-[#30363d] rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-300 hover:bg-[#30363d] hover:border-[#8b949e] focus:outline-none cursor-pointer transition-all">
                                <option value="latest">Sort</option>
                                <option value="oldest">Oldest</option>
                                <option value="az">A-Z</option>
                                <option value="za">Z-A</option>
                            </select>
                        </div>
                    </div>

                    {{-- New Snippet Button --}}
                    <div class="w-full lg:w-auto">
                        <a href="#"
                            class="flex items-center justify-center gap-2 btn-primary text-white text-sm px-3 py-2 rounded-xl font-bold transition-all duration-200 shadow-lg shadow-blue-900/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            New
                        </a>
                    </div>
                </div>



                {{-- Loading Spinner --}}
                <div id="loadingSpinner" class="hidden flex items-center justify-center py-12">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-12 h-12 rounded-full border-4 border-white/20 border-t-blue-500 animate-spin"></div>
                        <p class="text-gray-400 text-sm font-medium">Loading snippets...</p>
                    </div>
                </div>



                {{-- Snippets Container --}}
                @foreach ($snippets as $snippet)
                    <div class="snippet-card group border-b border-white/10 p-5 hover:bg-white/[0.02] transition-all"
                        data-language="{{ strtolower($snippet->language ?? '') }}"
                        data-status="{{ $snippet->isActive }}" data-title="{{ strtolower($snippet->title) }}">

                        {{-- Main Flex Wrapper: Column on mobile, Row on desktop --}}
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">

                            {{-- Left Side: Title, Description, Meta --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <a href="{{ url('snippets/' . $snippet->id . '/edit') }}"
                                        class="text-blue-400 text-lg md:text-xl font-semibold hover:underline decoration-2 truncate max-w-[200px] md:max-w-none">
                                        {{ strtolower($snippet->title) }}
                                    </a>
                                    <span
                                        class="px-2 py-0.5 bg-transparent text-gray-500 text-[10px] uppercase tracking-wider rounded-md border border-gray-800 font-bold">
                                        Public
                                    </span>
                                </div>

                                <p
                                    class="text-gray-400 text-sm leading-snug whitespace-pre-line mb-4 line-clamp-2 md:line-clamp-none">
                                    {{ $snippet->description }}
                                </p>

                                {{-- Meta Info: Wraps naturally on small screens --}}
                                <div
                                    class="flex flex-wrap items-center gap-x-4 gap-y-2 text-gray-500 text-[11px] md:text-xs">
                                    @if ($snippet->language)
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                                            {{ $snippet->language }}
                                        </span>
                                    @endif

                                    <span>Updated {{ $snippet->created_at->diffForHumans() }}</span>

                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-width="2"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                            </path>
                                        </svg>
                                        {{ $snippet->files->count() }} files
                                    </span>
                                </div>
                            </div>

                            {{-- Right Side: Action Buttons --}}
                            <div class="flex items-center gap-2 mt-2 md:mt-0 self-end md:self-start">

                                {{-- Edit Button --}}
                                <a href="{{ url('snippets/' . $snippet->id . '/edit') }}"
                                    class="p-2.5 md:p-2 bg-white/5 hover:bg-yellow-500/20 hover:text-yellow-400 border border-white/10 rounded-lg transition-all"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>

                                {{-- Delete Button --}}
                                <button onclick="deleteSnippet({{ $snippet->id }}, '{{ addslashes($snippet->title) }}')"
                                    class="p-2.5 md:p-2 bg-white/5 hover:bg-red-500/20 hover:text-red-400 border border-white/10 rounded-lg transition-all"
                                    title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>

                                {{-- Star / Marked Toggle --}}
                                <form action="{{ url('/snippet-marked') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="snippet_id" value="{{ $snippet->id }}">

                                    <button type="submit"
                                        class="flex items-center gap-1.5 px-4 md:px-3 py-2 md:py-1.5 border transition-all rounded-lg text-xs font-bold
            {{ $snippet->isMark == 1
                ? 'bg-yellow-500/20 border-yellow-500/50 text-yellow-400'
                : 'bg-white/5 border-white/10 text-gray-300 hover:bg-white/10' }}">

                                        <svg class="w-3.5 h-3.5 {{ $snippet->isMark == 1 ? 'fill-yellow-400' : 'fill-none' }}"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                            </path>
                                        </svg>

                                        <span>{{ $snippet->isMark == 1 ? 'Starred' : 'Star' }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

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

            {{-- User Profile Card --}}

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

            // Reset language filter bar buttons
            document.querySelectorAll('.lang-filter-btn').forEach(btn => {
                btn.classList.remove('bg-blue-500/20', 'text-blue-400', 'border-blue-500/30');
                btn.classList.add('bg-white/5', 'text-gray-400', 'border-white/10');
            });
            document.querySelector('[onclick="setLanguageFilter(\'all\')"]').classList.add('bg-blue-500/20',
                'text-blue-400', 'border-blue-500/30');

            // Reset sort
            document.getElementById('sortSelect').value = 'latest';
            document.getElementById('sortFilter').value = 'latest';
            filterState.sort = 'latest';

            // Reset status
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                btn.classList.add('text-gray-500');
            });
            document.querySelector('[data-status="all"]').classList.add('bg-blue-600', 'text-white', 'shadow-lg');
            document.querySelector('[data-status="all"]').classList.remove('text-gray-500');
            document.getElementById('statusFilter').value = 'all';
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

        // Sync filter bar with sidebar
        function setLanguageFilter(language) {
            // Update button styles
            document.querySelectorAll('.lang-filter-btn').forEach(btn => {
                btn.classList.remove('bg-blue-500/20', 'text-blue-400', 'border-blue-500/30');
                btn.classList.add('bg-white/5', 'text-gray-400', 'border-white/10');
            });

            const activeBtn = event.currentTarget;
            activeBtn.classList.remove('bg-white/5', 'text-gray-400', 'border-white/10');
            activeBtn.classList.add('bg-blue-500/20', 'text-blue-400', 'border-blue-500/30');

            // Update sidebar checkboxes
            if (language === 'all') {
                document.querySelectorAll('.language-checkbox').forEach(cb => cb.checked = false);
                filterState.languages = [];
            } else {
                document.querySelectorAll('.language-checkbox').forEach(cb => {
                    if (cb.value === language) {
                        cb.checked = true;
                    } else {
                        cb.checked = false;
                    }
                });
                filterState.languages = [language];
            }

            applyFilters();
        }

        function setStatusFilter(status) {
            // Update the status buttons in sidebar
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                btn.classList.add('text-gray-500');

                if (btn.getAttribute('data-status') === status) {
                    btn.classList.add('bg-blue-600', 'text-white', 'shadow-lg');
                    btn.classList.remove('text-gray-500');
                }
            });

            filterState.status = status;
            applyFilters();
        }

        function setSortFilter(sortValue) {
            document.getElementById('sortSelect').value = sortValue;
            filterState.sort = sortValue;
            applyFilters();
        }

        // Sync sidebar changes to filter bar
        function syncFilterBarFromSidebar() {
            // Update language filter buttons
            const activeLanguages = filterState.languages;

            document.querySelectorAll('.lang-filter-btn').forEach(btn => {
                btn.classList.remove('bg-blue-500/20', 'text-blue-400', 'border-blue-500/30');
                btn.classList.add('bg-white/5', 'text-gray-400', 'border-white/10');
            });

            if (activeLanguages.length === 0) {
                document.querySelector('[onclick="setLanguageFilter(\'all\')"]')?.classList.add('bg-blue-500/20',
                    'text-blue-400', 'border-blue-500/30');
            } else if (activeLanguages.length === 1) {
                const langBtn = document.querySelector(`[onclick="setLanguageFilter('${activeLanguages[0]}')"]`);
                if (langBtn) {
                    langBtn.classList.add('bg-blue-500/20', 'text-blue-400', 'border-blue-500/30');
                }
            }

            // Update status filter
            document.getElementById('statusFilter').value = filterState.status;

            // Update sort filter
            document.getElementById('sortFilter').value = filterState.sort;
        }

        // Override the original applyFilters to sync the bar
        const originalApplyFilters = applyFilters;
        applyFilters = function() {
            originalApplyFilters();
            syncFilterBarFromSidebar();
        };
    </script>
@endsection
