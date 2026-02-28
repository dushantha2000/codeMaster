<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>@yield('title', 'Dashboard') | CodeVault</title>
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

        /* Mobile Filter Panel Animation */
        .mobile-filter-panel {
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.2) transparent;
        }

        .mobile-filter-panel::-webkit-scrollbar {
            width: 4px;
        }

        .mobile-filter-panel::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
        }

        /* Ensure touch events work properly on mobile */
        @media (max-width: 1023px) {
            [x-cloak] {
                display: none !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="text-gray-100 h-full flex flex-col" x-data="snippetBrowser()" x-cloak>

    @include('common.loading')

    @include('common.notification')

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 md:hidden"
        @click="mobileMenuOpen = false"></div>

    @include('common.header')

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-4 md:p-8 pb-24 md:pb-8">
        <div class="max-w-7xl mx-auto flex gap-6">
            @yield('content')
        </div>
    </main>

    @include('common.footer')

    <!-- Preview Modal with Mobile Support -->
    @include('common.preview-modal')

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

    @stack('scripts')
</body>

</html>