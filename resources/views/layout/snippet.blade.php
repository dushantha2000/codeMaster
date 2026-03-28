<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | CodeVault</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;900&family=Fira+Code:wght@400;500;700&display=swap" rel="stylesheet">
     <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #0a0a0a;
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
            border: 1px solid rgba(255, 255, 255, 0.05);
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
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: white;
            transition: all 0.2s;
        }

        .input-field:focus {
            border-color: #0969da;
            box-shadow: 0 0 0 1px #0969da;
        }

        .tab-active {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.6);
        }

        .file-item {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .file-item:hover {
            background: rgba(255, 255, 255, 0.04);
            transform: translateX(2px);
        }

        .modal-backdrop {
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(24px);
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.01);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
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

<body class="text-gray-100 bg-[#0a0a0a] min-h-screen Selection:bg-blue-500/30 overflow-hidden" x-data="snippetEditor()" x-cloak>

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