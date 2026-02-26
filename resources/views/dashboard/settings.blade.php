{{-- 
    =================================================================
    Settings Page
    =================================================================
    Purpose: User settings page for managing preferences like
    notifications, theme, and API keys.
    
    Route: /dashboard/settings
    View: dashboard.settings
    =================================================================
--}}

@extends('layouts.dashboard')

@section('title', 'Settings - codeMaster')

@section('header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
    <p class="mt-1 text-sm text-gray-600">Manage your account preferences</p>
</div>
@endsection

@section('content')
<form action="{{ route('dashboard.settings.update') }}" method="POST">
    @csrf
    @method('POST')
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-800 text-sm">{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('api_key'))
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-blue-800 text-sm font-medium">Your new API key:</p>
            <p class="mt-2 p-2 bg-gray-800 text-gray-100 rounded font-mono text-sm select-all">{{ session('api_key') }}</p>
            <p class="mt-2 text-blue-700 text-xs">Make sure to copy this now. You won't be able to see it again!</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Settings Navigation -->
        <div class="lg:col-span-1">
            <nav class="space-y-1">
                <a href="#notifications" class="flex items-center px-3 py-2 text-sm font-medium text-gray-900 rounded-lg bg-gray-100">
                    <svg class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Notifications
                </a>
                <a href="#appearance" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                    <svg class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    Appearance
                </a>
                <a href="#privacy" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                    <svg class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Privacy
                </a>
                <a href="#api" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                    <svg class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    API Keys
                </a>
            </nav>
        </div>
        
        <!-- Settings Content -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Notifications Settings -->
            <div id="notifications" class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Notification Preferences</h2>
                    <p class="text-sm text-gray-600 mt-1">Choose how you want to be notified</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Email Notifications -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Email Notifications</h3>
                            <p class="text-sm text-gray-500">Receive email updates about your account</p>
                        </div>
                        <button 
                            type="button"
                            onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.classList.toggle('bg-indigo-600'); this.classList.toggle('bg-gray-200'); this.nextElementSibling.classList.toggle('translate-x-5'); this.nextElementSibling.classList.toggle('translate-x-0');"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ ($user->email_notifications ?? true) ? 'bg-indigo-600' : 'bg-gray-200' }}"
                            role="switch"
                            aria-checked="{{ ($user->email_notifications ?? true) ? 'true' : 'false' }}"
                        >
                            <input type="checkbox" name="email_notifications" class="sr-only" {{ ($user->email_notifications ?? true) ? 'checked' : '' }}>
                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ ($user->email_notifications ?? true) ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                    
                    <div class="border-t border-gray-200"></div>
                    
                    <!-- Comment Notifications -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Comment Notifications</h3>
                            <p class="text-sm text-gray-500">Get notified when someone comments on your snippets</p>
                        </div>
                        <button 
                            type="button"
                            onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.classList.toggle('bg-indigo-600'); this.classList.toggle('bg-gray-200'); this.nextElementSibling.classList.toggle('translate-x-5'); this.nextElementSibling.classList.toggle('translate-x-0');"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ ($user->comment_notifications ?? false) ? 'bg-indigo-600' : 'bg-gray-200' }}"
                            role="switch"
                            aria-checked="{{ ($user->comment_notifications ?? false) ? 'true' : 'false' }}"
                        >
                            <input type="checkbox" name="comment_notifications" class="sr-only" {{ ($user->comment_notifications ?? false) ? 'checked' : '' }}>
                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ ($user->comment_notifications ?? false) ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                    
                    <div class="border-t border-gray-200"></div>
                    
                    <!-- Marketing Emails -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Marketing Emails</h3>
                            <p class="text-sm text-gray-500">Receive updates about new features and tips</p>
                        </div>
                        <button 
                            type="button"
                            onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.classList.toggle('bg-indigo-600'); this.classList.toggle('bg-gray-200'); this.nextElementSibling.classList.toggle('translate-x-5'); this.nextElementSibling.classList.toggle('translate-x-0');"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ ($user->marketing_emails ?? false) ? 'bg-indigo-600' : 'bg-gray-200' }}"
                            role="switch"
                            aria-checked="{{ ($user->marketing_emails ?? false) ? 'true' : 'false' }}"
                        >
                            <input type="checkbox" name="marketing_emails" class="sr-only" {{ ($user->marketing_emails ?? false) ? 'checked' : '' }}>
                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ ($user->marketing_emails ?? false) ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Appearance Settings -->
            <div id="appearance" class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Appearance</h2>
                    <p class="text-sm text-gray-600 mt-1">Customize how the application looks</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Theme Selection -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Theme</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="theme" value="light" class="sr-only peer" {{ ($user->theme ?? 'system') == 'light' ? 'checked' : '' }}>
                                <div class="rounded-lg border-2 border-gray-200 p-4 hover:border-gray-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                    <div class="h-20 bg-white rounded border border-gray-200 mb-2"></div>
                                    <p class="text-sm text-center text-gray-600">Light</p>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="theme" value="dark" class="sr-only peer" {{ ($user->theme ?? 'system') == 'dark' ? 'checked' : '' }}>
                                <div class="rounded-lg border-2 border-gray-200 p-4 hover:border-gray-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                    <div class="h-20 bg-gray-800 rounded border border-gray-600 mb-2"></div>
                                    <p class="text-sm text-center text-gray-600">Dark</p>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="theme" value="system" class="sr-only peer" {{ ($user->theme ?? 'system') == 'system' ? 'checked' : '' }}>
                                <div class="rounded-lg border-2 border-gray-200 p-4 hover:border-gray-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                                    <div class="h-20 bg-gradient-to-r from-white to-gray-800 rounded border border-gray-200 mb-2"></div>
                                    <p class="text-sm text-center text-gray-600">System</p>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200"></div>
                    
                    <!-- Code Editor Theme -->
                    <div>
                        <label for="editor_theme" class="block text-sm font-medium text-gray-900">Code Editor Theme</label>
                        <select 
                            id="editor_theme" 
                            name="editor_theme"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                            <option value="github-dark" {{ ($user->editor_theme ?? 'github-dark') == 'github-dark' ? 'selected' : '' }}>GitHub Dark</option>
                            <option value="github-light" {{ ($user->editor_theme ?? 'github-dark') == 'github-light' ? 'selected' : '' }}>GitHub Light</option>
                            <option value="monokai" {{ ($user->editor_theme ?? 'github-dark') == 'monokai' ? 'selected' : '' }}>Monokai</option>
                            <option value="dracula" {{ ($user->editor_theme ?? 'github-dark') == 'dracula' ? 'selected' : '' }}>Dracula</option>
                            <option value="solarized-dark" {{ ($user->editor_theme ?? 'github-dark') == 'solarized-dark' ? 'selected' : '' }}>Solarized Dark</option>
                        </select>
                    </div>
                    
                    <!-- Tab Size -->
                    <div>
                        <label for="tab_size" class="block text-sm font-medium text-gray-900">Tab Size</label>
                        <select 
                            id="tab_size" 
                            name="tab_size"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                            <option value="2" {{ ($user->tab_size ?? 2) == 2 ? 'selected' : '' }}>2 spaces</option>
                            <option value="4" {{ ($user->tab_size ?? 2) == 4 ? 'selected' : '' }}>4 spaces</option>
                            <option value="8" {{ ($user->tab_size ?? 2) == 8 ? 'selected' : '' }}>8 spaces</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Privacy Settings -->
            <div id="privacy" class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Privacy</h2>
                    <p class="text-sm text-gray-600 mt-1">Control your privacy settings</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Profile Visibility -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Public Profile</h3>
                            <p class="text-sm text-gray-500">Allow others to view your profile</p>
                        </div>
                        <button 
                            type="button"
                            onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.classList.toggle('bg-indigo-600'); this.classList.toggle('bg-gray-200'); this.nextElementSibling.classList.toggle('translate-x-5'); this.nextElementSibling.classList.toggle('translate-x-0');"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ ($user->public_profile ?? true) ? 'bg-indigo-600' : 'bg-gray-200' }}"
                            role="switch"
                            aria-checked="{{ ($user->public_profile ?? true) ? 'true' : 'false' }}"
                        >
                            <input type="checkbox" name="public_profile" class="sr-only" {{ ($user->public_profile ?? true) ? 'checked' : '' }}>
                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ ($user->public_profile ?? true) ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                    
                    <div class="border-t border-gray-200"></div>
                    
                    <!-- Show Snippets in Public -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Public Snippets</h3>
                            <p class="text-sm text-gray-500">Allow your snippets to be visible to others</p>
                        </div>
                        <button 
                            type="button"
                            onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.classList.toggle('bg-indigo-600'); this.classList.toggle('bg-gray-200'); this.nextElementSibling.classList.toggle('translate-x-5'); this.nextElementSibling.classList.toggle('translate-x-0');"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ ($user->public_snippets ?? true) ? 'bg-indigo-600' : 'bg-gray-200' }}"
                            role="switch"
                            aria-checked="{{ ($user->public_snippets ?? true) ? 'true' : 'false' }}"
                        >
                            <input type="checkbox" name="public_snippets" class="sr-only" {{ ($user->public_snippets ?? true) ? 'checked' : '' }}>
                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ ($user->public_snippets ?? true) ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                    
                    <div class="border-t border-gray-200"></div>
                    
                    <!-- Analytics -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Usage Analytics</h3>
                            <p class="text-sm text-gray-500">Help us improve by sharing usage data</p>
                        </div>
                        <button 
                            type="button"
                            onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.classList.toggle('bg-indigo-600'); this.classList.toggle('bg-gray-200'); this.nextElementSibling.classList.toggle('translate-x-5'); this.nextElementSibling.classList.toggle('translate-x-0');"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ ($user->usage_analytics ?? false) ? 'bg-indigo-600' : 'bg-gray-200' }}"
                            role="switch"
                            aria-checked="{{ ($user->usage_analytics ?? false) ? 'true' : 'false' }}"
                        >
                            <input type="checkbox" name="usage_analytics" class="sr-only" {{ ($user->usage_analytics ?? false) ? 'checked' : '' }}>
                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ ($user->usage_analytics ?? false) ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- API Keys Section -->
            <div id="api" class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">API Keys</h2>
                        <p class="text-sm text-gray-600 mt-1">Manage your API keys for external access</p>
                    </div>
                </div>
                
                <div class="p-6">
                    <!-- Create New Key Form -->
                    <form action="{{ route('dashboard.api-keys.create') }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex gap-3">
                            <input 
                                type="text" 
                                name="name" 
                                placeholder="Key name (e.g., 'My App')"
                                required
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            >
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors"
                            >
                                Create New Key
                            </button>
                        </div>
                    </form>
                    
                    <!-- API Keys List -->
                    @if($apiKeys->count() > 0)
                        <div class="space-y-3">
                            @foreach($apiKeys as $key)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">{{ $key->name }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $key->key_prefix }}... • 
                                            Created {{ $key->created_at->format('M d, Y') }}
                                            @if($key->last_used_at)
                                                • Last used {{ $key->last_used_at->format('M d, Y') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('dashboard.api-keys.toggle', $key->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button 
                                                type="submit"
                                                class="px-3 py-1 text-xs font-medium rounded {{ $key->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}"
                                            >
                                                {{ $key->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('dashboard.api-keys.delete', $key->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this API key?')">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit"
                                                class="px-3 py-1 text-xs font-medium rounded bg-red-100 text-red-700 hover:bg-red-200"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No API keys yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Create an API key to access your snippets from external applications.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Save Button -->
            <div class="flex justify-end">
                <button 
                    type="submit"
                    class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                >
                    Save Settings
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
