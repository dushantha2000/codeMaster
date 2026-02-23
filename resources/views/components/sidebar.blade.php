{{-- 
    =================================================================
    Sidebar Component
    =================================================================
    Purpose: Dashboard sidebar navigation with menu items for
    authenticated users. Includes responsive mobile drawer.
    
    Props:
    - active: Current active route for highlighting
    =================================================================
--}}

@props([
    'active' => '',
])

<aside 
    id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out"
    aria-label="Sidebar"
>
    <div class="flex flex-col h-full">
        <!-- Logo / Brand Header -->
        <div class="flex items-center justify-between h-16 px-4 bg-gray-800 border-b border-gray-700">
            <a href="{{ url('dashboard.index') }}" class="flex items-center space-x-2">
                <svg class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                <span class="text-xl font-bold text-white">codeMaster</span>
            </a>
            
            <!-- Mobile Close Button -->
            <button 
                id="sidebar-close"
                class="md:hidden text-gray-400 hover:text-white"
                aria-label="Close sidebar"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Navigation Links -->
        <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
            <!-- Dashboard -->
            <a 
                href="{{ url('dashboard.index') }}"
                class="{{ $active === 'dashboard' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                aria-current="{{ $active === 'dashboard' ? 'page' : 'false' }}"
            >
                <svg class="{{ $active === 'dashboard' ? 'text-indigo-400' : 'text-gray-400 group-hover:text-indigo-400' }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
            
            <!-- My Snippets -->
            <a 
                href="{{ url('snippets.index') }}"
                class="{{ $active === 'snippets' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                aria-current="{{ $active === 'snippets' ? 'page' : 'false' }}"
            >
                <svg class="{{ $active === 'snippets' ? 'text-indigo-400' : 'text-gray-400 group-hover:text-indigo-400' }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                My Snippets
            </a>
            
            <!-- Categories -->
            <a 
                href="{{ url('categories.index') }}"
                class="{{ $active === 'categories' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                aria-current="{{ $active === 'categories' ? 'page' : 'false' }}"
            >
                <svg class="{{ $active === 'categories' ? 'text-indigo-400' : 'text-gray-400 group-hover:text-indigo-400' }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Categories
            </a>
            
            <!-- Divider -->
            <div class="pt-4 pb-2">
                <div class="border-t border-gray-700"></div>
            </div>
            
            <!-- Account Section -->
            <div class="px-3 py-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Account
                </p>
            </div>
            
            <!-- Profile -->
            <a 
                href="{{ route('dashboard.profile') }}"
                class="{{ $active === 'profile' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                aria-current="{{ $active === 'profile' ? 'page' : 'false' }}"
            >
                <svg class="{{ $active === 'profile' ? 'text-indigo-400' : 'text-gray-400 group-hover:text-indigo-400' }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile
            </a>
            
            <!-- Settings -->
            <a 
                href="{{ route('dashboard.settings') }}"
                class="{{ $active === 'settings' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                aria-current="{{ $active === 'settings' ? 'page' : 'false' }}"
            >
                <svg class="{{ $active === 'settings' ? 'text-indigo-400' : 'text-gray-400 group-hover:text-indigo-400' }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Settings
            </a>
            
            <!-- Admin Section (if user is admin) -->
            @auth
                @if(Auth::user()->is_admin ?? false)
                    <div class="pt-4 pb-2">
                        <div class="border-t border-gray-700"></div>
                    </div>
                    
                    <div class="px-3 py-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Administration
                        </p>
                    </div>
                    
                    <!-- Admin Dashboard -->
                    <a 
                        href="{{ route('admin.index') }}"
                        class="{{ $active === 'admin' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        aria-current="{{ $active === 'admin' ? 'page' : 'false' }}"
                    >
                        <svg class="{{ $active === 'admin' ? 'text-indigo-400' : 'text-gray-400 group-hover:text-indigo-400' }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Admin Panel
                    </a>
                    
                    <!-- Manage Users -->
                    <a 
                        href="{{ route('admin.users') }}"
                        class="{{ $active === 'admin-users' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        aria-current="{{ $active === 'admin-users' ? 'page' : 'false' }}"
                    >
                        <svg class="{{ $active === 'admin-users' ? 'text-indigo-400' : 'text-gray-400 group-hover:text-indigo-400' }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manage Users
                    </a>
                @endif
            @endauth
        </nav>
        
        <!-- User Info & Logout (Bottom) -->
        @auth
            <div class="border-t border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-gray-400 truncate">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                    <div class="ml-3">
                        <form method="POST" action="{{ url('logout') }}">
                            @csrf
                            <button 
                                type="submit" 
                                class="p-2 text-gray-400 hover:text-white transition-colors"
                                aria-label="Log out"
                            >
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</aside>
