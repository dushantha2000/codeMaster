<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>@yield('title', 'Dashboard') | CodeVault</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Shared Design System -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">

    <!-- Common Layout Styles (glass-card, mesh animation, etc.) -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    <!-- Dashboard Page-Specific Styles -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- CDN Dependencies -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Prism.js — Full language support via autoloader (50+ languages) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/prism-custom-themes.css') }}">

    @stack('styles')
</head>

<body class="text-gray-100 h-full flex flex-col bg-mesh bg-mesh-animated" x-data="snippetBrowser()" x-cloak>

    @include('common.loading')

    @include('common.notification')

    @include('common.header')

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto p-4 md:p-8 pb-24 md:pb-8">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Global Scripts — Prism.js syntax highlighting (all 50+ languages via autoloader) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-highlight/prism-line-highlight.min.js"></script>
    <script>
        // Configure Prism autoloader to load languages from CDN
        if (typeof Prism !== 'undefined' && Prism.plugins && Prism.plugins.autoloader) {
            Prism.plugins.autoloader.languages_path = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/';
        }
    </script>
    <script src="{{ asset('js/code-formatting.js') }}"></script>

    @stack('scripts')
</body>

</html>
