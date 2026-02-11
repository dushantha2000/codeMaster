<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | CodeVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            height: 100vh;
            overflow: hidden;
            background: #0a0a0a;
        }

        .code-font {
            font-family: 'Fira Code', monospace;
            line-height: 1.7;
        }

        [x-cloak] {
            display: none !important;
        }

        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .tab-active {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .file-item {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .file-item:hover {
            transform: translateX(4px);
        }

        .btn-primary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }

        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
            transform: translateY(-2px);
        }

        .code-editor {
            background: rgba(10, 10, 10, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .modal-backdrop {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(12px);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* =======================================
           RESPONSIVE DESIGN - MOBILE FIRST
           ======================================= */

        /* Tablet (1024px and below) */
        @media (max-width: 1024px) {
            .sidebar-container {
                width: 16rem;
            }
        }

        /* Mobile (768px and below) */
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

            .mobile-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.7);
                z-index: 30;
                backdrop-filter: blur(4px);
            }

            .mobile-overlay.show {
                display: block;
            }

            .hide-on-mobile {
                display: none !important;
            }

            .show-on-mobile {
                display: flex !important;
            }
        }

        /* Small Mobile (640px and below) */
        @media (max-width: 640px) {
            .sidebar-container {
                width: 18rem;
            }

            .header-title {
                font-size: 0.875rem !important;
                padding: 0.5rem !important;
            }

            .btn-mobile-sm {
                padding: 0.5rem !important;
                font-size: 0.75rem;
            }

            .btn-text-hide-mobile {
                display: none;
            }
        }

        /* Extra Small Mobile (480px and below) */
        @media (max-width: 480px) {
            .sidebar-container {
                width: 85vw;
                max-width: 16rem;
            }

            .modal-mobile {
                margin: 0.5rem;
                padding: 1.5rem !important;
            }

            .file-meta-mobile {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</head>

<body class="text-gray-100" x-data="snippetEditor()" x-cloak>

    @include('auth.loading')

    @yield('content')



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            // 1. Handle Form Submits
            $(document).on('submit', 'form', function() {
                $('#custom-loader').css('display', 'flex').fadeIn(200);
            });

            // 2. Handle Link Clicks (Event Delegation)
            // This catches clicks on the <a>, the <svg>, or the <path>
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
