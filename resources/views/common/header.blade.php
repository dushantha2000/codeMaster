<!-- Header -->
<header
    class="h-20 flex items-center  justify-between px-4 md:px-8 shrink-0  sticky top-0 z-30">
    <!-- Left side -->
    <div class="flex items-center gap-2 md:gap-2">
        <!-- Mobile menu button  -->
        <button @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden p-2 rounded-lg bg-white/5 border border-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>

        <!-- Logo -->
        <div class="w-10 h-10 bg-black-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile">
            <a href="{{ url('/') }}">CodeVault</a> <span class="text-blue-500 text-xs font-normal">v1.1</span>
        </h1>
    </div>

    
    <nav class="hidden lg:flex items-center self-stretch">
        <div class="flex items-center  px-1 py-1 shadow-2xl backdrop-blur-xl">
            <a href="{{ url('/my-snippets') }}" class="px-4 py-2 text-[11px] font-black  tracking-widest text-gray-400 hover:text-white hover:bg-white/5 ">
                Snippets
            </a>
           
            <a href="{{ url('/categories.index') }}" class="px-4 py-2 text-[11px] font-black  tracking-widest text-gray-400 hover:text-white hover:bg-white/5 rounded-full transition-all">
                Categories
            </a>
            
            <a href="{{ url('/profile') }}" class="px-4 py-2 text-[11px] font-black  tracking-widest text-gray-400 hover:text-white hover:bg-white/5 rounded-full transition-all">
                Partnerships
            </a>
        
            <a href="{{ url('/settings') }}" class="px-4 py-2 text-[11px] font-black  tracking-widest text-gray-400 hover:text-white hover:bg-white/5 rounded-full transition-all">
                Settings
            </a>
        </div>
    </nav>

    <!-- Right side -->
    <div class="flex items-center gap-2 md:gap-4">
        


        <!-- New button -->
        <a href="{{ url('snippets-create') }}"
            class="btn-primary px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span class="hide-on-mobile">New</span>
        </a>


        {{-- notifications --}}
        <div class="hidden md:flex items-center gap-1 mr-2" x-data="{ notificationsOpen: false, helpTooltip: false }">

            <div class="relative">
                <button @click="notificationsOpen = !notificationsOpen" @click.outside="notificationsOpen = false"
                    class="p-2 text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <span
                        class="absolute top-2 right-2.5 w-2 h-2 bg-blue-500 rounded-full border-2 border-[#0b0f15]"></span>
                </button>

                <div x-show="notificationsOpen" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    class="absolute top-full right-0 mt-3 w-80 glass-card rounded-2xl border border-white/10 shadow-2xl z-50 overflow-hidden">
                    <div class="p-4 border-b border-white/5 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-white">Notifications</h3>
                        <span class="text-[10px] bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded-full">2 New</span>
                    </div>
                    <div class="max-h-60 overflow-y-auto">
                        <div class="p-4 border-b border-white/5 hover:bg-white/5 transition-colors cursor-pointer">
                            <p class="text-xs text-white font-medium">New Category Created</p>
                            <p class="text-[10px] text-gray-500 mt-1">You created "Laravel Snippets" successfully.</p>
                        </div>
                        <div class="p-4 hover:bg-white/5 transition-colors cursor-pointer">
                            <p class="text-xs text-white font-medium">Welcome to CodeVault!</p>
                            <p class="text-[10px] text-gray-500 mt-1">Start organizing your code snippets today.</p>
                        </div>
                    </div>
                    <a href="#"
                        class="block p-3 text-center text-[10px] text-gray-400 hover:text-white bg-white/5 font-bold uppercase tracking-widest">View
                        All</a>
                </div>
            </div>

            <div class="relative">
                <button @mouseenter="helpTooltip = true" @mouseleave="helpTooltip = false"
                    class="p-2 text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.443 1.103m-2.435 4.1l.243.25h2.382l.243-.25c.34-.35.34-.917 0-1.267l-.243-.25H9.414l-.243.25c-.34.35-.34.917 0 1.267zM12 18h.01">
                        </path>
                    </svg>
                </button>

                <div x-show="helpTooltip"
                    class="absolute top-full right-0 mt-2 w-48 p-2 bg-gray-900 text-gray-300 text-[10px] rounded-lg border border-white/10 shadow-xl pointer-events-none z-50">
                    Click for Documentation & Keyboard Shortcuts
                </div>
            </div>
        </div>

        <!-- User menu -->
        <div class="relative ml-2" x-data="{ userMenuOpen: false }">
            <button @click="userMenuOpen = !userMenuOpen"
                class="flex items-center gap-2 p-1 pr-3 rounded-full bg-white/5 border border-white/10 hover:bg-white/10 transition-all">
                <div
                    class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-900/20 overflow-hidden">
                    @if (Auth::user()->profile_image)
                        <img src="{{ asset('profileImages/' . Auth::user()->profile_image) }}"
                            alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    @else

                        <span class="text-xs">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    @endif
                </div>
                <span class="text-sm text-gray-300 font-medium hide-on-mobile">{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 text-gray-500 transition-transform" :class="userMenuOpen ? 'rotate-180' : ''"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- User dropdown -->
            <div x-show="userMenuOpen" @click.outside="userMenuOpen = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                class="absolute top-full right-0 mt-2 w-48 glass-card rounded-xl border border-white/10 shadow-2xl z-50 py-2">
                <!-- Dropdown content -->
                <div class="px-4 py-2 border-b border-white/5 mb-1">
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Signed in as</p>
                    <p class="text-sm text-white truncate">{{ Auth::user()->name }}</p>
                </div>
                <a href="{{ url('/my-snippets') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                    </svg>
                    Snippets
                </a>

                <a href="{{ url('/categories.index') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Category
                </a>

                <a href="{{ url('/profile') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3.5" />
                    </svg>
                    Partnerships
                </a>



                <a href="{{ url('/settings') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z">
                        </path>
                    </svg>
                    Settings
                </a>
                <hr class="border-white/5 my-1">
                <form action="{{ url('/logout') }}" method="POST">
                    {{ csrf_field() }}
                    <button type="submit"
                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-400 hover:bg-red-500/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
