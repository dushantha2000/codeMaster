{{-- 
    =================================================================
    403 Forbidden Error Page
    =================================================================
    Purpose: Displayed when user doesn't have permission to access
    a resource.
    
    Route: Error 403
    View: errors.403
    =================================================================
--}}

@extends('layouts.app')

@section('title', '403 - Access Forbidden')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
        <!-- Error Icon -->
        <div class="mb-8">
            <svg class="mx-auto h-24 w-24 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        
        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-gray-900 mb-2">403</h1>
        
        <!-- Error Message -->
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Access Forbidden</h2>
        <p class="text-gray-600 mb-8">
            You don't have permission to access this page. If you believe this is an error, please contact the administrator.
        </p>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
                <a 
                    href="{{ route('dashboard.index') }}" 
                    class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors"
                >
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Go to Dashboard
                </a>
            @else
                <a 
                    href="{{ route('login') }}" 
                    class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors"
                >
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Sign In
                </a>
            @endauth
            
            <button 
                onclick="window.history.back()" 
                class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors"
            >
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Go Back
            </button>
        </div>
        
        <!-- Contact Support -->
        <div class="mt-12 p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-600">
                Need help?
                <a href="mailto:support@codemaster.app" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    Contact Support
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
