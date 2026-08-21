<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shared Snippet') | CodeVault</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Shared Design System -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">

    <!-- Share Page Styles (glass-card variant, scrollbar) -->
    <link rel="stylesheet" href="{{ asset('css/share.css') }}">

    <!-- CDN Dependencies -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />

    @stack('styles')
</head>

<body class="text-gray-100 min-h-screen flex flex-col bg-mesh">

    <!-- Main content area — centered, max-width constrained -->
    <main class="flex-1 w-full max-w-7xl mx-auto p-4 md:p-8">
        @yield('content')
    </main>

    <!-- Shared link attribution footer -->
    <footer class="py-6 text-center">
        <a href="{{ url('/') }}"
            class="text-[10px] font-bold tracking-widest text-gray-600 hover:text-blue-400 transition-colors">
            🔗 Shared via CodeVault
        </a>
    </footer>

    @include('common.notification')

    <!-- Prism.js — syntax highlighting for shared code snippets -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-jsx.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>

    <script>
        // Initialize Prism syntax highlighting after DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Prism !== 'undefined') {
                Prism.highlightAll();
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
