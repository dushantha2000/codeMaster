<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | CodeVault</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Roboto+Mono:wght@400;500;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #030303;
            color: #EDEDED;
            overflow-y: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-image:
                radial-gradient(at 0% 0%, rgba(168, 85, 247, 0.07) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.05) 0px, transparent 60%);
        }

        [x-cloak] {
            display: none !important;
        }

        /* Shared glass surface — identical to app.blade.php */
        .glass-card {
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            box-shadow: 0 4px 50px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Auth form input — deep black with purple focus ring */
        .input-field {
            background: #0A0A0A;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.3);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .input-field:focus {
            border-color: rgba(168, 85, 247, 0.45);
            background: rgba(168, 85, 247, 0.03);
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.3), 0 0 0 4px rgba(168, 85, 247, 0.08);
        }

        /* Purple panel glow — right/left decorative half on auth split screen */
        .image-glow-purple {
            background: radial-gradient(circle at center, rgba(168, 85, 247, 0.08) 0%, transparent 70%);
        }

        /* Primary CTA — purple, matching app.blade.php btn-primary exactly */
        .btn-primary {
            background-color: #a855f7;
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 10px;
            box-shadow: 0 2px 20px rgba(168, 85, 247, 0.2);
            transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
        }

        .btn-primary:hover {
            background-color: #9333ea;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(168, 85, 247, 0.35);
        }

        /* Subtle scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: rgba(168, 85, 247, 0.2); border-radius: 10px; }
    </style>
    @stack('styles')
</head>

<body class="text-gray-100 flex items-center justify-center min-h-screen p-4 md:p-8">

    @include('auth.loading')

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
