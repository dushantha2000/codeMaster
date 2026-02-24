{{-- 
    =================================================================
    Forgot Password Page
    =================================================================
    Route: /forgot-password
    View: auth.forgot-password
    =================================================================
--}}

@extends('layouts.auth')

@section('title', 'Forgot Password - codeMaster')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo & Title -->
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">
                Forgot your password?
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Just enter your email address and we'll send you a link to reset your password.
            </p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-sm text-green-600">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Forgot Password Form -->
        <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email address
                </label>
                <div class="mt-1">
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="email" 
                        required
                        value="{{ old('email') }}"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="you@example.com"
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit" 
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </span>
                    Send Password Reset Link
                </button>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    ← Back to login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
