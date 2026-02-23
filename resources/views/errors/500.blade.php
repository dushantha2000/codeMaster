{{-- 
    =================================================================
    500 Server Error Page
    =================================================================
    Purpose: Displayed when a server error occurs.
    
    Route: Error 500
    View: errors.500
    =================================================================
--}}

@extends('layouts.app')

@section('title', '500 - Server Error')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
        <!-- Error Icon -->
        <div class="mb-8">
            <svg class="mx-auto h-24 w-24 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        
        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-gray-900 mb-2">500</h1>
        
        <!-- Error Message -->
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Server Error</h2>
        <p class="text-gray-600 mb-8">
            Something went wrong on our end. We're working to fix the issue. Please try again in a few minutes.
        </p>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a 
                href="{{ route('home') }}" 
                class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors"
            >
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Go Home
            </a>
            <button 
                onclick="window.location.reload()" 
                class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors"
            >
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Try Again
            </button>
        </div>
        
        <!-- Error Details (for debugging) -->
        @if(config('app.debug'))
            <div class="mt-12 text-left bg-gray-100 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Error Details:</h3>
                <pre class="text-xs text-gray-600 overflow-x-auto">{{ $exception->getMessage() ?? 'No error message available' }}</pre>
            </div>
        @endif
    </div>
</div>
@endsection
