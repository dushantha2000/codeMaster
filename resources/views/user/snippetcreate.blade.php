@extends('layout.snippet')

@section('title', 'My Profile')

@section('content')

    <body class="text-gray-100" x-data="snippetEditor()" x-cloak>

        <form action="{{ url('/snippet-store') }}" method="POST" class="h-full flex flex-col">
            {{ csrf_field() }}

            <!-- Hidden inputs for project metadata -->
            <input type="hidden" name="title" x-model="projectInfo.title">
            <input type="hidden" name="description" x-model="projectInfo.description">
            <input type="hidden" name="language" x-model="projectInfo.language">
            <input type="hidden" name="category" x-model="projectInfo.category">

            <!-- Modern Header -->
            <header
                class="h-16 flex items-center justify-between px-4 md:px-8 shrink-0 bg-[#030303] border-b border-white/5 gap-4">

                <div class="flex items-center gap-3 md:gap-4 shrink-0">
                    <button type="button" @click="toggleMobileSidebar"
                        class="md:hidden p-2 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 transition-all">
                        <svg class="w-5 h-5 text-[#A1A1AA]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="flex items-center gap-3">
                        <div
                            class="w-7 h-7 bg-white/5 rounded-lg flex items-center justify-center border border-white/10">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h1 class="text-base font-semibold text-[#EDEDED] tracking-tight hide-on-mobile">
                            <a href="{{ url('/') }}" class="hover:text-white transition-colors">codevault</a>
                            <span class="text-blue-500/60 text-2xs ml-1 font-medium tracking-normal">pro</span>
                        </h1>
                    </div>
                </div>

                <!-- Project Info Display (Center) -->
                <div class="flex-1 flex items-center justify-center gap-2 md:gap-3 max-w-2xl px-2 min-w-0">
                    <div class="text-center min-w-0 flex-1">
                        <h2 class="text-sm md:text-base font-medium text-[#EDEDED] truncate px-2"
                            x-text="projectInfo.title || 'untitled project'"></h2>
                        <div class="hidden md:block relative group">
                            <p class="text-2xs text-[#71717A] truncate px-2 cursor-help"
                                x-text="projectInfo.description || 'no description'"></p>
                            <!-- Tooltip for long descriptions -->
                            <div x-show="projectInfo.description && projectInfo.description.length > 50"
                                class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 hidden group-hover:block w-64 bg-[#121212] text-[#EDEDED] text-xs rounded-lg px-3 py-2 shadow-2xl border border-white/10 z-50 pointer-events-none">
                                <div class="break-words" x-text="projectInfo.description"></div>
                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                    <div class="border-4 border-transparent border-t-[#121212]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" @click="showProjectModal = true"
                        class="p-1.5 rounded-md bg-white/5 border border-white/10 hover:bg-white/10 transition-all group shrink-0">
                        <svg class="w-3.5 h-3.5 text-[#71717A] group-hover:text-[#EDEDED] transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center gap-2 md:gap-3 shrink-0">
                    <div class="flex items-center gap-2 border-l border-white/10 pl-2 md:pl-3">
                        <button type="submit"
                            class="btn-primary px-4 py-1.5 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="hidden md:inline text-xs font-semibold">deploy</span>
                        </button>

                        <a href="{{ url('/dashboard') }}"
                            class="p-1.5 rounded-md border border-white/10 bg-white/5 text-[#71717A] hover:text-[#EDEDED] transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Mobile Overlay -->
            <div class="mobile-overlay" :class="{ 'show': mobileMenuOpen }" @click="toggleMobileSidebar"></div>

            <!-- Main Content Area -->
            <div class="flex-1 flex overflow-hidden p-2 md:p-4 gap-2 md:gap-4">

                <!-- Sidebar - Files List -->
                <aside
                    class="sidebar-container w-72 glass-card rounded-xl flex flex-col overflow-hidden shadow-2xl"
                    :class="{ 'mobile-open': mobileMenuOpen }">
                    <!-- Sidebar Header -->
                    <div class="p-6 border-b border-white/5 bg-white/[0.01]">
                        <div class="flex justify-between items-center mb-6">
                            <h2
                                class="text-3xs font-bold tracking-normal text-[#3F3F46] flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                    </path>
                                </svg>
                                logic nodes
                            </h2>
                            <div class="flex items-center gap-2">
                                <span class="text-2xs px-2 py-0.5 rounded-md bg-blue-500/10 text-blue-400 font-bold border border-blue-500/20"
                                    x-text="files.length"></span>
                            </div>
                        </div>

                        <button type="button" @click="showAddFileModal = true; mobileMenuOpen = false"
                            class="w-full bg-white/5 hover:bg-white/10 border border-white/5 text-[#EDEDED] px-4 py-3 rounded-xl font-bold text-2xs tracking-normal transition-all flex items-center justify-center gap-2 shadow-xl">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            add node
                        </button>
                    </div>

                    <!-- Files List -->
                    <div class="flex-1 overflow-y-auto p-3 space-y-2 custom-scrollbar">
                        <template x-for="(file, index) in files" :key="index">
                            <div @click="activeTab = index; mobileMenuOpen = false"
                                :class="activeTab === index ? 'bg-blue-500/5 text-[#EDEDED] border-blue-500/20 shadow-[0_0_20px_rgba(168,85,247,0.05)]' :
                                    'text-[#3F3F46] hover:bg-white/[0.02] hover:text-[#71717A] border-transparent'"
                                class="file-item flex items-center justify-between p-3 rounded-xl cursor-pointer group transition-all border">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="text-xl shrink-0 transition-all duration-300" 
                                         :class="activeTab === index ? 'opacity-100 scale-110' : 'opacity-40 grayscale group-hover:opacity-60 group-hover:grayscale-0'"
                                         x-text="getFileIcon(file.name)">📄</div>
                                    <div class="flex-1 min-w-0">
                                        <div x-text="file.name || 'untitled.php'"
                                            class="text-2xs font-bold truncate tracking-tight"></div>
                                        <div x-text="file.path || 'root'"
                                            class="text-3xs opacity-40 truncate font-mono tracking-tighter"
                                            :class="activeTab === index ? 'text-blue-400' : ''"></div>
                                    </div>
                                </div>
                                <button type="button" @click.stop="confirmDelete(index)" x-show="files.length > 1"
                                    class="opacity-0 group-hover:opacity-100 text-[#3F3F46] hover:text-red-400 p-1.5 rounded-lg hover:bg-red-400/10 transition-all shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
v>
                </aside>

                <!-- Main Editor Area -->
                <main class="flex-1 glass-card rounded-xl md:rounded-2xl flex flex-col overflow-hidden shadow-2xl">
                    <template x-for="(file, index) in files" :key="index">
                        <div x-show="activeTab === index" class="h-full flex flex-col">
                            <!-- File Metadata -->
                            <div class="p-6 md:p-8 border-b border-white/5 bg-white/[0.01]">
                                <div class="file-meta-mobile grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                                    <div>
                                        <label
                                            class="text-3xs font-black text-[#3F3F46] uppercase tracking-[0.2em] block mb-3 flex items-center gap-2 ml-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            node identity
                                        </label>
                                        <input type="text" x-model="file.name" name="file_names[]" required
                                            placeholder="e.g. UserController.php"
                                            class="w-full bg-[#050505] border border-white/5 rounded-2xl px-5 py-3.5 text-xs text-[#EDEDED] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/40 outline-none transition-all placeholder-[#3F3F46] shadow-inner">
                                    </div>
                                    <div>
                                        <label
                                            class="text-3xs font-black text-[#3F3F46] uppercase tracking-[0.2em] block mb-3 flex items-center gap-2 ml-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                                </path>
                                            </svg>
                                            namespace path
                                        </label>
                                        <input type="text" x-model="file.path" name="file_paths[]"
                                            placeholder="e.g. app/Http/Controllers" required
                                            class="w-full bg-[#050505] border border-white/5 rounded-2xl px-5 py-3.5 text-xs text-[#EDEDED] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/40 outline-none transition-all placeholder-[#3F3F46] shadow-inner">
                                    </div>
                                </div>

                                <!-- Quick Stats -->
                                <div class="flex gap-6 mt-6 text-3xs text-[#3F3F46] font-black uppercase tracking-[0.2em] ml-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M4 6h16M4 12h16m-7 6h7"></path>
                                        </svg>
                                        <span x-text="(file.content || '').split('\n').length + ' lines'"></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        <span x-text="(file.content || '').length + ' bytes'"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Code Editor -->
                            <div class="flex-1 relative bg-[#030303] overflow-hidden">
                                <textarea name="contents[]" x-model="file.content" @input="updateStats" required
                                    class="absolute inset-0 w-full h-full bg-transparent p-6 pl-14 code-font text-[13px] text-[#A1A1AA] focus:text-[#EDEDED] outline-none resize-none leading-[1.6] transition-colors"
                                    placeholder="// Initialize logic stream...&#10;// Enjoy! 🚀" spellcheck="false"></textarea>

                                <!-- Line Numbers -->
                                <div x-show="showLineNumbers"
                                    class="absolute left-0 top-0 bottom-0 w-10 bg-white/[0.01] border-r border-white/5 text-[#3F3F46] text-2xs code-font pt-6 pr-3 select-none pointer-events-none overflow-hidden text-right">
                                    <template x-for="(line, i) in (file.content || '').split('\n')" :key="i">
                                        <div class="leading-[1.6] h-[1.6em]" x-text="i + 1"></div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </main>
            </div>
        </form>

        <!-- Initial Project Setup Modal -->
        <div x-show="showInitialModal" x-cloak
            class="fixed inset-0 z-[60] flex items-center justify-center bg-black/90 backdrop-blur-xl p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div @click.away="false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="modal-mobile glass-card rounded-[2.5rem] p-10 w-full max-w-lg shadow-2xl border border-white/5 relative overflow-hidden">
                
                {{-- Decorative Background Glow --}}
                <div class="absolute -top-24 -left-24 w-48 h-48 bg-blue-500/5 blur-3xl rounded-full"></div>

                <div class="mb-10 relative">
                    <h3 class="text-4xl font-bold text-[#EDEDED] mb-3 tracking-tighter">new logic entry</h3>
                    <p class="text-2xs font-bold tracking-normal text-[#3F3F46]">initialize your vault snippet with secure metadata.</p>
                </div>

                <div class="space-y-6 relative">
                    <div>
                        <label class="text-2xs font-bold text-[#71717A] tracking-normal mb-3 block ml-1">archive title</label>
                        <input type="text" x-model="projectInfo.title" @keyup.enter="submitProjectInfo"
                            placeholder="e.g. auth protocol"
                            class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-sm text-[#EDEDED] outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/50 transition-all shadow-inner placeholder-[#3F3F46]"
                            :class="{ 'border-red-500/30': projectValidation.title }">
                        <p x-show="projectValidation.title" class="text-2xs text-red-500 mt-2 font-bold uppercase tracking-widest"
                            x-text="projectValidation.title"></p>
                    </div>

                    <div>
                        <label class="text-2xs font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 block ml-1">
                            secure description
                        </label>
                        <textarea x-model="projectInfo.description" rows="3"
                            placeholder="define the scope of this logic..."
                            class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-sm text-[#EDEDED] outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/50 transition-all shadow-inner resize-none placeholder-[#3F3F46]"
                            :class="{ 'border-red-500/30': projectValidation.description }"></textarea>
                        <p x-show="projectValidation.description" class="text-2xs text-red-500 mt-2 font-bold uppercase tracking-widest"
                            x-text="projectValidation.description"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-6 relative">
                        <div>
                            <label class="text-2xs font-bold text-[#71717A] tracking-normal mb-3 block ml-1">language</label>
                            <div class="relative">
                                <select x-model="projectInfo.language"
                                    class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-xs text-[#EDEDED] outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/50 transition-all cursor-pointer shadow-inner appearance-none">
                                    <option value="laravel">laravel</option>
                                    <option value="tailwind">tailwind css</option>
                                    <option value="react">react</option>
                                    <option value="vue">vue.js</option>
                                    <option value="javascript">javascript</option>
                                    <option value="php">php</option>
                                    <option value="python">python</option>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-4 h-4 text-[#3F3F46]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="text-2xs font-bold text-[#71717A] tracking-normal mb-3 block ml-1">category</label>
                            @if ($categories->isEmpty())
                                <div class="h-[54px] flex items-center px-5 bg-[#0A0A0A] rounded-2xl border border-dashed border-white/10">
                                    <a href="{{ url('/create-new') . '?type=category' }}"
                                        class="text-2xs text-blue-400 hover:text-blue-300 font-bold tracking-normal transition-colors">invoke category</a>
                                </div>
                            @else
                                <select x-model="projectInfo.category"
                                    class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-xs text-[#EDEDED] outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/50 transition-all cursor-pointer shadow-inner appearance-none">
                                    <option value="" disabled selected>select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category_id }}">
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 mt-12 relative">
                    <a href="{{ url('/') }}"
                        class="flex-1 bg-white/5 hover:bg-white/10 text-[#71717A] hover:text-[#EDEDED] px-6 py-4 rounded-2xl text-2xs font-bold tracking-normal transition-all border border-white/5 text-center flex items-center justify-center">
                        abort
                    </a>
                    <button type="button" @click="submitProjectInfo"
                        class="flex-1 btn-primary px-6 py-4 rounded-2xl text-2xs font-bold tracking-normal h-[54px]">
                        create snippet
                    </button>
                </div>
            </div>
        </div>

        <!-- Project Info Edit Modal -->
        <div x-show="showProjectModal" x-cloak @click.self="showProjectModal = false"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-xl p-6 hidden animate-in fade-in duration-300">
            <div @click.away="showProjectModal = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="modal-mobile glass-card rounded-[2.5rem] p-10 w-full max-w-lg shadow-2xl border border-white/5 relative overflow-hidden">
                
                <div class="absolute -top-24 -left-24 w-48 h-48 bg-blue-500/5 blur-3xl rounded-full"></div>

                <div class="flex items-center justify-between mb-10 relative">
                    <h3 class="text-3xl font-black text-[#EDEDED] flex items-center gap-3 tracking-tighter">
                        archive metadata
                    </h3>
                    <button @click="showProjectModal = false"
                        class="text-[#71717A] hover:text-white transition-colors text-3xl">&times;</button>
                </div>

                <div class="space-y-6 relative">
                    <div>
                        <label class="text-2xs font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 block ml-1">archive title</label>
                        <input type="text" x-model="projectInfo.title" required placeholder="e.g. auth protocol"
                            class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/50 outline-none transition-all shadow-inner placeholder-[#3F3F46]">
                    </div>

                    <div>
                        <label class="text-2xs font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 block ml-1">secure description</label>
                        <textarea x-model="projectInfo.description" required rows="3" placeholder="define the scope..."
                            class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/50 outline-none transition-all resize-none shadow-inner placeholder-[#3F3F46]"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-2xs font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 block ml-1">language</label>
                            <select x-model="projectInfo.language"
                                class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-xs text-[#EDEDED] outline-none focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer shadow-inner appearance-none">
                                <option value="laravel">laravel</option>
                                <option value="tailwind">tailwind css</option>
                                <option value="react">react</option>
                                <option value="vue">vue.js</option>
                                <option value="javascript">javascript</option>
                                <option value="php">php</option>
                                <option value="python">python</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-2xs font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 block ml-1">category</label>
                            @if ($categories->isEmpty())
                                <div class="h-[54px] flex items-center px-5 bg-[#0A0A0A] rounded-2xl border border-dashed border-white/10">
                                    <span class="text-3xs font-black uppercase tracking-widest">locked</span>
                                </div>
                            @else
                                <select x-model="projectInfo.category"
                                    class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-xs text-[#EDEDED] outline-none focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer shadow-inner appearance-none">
                                    <option value="" disabled selected>category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category_id }}">
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 mt-12 relative">
                    <button type="button" @click="showProjectModal = false"
                        class="flex-1 bg-white/5 hover:bg-white/10 text-[#71717A] hover:text-[#EDEDED] px-6 py-4 rounded-2xl text-2xs font-black uppercase tracking-widest transition-all border border-white/5">
                        cancel
                    </button>
                    <button type="button" @click="showProjectModal = false"
                        class="flex-1 btn-primary px-6 py-4 rounded-2xl text-2xs font-black uppercase tracking-[0.2em] h-[54px]">
                        commit updates
                    </button>
                </div>
            </div>
        </div>

        <!-- Add File Modal -->
        <div x-show="showAddFileModal" x-cloak @click.self="showAddFileModal = false"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-xl p-6 hidden animate-in fade-in duration-300">
            <div @click.away="showAddFileModal = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="modal-mobile glass-card rounded-[2.5rem] p-10 w-full max-w-md shadow-2xl border border-white/5 relative overflow-hidden">
                
                <div class="absolute -top-24 -left-24 w-48 h-48 bg-blue-500/5 blur-3xl rounded-full"></div>

                <div class="flex items-center justify-between mb-10 relative">
                    <h3 class="text-3xl font-black text-[#EDEDED] flex items-center gap-3 tracking-tighter">
                        new node
                    </h3>
                    <button @click="showAddFileModal = false"
                        class="text-[#71717A] hover:text-white transition-colors text-3xl">&times;</button>
                </div>

                <div class="space-y-6 relative">
                    <div>
                        <label class="text-2xs font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 block ml-1">entity name</label>
                        <input type="text" x-model="newFile.name" @keyup.enter="addFile" required
                            placeholder="e.g. index.php"
                            class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/50 outline-none transition-all shadow-inner placeholder-[#3F3F46]">
                    </div>

                    <div>
                        <label class="text-2xs font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 block ml-1">relative path</label>
                        <input type="text" x-model="newFile.path" @keyup.enter="addFile"
                            placeholder="e.g. src/logic" required
                            class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/50 outline-none transition-all shadow-inner placeholder-[#3F3F46]">
                    </div>

                    <!-- Quick Templates -->
                    <div>
                        <label class="text-2xs font-black text-[#71717A] uppercase tracking-[0.2em] mb-4 block ml-1">logic archetypes</label>
                        <div class="grid grid-cols-3 gap-3">
                            <button type="button" @click="newFile.name = 'index.php'"
                                class="px-3 py-3 bg-[#0A0A0A] hover:bg-blue-500/10 rounded-xl text-3xs font-black uppercase tracking-widest text-[#A1A1AA] hover:text-blue-400 transition-all border border-white/5 hover:border-blue-500/30">
                                php
                            </button>
                            <button type="button" @click="newFile.name = 'script.js'"
                                class="px-3 py-3 bg-[#0A0A0A] hover:bg-blue-500/10 rounded-xl text-3xs font-black uppercase tracking-widest text-[#A1A1AA] hover:text-blue-400 transition-all border border-white/5 hover:border-blue-500/30">
                                js
                            </button>
                            <button type="button" @click="newFile.name = 'style.css'"
                                class="px-3 py-3 bg-[#0A0A0A] hover:bg-blue-500/10 rounded-xl text-3xs font-black uppercase tracking-widest text-[#A1A1AA] hover:text-blue-400 transition-all border border-white/5 hover:border-blue-500/30">
                                css
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 mt-12 relative">
                    <button type="button" @click="showAddFileModal = false"
                        class="flex-1 bg-white/5 hover:bg-white/10 text-[#71717A] hover:text-[#EDEDED] px-6 py-4 rounded-2xl text-2xs font-black uppercase tracking-widest transition-all border border-white/5">
                        cancel
                    </button>
                    <button type="button" @click="addFile"
                        class="flex-1 btn-primary px-6 py-4 rounded-2xl text-2xs font-black uppercase tracking-[0.2em] h-[54px]">
                        commit node
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
                class="modal-mobile glass-card rounded-2xl p-6 md:p-10 w-full max-w-md shadow-2xl border border-white/10">

                <div class="text-center">
                    <div
                        class="mx-auto w-14 h-14 bg-red-500/10 rounded-full flex items-center justify-center mb-6 border border-red-500/20">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-semibold text-[#EDEDED] mb-2">Delete file?</h3>
                    <p class="text-sm text-[#71717A] mb-8">This action cannot be undone. This will permanently remove the file from this snippet.</p>

                    <div class="flex gap-3">
                        <button @click="deleteConfirm = null"
                            class="flex-1 bg-white/5 hover:bg-white/10 text-[#EDEDED] px-6 py-2.5 rounded-lg text-sm font-semibold transition-all border border-white/10">
                            Cancel
                        </button>
                        <button @click="removeFile(deleteConfirm)"
                            class="flex-1 bg-red-500/20 hover:bg-red-500/30 text-red-200 px-6 py-2.5 rounded-lg text-sm font-semibold transition-all border border-red-500/30">
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
                    showProjectModal: false,
                    showInitialModal: true,
                    showSettings: false,
                    showLineNumbers: true,
                    autoSave: false,
                    deleteConfirm: null,
                    mobileMenuOpen: false,
                    projectInfo: {
                        title: '',
                        description: '',
                        language: 'laravel',
                        category: '',

                    },

                    projectValidation: {
                        title: '',
                        description: ''
                    },
                    newFile: {
                        name: '',
                        path: '',
                        content: ''
                    },
                    files: [{
                        name: 'web.php',
                        path: 'routes/',
                        content: ''
                    }],

                    init() {
                        // Keyboard shortcuts
                        document.addEventListener('keydown', (e) => {
                            // Ctrl/Cmd + S to save
                            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                                e.preventDefault();
                                this.$el.querySelector('form').dispatchEvent(new Event('submit'));
                            }

                            // Ctrl/Cmd + N for new file
                            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                                e.preventDefault();
                                this.showAddFileModal = true;
                            }

                            // Escape to close modals
                            if (e.key === 'Escape') {
                                this.showAddFileModal = false;
                                this.showProjectModal = false;
                                this.showSettings = false;
                                this.deleteConfirm = null;
                            }
                        });
                    },

                    toggleMobileSidebar() {
                        this.mobileMenuOpen = !this.mobileMenuOpen;
                    },

                    submitProjectInfo() {
                        // Reset validation
                        this.projectValidation = {
                            title: '',
                            description: ''
                        };

                        let isValid = true;

                        // Validate title
                        if (!this.projectInfo.title.trim()) {
                            this.projectValidation.title = 'Project name is required';
                            isValid = false;
                        } else if (this.projectInfo.title.trim().length < 3) {
                            this.projectValidation.title = 'Project name must be at least 3 characters';
                            isValid = false;
                        }

                        // Validate description
                        if (!this.projectInfo.description.trim()) {
                            this.projectValidation.description = 'Description is required';
                            isValid = false;
                        } else if (this.projectInfo.description.trim().length < 10) {
                            this.projectValidation.description = 'Description must be at least 10 characters';
                            isValid = false;
                        }
                        if (!this.projectInfo.category) {
                            // You can add category validation if needed
                            this.projectValidation.category = 'Please select a category';
                            isValid = false;
                        }

                        if (isValid) {
                            this.showInitialModal = false;
                        }
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
        font-family: 'Roboto Mono', monospace;
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
