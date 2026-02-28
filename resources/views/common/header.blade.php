<!-- Header -->
<header
    class="h-20 flex items-center justify-between px-4 md:px-8 shrink-0 glass-card border-b border-white/5 sticky top-0 z-30">
    <!-- Left side -->
    <div class="flex items-center gap-2 md:gap-2">
        <!-- Mobile menu button (fixed) -->
        <button @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden p-2 rounded-lg bg-white/5 border border-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>

        <!-- Logo -->
        <div class="w-8 h-8 bg-black-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile">
            <a href="{{ url('/') }}">CodeVault</a> <span class="text-blue-500 text-xs font-normal">v1.1</span>
        </h1>
    </div>

    <!-- Search (hidden on mobile) - Only shown on pages that yield it -->
    @hasSection('show-search')
        <div class="hidden md:block relative flex-1 max-w-md mx-4">
            <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchSnippets()" placeholder="Search..."
                class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 outline-none focus:border-white/30 transition-all">
        </div>
    @endif

    <!-- Right side -->
    <div class="flex items-center gap-2 md:gap-4">
        <!-- Language filter (desktop) - Only shown when search is shown -->
        @hasSection('show-search')
            <div class="relative hide-on-mobile" x-data="{ open: false }">
                <button @click="open = !open"
                    class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm flex items-center justify-between min-w-[160px] hover:bg-white/10 transition-all">
                    <span x-text="selectedLanguageName"></span>
                    <svg class="w-4 h-4 ml-2 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open" @click.outside="open = false"
                    class="absolute top-full right-0 mt-2 w-48 max-h-60 overflow-y-auto glass-card rounded-xl border border-white/10 shadow-2xl z-50 py-2">
                    <template x-for="lang in languageList">
                        <button
                            @click="selectedLanguage = lang.id; selectedLanguageName = lang.icon + ' ' + lang.name; open = false; fetchSnippets();"
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-colors">
                            <span x-text="lang.icon + ' ' + lang.name"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Mobile search button (simplified) -->
            <button @click="mobileFiltersOpen = !mobileFiltersOpen"
                class="md:hidden p-2 rounded-lg bg-white/5 border border-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        @else
            <!-- Empty div to maintain spacing when search is hidden -->
            <div class="hidden md:block flex-1 max-w-md mx-4"></div>
        @endif

        <!-- New button -->
        <a href="{{ url('snippets-create') }}"
            class="btn-primary px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span class="hide-on-mobile">New</span>
        </a>

        <!-- User menu -->
        <div class="relative ml-2" x-data="{ userMenuOpen: false }">
            <button @click="userMenuOpen = !userMenuOpen"
                class="flex items-center gap-2 p-1 pr-3 rounded-full bg-white/5 border border-white/10 hover:bg-white/10 transition-all">
                <div
                    class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-blue-900/20">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span class="text-sm text-gray-300 font-medium hide-on-mobile">{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 text-gray-500 transition-transform" :class="userMenuOpen ? 'rotate-180' : ''"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- User dropdown -->
            <div x-show="userMenuOpen" @click.outside="userMenuOpen = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                class="absolute top-full right-0 mt-2 w-48 glass-card rounded-xl border border-white/10 shadow-2xl z-50 py-2">
                <!-- Dropdown content -->
                <div class="px-4 py-2 border-b border-white/5 mb-1">
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Signed in as</p>
                    <p class="text-sm text-white truncate">{{ Auth::user()->name }}</p>
                </div>
                <a href="{{ url('/profile') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3.5" />
                    </svg>
                    My Partnerships
                </a>
                <a href="{{ url('/my-snippets') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                    </svg>
                    My Snippets
                </a>
                <a href="{{ url('/settings') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z">
                        </path>
                    </svg>
                    Settings
                </a>
                <hr class="border-white/5 my-1">
                <form action="{{ url('/logout') }}" method="POST">
                    {{ csrf_field() }}
                    <button type="submit"
                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-400 hover:bg-red-500/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>