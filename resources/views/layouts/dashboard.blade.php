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
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @yield('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar Navigation -->
        @include('components.sidebar')
        
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen ml-0 md:ml-64">
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
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-40 hidden md:hidden" aria-hidden="true"></div>
    
    <!-- Additional Scripts -->
    @yield('scripts')
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                });
                
                if (overlay) {
                    overlay.addEventListener('click', function() {
                        sidebar.classList.add('-translate-x-full');
                        overlay.classList.add('hidden');
                    });
                }
            }
        });
    </script>
</body>
</html>
