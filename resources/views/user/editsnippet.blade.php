@extends('user.master')

@section('title', 'Edit')

@section('content')
<body class="text-gray-100" x-data="snippetEditor()" x-cloak>
        <form action="{{ url('/snippets/update', $snippet->id) }}" method="POST" class="h-full flex flex-col">
            {{ csrf_field() }}

            <!-- Header -->
            <header
                class="h-20 flex items-center justify-between px-4 md:px-8 shrink-0 glass-card border-b border-white/5 gap-4">

                <div class="flex items-center gap-3 md:gap-4 shrink-0">
                    <button type="button" @click="toggleMobileSidebar"
                        class="md:hidden p-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 bg-black-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile"><a
                                href="{{ url('/') }}">CodeVault</a> <span
                                class="text-blue-500 text-xs font-normal">v1.0</span>
                        </h1>
                    </div>
                </div>

                <div class="flex-1 flex items-center justify-center gap-3 max-w-2xl px-2 min-w-0">
                    <div class="relative flex-1 min-w-0 max-w-[280px] md:max-w-none">
                        <input type="text" name="title" value="{{ $snippet->title }}" required
                            placeholder="Project name..."
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm md:text-base font-bold text-white placeholder-gray-600 outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all">
                    </div>

                    <div class="relative flex-1 hidden lg:block group min-w-0">
                        <input type="text" name="description" value="{{ $snippet->description }}" required
                            placeholder="Brief description..."
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm font-medium text-gray-400 placeholder-gray-700 outline-none focus:border-white/20 transition-all cursor-help">
                        <!-- Tooltip for long descriptions -->
                        <div x-show="'{{ $snippet->description }}'.length > 50" 
                            class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 hidden group-hover:block w-64 bg-gray-900 text-white text-xs rounded-lg px-3 py-2 shadow-xl border border-white/10 z-50 pointer-events-none">
                            <div class="break-words">{{ $snippet->description }}</div>
                            <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                <div class="border-4 border-transparent border-t-gray-900"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 md:gap-3 shrink-0">
                    <div class="relative hidden sm:block">
                        <select name="language"
                            class="appearance-none bg-gray-900 border border-white/10 rounded-xl px-4 py-2.5 pr-10 text-xs font-bold text-white outline-none hover:bg-gray-800 focus:border-blue-500/40 transition-all cursor-pointer">
                            <option value="laravel" {{ $snippet->language == 'laravel' ? 'selected' : '' }}>🔸 Laravel
                            </option>
                            <option value="php" {{ $snippet->language == 'php' ? 'selected' : '' }}>🐘 PHP</option>
                            <option value="javascript" {{ $snippet->language == 'javascript' ? 'selected' : '' }}>📜 JS
                            </option>
                            <option value="python" {{ $snippet->language == 'python' ? 'selected' : '' }}>🐍 Python</option>
                            <option value="html" {{ $snippet->language == 'html' ? 'selected' : '' }}>🌐 HTML</option>
                            <option value="css" {{ $snippet->language == 'css' ? 'selected' : '' }}>🎨 CSS</option>
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 border-l border-white/10 pl-2 md:pl-4">
                        <button type="button" @click="showSettings = true"
                            class="hidden md:flex p-2.5 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-blue-500/30 transition-all group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </button>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-500 text-white px-4 md:px-6 py-2.5 rounded-xl font-bold text-xs md:text-sm transition-all flex items-center gap-2 shadow-lg shadow-blue-600/20 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="hidden md:inline">Save Changes</span>
                        </button>

                        <a href="{{ url('/my-snippets') }}"
                            class="p-2.5 rounded-xl border border-white/10 bg-white/5 text-gray-400 hover:text-white hover:bg-white/10 transition-all group">
                            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div
                    class="mx-4 md:mx-8 mt-4 p-4 bg-green-500/10 border border-green-500/20 rounded-lg text-green-400 text-sm md:text-base">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mx-4 md:mx-8 mt-4 p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-400 text-sm md:text-base">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Mobile Overlay -->
            <div class="mobile-overlay" :class="{ 'show': mobileMenuOpen }" @click="toggleMobileSidebar"></div>

            <!-- Main Content Area -->
            <div class="flex-1 flex overflow-hidden p-2 md:p-4 gap-2 md:gap-4">

                <!-- Sidebar - Files List -->
                <aside
                    class="sidebar-container w-80 glass-card rounded-xl md:rounded-2xl flex flex-col overflow-hidden shadow-2xl"
                    :class="{ 'mobile-open': mobileMenuOpen }">
                    <!-- Sidebar Header -->
                    <div class="p-4 md:p-5 border-b border-white/5 bg-white/5">
                        <div class="flex justify-between items-center mb-3 md:mb-4">
                            <h2
                                class="text-xs md:text-sm font-bold uppercase tracking-wider text-gray-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                    </path>
                                </svg>
                                Files
                            </h2>
                            <div class="flex items-center gap-2">
                                <span class="text-xs px-2 py-1 rounded-full bg-white/10 text-gray-300 font-semibold"
                                    x-text="files.length"></span>
                                <button type="button" @click="toggleMobileSidebar"
                                    class="md:hidden p-1.5 rounded-lg hover:bg-white/10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="button" @click="showAddFileModal = true; mobileMenuOpen = false"
                            class="w-full bg-white/10 hover:bg-white/15 border border-white/10 text-white px-3 md:px-4 py-2.5 md:py-3 rounded-xl font-semibold text-xs md:text-sm transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Add File
                        </button>
                    </div>

                    <!-- Files List -->
                    <div class="flex-1 overflow-y-auto p-2 md:p-3 space-y-2 custom-scrollbar">
                        <template x-for="(file, index) in files" :key="index">
                            <div @click="activeTab = index; mobileMenuOpen = false"
                                :class="activeTab === index ? 'tab-active text-white scale-105' :
                                    'bg-white/5 text-gray-400 hover:bg-white/10'"
                                class="file-item flex items-center justify-between p-3 md:p-4 rounded-xl cursor-pointer group transition-all">
                                <div class="flex items-center gap-2 md:gap-3 flex-1 min-w-0">
                                    <div class="text-xl md:text-2xl shrink-0" x-text="getFileIcon(file.name)">📄</div>
                                    <div class="flex-1 min-w-0">
                                        <div x-text="file.name || 'untitled.php'"
                                            class="text-xs md:text-sm font-semibold truncate"></div>
                                        <div x-text="file.path || 'root'"
                                            class="text-[10px] md:text-xs opacity-60 truncate"></div>
                                    </div>
                                </div>
                                <button type="button" @click.stop="confirmDelete(index)" x-show="files.length > 1"
                                    class="ml-2 opacity-0 group-hover:opacity-100 md:opacity-100 text-gray-400 hover:text-red-400 p-1.5 rounded-lg hover:bg-white/10 transition-all shrink-0">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </aside>

                <!-- Main Editor Area -->
                <main class="flex-1 glass-card rounded-xl md:rounded-2xl flex flex-col overflow-hidden shadow-2xl">
                    <template x-for="(file, index) in files" :key="index">
                        <div x-show="activeTab === index" class="h-full flex flex-col">
                            <!-- File Metadata -->
                            <div class="p-4 md:p-6 border-b border-white/5 bg-white/5">
                                <div class="file-meta-mobile grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                    <div>
                                        <label
                                            class="text-[10px] md:text-xs font-bold text-gray-400 block mb-2 flex items-center gap-2">
                                            <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            File Name
                                        </label>
                                        <input type="text" x-model="file.name" name="file_names[]" required
                                            placeholder="e.g. UserController.php"
                                            class="w-full bg-white/5 border border-white/10 rounded-lg px-3 md:px-4 py-2 md:py-2.5 text-xs md:text-sm focus:border-white/30 focus:bg-white/10 outline-none transition-all">
                                    </div>
                                    <div>
                                        <label
                                            class="text-[10px] md:text-xs font-bold text-gray-400 block mb-2 flex items-center gap-2">
                                            <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                                </path>
                                            </svg>
                                            File Path
                                        </label>
                                        <input type="text" x-model="file.path" name="file_paths[]" required
                                            placeholder="e.g. app/Http/Controllers"
                                            class="w-full bg-white/5 border border-white/10 rounded-lg px-3 md:px-4 py-2 md:py-2.5 text-xs md:text-sm focus:border-white/30 focus:bg-white/10 outline-none transition-all">
                                    </div>
                                </div>

                                <!-- Quick Stats -->
                                <div class="flex gap-4 md:gap-6 mt-3 md:mt-4 text-[10px] md:text-xs text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16m-7 6h7"></path>
                                        </svg>
                                        <span x-text="(file.content || '').split('\n').length + ' lines'"></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        <span x-text="(file.content || '').length + ' chars'"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Code Editor -->
                            <div class="flex-1 relative code-editor overflow-hidden">
                                <textarea name="contents[]" x-model="file.content" @input="updateStats" required
                                    class="absolute inset-0 w-full h-full bg-transparent p-4 pl-10 md:p-8 md:pl-16 code-font text-xs md:text-sm text-green-400 outline-none resize-none leading-[1.5]"
                                    placeholder="// Start coding...&#10;// Enjoy! 🚀" spellcheck="false"></textarea>

                                <!-- Line Numbers -->
                                <div x-show="showLineNumbers"
                                    class="absolute left-0 top-0 bottom-0 w-8 md:w-12 bg-black/30 border-r border-white/5 text-gray-600 text-[10px] md:text-xs code-font pt-4 md:pt-8 pr-2 select-none pointer-events-none overflow-hidden">
                                    <template x-for="(line, i) in (file.content || '').split('\n')" :key="i">
                                        <div class="text-right leading-[1.5] h-[1.5em]" x-text="i + 1"></div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </main>
            </div>
        </form>

        <!-- Add File Modal -->
        <div x-show="showAddFileModal" x-cloak @click.self="showAddFileModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center modal-backdrop p-4">
            <div @click.away="showAddFileModal = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="modal-mobile glass-card rounded-2xl p-6 md:p-8 w-full max-w-md shadow-2xl border border-white/10">

                <div class="flex items-center justify-between mb-4 md:mb-6">
                    <h3 class="text-xl md:text-2xl font-bold flex items-center gap-2 md:gap-3">
                        <div class="bg-white/10 backdrop-blur-sm p-2 rounded-lg border border-white/10">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                        </div>
                        <span class="text-base md:text-2xl">New File</span>
                    </h3>
                    <button @click="showAddFileModal = false"
                        class="text-gray-400 hover:text-white p-2 rounded-lg hover:bg-white/10 transition-all">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4 md:space-y-5">
                    <div>
                        <label class="text-xs md:text-sm font-semibold text-gray-300 block mb-2">File Name</label>
                        <input type="text" x-model="newFile.name" @keyup.enter="addFile" required placeholder="e.g. index.php"
                            class="w-full bg-white/5 border border-white/10 rounded-lg px-3 md:px-4 py-2.5 md:py-3 text-sm md:text-base outline-none focus:border-white/30 focus:bg-white/10 transition-all">
                    </div>

                    <div>
                        <label class="text-xs md:text-sm font-semibold text-gray-300 block mb-2">File Path
                            (Optional)</label>
                        <input type="text" x-model="newFile.path" @keyup.enter="addFile" required
                            placeholder="e.g. src/components"
                            class="w-full bg-white/5 border border-white/10 rounded-lg px-3 md:px-4 py-2.5 md:py-3 text-sm md:text-base outline-none focus:border-white/30 focus:bg-white/10 transition-all">
                    </div>

                    <!-- Quick Templates -->
                    <div>
                        <label class="text-xs md:text-sm font-semibold text-gray-300 block mb-2 md:mb-3">Quick
                            Templates</label>
                        <div class="grid grid-cols-3 gap-2">
                            <button type="button" @click="newFile.name = 'index.php'"
                                class="px-2 md:px-3 py-2 bg-white/5 hover:bg-white/10 rounded-lg text-[10px] md:text-xs font-semibold transition-all border border-white/10 hover:border-white/20">
                                PHP
                            </button>
                            <button type="button" @click="newFile.name = 'script.js'"
                                class="px-2 md:px-3 py-2 bg-white/5 hover:bg-white/10 rounded-lg text-[10px] md:text-xs font-semibold transition-all border border-white/10 hover:border-white/20">
                                JS
                            </button>
                            <button type="button" @click="newFile.name = 'style.css'"
                                class="px-2 md:px-3 py-2 bg-white/5 hover:bg-white/10 rounded-lg text-[10px] md:text-xs font-semibold transition-all border border-white/10 hover:border-white/20">
                                CSS
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-6 md:mt-8">
                    <button type="button" @click="showAddFileModal = false"
                        class="flex-1 bg-white/5 hover:bg-white/10 text-white px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-sm md:text-base font-semibold transition-all border border-white/10">
                        Cancel
                    </button>
                    <button type="button" @click="addFile"
                        class="flex-1 btn-primary text-white px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-sm md:text-base font-semibold transition-all">
                        Create
                    </button>
                </div>
            </div>
        </div>

        <!-- Settings Modal -->
        <div x-show="showSettings" x-cloak @click.self="showSettings = false"
            class="fixed inset-0 z-50 flex items-center justify-center modal-backdrop p-4">
            <div @click.away="showSettings = false" x-transition
                class="modal-mobile glass-card rounded-2xl p-6 md:p-8 w-full max-w-lg shadow-2xl border border-white/10">

                <h3 class="text-xl md:text-2xl font-bold mb-4 md:mb-6 flex items-center gap-2 md:gap-3">
                    <div class="bg-white/10 backdrop-blur-sm p-2 rounded-lg border border-white/10">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                        </svg>
                    </div>
                    Settings
                </h3>

                <div class="space-y-3 md:space-y-4">
                    <div class="flex items-center justify-between p-3 md:p-4 bg-white/5 rounded-lg border border-white/5">
                        <span class="text-sm md:text-base font-semibold">Line Numbers</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="showLineNumbers" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-white/10 peer-focus:ring-2 peer-focus:ring-white/20 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-white/30">
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-3 md:p-4 bg-white/5 rounded-lg border border-white/5">
                        <span class="text-sm md:text-base font-semibold">Auto-save</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="autoSave" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-white/10 peer-focus:ring-2 peer-focus:ring-white/20 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-white/30">
                            </div>
                        </label>
                    </div>
                </div>

                <button @click="showSettings = false"
                    class="w-full btn-primary text-white px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-sm md:text-base font-semibold mt-4 md:mt-6 transition-all">
                    Close
                </button>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="deleteConfirm !== null" x-cloak @click.self="deleteConfirm = null"
            class="fixed inset-0 z-50 flex items-center justify-center modal-backdrop p-4">
            <div x-transition
                class="modal-mobile glass-card rounded-2xl p-6 md:p-8 w-full max-w-md shadow-2xl border border-white/10">

                <div class="text-center">
                    <div
                        class="mx-auto w-12 h-12 md:w-16 md:h-16 bg-red-500/10 rounded-full flex items-center justify-center mb-3 md:mb-4 border border-red-500/20">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-lg md:text-xl font-bold mb-2">Delete File?</h3>
                    <p class="text-sm md:text-base text-gray-400 mb-4 md:mb-6">This action cannot be undone.</p>

                    <div class="flex gap-3">
                        <button @click="deleteConfirm = null"
                            class="flex-1 bg-white/5 hover:bg-white/10 text-white px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-sm md:text-base font-semibold transition-all border border-white/10">
                            Cancel
                        </button>
                        <button @click="removeFile(deleteConfirm)"
                            class="flex-1 bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-sm md:text-base font-semibold transition-all border border-red-500/30">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function snippetEditor() {
                return {
                    activeTab: 0,
                    showAddFileModal: false,
                    showSettings: false,
                    showLineNumbers: true,
                    autoSave: false,
                    deleteConfirm: null,
                    mobileMenuOpen: false,
                    newFile: {
                        name: '',
                        path: '',
                        content: ''
                    },
                    files: {!! json_encode(
                        $snippet->files->map(function ($file) {
                                return [
                                    'name' => $file->file_name,
                                    'path' => $file->file_path,
                                    'content' => $file->content,
                                ];
                            })->toArray(),
                    ) !!},

                    init() {
                        // Keyboard shortcuts
                        document.addEventListener('keydown', (e) => {
                            // Ctrl/Cmd + S to save
                            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                                e.preventDefault();
                                this.$el.querySelector('form').dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
                            }
                            
                            // Ctrl/Cmd + N for new file
                            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                                e.preventDefault();
                                this.showAddFileModal = true;
                            }

                            // Escape to close modals
                            if (e.key === 'Escape') {
                                this.showAddFileModal = false;
                                this.showSettings = false;
                                this.deleteConfirm = null;
                            }
                        });
                    },

                    toggleMobileSidebar() {
                        this.mobileMenuOpen = !this.mobileMenuOpen;
                    },

                    addFile() {
                        if (!this.newFile.name.trim()) {
                            this.newFile.name = 'untitled.php';
                        }

                        this.files.push({
                            name: this.newFile.name,
                            path: this.newFile.path,
                            content: this.newFile.content || ''
                        });

                        this.activeTab = this.files.length - 1;
                        this.showAddFileModal = false;

                        // Reset modal
                        this.newFile = {
                            name: '',
                            path: '',
                            content: ''
                        };
                    },

                    confirmDelete(index) {
                        this.deleteConfirm = index;
                    },

                    removeFile(index) {
                        if (this.files.length > 1) {
                            this.files.splice(index, 1);
                            this.activeTab = Math.max(0, index - 1);
                        }
                        this.deleteConfirm = null;
                    },

                    getFileIcon(filename) {
                        if (!filename) return '📄';

                        const ext = filename.split('.').pop().toLowerCase();
                        const icons = {
                            'php': '🐘',
                            'js': '📜',
                            'jsx': '⚛️',
                            'ts': '📘',
                            'tsx': '⚛️',
                            'css': '🎨',
                            'html': '🌐',
                            'json': '📋',
                            'md': '📝',
                            'py': '🐍',
                            'sql': '🗄️',
                            'vue': '💚',
                            'xml': '📰',
                            'java': '☕',
                            'cpp': '⚙️',
                            'c': '⚙️',
                            'rb': '💎',
                            'go': '🔷',
                            'rs': '🦀'
                        };

                        return icons[ext] || '📄';
                    },

                    updateStats() {
                        if (this.autoSave) {
                            // Implement auto-save
                        }
                    }
                }
            }
        </script>
        <script>
            setTimeout(function() {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 3000);
        </script>
</body>

@endsection

<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Ensure proper responsive behavior */
    @media (max-width: 768px) {
        .hide-on-mobile {
            display: none !important;
        }
        
        .modal-mobile {
            max-height: 90vh;
            overflow-y: auto;
        }
    }

    /* Line numbers and textarea sync */
    .code-editor textarea {
        line-height: 1.5;
        font-family: 'Courier New', monospace;
    }

    /* Mobile sidebar */
    .sidebar-container {
        transition: transform 0.3s ease;
    }

    @media (max-width: 768px) {
        .sidebar-container {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 40;
            transform: translateX(-100%);
        }

        .sidebar-container.mobile-open {
            transform: translateX(0);
        }

        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 30;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .mobile-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }
    }

    /* Smooth transitions */
    * {
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    /* Prevent layout shift on modal open */
    body.modal-open {
        overflow: hidden;
    }
</style>