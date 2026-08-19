<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shared Snippet') | CodeVault</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Shared Design System -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">

    <!-- CDN Dependencies -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />

    <style>
        /* ---- Share-Specific Overrides ---- */

        .glass-card:hover {
            border-color: var(--color-accent-border);
        }

        /* Glass Card Hover (share-specific: no transform) */
        .glass-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Mini scrollbar */
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
            class="text-[10px] font-bold tracking-widest text-gray-600 hover:text-blue-400 transition-colors">
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
