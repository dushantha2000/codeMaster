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
    href="https://fonts.googleapis.com/css2?family=Fira+Code&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />

    <style>
        /* Base Styles */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            /* background: #030303; */
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
            /* Refined border for a sharper 'edge' */
            border: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* The "Glow" Effect */
        .glass-effect {
            /* Subtle inner shadow to simulate light hitting the edges */
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.02),
                0 10px 30px rgba(0, 0, 0, 0.5);
        }

        /* Hover Interaction: Premium Border Glow */
        .glass-card:hover {
            background: rgba(25, 25, 25, 0.7);
            border-color: rgba(59, 130, 246, 0.3);
            /* Subtle Blue Glow on hover */
            transform: translateY(-2px);
            box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.05),
                0 20px 40px rgba(0, 0, 0, 0.6);
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

        /* --- True Obsidian Background (Clean & Professional) --- */
        .bg-mesh {
            background-color: #050505;
            /* Solid dark background */
            position: relative;
            min-height: 100vh;
        }

        /* Subtle gradient to keep it from looking 'flat' without using colors */
        .bg-mesh::before {
            content: "";
            position: fixed;
            inset: 0;
            /* Uses only grayscale/zinc tones for a clean look */
            background: radial-gradient(circle at 50% -20%, rgba(255, 255, 255, 0.03) 0%, transparent 50%);
            z-index: -1;
            pointer-events: none;
        }

        /* Sharper, cleaner Technical Grid */
        .bg-mesh::after {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 30px 30px;
            /* Soft edges so the grid doesn't distract from your code */
            mask-image: radial-gradient(circle at 50% 50%, black 30%, transparent 95%);
            z-index: -1;
            pointer-events: none;
        }

        /* Smooth "Breathing" for Production Environments */
        @keyframes mesh-breathing {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.05);
                opacity: 1;
            }
        }

        /* Subtle Ambient Animation */
        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-1%, 1%);
            }
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
