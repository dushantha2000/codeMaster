<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | CodeVault</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
     <script src="https://cdn.tailwindcss.com"></script>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] {
            display: none !important;
        }

        .tab-active {
            background: rgba(168, 85, 247, 0.1);
            border: 1px solid rgba(168, 85, 247, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.6);
        }

        .file-item {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .file-item:hover {
            background: rgba(255, 255, 255, 0.04);
            transform: translateX(2px);
        }

        .code-editor {
            background: rgba(10, 10, 10, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .modal-backdrop {
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(24px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar-container {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                z-index: 40;
                width: 20rem;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar-container.mobile-open {
                transform: translateX(0);
            }

            .hide-on-mobile {
                display: none !important;
            }
        }
    </style>
</head>

<body class="text-gray-100 bg-[#030303] min-h-screen" x-data="snippetEditor()" x-cloak>

    @include('common.loading')
    
    @yield('content')
    
    @include('common.notification')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $(document).on('submit', 'form', function() {
                $('#custom-loader').css('display', 'flex').fadeIn(200);
            });

            $(document).on('click', '.load-btn', function() {
                $('#custom-loader').css('display', 'flex').show();
            });
        });

        window.addEventListener('pageshow', function() {
            $('#custom-loader').fadeOut(300);
        });
    </script>

    @stack('scripts')
</body>
</html>