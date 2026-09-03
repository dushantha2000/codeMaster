<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | CodeVault</title>

    <!-- Shared Design System -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">

    <!-- Snippet Editor Styles (tabs, file list, responsive sidebar) -->
    <link rel="stylesheet" href="{{ asset('css/snippet-editor.css') }}">

    <!-- CDN Dependencies -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Prism.js — Full language support via autoloader (50+ languages) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/prism-custom-themes.css') }}">

</head>

<body class="text-gray-100 bg-[#0a0a0a] min-h-screen selection:bg-blue-500/30 overflow-hidden" x-data="snippetEditor()" x-cloak>

    @include('common.loading')
    
    @yield('content')
    
    @include('common.notification')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Show loader on form submissions
            $(document).on('submit', 'form', function() {
                $('#custom-loader').css('display', 'flex').fadeIn(200);
            });

            // Show loader on load-button clicks (event delegation for dynamic content)
            $(document).on('click', '.load-btn', function() {
                $('#custom-loader').css('display', 'flex').show();
            });
        });

        // Robust loader hide — fires on page restore from bfcache
        window.addEventListener('pageshow', function() {
            $('#custom-loader').fadeOut(300);
        });
    </script>

    <!-- Prism.js — autoloader for all 50+ languages -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script>
        if (typeof Prism !== 'undefined' && Prism.plugins && Prism.plugins.autoloader) {
            Prism.plugins.autoloader.languages_path = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/';
        }
    </script>
    <script src="{{ asset('js/code-formatting.js') }}"></script>

    @stack('scripts')
</body>
</html>
