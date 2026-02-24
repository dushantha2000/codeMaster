{{-- 
    =================================================================
    Profile Page
    =================================================================
    Purpose: User profile view where users can view and edit
    their profile information including name, email, and bio.
    
    Route: /dashboard/profile
    View: dashboard.profile
    =================================================================
--}}

@extends('layouts.dashboard')

@section('title', 'Profile - codeMaster')

@section('header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Profile Settings</h1>
    <p class="mt-1 text-sm text-gray-600">Manage your personal information</p>
</div>
@endsection

@php
    $totalSnippets = $totalSnippets ?? 0;
@endphp

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Profile Information -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Profile Information</h2>
                <p class="text-sm text-gray-600 mt-1">Update your account's profile information</p>
            </div>
            
            <form method="POST" action="{{ url('profile.update') }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')
                
                <!-- Avatar -->
                <div class="flex items-center space-x-6">
                    <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                        <p class="text-xs text-gray-500 mt-1">JPG, GIF or PNG. 1MB max.</p>
                        <button type="button" class="mt-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                            Upload new photo
                        </button>
                    </div>
                </div>
                
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', Auth::user()->name) }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @endif
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', Auth::user()->email) }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @endif
                </div>
                
                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea 
                        id="bio" 
                        name="bio" 
                        rows="4"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('bio') border-red-500 @enderror"
                        placeholder="Tell us a little about yourself..."
                    >{{ old('bio', Auth::user()->bio ?? '') }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">Brief description for your profile.</p>
                    @error('bio')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @endif
                </div>
                
                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Security Section -->
        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Security</h2>
                <p class="text-sm text-gray-600 mt-1">Manage your password and security settings</p>
            </div>
            
            <div class="p-6">
                <!-- Change Password -->
                <div class="flex items-center justify-between py-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Password</h3>
                        <p class="text-sm text-gray-500">Change your password regularly for security</p>
                    </div>
                    <a 
                        href="{{ route('password.request') }}"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors"
                    >
                        Change Password
                    </a>
                </div>
                
                <div class="border-t border-gray-200"></div>
                
                <!-- Two-Factor Authentication -->
                <div class="flex items-center justify-between py-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h3>
                        <p class="text-sm text-gray-500">Add an extra layer of security to your account</p>
                    </div>
                    <button 
                        type="button"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors"
                    >
                        Enable
                    </button>
                </div>
                
                <div class="border-t border-gray-200"></div>
                
                <!-- Active Sessions -->
                <div class="flex items-center justify-between py-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Active Sessions</h3>
                        <p class="text-sm text-gray-500">Manage your active sessions on other devices</p>
                    </div>
                    <button 
                        type="button"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors"
                    >
                        View Sessions
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Account Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Status</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Email Verified</span>
                    @if(Auth::user()->email_verified_at)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Verified
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Member Since</span>
                    <span class="text-sm text-gray-900">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Total Snippets</span>
                    <span class="text-sm text-gray-900">{{ $totalSnippets ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <!-- Danger Zone -->
        <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
            <h3 class="text-lg font-semibold text-red-600 mb-4">Danger Zone</h3>
            <p class="text-sm text-gray-600 mb-4">Once you delete your account, there is no going back.</p>
            <button 
                type="button"
                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors"
                onclick="if(confirm('Are you sure you want to delete your account?')) { document.getElementById('delete-account-form').submit(); }"
            >
                Delete Account
            </button>
            <form id="delete-account-form" method="POST" action="{{ url('profile.destroy') }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection
