{{-- 
    =================================================================
    Authentication Pages Layout
    =================================================================
    Purpose: This layout provides a clean, centered design for all 
    authentication-related pages (login, register, forgot password, 
    reset password). It features a minimal design focused on the form.
    
    Usage: Extend this layout for auth pages:
    @extends('layouts.auth')
    
    Sections:
    - title: Page title (yielded)
    - content: Main page content (yielded)
    - styles: Additional CSS styles (yielded)
    - scripts: Additional JavaScript scripts (yielded)
    =================================================================
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="codeMaster - Secure code snippet manager">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'codeMaster - Authentication')</title>
    
    <!-- Fonts -->
   <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
     <script src="https://cdn.tailwindcss.com"></script>
    <!-- Scripts -->
    {{-- @vite(['resources/css/auth.css', 'resources/js/app.js']) --}}
    
    <!-- Additional Styles -->
    @yield('styles')
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Logo / Brand -->
        <div class="mb-8 text-center">
            <a href="{{ url('home') }}" class="inline-flex items-center justify-center">
                <svg class="h-12 w-12 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                <span class="ml-3 text-3xl font-bold text-gray-900">codeMaster</span>
            </a>
            <p class="mt-2 text-sm text-gray-600">
                Secure multi-file code snippet manager
            </p>
        </div>
        
        <!-- Auth Card -->
        <div class="w-full max-w-md">
            <!-- Flash Messages -->
            @include('partials.success-message')
            @include('partials.error-message')
            
            <!-- Main Auth Form Container -->
            <div class="bg-white py-8 px-6 shadow-xl rounded-lg border border-gray-200">
                <!-- Page Title -->
                @hasSection('heading')
                    <div class="mb-6 text-center">
                        <h2 class="text-2xl font-bold text-gray-900">
                            @yield('heading')
                        </h2>
                        @hasSection('subheading')
                            <p class="mt-2 text-sm text-gray-600">
                                @yield('subheading')
                            </p>
                        @endif
                    </div>
                @endif
                
                <!-- Page Content -->
                @yield('content')
            </div>
            
            <!-- Additional Links -->
            @hasSection('auth-links')
                <div class="mt-6 text-center">
                    @yield('auth-links')
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} codeMaster. All rights reserved.</p>
        </div>
    </div>
    
    <!-- Additional Scripts -->
    @yield('scripts')
</body>
</html>
