<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Dashboard | CodeVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />

    <style>
        /* Base Styles */
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #0a0a0a;
        }

        .code-font {
            font-family: 'Fira Code', monospace;
        }

        [x-cloak] {
            display: none !important;
        }

        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .btn-primary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        /* Prism background styling */
        pre[class*="language-"] {
            background: rgba(0, 0, 0, 0.3) !important;
            border-radius: 1rem !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            white-space: pre-wrap !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            max-width: 100% !important;
        }

        code[class*="language-"] {
            white-space: pre-wrap !important;
            word-break: break-word !important;
            font-family: 'Fira Code', monospace !important;
            font-size: 13px !important;
            line-height: 1.6 !important;
        }

        /* Dropdown styling */
        select option {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        select:focus {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .custom-mini-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-mini-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        /* Desktop file sidebar always visible */
        @media (min-width: 768px) {
            aside.md\:block {
                display: block !important;
                position: relative !important;
                transform: none !important;
                opacity: 1 !important;
                visibility: visible !important;
            }
        }

        /* Mobile Specific Styles */
        @media (max-width: 768px) {
            .hide-on-mobile {
                display: none !important;
            }

            /* Smooth scrolling */
            .overflow-auto {
                -webkit-overflow-scrolling: touch;
            }

            /* Better touch targets */
            button,
            a,
            .clickable {
                min-height: 44px;
                min-width: 44px;
            }

            /* Modal adjustments */
            .glass-card {
                border-radius: 0;
            }

            /* File sidebar */
            aside {
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            }

            /* Code area */
            pre {
                font-size: 11px;
                line-height: 1.5;
            }

            code[class*="language-"] {
                font-size: 11px !important;
            }

            /* Custom scrollbar for mobile */
            .custom-mini-scrollbar::-webkit-scrollbar {
                width: 3px;
            }

            /* Header fixes */
            .header-title {
                font-size: 1rem;
            }

            /* Card fixes */
            .snippet-card {
                margin-bottom: 0.75rem;
            }

            .snippet-card .p-5 {
                padding: 1rem;
            }

            /* Max width truncate */
            .max-w-[150px] {
                max-width: 150px;
            }
        }

        /* Small phones */
        @media (max-width: 380px) {
            .max-w-[150px] {
                max-width: 120px;
            }

            pre,
            code[class*="language-"] {
                font-size: 10px !important;
            }
        }

        /* File icon colors */
        .file-icon-js {
            color: #f7df1e;
        }

        .file-icon-jsx {
            color: #61dafb;
        }

        .file-icon-php {
            color: #8892bf;
        }

        .file-icon-html {
            color: #e34c26;
        }

        .file-icon-css {
            color: #264de4;
        }

        .file-icon-json {
            color: #f7df1e;
        }
    </style>
</head>

<body class="text-gray-100 h-full flex flex-col" x-data="snippetBrowser()" x-cloak>

    @include('common.notification')

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 md:hidden"
        @click="mobileMenuOpen = false"></div>

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

        <!-- Search (hidden on mobile) -->
        <div class="hidden md:block relative flex-1 max-w-md mx-4">
            <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchSnippets()" placeholder="Search..."
                class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 outline-none focus:border-white/30 transition-all">
        </div>

        <!-- Right side -->
        <div class="flex items-center gap-2 md:gap-4">
            <!-- Language filter (desktop) -->
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
                    <!-- Dropdown content (same as before) -->
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

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-4 md:p-8">
        <div class="max-w-7xl mx-auto flex gap-6">
            <!-- Mobile Filter Button -->
            <button @click="mobileFiltersOpen = !mobileFiltersOpen"
                class="lg:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-blue-600 hover:bg-blue-700 rounded-full shadow-lg shadow-blue-900/50 flex items-center justify-center transition-all">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
            </button>

            <!-- Mobile Filter Overlay -->
            <div x-show="mobileFiltersOpen" @click="mobileFiltersOpen = false"
                class="lg:hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50"
                x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
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
        </div>
    </main>

    <!-- Preview Modal with Mobile Support -->
    <div x-show="showPreview" class="fixed inset-0 z-50 overflow-hidden flex items-center justify-end p-0 md:p-4"
        x-cloak>
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity" x-show="showPreview"
            x-transition:enter="duration-500" x-transition:leave="duration-300" @click="showPreview = false"></div>

        <!-- Modal -->
        <div class="relative w-full md:max-w-5xl h-full md:h-[90vh] glass-card md:rounded-[2rem] shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-white/10 flex flex-col overflow-hidden"
            x-show="showPreview" x-transition:enter="transform transition duration-500 ease-out"
            x-transition:enter-start="translate-x-full opacity-0 scale-95"
            x-transition:enter-end="translate-x-0 opacity-100 scale-100"
            x-transition:leave="transform transition duration-300 ease-in"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0">

            <!-- Header -->
            <div
                class="h-16 md:h-20 flex items-center justify-between px-4 md:px-8 bg-white/[0.02] border-b border-white/5">
                <div class="flex items-center gap-2 md:gap-4">
                    <!-- Mobile File Toggle Button -->
                    <button @click="mobileFileListOpen = !mobileFileListOpen"
                        class="md:hidden p-2 bg-white/5 rounded-lg border border-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="p-2 md:p-3 bg-blue-500/10 rounded-xl md:rounded-2xl border border-blue-500/20">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base md:text-xl font-bold text-white tracking-tight max-w-[150px] md:max-w-none truncate"
                            x-text="selectedSnippet?.title"></h2>
                        <p class="text-[8px] md:text-[10px] text-gray-500 font-mono uppercase tracking-widest"
                            x-text="selectedSnippet?.language + ' - ' + selectedSnippet?.files?.length + ' files'"></p>
                    </div>
                </div>
                <button @click="showPreview = false"
                    class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center bg-white/5 text-gray-400 hover:text-white hover:bg-red-500/20 transition-all border border-white/10">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>


            <!-- Content -->
            <div class="flex-1 flex overflow-hidden relative">
                <!-- File List Sidebar - Always visible on desktop -->
                <aside
                    :class="mobileFileListOpen ? 'absolute left-0 top-0 bottom-0 w-64 bg-black/95 z-10' :
                        'hidden md:block md:relative md:w-64 md:bg-black/40'"
                    class="border-r border-white/5 p-4 md:p-6 overflow-y-auto custom-mini-scrollbar">

                    <!-- Mobile Header -->
                    <div x-show="mobileFileListOpen" class="flex items-center justify-between mb-4 md:hidden">
                        <div class="text-[10px] font-bold text-gray-600 uppercase tracking-tighter">PROJECT FILES</div>
                        <button @click="mobileFileListOpen = false" class="p-1 bg-white/5 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Desktop Header -->
                    <div class="hidden md:flex items-center justify-between mb-4">
                        <div class="text-[10px] font-bold text-gray-600 uppercase tracking-tighter">PROJECT FILES</div>
                        <span class="text-xs px-2 py-1 rounded-full bg-white/10 text-gray-300"
                            x-text="selectedSnippet?.files?.length + ' files'"></span>
                    </div>

                    <!-- Files List (same for mobile & desktop) -->
                    <nav class="space-y-1.5">
                        <template x-for="(file, index) in selectedSnippet?.files" :key="index">
                            <button
                                @click="activeFileTab = index; mobileFileListOpen = false; $nextTick(() => { Prism.highlightAll(); })"
                                :class="activeFileTab === index ?
                                    'bg-blue-600/10 text-blue-400 border-blue-500/50 shadow-[0_0_15px_rgba(59,130,246,0.1)]' :
                                    'text-gray-500 border-transparent hover:text-gray-300 hover:bg-white/5'"
                                class="w-full text-left px-3 md:px-4 py-2.5 md:py-3 rounded-lg md:rounded-xl text-xs md:text-[11px] font-mono border transition-all flex items-center justify-between group">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="text-sm md:text-base" x-text="getFileIcon(file.file_name)"></span>
                                    <span class="truncate" x-text="file.file_name"></span>
                                </div>
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-500 opacity-0 group-hover:opacity-100"
                                    x-show="activeFileTab === index"></div>
                            </button>
                        </template>
                    </nav>

                    <!-- File count for mobile -->
                    <div class="mt-4 pt-4 border-t border-white/5 md:hidden" x-show="mobileFileListOpen">
                        <span class="text-xs text-gray-400">
                            Total: <span class="text-white font-bold" x-text="selectedSnippet?.files?.length"></span>
                            files
                        </span>
                    </div>
                </aside>

                <!-- Code Display (unchanged) -->
                <!-- Code Display -->
                <div class="flex-1 flex flex-col bg-[#050505]/60">
                    <template x-for="(file, index) in selectedSnippet?.files" :key="index">
                        <div x-show="activeFileTab === index" class="h-full flex flex-col p-3 md:p-6"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0">

                            <!-- File Info Bar -->
                            <div
                                class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-3 md:mb-4 bg-white/5 px-3 md:px-4 py-2 rounded-lg border border-white/5">
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="text-gray-400">📄</span>
                                    <span
                                        class="text-white font-mono text-xs md:text-sm truncate max-w-[150px] md:max-w-none"
                                        x-text="file.file_name"></span>
                                </div>
                                <div class="flex items-center gap-3 text-[10px] md:text-xs">
                                    <span class="text-gray-400">
                                        <span class="md:hidden">📊</span>
                                        <span class="hidden md:inline">Size:</span>
                                        <span class="text-white ml-1"
                                            x-text="(file.content?.length || 0) + ' chars'"></span>
                                    </span>
                                    <span class="text-gray-600">|</span>
                                    <span class="text-gray-400">
                                        <span class="md:hidden">📏</span>
                                        <span class="hidden md:inline">Lines:</span>
                                        <span class="text-white ml-1"
                                            x-text="(file.content?.split('\n').length || 0)"></span>
                                    </span>
                                </div>
                            </div>

                            <!-- Code Container -->
                            <div
                                class="flex-1 bg-black/40 rounded-xl border border-white/5 overflow-hidden relative group">
                                <!-- Copy Button -->
                                <button @click="copyCode(file.content)"
                                    class="absolute right-2 md:right-4 top-2 md:top-4 z-10 px-2 md:px-3 py-1 md:py-1.5 rounded-lg border border-white/10 bg-white/5 hover:bg-white/10 transition-all flex items-center gap-1 md:gap-2 text-[10px] md:text-xs">
                                    <span x-show="!copyDone">📋</span>
                                    <span x-show="!copyDone" class="hidden md:inline">Copy</span>
                                    <span x-show="copyDone">✅</span>
                                    <span x-show="copyDone" class="hidden md:inline">Copied!</span>
                                </button>

                                <!-- Code with proper wrapping -->
                                <pre class="h-full overflow-auto p-3 md:p-6 !m-0 !bg-transparent custom-scrollbar text-[11px] md:text-sm"><code :class="'language-' + (selectedSnippet?.language?.toLowerCase() || 'javascript')" 
                      class="!whitespace-pre-wrap !break-words !font-mono leading-relaxed"
                      x-text="file.content"></code></pre>
                            </div>
                        </div>
                    </template>

                    <!-- Empty State -->
                    <div x-show="!selectedSnippet?.files?.length" class="flex-1 flex items-center justify-center p-6">
                        <div class="text-center">
                            <div class="text-4xl mb-3">📁</div>
                            <p class="text-gray-400 text-sm">No files available</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full mt-5 border-t border-white/10 bg-white/[0.02] backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-6 py-5">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-black-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile">CodeVault <span
                            class="text-blue-500 text-xs font-normal">v1.1</span></h1>
                </div>
                <div class="flex items-center gap-6 text-gray-500 text-xs font-bold tracking-widest uppercase">
                    <span>&copy; 2026 CodeVault Inc.</span>
                    <div class="flex gap-2 items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-[10px]">Secure Online</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js Script (Fixed) -->
    <script>
        function snippetBrowser() {
            return {
                // Data properties
                snippets: [],
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
                fetchSnippets() {
                    this.loading = true;
                    const url =
                        `/api/search?q=${encodeURIComponent(this.searchQuery)}&lang=${this.selectedLanguage}&status=${this.statusFilter}`;

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

    <!-- Prism.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-jsx.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
</body>

</html>
