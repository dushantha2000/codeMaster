{{-- 
    =================================================================
    Dashboard Index Page
    =================================================================
    Purpose: Main dashboard view showing user statistics, recent
    snippets, and quick actions.
    
    Route: /dashboard
    View: dashboard.index
    =================================================================
--}}

@extends('layouts.dashboard')

@section('title', 'Dashboard - codeMaster')

@php
    $recentSnippetsCount = $recentSnippetsCount ?? 0;
    $totalSnippets = $totalSnippets ?? 0;
    $totalCategories = $totalCategories ?? 0;
    $totalFiles = $totalFiles ?? 0;
    $storageUsed = $storageUsed ?? '0 KB';
    $recentSnippets = $recentSnippets ?? collect();
    $topLanguages = $topLanguages ?? [];
@endphp
<style>
    /* Dashboard-specific styles */
    .stat-card {
        @apply bg-white rounded-xl shadow-sm border border-gray-200 p-6 transition-all hover:shadow-md;
    }
    .stat-icon {
        @apply h-10 w-10 rounded-lg flex items-center justify-center;
    }
</style>
@endpush

@section('header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Welcome back, {{ Auth::user()->name }}!
        </h1>
        <p class="mt-1 text-sm text-gray-600">
            Here's what's happening with your code snippets
        </p>
    </div>
    <a 
        href="{{ route('snippets.create') }}" 
        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors"
    >
        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        New Snippet
    </a>
</div>
@endsection

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Snippets -->
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div class="stat-icon bg-indigo-100">
                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
            </div>
            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                +{{ $recentSnippetsCount ?? 0 }} this week
            </span>
        </div>
        <div class="mt-4">
            <p class="text-3xl font-bold text-gray-900">{{ $totalSnippets ?? 0 }}</p>
            <p class="text-sm text-gray-600">Total Snippets</p>
        </div>
    </div>
    
    <!-- Total Categories -->
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div class="stat-icon bg-purple-100">
                <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-3xl font-bold text-gray-900">{{ $totalCategories ?? 0 }}</p>
            <p class="text-sm text-gray-600">Categories</p>
        </div>
    </div>
    
    <!-- Total Files -->
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div class="stat-icon bg-blue-100">
                <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-3xl font-bold text-gray-900">{{ $totalFiles ?? 0 }}</p>
            <p class="text-sm text-gray-600">Code Files</p>
        </div>
    </div>
    
    <!-- Storage Used -->
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div class="stat-icon bg-green-100">
                <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-3xl font-bold text-gray-900">{{ $storageUsed ?? '0 KB' }}</p>
            <p class="text-sm text-gray-600">Storage Used</p>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Snippets -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Recent Snippets</h2>
                <a href="{{ route('snippets.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    View all
                </a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentSnippets ?? [] as $snippet)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('snippets.show', $snippet->id) }}" class="block">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">
                                        {{ $snippet->title }}
                                    </h3>
                                    <div class="flex items-center mt-1 space-x-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $snippet->language ?? 'Plain Text' }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $snippet->files_count ?? 0 }} files
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            •
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $snippet->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="ml-4 flex items-center space-x-2">
                                <button 
                                    onclick="copyToClipboard('{{ $snippet->id }}')"
                                    class="p-2 text-gray-400 hover:text-indigo-600 transition-colors"
                                    title="Copy code"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No snippets yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first code snippet.</p>
                        <div class="mt-6">
                            <a href="{{ route('snippets.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Snippet
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('snippets.create') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-indigo-100 rounded-lg mr-3">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium">Create New Snippet</span>
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-purple-100 rounded-lg mr-3">
                        <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium">Manage Categories</span>
                </a>
                <a href="{{ route('dashboard.profile') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-blue-100 rounded-lg mr-3">
                        <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium">Update Profile</span>
                </a>
                <a href="{{ route('dashboard.settings') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-green-100 rounded-lg mr-3">
                        <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium">Account Settings</span>
                </a>
            </div>
        </div>
        
        <!-- Popular Languages Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Top Languages</h2>
            <div class="flex flex-wrap gap-2">
                @forelse($topLanguages ?? [] as $language => $count)
                    <a href="{{ route('snippets.index', ['language' => $language]) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors">
                        {{ $language }}
                        <span class="ml-1.5 text-xs text-gray-500">({{ $count }})</span>
                    </a>
                @empty
                    <p class="text-sm text-gray-500">No data available</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyToClipboard(snippetId) {
        // Copy snippet code to clipboard
        fetch(`/snippets/${snippetId}/copy`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show toast notification
                alert('Code copied to clipboard!');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endpush
