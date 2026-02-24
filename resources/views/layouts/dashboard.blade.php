{{-- 
    =================================================================
    Dashboard Layout
    =================================================================
    Purpose: This layout provides the structure for authenticated user 
    dashboard pages. It includes a sidebar navigation, top navbar, 
    and main content area with responsive design.
    
    Usage: Extend this layout for dashboard pages:
    @extends('layouts.dashboard')
    
    Sections:
    - title: Page title (yielded)
    - content: Main page content (yielded)
    - header: Page header content (yielded)
    - styles: Additional CSS styles (yielded)
    - scripts: Additional JavaScript scripts (yielded)
    =================================================================
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="codeMaster Dashboard - Manage your code snippets">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard - codeMaster')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    
    <!-- Scripts -->
    @stack('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @yield('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" style="font-family: 'Space Grotesk', sans-serif;">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navbar -->
        @include('components.navbar')
        
        <!-- Flash Messages -->
        @include('partials.success-message')
        @include('partials.error-message')
        
        <!-- Page Header -->
        @hasSection('header')
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    @yield('header')
                </div>
            </div>
        @endif
        
        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                @yield('content')
            </div>
        </main>
        
        <!-- Footer -->
        @include('components.footer')
    </div>
    
    <!-- Additional Scripts -->
    @yield('scripts')
</body>
</html>
