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

    <!-- CDN Dependencies -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />

    <style>
        /* ---- Layout-Specific Overrides ---- */

        /* Glass Card Hover (dashboard-specific glow) */
        .glass-card:hover {
            background: rgba(25, 25, 25, 0.7);
            border-color: var(--color-accent-border);
            transform: translateY(-2px);
            box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.05),
                0 20px 40px rgba(0, 0, 0, 0.6);
        }

        /* Glass Effect inner glow */
        .glass-effect {
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.02),
                0 10px 30px rgba(0, 0, 0, 0.5);
        }

        /* Optional: Shine reflection effect */
        .glass-card::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    transparent,
                    rgba(255, 255, 255, 0.03),
                    transparent);
            transform: rotate(45deg);
            transition: 0.8s;
            pointer-events: none;
        }

        .glass-card:hover::after {
            left: 100%;
        }

        /* Mesh breathing animation */
        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-1%, 1%); }
        }

        .bg-mesh-animated::before {
            animation: float 20s ease-in-out infinite;
        }
    </style>

    @stack('styles')
</head>

<body class="text-gray-100 h-full flex flex-col bg-mesh bg-mesh-animated" x-data="snippetBrowser()" x-cloak>

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
