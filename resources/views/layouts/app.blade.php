{{-- 
    =================================================================
    Main Application Layout - Master Layout
    =================================================================
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="codeMaster - Secure multi-file code snippet manager for developers">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'codeMaster - Code Snippet Manager')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @yield('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" style="font-family: 'Space Grotesk', sans-serif;">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation Bar -->
        @include('components.navbar')
        
        <!-- Main Content Area -->
        <main class="flex-grow">
            <!-- Flash Messages / Notifications -->
            @include('partials.success-message')
            @include('partials.error-message')
            
            <!-- Page Content -->
            @yield('content')
        </main>
        
        <!-- Footer -->
        @include('components.footer')
    </div>
    
    <!-- Additional Scripts -->
    @stack('scripts')
    
    <!-- Global JavaScript Variables -->
    <script>
        // Make auth user available globally
        window.Auth = {
            user: @auth
                {!! json_encode(Auth::user()) !!}
            @else
                null
            @endauth
        };
    </script>
</body>
</html>
