@extends('layout.snippet')

@section('title', 'Refactor Logic Node')

@section('content')

    <div class="h-full flex flex-col bg-[#030303]">
        @if (isset($snippet))
            <script>
                window.snippetData = {
                    projectInfo: {
                        title: @json($snippet->title),
                        description: @json($snippet->description),
                        language: @json($snippet->language ?? 'laravel'),
                        category: @json($snippet->category_id),
                    },
                    files: @json($files)
                };
            </script>
        @endif

        <form action="{{ isset($snippet) ? url('/snippets/update/' . $snippet->id) : url('/snippet-store') }}" method="POST"
            class="h-screen flex flex-col overflow-hidden">
            {{ csrf_field() }}

            <!-- Hidden inputs for project metadata -->
            <input type="hidden" name="title" x-model="projectInfo.title">
            <input type="hidden" name="description" x-model="projectInfo.description">
            <input type="hidden" name="language" x-model="projectInfo.language">
            <input type="hidden" name="category" x-model="projectInfo.category">

            <!-- Default UI Header -->
            <header
                class="h-20 flex items-center justify-between px-4 md:px-8 shrink-0 glass-card border-b border-white/5 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button type="button" @click="toggleMobileSidebar"
                        class="md:hidden p-2 rounded-lg bg-white/5 border border-white/10 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 bg-black border border-white/10 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile">
                            <a href="{{ url('/') }}">CodeVault</a> <span
                                class="text-blue-500 text-xs font-normal">v1.1</span>
                        </h1>
                    </div>
                </div>

                <!-- Project Info Section (Center) -->
                <div class="flex-1 flex items-center justify-center gap-4 max-w-xl px-4 min-w-0 group cursor-pointer"
                    @click="showProjectModal = true">
                    <div class="text-center min-w-0 flex-1">
                        <h2 class="text-lg font-bold text-white truncate group-hover:text-blue-400 transition-colors"
                            x-text="projectInfo.title || 'Untitled Snippet'"></h2>
                        <div class="hidden md:block">
                            <p class="text-xs text-gray-500 truncate"
                                x-text="projectInfo.description || 'No description provided'"></p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 shrink-0">
                    <div class="flex items-center gap-2">
                        <button type="submit" class="btn-primary px-3 md:px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg hover:shadow-blue-900/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="hidden md:inline">Save Changes</span>
                            <span class="md:hidden">Save</span>
                        </button>

                        <a href="{{ url('/dashboard') }}"
                            class="p-2 rounded-lg bg-white/5 border border-white/10 text-gray-500 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Workspace -->
            <div class="flex-1 flex overflow-hidden p-2 md:p-6 gap-2 md:gap-4">
                
                <!-- Sidebar Backdrop (Mobile) -->
                <div class="sidebar-backdrop md:hidden" :class="{ 'active': mobileMenuOpen }" @click="mobileMenuOpen = false"></div>

                <!-- Sidebar: Files -->
                <aside class="sidebar-container md:w-72 glass-card rounded-xl flex flex-col overflow-hidden shadow-2xl border border-white/5 md:relative"
                    :class="{ 'mobile-open': mobileMenuOpen }">
                    <div class="p-4 md:p-6 border-b border-white/5 bg-white/[0.01]">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-500">File Logic</h2>
                            
                            <!-- Close Button (Mobile) -->
                            <button type="button" @click="mobileMenuOpen = false" class="md:hidden p-1 -mr-2 text-gray-500 hover:text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            
                            <span class="hidden md:inline-block text-xs px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-400 font-bold border border-blue-500/20" x-text="files.length"></span>
                        </div>

                        <button type="button" @click="showAddFileModal = true; mobileMenuOpen = false"
                            class="w-full bg-white/5 hover:bg-white/10 border border-white/10 text-white px-4 py-3 rounded-lg font-bold text-sm transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add New File
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-3 space-y-1 custom-scrollbar">
                        <template x-for="(file, index) in files" :key="index">
                            <div @click="activeTab = index; mobileMenuOpen = false"
                                :class="activeTab === index ? 'tab-active text-white border-blue-500/30' : 'text-gray-500 hover:bg-white/5 hover:text-gray-300 border-transparent'"
                                class="file-item flex items-center justify-between p-3 rounded-xl cursor-pointer group transition-all border">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="text-xl" x-text="getFileIcon(file.name)">📄</div>
                                    <div class="flex-1 min-w-0">
                                        <div x-text="file.name || 'untitled'" class="text-sm font-bold truncate"></div>
                                        <div x-text="file.path || 'root'" class="text-[10px] opacity-40 truncate"></div>
                                    </div>
                                </div>
                                <button type="button" @click.stop="confirmDelete(index)" x-show="files.length > 1"
                                    class="opacity-0 group-hover:opacity-100 text-gray-400 hover:text-red-400 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </aside>

                <!-- Editor Workspace -->
                <main
                    class="flex-1 glass-card rounded-xl flex flex-col overflow-hidden shadow-2xl border border-white/5 relative z-10">
                    <template x-for="(file, index) in files" :key="index">
                        <div x-show="activeTab === index" class="h-full flex flex-col">
                             <!-- File Meta -->
                            <div class="p-3 md:p-6 border-b border-white/5 bg-white/[0.01]">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
                                    <div>
                                        <label class="text-xs font-bold text-gray-500 mb-2 block ml-1">File Identity</label>
                                        <input type="text" x-model="file.name" name="file_names[]" required placeholder="e.g. index.php"
                                            class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-700">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500 mb-2 block ml-1">Target Directory</label>
                                        <input type="text" x-model="file.path" name="file_paths[]" placeholder="e.g. src/app" required
                                            class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-700">
                                    </div>
                                </div>
                            </div>

                            <!-- Editor Textarea -->
                            <div class="flex-1 relative bg-black/20 overflow-hidden">
                                <textarea name="contents[]" x-model="file.content" required
                                    class="absolute inset-0 w-full h-full bg-transparent left-2 md:left-5 p-4 md:p-10 pl-10 md:pl-16 code-font text-[13px] md:text-[14px] text-gray-400 focus:text-white outline-none resize-none leading-relaxed transition-colors scrollbar-hide"
                                    placeholder="// Enter code here..."></textarea>

                                <!-- Line Numbers -->
                                <div x-show="showLineNumbers"
                                    class="absolute left-0 top-0 bottom-0 w-8 md:w-12 bg-white/[0.02] border-r border-white/5 text-gray-700 text-[10px] md:text-[11px] code-font pt-4 md:pt-10 pr-2 md:pr-3 pointer-events-none text-right">
                                    <template x-for="(line, i) in (file.content || '').split('\n')" :key="i">
                                        <div class="leading-relaxed h-[1.5em]" x-text="i + 1"></div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </main>
            </div>
        </form>

        <!-- Modals -->
        <template x-if="true">
            <div>
                <!-- Settings Edit Modal -->
                <div x-show="showProjectModal" x-cloak @click.self="showProjectModal = false"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
                    <div
                        class="glass-card rounded-2xl p-8 w-full max-w-xl shadow-2xl border border-white/10 animate-in slide-in-from-bottom-4 duration-300">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-bold text-white">Project Specs</h3>
                            <button @click="showProjectModal = false"
                                class="text-gray-500 hover:text-white transition-colors text-2xl">&times;</button>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="text-xs font-bold text-gray-500 mb-2 block ml-1">Title</label>
                                <input type="text" x-model="projectInfo.title" required
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500/50 transition-all">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-500 mb-2 block ml-1">Description</label>
                                <textarea x-model="projectInfo.description" required rows="3"
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500/50 transition-all resize-none shadow-inner"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="text-xs font-bold text-gray-500 mb-2 block ml-1">Language</label>
                                    <select x-model="projectInfo.language"
                                        class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-sm text-white focus:outline-none appearance-none">
                                        <option value="laravel">Laravel</option>
                                        <option value="tailwind">Tailwind CSS</option>
                                        <option value="react">React</option>
                                        <option value="vue">Vue.js</option>
                                        <option value="javascript">JavaScript</option>
                                        <option value="php">PHP</option>
                                        <option value="python">Python</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500 mb-2 block ml-1">Category</label>
                                    <select x-model="projectInfo.category"
                                        class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-sm text-white focus:outline-none appearance-none">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-10">
                            <button type="button" @click="showProjectModal = false"
                                class="flex-1 bg-white/5 hover:bg-white/10 text-gray-500 hover:text-white px-6 py-3 rounded-lg text-sm font-bold transition-all border border-white/5">Close</button>
                            <button type="button" @click="showProjectModal = false"
                                class="flex-1 btn-primary px-6 py-3 rounded-lg text-sm font-bold h-[48px]">Update
                                Meta</button>
                        </div>
                    </div>
                </div>

                <!-- Add File Modal -->
                <div x-show="showAddFileModal" x-cloak @click.self="showAddFileModal = false"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
                    <div
                        class="glass-card rounded-2xl p-8 w-full max-w-md shadow-2xl border border-white/10 animate-in zoom-in-95 duration-300">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-bold text-white">New Logic Node</h3>
                            <button @click="showAddFileModal = false"
                                class="text-gray-500 hover:text-white transition-colors text-2xl">&times;</button>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="text-xs font-bold text-gray-500 mb-2 block ml-1">Node Name</label>
                                <input type="text" x-model="newFile.name" @keyup.enter="addFile" required
                                    placeholder="e.g. LogicController.php"
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500/50 transition-all">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-500 mb-2 block ml-1">Logic Path</label>
                                <input type="text" x-model="newFile.path" @keyup.enter="addFile"
                                    placeholder="e.g. app/Http/Logic" required
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500/50 transition-all">
                            </div>
                        </div>

                        <div class="flex gap-4 mt-10">
                            <button type="button" @click="showAddFileModal = false"
                                class="flex-1 bg-white/5 hover:bg-white/10 text-gray-500 hover:text-white px-6 py-3 rounded-lg text-sm font-bold transition-all border border-white/5">Cancel</button>
                            <button type="button" @click="addFile"
                                class="flex-1 btn-primary px-6 py-3 rounded-lg text-sm font-bold h-[48px]">Register
                                Node</button>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div x-show="deleteConfirm !== null" x-cloak @click.self="deleteConfirm = null"
                    class="fixed inset-0 z-[110] flex items-center justify-center bg-black/90 backdrop-blur-lg p-4">
                    <div
                        class="glass-card rounded-2xl p-8 w-full max-w-sm shadow-2xl border border-white/10 text-center animate-in zoom-in-95 duration-300">
                        <div class="mx-auto w-16 h-16 bg-red-600/10 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>

                        <h3 class="text-xl font-bold text-white mb-2">Delete Node?</h3>
                        <p class="text-sm text-gray-500 mb-8">This action cannot be undone.</p>

                        <div class="flex flex-col gap-2">
                            <button @click="removeFile(deleteConfirm)"
                                class="w-full bg-red-600 hover:bg-red-500 text-white py-3 rounded-lg font-bold text-sm transition-all shadow-lg">Confirm
                                Delete</button>
                            <button @click="deleteConfirm = null"
                                class="w-full py-3 bg-white/5 hover:bg-white/10 text-gray-500 hover:text-white rounded-lg font-bold text-sm transition-all">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <script>
        function snippetEditor() {
            return {
                activeTab: 0,
                showAddFileModal: false,
                showProjectModal: false,
                showInitialModal: false,
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
                newFile: {
                    name: '',
                    path: '',
                    content: ''
                },
                files: [],

                init() {
                    // Load existing snippet data
                    if (window.snippetData) {
                        Object.assign(this.projectInfo, window.snippetData.projectInfo);
                        this.files = window.snippetData.files;
                        this.activeTab = 0;
                    }

                    // Keyboard shortcuts
                    document.addEventListener('keydown', (e) => {
                        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                            e.preventDefault();
                            this.$el.querySelector('form').dispatchEvent(new Event('submit'));
                        }
                        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                            e.preventDefault();
                            this.showAddFileModal = true;
                        }
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

                addFile() {
                    if (!this.newFile.name.trim()) return;
                    this.files.push({
                        name: this.newFile.name,
                        path: this.newFile.path,
                        content: this.newFile.content || ''
                    });
                    this.activeTab = this.files.length - 1;
                    this.showAddFileModal = false;
                    this.newFile = { name: '', path: '', content: '' };
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
                        'php': '🐘', 'js': '🟨', 'jsx': '⚛️', 'ts': '📘', 'tsx': '⚛️',
                        'css': '🎨', 'html': '🌐', 'json': '📋', 'md': '📝', 'py': '🐍',
                        'sql': '🗄️', 'vue': '💚', 'xml': '📰', 'java': '☕', 'cpp': '⚙️',
                        'c': '⚙️', 'rb': '💎', 'go': '🔷', 'rs': '🦀'
                    };
                    return icons[ext] || '📄';
                },

                updateStats() {
                    // Update any stats if needed
                }
            }
        }
    </script>

@endsection

<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Selection Color */
    ::selection {
        background: rgba(59, 130, 246, 0.3);
        color: white;
    }

    /* Hide horizontal scroll for textarea */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    @media (max-width: 768px) {
        .hide-on-mobile {
            display: none !important;
        }
    }
</style>