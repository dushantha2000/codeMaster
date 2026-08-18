<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shared Snippet') | CodeVault</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            border: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            border-color: rgba(59, 130, 246, 0.3);
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

        /* Obsidian-style background matching the dashboard */
        .bg-mesh {
            background-color: #050505;
            position: relative;
            min-height: 100vh;
        }

        .bg-mesh::before {
            content: "";
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at 50% -20%, rgba(255, 255, 255, 0.03) 0%, transparent 50%);
            z-index: -1;
            pointer-events: none;
        }

        .bg-mesh::after {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 30px 30px;
            mask-image: radial-gradient(circle at 50% 50%, black 30%, transparent 95%);
            z-index: -1;
            pointer-events: none;
        }

        /* Prism styling matching the dashboard */
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

        .custom-mini-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-mini-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
    </style>
    @stack('styles')
</head>

<body class="text-gray-100 min-h-screen flex flex-col bg-mesh">

    <main class="flex-1 w-full max-w-7xl mx-auto p-4 md:p-8">
        @yield('content')
    </main>

    <footer class="py-6 text-center">
        <a href="{{ url('/') }}"
            class="text-[10px] font-bold uppercase tracking-widest text-gray-600 hover:text-blue-400 transition-colors">
            🔗 Shared via CodeVault
        </a>
    </footer>

    @include('common.notification')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-jsx.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Prism !== 'undefined') {
                Prism.highlightAll();
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
