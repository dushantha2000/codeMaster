{{-- ============================================================
     Snippet Preview Modal — Slide-in Panel
     ============================================================
     Full-screen slide-in panel for viewing snippet files with
     syntax highlighting. Includes mobile file list toggle,
     copy-to-clipboard, and share link integration.
     Uses Alpine.js for all interactive state.
     ============================================================ --}}
<div x-show="showPreview" class="fixed inset-0 z-50 overflow-hidden flex items-center justify-end p-0 md:p-4" x-cloak>
    {{-- Backdrop overlay — click to close --}}
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity" x-show="showPreview"
        x-transition:enter="duration-500" x-transition:leave="duration-300" @click="showPreview = false"></div>

    {{-- Main modal panel --}}
    <div class="relative w-full md:max-w-5xl h-full md:h-[90vh] md:rounded-3xl flex flex-col overflow-hidden"
        x-show="showPreview" x-transition:enter="transform transition duration-500 ease-out"
        x-transition:enter-start="translate-x-full opacity-0 scale-95"
        x-transition:enter-end="translate-x-0 opacity-100 scale-100"
        x-transition:leave="transform transition duration-300 ease-in"
        x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0">

        {{-- Modal header — title, file toggle, share, close --}}
        <div
            class="h-16 md:h-20 flex items-center justify-between px-4 md:px-8 bg-white/[0.02] border-b border-white/5">
            <div class="flex items-center gap-2 md:gap-4">
                {{-- Mobile file list toggle (hamburger icon) --}}
                <button @click="mobileFileListOpen = !mobileFileListOpen"
                    class="md:hidden p-2 bg-white/5 rounded-lg border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="p-2 md:p-3  md:rounded-2xl ">
                    <img src="{{ asset('logo/mainlogo.png') }}" alt="CodeVault Logo"
                        class="w-10 h-10 object-contain transform scale-125">
                </div>
                <div>
                    <h2 class="text-base md:text-xl font-bold text-white tracking-tight max-w-[150px] md:max-w-none truncate"
                        x-text="selectedSnippet?.title"></h2>
                    <p class="text-[8px] md:text-[10px] text-gray-500 font-mono uppercase tracking-widest"
                        x-text="(selectedSnippet?.language || 'N/A') + ' - ' + (selectedSnippet?.files?.length || 0) + ' files'">
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                {{-- Share Button (visible to the snippet owner only) --}}
                <button x-show="selectedSnippet && selectedSnippet.user_id == {{ Auth::id() }}"
                    @click="window.dispatchEvent(new CustomEvent('open-share-modal', { detail: selectedSnippet.id }))"
                    class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center bg-white/5 text-gray-400 hover:text-blue-400 hover:bg-blue-500/20 transition-all border border-white/10"
                    title="Share snippet">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"></path>
                    </svg>
                </button>

                <button @click="showPreview = false"
                    class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10 transition-all">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Modal body — file sidebar + code display --}}
        <div class="flex-1 flex overflow-hidden relative">
            {{-- File list sidebar — file navigation panel --}}
            <aside
                :class="mobileFileListOpen ? 'absolute left-0 top-0 bottom-0 w-64 bg-black/95 z-10' :
                    'hidden md:block md:relative md:w-64 md:bg-black/40'"
                class="border-r border-white/5 p-4 md:p-6 overflow-y-auto custom-mini-scrollbar">

                {{-- Mobile file list header with close button --}}
                <div x-show="mobileFileListOpen" class="flex items-center justify-between mb-4 md:hidden">
                    <div class="text-[10px] font-bold text-gray-600 uppercase tracking-tighter">PROJECT FILES</div>
                    <button @click="mobileFileListOpen = false" class="p-1 bg-white/5 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Desktop file list header --}}
                <div class="hidden md:flex items-center justify-between mb-4">
                    
                    <span class="text-xs px-4 py-1 rounded-full bg-white/10 text-gray-300">Files</span>
                </div>

                {{-- Files list — clickable file tabs --}}
                <nav class="space-y-1.5">
                    <template x-for="(file, index) in selectedSnippet?.files || []" :key="index">
                        <button
                            @click="activeFileTab = index; mobileFileListOpen = false; setTimeout(() => { if (typeof Prism !== 'undefined') Prism.highlightAll(); }, 50)"
                            :class="activeFileTab === index ? 'bg-blue-600/10 text-blue-400 border-blue-500/50' :
                                'text-gray-500 border-transparent hover:text-gray-300 hover:bg-white/5'"
                            class="w-full text-left px-3 md:px-4 py-2.5 md:py-3 rounded-lg md:rounded-xl text-xs md:text-[11px] font-mono border transition-all flex items-center justify-between group">
                            <div class="flex items-center gap-2 min-w-0">
                                <template x-if="getFileIcon(file.file_name)">
                                    <img x-cloak :src="getFileIcon(file.file_name)" :alt="file.file_name"
                                        :title="file.file_name" class="w-4 h-4 md:w-5 md:h-5 object-contain shrink-0">
                                </template>
                                <span x-cloak x-show="!getFileIcon(file.file_name)"
                                    class="text-sm md:text-base leading-none shrink-0">📄</span>
                                <span class="truncate" x-text="file.file_name"></span>
                            </div>
                        </button>
                    </template>
                </nav>
            </aside>

            {{-- Code display area — shows active file with syntax highlighting --}}
            <div class="flex-1 flex flex-col bg-[#050505]/60">
                <template x-for="(file, index) in selectedSnippet?.files || []" :key="index">
                    <div x-show="activeFileTab === index" class="h-full flex flex-col p-3 md:p-6">
                        {{-- File info bar — shows current filename + metadata --}}
                        <div
                            class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-3 md:mb-4 bg-white/5 px-3 md:px-4 py-2 rounded-lg border border-white/5">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="text-gray-400">📄</span>
                                <span
                                    class="text-white font-mono text-xs md:text-sm truncate max-w-[150px] md:max-w-none"
                                    x-text="file.file_name"></span>
                            </div>
                            <div class="flex items-center gap-3 text-[10px] text-gray-500 font-mono">
                                <span x-text="getPreviewLanguageLabel(file.file_name, selectedSnippet?.language)" class="px-2 py-0.5 rounded bg-blue-500/10 text-blue-400"></span>
                                <span x-text="getPreviewFileStats(file.content)"></span>
                            </div>
                        </div>

                        {{-- Code container — Prism.js highlighted code block --}}
                        <div class="flex-1 bg-black/40 rounded-xl border border-white/5 overflow-hidden relative">
                            {{-- Copy button — clipboard copy with feedback --}}
                            <button @click="copyCode(file.content)"
                                class="absolute right-2 md:right-4 top-2 md:top-4 z-10 px-2 md:px-3 py-1 md:py-1.5 rounded-lg border border-white/10 bg-white/5 hover:bg-white/10 transition-all flex items-center gap-1 md:gap-2 text-[10px] md:text-xs">
                                <span x-show="!copyDone">📋</span>
                                <span x-show="!copyDone" class="hidden md:inline">Copy</span>
                                <span x-show="copyDone">✅</span>
                                <span x-show="copyDone" class="hidden md:inline">Copied!</span>
                            </button>

                            {{-- Highlighted code output --}}
                            <pre class="h-full overflow-auto p-3 md:p-6 !m-0 !bg-transparent text-[11px] md:text-sm"><code :class="'language-' + ((selectedSnippet?.language || 'javascript').toLowerCase())" 
                                  class="!whitespace-pre-wrap !break-words !font-mono"
                                  x-text="file.content || '// No content'"></code></pre>
                        </div>
                    </div>
                </template>

                {{-- Empty state — shown when snippet has no files --}}
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

{{-- Share Link Modal --}}
<div x-data="shareModal()" x-show="isOpen" x-cloak
    x-on:open-share-modal.window="openModal($event.detail)"
    class="fixed inset-0 z-[70] overflow-y-auto p-4 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity" @click="closeModal()"></div>

    <div class="relative w-full max-w-lg glass-card rounded-3xl border border-white/10 shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
            <div>
                <h3 class="text-base font-bold text-white tracking-tight">Share Snippet</h3>
                
            </div>
            <button @click="closeModal()"
                class="w-8 h-8 rounded-full flex items-center justify-center bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6 space-y-5">
            {{-- Link options --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Expiry</label>
                    <select x-model="expiry"
                        class="w-full bg-[#050505] border border-white/10 text-white text-sm rounded-xl px-3 py-2.5 focus:border-blue-500 focus:outline-none">
                        <option value="never">Never expires</option>
                        <option value="1">1 day</option>
                        <option value="7">7 days</option>
                        <option value="30">30 days</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Password (optional)</label>
                    <input type="password" x-model="password" placeholder="No password"
                        class="w-full bg-[#050505] border border-white/10 text-white text-sm rounded-xl px-3 py-2.5 placeholder-gray-600 focus:border-blue-500 focus:outline-none">
                </div>
            </div>

            <p x-show="error" class="text-xs text-red-400" x-text="error"></p>

            {{-- Create --}}
            <div x-show="!shareCreated">
                <button @click="createLink()" :disabled="creating"
                    class="w-full py-3 rounded-xl btn-primary disabled:opacity-50 text-sm font-bold transition-all active:scale-[0.98]">
                    <span x-text="creating ? 'Creating link...' : 'Generate Share Link'"></span>
                </button>
            </div>

            {{-- Generated URL --}}
            <div x-show="shareCreated" class="space-y-3">
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest">Your public link</label>
                <div class="flex items-center gap-2">
                    <input readonly :value="shareUrl"
                        class="flex-1 bg-[#050505] border border-white/10 text-white text-xs font-mono rounded-xl px-3 py-2.5 truncate focus:border-blue-500 focus:outline-none">
                    <button @click="copyUrl()"
                        class="px-4 py-2.5 rounded-xl hover:text-white/10 text-xs font-bold transition-all">
                        Copy
                    </button>
                    <a :href="shareUrl" target="_blank" rel="noopener"
                        class="px-4 py-2.5 rounded-xl text-blue-400 hover:text-blue-600/30 text-xs font-bold transition-all">
                        Open
                    </a>
                </div>
                <p class="text-[10px] text-gray-600">
                    The full link is only shown once. Anyone with it can view this snippet
                    <span x-show="password">(password required)</span>.
                </p>
            </div>

            {{-- Existing links --}}
            <div x-show="links.length > 0" class="pt-4 border-t border-white/5">
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">Active links
                    (<span x-text="links.length"></span>)</label>
                <div class="space-y-2 max-h-40 overflow-y-auto custom-mini-scrollbar">
                    <template x-for="link in links" :key="link.id">
                        <div class="flex items-center justify-between gap-3 px-3 py-2.5 bg-white/[0.02] border border-white/5 rounded-xl">
                            <div class="min-w-0">
                                <p class="text-xs text-gray-300 truncate">
                                    <span x-text="link.has_password ? '🔒' : '🔗'"></span>
                                    Created <span x-text="formatDate(link.created_at)"></span>
                                </p>
                                <p class="text-[10px] text-gray-600 font-mono">
                                    <span x-text="link.views_count + ' views'"></span>
                                    · Expires
                                    <span x-text="link.expired ? 'already' : (link.expires_at ? formatDate(link.expires_at) : 'never')"></span>
                                </p>
                            </div>
                            <button @click="askRevoke(link.id)"
                                class="shrink-0 px-3 py-1.5 rounded-lg   text-red-400 hover:text-red-500/20 text-[10px] font-bold transition-all">
                                Revoke
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    {{-- Confirm Revoke Modal --}}
    <div x-show="revokeTarget !== null" x-cloak
        class="fixed inset-0 z-[80] p-4 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md" @click="cancelRevoke()"></div>

        <div class="relative w-full max-w-sm glass-card rounded-3xl border border-white/10 shadow-2xl overflow-hidden">
            <div class="p-8">
                <div class="text-center">
                    <div
                        class="w-16 h-16 mx-auto mb-6 rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-tight">Revoke share link?</h3>
                    <p class="text-xs text-gray-400 mt-2">Anyone with this link will lose access immediately. This can't
                        be undone.</p>
                </div>
                <div class="flex gap-3 mt-6">
                    <button @click="cancelRevoke()"
                        class="flex-1 py-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-sm font-bold transition-all">
                        Cancel
                    </button>
                    <button @click="confirmRevoke()" :disabled="revoking"
                        class="flex-1 py-3 rounded-xl bg-red-600 hover:bg-red-500 disabled:opacity-50 text-white text-sm font-bold transition-all active:scale-[0.98]">
                        <span x-text="revoking ? 'Revoking...' : 'Yes, revoke'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function shareModal() {
        return {
            isOpen: false,
            creating: false,
            snippetId: null,
            password: '',
            expiry: 'never',
            shareUrl: '',
            shareCreated: false,
            error: '',
            links: [],
            revokeTarget: null,
            revoking: false,

            openModal(id) {
                this.snippetId = id;
                this.password = '';
                this.expiry = 'never';
                this.shareUrl = '';
                this.shareCreated = false;
                this.error = '';
                this.loadLinks();
                this.isOpen = true;
            },

            closeModal() {
                this.isOpen = false;
            },

            csrf() {
                const meta = document.querySelector('meta[name="csrf-token"]');
                return meta ? meta.content : '';
            },

            loadLinks() {
                fetch(`/snippets/${this.snippetId}/share-links`)
                    .then(r => r.json())
                    .then(data => { this.links = data || []; })
                    .catch(() => { this.links = []; });
            },

            createLink() {
                this.creating = true;
                this.error = '';
                const formData = new FormData();
                if (this.password) formData.append('password', this.password);
                if (this.expiry !== 'never') formData.append('expires_in_days', this.expiry);

                fetch(`/snippets/${this.snippetId}/share-links`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrf(),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(r => r.json().then(d => ({ ok: r.ok, data: d })))
                    .then(({ ok, data }) => {
                        if (!ok) throw new Error(data.message || 'Failed to create share link.');
                        this.shareUrl = data.url;
                        this.shareCreated = true;
                        this.loadLinks();
                    })
                    .catch(err => { this.error = err.message || 'Something went wrong.'; })
                    .finally(() => { this.creating = false; });
            },

            askRevoke(id) {
                this.revokeTarget = id;
            },

            cancelRevoke() {
                this.revokeTarget = null;
            },

            confirmRevoke() {
                this.revoking = true;
                fetch(`/share-links/${this.revokeTarget}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': this.csrf(),
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(() => {
                        this.loadLinks();
                        this.revokeTarget = null;
                        showToast('Share link revoked.', 'success');
                    })
                    .catch(() => showToast('Failed to revoke link.', 'error'))
                    .finally(() => { this.revoking = false; });
            },

            copyUrl() {
                navigator.clipboard.writeText(this.shareUrl).then(() => {
                    showToast('Link copied to clipboard!', 'success');
                });
            },

            formatDate(d) {
                if (!d) return 'Never';
                return new Date(d).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' });
            }
        };
    }
</script>
