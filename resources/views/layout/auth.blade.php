<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | CodeVault</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Shared Design System -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">

    <!-- CDN Dependencies -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ---- Auth-Specific Overrides ---- */

        body {
            overflow-y: auto;
        }

        .image-glow-blue {
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
        }

        .image-glow-red {
            background: radial-gradient(circle at center, rgba(239, 68, 68, 0.08) 0%, transparent 70%);
        }
    </style>
    @stack('styles')
</head>

<body class="text-gray-100 flex items-center justify-center min-h-screen p-4">

    @include('common.loading')

    @yield('content')

    @include('common.notification')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // 1. Handle Form Submits
            $(document).on('submit', 'form', function() {
                $('#custom-loader').css('display', 'flex').fadeIn(200);
            });

            // 2. Handle Link Clicks (Event Delegation)
            $(document).on('click', '.load-btn', function() {
                $('#custom-loader').css('display', 'flex').show();
            });
        });

        // 3. Robust Hide logic
        window.addEventListener('pageshow', function() {
            $('#custom-loader').fadeOut(300);
        });
    </script>

    @stack('scripts')


</body>

</html>
