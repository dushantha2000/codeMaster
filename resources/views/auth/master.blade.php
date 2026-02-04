<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | CodeVault</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #0a0a0a;
            overflow-y: auto;
        }

        [x-cloak] {
            display: none !important;
        }

        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.2s ease;
        }

        .input-field:focus {
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(255, 255, 255, 0.07);
            outline: none;
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

    @include('auth.loading')

    @yield('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            $('form').on('submit', function() {
                $('#custom-loader').fadeIn();
            });

            $('.load-btn').on('click', function() {
                $('#custom-loader').show();
            });
        });
        window.addEventListener('load', function() {
            $('#custom-loader').fadeOut();
        });
    </script>

    @stack('scripts')

   
</body>

</html>
