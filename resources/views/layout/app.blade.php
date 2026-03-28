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
            background: #070707;
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
            background: rgb(255, 255, 255);
            color: rgb(0, 0, 0);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s;
            
        }

        .btn-primary:hover {
            background: rgb(0, 0, 0);
            transform: translateY(-1px);
            color: rgb(255, 255, 255);
        }

        .input-field {
            background: #050505;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.2s;
        }

        .input-field:focus {
            border-color: #0969da;
            box-shadow: 0 0 0 1px #0969da;
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

        .bg-mesh {
            background-image:
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.05) 0px, transparent 70%),
                radial-gradient(at 100% 100%, rgba(147, 51, 234, 0.05) 0px, transparent 90%);
        }
    </style>

    <script>
        // Critical: Provide the global snippetBrowser function immediately for Alpine
        window.snippetBrowser = function() {
            return {
                snippets: [],
                searchQuery: '',
                selectedLanguage: '',
                selectedLanguageName: 'All Languages',
                selectedStatus: 'all',
                sortBy: 'latest',
                mobileFiltersOpen: false,
                loading: false,
                showPreview: false,
                selectedSnippet: null,
                activeFileTab: 0,
                mobileMenuOpen: false,
                mobileFileListOpen: false,
                copyDone: false,
                total: 0,
                currentPage: 1,
                lastPage: 1,

                languageList: [
                    { id: '', name: 'All Languages', icon: '🌐' },
                    { id: 'Laravel', name: 'Laravel', icon: '🐘' },
                    { id: 'React', name: 'React', icon: '⚛️' },
                    { id: 'Tailwind', name: 'Tailwind', icon: '🍃' },
                    { id: 'Javascript', name: 'Javascript', icon: '🟨' },
                    { id: 'Python', name: 'Python', icon: '🐍' },
                    { id: 'PHP', name: 'PHP', icon: '🐘' }
                ],

                fetchSnippets() { console.log("Global fallback fetch"); },
                init() { console.log("Global fallback init"); },
                openSnippet(id) { console.log("Global fallback open", id); },
                copyCode(text) { console.log("Global fallback copy"); },
                formatDate(d) { return d ? new Date(d).toLocaleDateString() : 'N/A'; }
            };
        };
    </script>

    @stack('styles')
</head>

<body class="text-gray-100 h-full flex flex-col bg-mesh" x-data="snippetBrowser()" x-cloak>

    @include('common.loading')

    @include('common.notification')

    @include('common.header')

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-4 md:p-8 pb-24 md:pb-8">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Global Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-jsx.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>

    @stack('scripts')
</body>

</html>