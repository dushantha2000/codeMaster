<!-- Preview Modal with Mobile Support -->
<div x-show="showPreview" class="fixed inset-0 z-50 overflow-hidden flex items-center justify-end p-0 md:p-4"
    x-cloak>
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity" x-show="showPreview"
        x-transition:enter="duration-500" x-transition:leave="duration-300" @click="showPreview = false"></div>

    <!-- Modal -->
    <div class="relative w-full md:max-w-5xl h-full md:h-[90vh] glass-card md:rounded-[2rem] shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-white/10 flex flex-col overflow-hidden"
        x-show="showPreview" x-transition:enter="transform transition duration-500 ease-out"
        x-transition:enter-start="translate-x-full opacity-0 scale-95"
        x-transition:enter-end="translate-x-0 opacity-100 scale-100"
        x-transition:leave="transform transition duration-300 ease-in"
        x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0">

        <!-- Header -->
        <div
            class="h-16 md:h-20 flex items-center justify-between px-4 md:px-8 bg-white/[0.02] border-b border-white/5">
            <div class="flex items-center gap-2 md:gap-4">
                <!-- Mobile File Toggle Button -->
                <button @click="mobileFileListOpen = !mobileFileListOpen"
                    class="md:hidden p-2 bg-white/5 rounded-lg border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="p-2 md:p-3 bg-blue-500/10 rounded-xl md:rounded-2xl border border-blue-500/20">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base md:text-xl font-bold text-white tracking-tight max-w-[150px] md:max-w-none truncate"
                        x-text="selectedSnippet?.title"></h2>
                    <p class="text-[8px] md:text-[10px] text-gray-500 font-mono uppercase tracking-widest"
                        x-text="selectedSnippet?.language + ' - ' + selectedSnippet?.files?.length + ' files'"></p>
                </div>
            </div>
            <button @click="showPreview = false"
                class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center bg-white/5 text-gray-400 hover:text-white hover:bg-red-500/20 transition-all border border-white/10">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="flex-1 flex overflow-hidden relative">
            <!-- File List Sidebar - Always visible on desktop -->
            <aside
                :class="mobileFileListOpen ? 'absolute left-0 top-0 bottom-0 w-64 bg-black/95 z-10' :
                    'hidden md:block md:relative md:w-64 md:bg-black/40'"
                class="border-r border-white/5 p-4 md:p-6 overflow-y-auto custom-mini-scrollbar">

                <!-- Mobile Header -->
                <div x-show="mobileFileListOpen" class="flex items-center justify-between mb-4 md:hidden">
                    <div class="text-[10px] font-bold text-gray-600 uppercase tracking-tighter">PROJECT FILES</div>
                    <button @click="mobileFileListOpen = false" class="p-1 bg-white/5 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Desktop Header -->
                <div class="hidden md:flex items-center justify-between mb-4">
                    <div class="text-[10px] font-bold text-gray-600 uppercase tracking-tighter">PROJECT FILES</div>
                    <span class="text-xs px-2 py-1 rounded-full bg-white/10 text-gray-300"
                        x-text="selectedSnippet?.files?.length + ' files'"></span>
                </div>

                <!-- Files List (same for mobile & desktop) -->
                <nav class="space-y-1.5">
                    <template x-for="(file, index) in selectedSnippet?.files" :key="index">
                        <button
                            @click="activeFileTab = index; mobileFileListOpen = false; $nextTick(() => { Prism.highlightAll(); })"
                            :class="activeFileTab === index ?
                                'bg-blue-600/10 text-blue-400 border-blue-500/50 shadow-[0_0_15px_rgba(59,130,246,0.1)]' :
                                'text-gray-500 border-transparent hover:text-gray-300 hover:bg-white/5'"
                            class="w-full text-left px-3 md:px-4 py-2.5 md:py-3 rounded-lg md:rounded-xl text-xs md:text-[11px] font-mono border transition-all flex items-center justify-between group">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="text-sm md:text-base" x-text="getFileIcon(file.file_name)"></span>
                                <span class="truncate" x-text="file.file_name"></span>
                            </div>
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 opacity-0 group-hover:opacity-100"
                                x-show="activeFileTab === index"></div>
                        </button>
                    </template>
                </nav>

                <!-- File count for mobile -->
                <div class="mt-4 pt-4 border-t border-white/5 md:hidden" x-show="mobileFileListOpen">
                    <span class="text-xs text-gray-400">
                        Total: <span class="text-white font-bold" x-text="selectedSnippet?.files?.length"></span>
                        files
                    </span>
                </div>
            </aside>

            <!-- Code Display -->
            <div class="flex-1 flex flex-col bg-[#050505]/60">
                <template x-for="(file, index) in selectedSnippet?.files" :key="index">
                    <div x-show="activeFileTab === index" class="h-full flex flex-col p-3 md:p-6"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">

                        <!-- File Info Bar -->
                        <div
                            class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-3 md:mb-4 bg-white/5 px-3 md:px-4 py-2 rounded-lg border border-white/5">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="text-gray-400">📄</span>
                                <span class="text-white font-mono text-xs md:text-sm truncate max-w-[150px] md:max-w-none"
                                    x-text="file.file_name"></span>
                            </div>
                            <div class="flex items-center gap-3 text-[10px] md:text-xs">
                                <span class="text-gray-400">
                                    <span class="md:hidden">📊</span>
                                    <span class="hidden md:inline">Size:</span>
                                    <span class="text-white ml-1"
                                        x-text="(file.content?.length || 0) + ' chars'"></span>
                                </span>
                                <span class="text-gray-600">|</span>
                                <span class="text-gray-400">
                                    <span class="md:hidden">📏</span>
                                    <span class="hidden md:inline">Lines:</span>
                                    <span class="text-white ml-1"
                                        x-text="(file.content?.split('\n').length || 0)"></span>
                                </span>
                            </div>
                        </div>

                        <!-- Code Container -->
                        <div
                            class="flex-1 bg-black/40 rounded-xl border border-white/5 overflow-hidden relative group">
                            <!-- Copy Button -->
                            <button @click="copyCode(file.content)"
                                class="absolute right-2 md:right-4 top-2 md:top-4 z-10 px-2 md:px-3 py-1 md:py-1.5 rounded-lg border border-white/10 bg-white/5 hover:bg-white/10 transition-all flex items-center gap-1 md:gap-2 text-[10px] md:text-xs">
                                <span x-show="!copyDone">📋</span>
                                <span x-show="!copyDone" class="hidden md:inline">Copy</span>
                                <span x-show="copyDone">✅</span>
                                <span x-show="copyDone" class="hidden md:inline">Copied!</span>
                            </button>

                            <!-- Code with proper wrapping -->
                            <pre class="h-full overflow-auto p-3 md:p-6 !m-0 !bg-transparent custom-scrollbar text-[11px] md:text-sm"><code :class="'language-' + (selectedSnippet?.language?.toLowerCase() || 'javascript')" 
                  class="!whitespace-pre-wrap !break-words !font-mono leading-relaxed"
                  x-text="file.content"></code></pre>
                        </div>
                    </div>
                </template>

                <!-- Empty State -->
                <div x-show="!selectedSnippet?.files?.length" class="flex-1 flex items-center justify-center p-6">
                    <div class="text-center">
                        <div class="text-4xl mb-3">📁</div>
                        <p class="text-gray-400 text-sm">No files available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>