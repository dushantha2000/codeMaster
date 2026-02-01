<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snippet Dashboard | My Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
            <input type="text" x-model="searchQuery" @input="searchSnippets()" placeholder="Search..."
                class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 outline-none focus:border-white/30 transition-all">
        </div>

        <div class="flex items-center gap-2 md:gap-4">
            <div class="relative hide-on-mobile" x-data="{ open: false, selected: 'All Languages' }">
                <button @click="open = !open"
                    class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm flex items-center justify-between min-w-[160px] hover:bg-white/10 transition-all">
                    <span x-text="selected"></span>
                    <svg class="w-4 h-4 ml-2 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open" @click.outside="open = false"
                    class="absolute top-full right-0 mt-2 w-48 max-h-60 overflow-y-auto glass-card rounded-xl border border-white/10 shadow-2xl z-50 py-2">

                    <template
                        x-for="lang in [
    {id: '', name: 'All Languages', icon: '🌐'},
    {id: 'python', name: 'Python', icon: '🐍'},
    {id: 'javascript', name: 'JavaScript', icon: '🟨'},
    {id: 'typescript', name: 'TypeScript', icon: '🔷'},
    {id: 'php', name: 'PHP', icon: '🐘'},
    {id: 'java', name: 'Java', icon: '☕'},
    {id: 'csharp', name: 'C#', icon: '🔷'},
    {id: 'cpp', name: 'C++', icon: '🔧'},
    {id: 'c', name: 'C', icon: '🔧'},
    {id: 'ruby', name: 'Ruby', icon: '💎'},
    {id: 'go', name: 'Go', icon: '🐹'},
    {id: 'rust', name: 'Rust', icon: '🦀'},
    {id: 'swift', name: 'Swift', icon: '🦉'},
    {id: 'kotlin', name: 'Kotlin', icon: '🎯'},
    {id: 'dart', name: 'Dart', icon: '🎯'},
    {id: 'scala', name: 'Scala', icon: '⚖️'},
    {id: 'r', name: 'R', icon: '📊'},
    {id: 'perl', name: 'Perl', icon: '🐪'},
    {id: 'lua', name: 'Lua', icon: '🌙'},
    {id: 'haskell', name: 'Haskell', icon: 'λ'},
    {id: 'clojure', name: 'Clojure', icon: '☘️'},
    {id: 'elixir', name: 'Elixir', icon: '🧪'},
    {id: 'erlang', name: 'Erlang', icon: '📞'},
    {id: 'html', name: 'HTML', icon: '🌐'},
    {id: 'css', name: 'CSS', icon: '🎨'},
    {id: 'sql', name: 'SQL', icon: '🗄️'},
    {id: 'bash', name: 'Bash', icon: '🐚'},
    {id: 'powershell', name: 'PowerShell', icon: '💙'},
    {id: 'yaml', name: 'YAML', icon: '📄'},
    {id: 'json', name: 'JSON', icon: '📋'},
    {id: 'xml', name: 'XML', icon: '📄'},
    {id: 'markdown', name: 'Markdown', icon: '📝'},
    {id: 'dockerfile', name: 'Dockerfile', icon: '🐳'},
    {id: 'makefile', name: 'Makefile', icon: '🔨'}
]">
                        <button
                            @click="selected = lang.icon + ' ' + lang.name; open = false; /* add filter logic here */"
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-colors">
                            <span x-text="lang.icon + ' ' + lang.name"></span>
                        </button>
                    </template>
                </div>
            </div>
            <a href="{{ route('snippets-create') }}"
                class="btn-primary px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="hide-on-mobile">New</span>
            </a>
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
                    <div
                        class="glass-card rounded-2xl p-6 hover:border-white/20 transition-all group flex flex-col justify-between h-64">
                        <div>
                            <div class="flex items-start justify-between mb-4">
                                <span
                                    class="px-3 py-1 bg-white/10 text-[10px] font-bold uppercase rounded-full border border-white/10">
                                    <span x-text="snippet.language"></span>
                                </span>
                                <span class="text-[10px] text-gray-500"
                                    x-text="new Date(snippet.created_at).toLocaleDateString()"></span>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2" x-text="snippet.title"></h3>
                            <p class="text-gray-400 text-sm line-clamp-2"
                                x-text="snippet.description || 'No description.'"></p>
                        </div>

                        <div class="flex items-center justify-between border-t border-white/5 pt-4 mt-4">
                            <div class="flex -space-x-2">
                                <template x-for="file in snippet.files" :key="file.id">
                                    <div class="w-7 h-7 bg-white/10 border border-white/10 rounded flex items-center justify-center text-[10px]"
                                        :title="file.file_name">
                                        <span x-text="file.extension.charAt(0).toUpperCase()"></span>
                                    </div>
                                </template>
                            </div>
                            <button @click="openSnippet(snippet.id)"
                                class="text-xs font-bold text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                View Code →
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="!loading && snippets.length === 0" class="text-center py-12">
                <p class="text-gray-400">No snippets found.</p>
            </div>
        </div>
    </main>

    <div x-show="showPreview" class="fixed inset-0 z-50 overflow-hidden" x-transition>
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showPreview = false"></div>
        <div
            class="absolute inset-y-0 right-0 max-w-4xl w-full bg-[#0d1117] shadow-2xl flex flex-col border-l border-white/10">
            <div class="h-16 flex items-center justify-between px-6 border-b border-white/10 bg-[#161b22]">
                <h2 class="text-lg font-bold" x-text="selectedSnippet?.title"></h2>
                <button @click="showPreview = false" class="text-gray-400 hover:text-white text-2xl">&times;</button>
            </div>
            <div class="flex-1 flex overflow-hidden">
                <aside class="w-48 bg-black/20 border-r border-white/5 p-4 overflow-y-auto">
                    <nav class="space-y-2">
                        <template x-for="(file, index) in selectedSnippet?.files" :key="index">
                            <button @click="activeFileTab = index"
                                :class="activeFileTab === index ? 'bg-blue-600/20 text-blue-400' : 'text-gray-500'"
                                class="w-full text-left p-2 rounded text-xs font-medium transition-all truncate">
                                <span x-text="file.file_name"></span>
                            </button>
                        </template>
                    </nav>
                </aside>
                <div class="flex-1 bg-gray-950 overflow-auto p-6">
                    <template x-for="(file, index) in selectedSnippet?.files" :key="index">
                        <div x-show="activeFileTab === index">
                            <div class="flex justify-between mb-4">
                                <span class="text-[10px] text-gray-500 font-mono" x-text="file.file_path"></span>
                                <button class="text-xs bg-white/5 px-2 py-1 rounded">Copy</button>
                            </div>
                            <pre class="font-mono text-sm text-blue-300 whitespace-pre-wrap"><code x-text="file.content"></code></pre>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <script>
        function snippetBrowser() {
            return {
                snippets: [],
                searchQuery: '',
                loading: false,
                showPreview: false,
                selectedSnippet: null,
                activeFileTab: 0,
                mobileMenuOpen: false,

                fetchSnippets() {
                    this.loading = true;
                    fetch(`/api/search?q=${encodeURIComponent(this.searchQuery)}`)
                        .then(res => res.json())
                        .then(data => {
                            this.snippets = data.data || [];
                            this.loading = false;
                        })
                        .catch(error => {
                            console.error('Error fetching snippets:', error);
                            this.loading = false;
                        });
                },

                searchSnippets() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.fetchSnippets();
                    }, 300);
                },

                openSnippet(id) {
                    // Logic to fetch your data
                    fetch(`/api/snippets/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            this.selectedSnippet = data;
                            this.activeFileTab = 0;
                            this.showPreview = true;
                        });
                }
            }
        }
    </script>
</body>

</html>
