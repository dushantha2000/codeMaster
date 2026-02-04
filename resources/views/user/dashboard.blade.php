<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | CodeVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
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

        /* Mobile fixes */
        @media (max-width: 768px) {
            .hide-on-mobile {
                display: none !important;
            }
        }

        /* Style the dropdown list itself */
        select option {
            background-color: #1a1a1a;
            /* Dark background */
            color: #ffffff;
            /* White text */
        }

        /* Remove the default highlight color on some browsers */
        select:focus {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="text-gray-100 h-full flex flex-col" x-data="snippetBrowser()" x-cloak x-init="fetchSnippets()">

    <div x-show="mobileMenuOpen" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 md:hidden"
        @click="mobileMenuOpen = false"></div>

    <header
        class="h-20 flex items-center justify-between px-4 md:px-8 shrink-0 glass-card border-b border-white/5 sticky top-0 z-30">
        <div class="flex items-center gap-3 md:gap-6">
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden p-2 rounded-lg bg-white/5 border border-white/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
            <div class="bg-white/10 p-2 md:p-3 rounded-xl border border-white/10">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile">CodeVault <span
                    class="text-blue-500 text-xs font-normal">v1.0</span></h1>
        </div>

        <div class="relative flex-1 max-w-md mx-4">
            <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchSnippets()" placeholder="Search..."
                class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 outline-none focus:border-white/30 transition-all">
        </div>

        <div class="flex items-center gap-2 md:gap-4">
            <div class="relative hide-on-mobile" x-data="{ open: false, selected: 'All Languages' }">
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
            <a href="{{ url('snippets-create') }}"
                class="btn-primary px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="hide-on-mobile">New</span>
            </a>

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

                <div x-show="userMenuOpen" @click.outside="userMenuOpen = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    class="absolute top-full right-0 mt-2 w-48 glass-card rounded-xl border border-white/10 shadow-2xl z-50 py-2">

                    <div class="px-4 py-2 border-b border-white/5 mb-1">
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Signed in as</p>
                        <p class="text-sm text-white truncate">{{ Auth::user()->name }}</p>
                    </div>

                    <a href="{{ url('/profile') }}"
                        class="load-btn flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        My Profile
                    </a>

                    <a href="{{ url('/my-snippets') }}"
                        class="load-btn flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        My Snippets
                    </a>

                    <a href="{{ url('/settings') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z">
                            </path>
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>

                    <hr class="border-white/5 my-1">

                    <form action="{{ url('/logout') }}" method="POST">
                        {{ csrf_field() }}

                        <button type="submit"
                            class=" w-full flex items-center gap-2 px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 transition-colors text-left">
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

     

    <main class="flex-1 overflow-y-auto p-4 md:p-8">
        <div class="max-w-7xl mx-auto">
            <div x-show="loading" class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                <p class="mt-2 text-gray-400">Loading snippets...</p>
            </div>

            <div x-show="!loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="snippet in snippets" :key="snippet.id">
                    <div @click="openSnippet(snippet.id)"
                        class="relative group h-72 w-full transition-all duration-500 [perspective:1000px]">

                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <div
                            class="relative h-full w-full glass-card rounded-3xl border border-white/10 overflow-hidden transition-all duration-500 group-hover:[transform:rotateX(5deg)_rotateY(-5deg)_translateY(-10px)] group-hover:border-white/20 flex flex-col">

                            <div class="absolute inset-0 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity pointer-events-none"
                                style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;">
                            </div>

                            <div class="p-6 pb-2 flex justify-between items-start">
                                <div class="relative">
                                    <div
                                        class="absolute -left-6 top-0 w-1 h-8 bg-blue-500 rounded-r-full shadow-[0_0_15px_rgba(59,130,246,0.8)]">
                                    </div>
                                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-blue-400"
                                        x-text="snippet.language"></span>
                                    <h3 class="text-xl font-bold text-white mt-1 group-hover:tracking-wide transition-all duration-500"
                                        x-text="snippet.title"></h3>
                                </div>
                                <div
                                    class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center rotate-12 group-hover:rotate-0 transition-transform duration-500">
                                    <span class="text-xl" x-text="getLangIcon(snippet.language)"></span>
                                </div>
                            </div>

                            <div class="px-6 flex-1 relative mt-2">
                                <p class="text-gray-400 text-xs leading-relaxed line-clamp-4 font-light opacity-60 group-hover:opacity-100 transition-opacity"
                                    x-text="snippet.description || '// No documentation attached...'"></p>

                                <div
                                    class="absolute bottom-0 right-6 text-[8px] font-mono text-white/5 select-none overflow-hidden whitespace-nowrap w-full text-right uppercase">
                                    vault_id: <span x-text="snippet.id"></span> // secure_access_granted //
                                </div>
                            </div>

                            <div class="p-6 pt-2 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex -space-x-2">
                                        <template x-for="file in snippet.files.slice(0, 4)">
                                            <div
                                                class="w-6 h-6 rounded-full bg-[#0a0a0a] border border-white/20 flex items-center justify-center text-[8px] font-bold text-white group-hover:translate-y-[-4px] transition-transform duration-300">
                                                <span x-text="file.extension.slice(0,2)"></span>
                                            </div>
                                        </template>
                                    </div>
                                    <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest"
                                        x-text="snippet.files.length + ' fragments'"></span>
                                </div>

                                <div
                                    class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center group-hover:bg-blue-600 group-hover:border-blue-500 transition-all duration-500 shadow-inner">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="!loading && snippets.length === 0">
                <div class=" rounded-xl p-12 text-center">
                    <div
                        class="w-16 h-16  rounded-full flex items-center justify-center mx-auto mb-6 border ">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">No snippets yet</h3>
                    <p class="text-gray-400 mb-6 max-w-md mx-auto">Your code vault is empty. Start building your
                        collection by creating your first snippet.</p>
                    <a href="{{ route('snippets-create') }}"
                        class="inline-flex items-center gap-2 btn-primary  text-sm  px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Create Your First Snippet
                    </a>
                </div>
            </div>
        </div>
    </main>

    <div x-show="showPreview" class="fixed inset-0 z-50 overflow-hidden flex items-center justify-end p-4" x-cloak>
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity" x-show="showPreview"
            x-transition:enter="duration-500" x-transition:leave="duration-300" @click="showPreview = false"></div>

        <div class="relative w-full max-w-5xl h-[90vh] glass-card rounded-[2rem] shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-white/10 flex flex-col overflow-hidden"
            x-show="showPreview" x-transition:enter="transform transition duration-500 ease-out"
            x-transition:enter-start="translate-x-full opacity-0 scale-95"
            x-transition:enter-end="translate-x-0 opacity-100 scale-100"
            x-transition:leave="transform transition duration-300 ease-in"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0">

            <div class="h-20 flex items-center justify-between px-8 bg-white/[0.02] border-b border-white/5">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white tracking-tight" x-text="selectedSnippet?.title"></h2>
                        <p class="text-[10px] text-gray-500 font-mono uppercase tracking-widest"
                            x-text="selectedSnippet?.language + ' // VERSION 1.0'"></p>
                    </div>
                </div>
                <button @click="showPreview = false"
                    class="w-10 h-10 rounded-full flex items-center justify-center bg-white/5 text-gray-400 hover:text-white hover:bg-red-500/20 transition-all border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex-1 flex overflow-hidden">
                <aside class="w-64 bg-black/40 border-r border-white/5 p-6 overflow-y-auto">
                    <div class="mb-4 text-[10px] font-bold text-gray-600 uppercase tracking-tighter">Project Files
                    </div>
                    <nav class="space-y-1.5">
                        <template x-for="(file, index) in selectedSnippet?.files" :key="index">
                            <button @click="activeFileTab = index"
                                :class="activeFileTab === index ?
                                    'bg-blue-600/10 text-blue-400 border-blue-500/50 shadow-[0_0_15px_rgba(59,130,246,0.1)]' :
                                    'text-gray-500 border-transparent hover:text-gray-300'"
                                class="w-full text-left px-4 py-3 rounded-xl text-[11px] font-mono border transition-all flex items-center justify-between group">
                                <span class="truncate" x-text="file.file_name"></span>
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-500 opacity-0 group-hover:opacity-100"
                                    x-show="activeFileTab === index"></div>
                            </button>
                        </template>
                    </nav>
                </aside>

                <div class="flex-1 flex flex-col bg-[#050505]/60 relative">
                    <template x-for="(file, index) in selectedSnippet?.files" :key="index">
                        <div x-show="activeFileTab === index" class="h-full flex flex-col p-8"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0">

                            <div
                                class="flex items-center justify-between mb-6 bg-white/5 p-4 rounded-2xl border border-white/5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]">
                                    </div>
                                    <span class="text-[11px] font-mono text-gray-400"
                                        x-text="file.file_path || 'root/' + file.file_name"></span>
                                </div>
                                <button @click="navigator.clipboard.writeText(file.content)"
                                    class="text-[10px] font-bold uppercase tracking-widest bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg transition-all shadow-lg shadow-blue-900/20">
                                    Copy Code
                                </button>
                            </div>

                            <div
                                class="flex-1 bg-black/40 rounded-3xl border border-white/5 p-6 overflow-auto custom-scrollbar relative group">
                                <div
                                    class="absolute left-0 top-6 bottom-6 w-10 border-r border-white/5 flex flex-col text-[10px] font-mono text-gray-700 items-center select-none">
                                    <span>01</span><span>02</span><span>03</span><span>04</span><span>05</span>
                                </div>
                                <pre class="pl-8 font-mono text-sm text-blue-100/90 whitespace-pre leading-relaxed"><code x-text="file.content"></code></pre>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <footer class="w-full mt-20 border-t border-white/10 bg-white/[0.02] backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-black-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
                   <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
                </div>
                <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile">CodeVault <span
                    class="text-blue-500 text-xs font-normal">v1.0</span></h1>
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

    <script>
        function snippetBrowser() {
            return {
                // Data Properties
                snippets: [],
                searchQuery: '',
                selectedLanguage: '', // Stores the database ID (e.g., 'php')
                selectedLanguageName: 'All Languages', // Stores the UI display name

                // UI State
                loading: false,
                showPreview: false,
                selectedSnippet: null,
                activeFileTab: 0,
                mobileMenuOpen: false,
                searchTimeout: null,

                // The list used by the dropdown loop
                languageList: [{
                        id: '',
                        name: 'All Languages',
                        icon: '🌐'
                    },
                    {
                        id: 'Laravel',
                        name: 'Laravel',
                        icon: '🐘'
                    }
                ],

                // Main Fetch Function
                fetchSnippets() {
                    this.loading = true;

                    // Construct URL with both Search Query and Language Filter
                    const url = `/api/search?q=${encodeURIComponent(this.searchQuery)}&lang=${this.selectedLanguage}`;

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            // Laravel Pagination usually wraps results in a .data array
                            this.snippets = data.data || data;
                            this.loading = false;
                        })
                        .catch(err => {
                            console.error("Fetch Error:", err);
                            this.loading = false;
                        });
                },

                // Debounced search for the input field
                searchSnippets() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.fetchSnippets();
                    }, 300);
                },

                // Opens the Slide-over Preview
                openSnippet(id) {
                    this.loading = true;
                    fetch(`/api/snippets/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            this.selectedSnippet = data;
                            this.activeFileTab = 0;
                            this.showPreview = true;
                            this.loading = false;
                        })
                        .catch(err => {
                            console.error("Detail Error:", err);
                            this.loading = false;
                        });
                },

                // Helper to get icons for the cards
                getLangIcon(lang) {
                    if (!lang) return '📄';

                    const icons = {
                        'php': '🐘',

                    };

                    return icons[lang.toLowerCase()] || '📄';
                }
            }
        }
    </script>

    
</body>

</html>
