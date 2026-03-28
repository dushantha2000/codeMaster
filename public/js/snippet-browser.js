/**
 * CodeVault — Shared Snippet Browser Alpine.js Component
 * Single source of truth. Loaded globally via app.blade.php.
 * Used by: dashboard, mysnippets (each page provides its own fetchSnippets URL via init overrides)
 */
function snippetBrowser() {
    return {
        // ─── State ───────────────────────────────────────────────
        snippets: [],
        currentPage: 1,
        lastPage: 1,
        total: 0,
        searchQuery: '',
        selectedLanguage: 'all',
        selectedLanguageName: 'All Languages',
        selectedStatus: 'all',
        selectedSort: 'latest',
        sortBy: 'latest',
        statusFilter: 'all',
        showStarredOnly: false,
        mobileFiltersOpen: false,
        loading: false,
        showPreview: false,
        selectedSnippet: null,
        activeFileTab: 0,
        mobileMenuOpen: false,
        mobileFileListOpen: false,
        copyDone: false,

        // ─── Language List ────────────────────────────────────────
        languageList: [
            { id: '',            name: 'All Languages', icon: '🌐' },
            { id: 'Laravel',     name: 'Laravel',       icon: '🟠' },
            { id: 'React',       name: 'React',         icon: '⚛️' },
            { id: 'Tailwind',    name: 'Tailwind',      icon: '🍃' },
            { id: 'Javascript',  name: 'JavaScript',    icon: '🟨' },
            { id: 'Typescript',  name: 'TypeScript',    icon: '📘' },
            { id: 'Python',      name: 'Python',        icon: '🐍' },
            { id: 'PHP',         name: 'PHP',           icon: '🐘' },
            { id: 'HTML',        name: 'HTML',          icon: '🌐' },
            { id: 'CSS',         name: 'CSS',           icon: '🎨' },
            { id: 'Vue',         name: 'Vue',           icon: '💚' },
            { id: 'SQL',         name: 'SQL',           icon: '🗄️' },
        ],

        // ─── Methods ──────────────────────────────────────────────

        /**
         * Main fetch — used by Dashboard (all snippets).
         * Override this per-page if needed via x-init.
         */
        fetchSnippets(page = 1) {
            this.currentPage = page;
            this.loading = true;

            const params = new URLSearchParams({
                q:      this.searchQuery,
                lang:   this.selectedLanguage !== 'all' ? this.selectedLanguage : '',
                status: this.statusFilter !== 'all' ? this.statusFilter : '',
                sort:   this.sortBy,
                isMark: this.showStarredOnly ? 1 : 0,
                page:   this.currentPage,
            });

            fetch(`/api/search?${params}`)
                .then(res => res.json())
                .then(data => {
                    let snippets = data.data || data;
                    if (this.sortBy === 'az') snippets.sort((a, b) => a.title.localeCompare(b.title));
                    else if (this.sortBy === 'za') snippets.sort((a, b) => b.title.localeCompare(a.title));
                    this.snippets  = snippets;
                    this.lastPage  = data.last_page || 1;
                    this.total     = data.total || 0;
                    this.loading   = false;
                })
                .catch(err => {
                    console.error('Fetch Error:', err);
                    this.loading = false;
                });
        },

        openSnippet(id) {
            this.loading = true;
            fetch(`/api/snippets/${id}`)
                .then(res => res.json())
                .then(data => {
                    this.selectedSnippet   = data;
                    this.activeFileTab     = 0;
                    this.showPreview       = true;
                    this.mobileFileListOpen = false;
                    this.loading           = false;
                    this.$nextTick(() => {
                        if (typeof Prism !== 'undefined') Prism.highlightAll();
                    });
                })
                .catch(err => {
                    console.error('Detail Error:', err);
                    this.loading = false;
                });
        },

        copyCode(text) {
            navigator.clipboard.writeText(text)
                .then(() => this._flashCopy())
                .catch(() => {
                    // Fallback for browsers without clipboard API
                    const el = document.createElement('textarea');
                    el.value = text;
                    document.body.appendChild(el);
                    el.select();
                    document.execCommand('copy');
                    document.body.removeChild(el);
                    this._flashCopy();
                });
        },

        _flashCopy() {
            this.copyDone = true;
            setTimeout(() => this.copyDone = false, 2000);
        },

        toggleStar(id) {
            const formData = new FormData();
            formData.append('snippet_id', id);
            // CSRF token injected via meta tag
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta) formData.append('_token', meta.getAttribute('content'));

            fetch('/snippet-marked', { method: 'POST', body: formData })
                .then(() => this.fetchSnippets(this.currentPage))
                .catch(err => console.error('Star Error:', err));
        },

        // ─── Icon helpers ─────────────────────────────────────────
        getLangIcon(lang) {
            if (!lang) return '📄';
            const icons = {
                'php': '🐘', 'laravel': '🟠', 'javascript': '🟨', 'js': '🟨',
                'typescript': '📘', 'ts': '📘', 'python': '🐍', 'html': '🌐',
                'css': '🎨', 'react': '⚛️', 'vue': '💚', 'database': '🗄️', 'sql': '🗄️',
            };
            return icons[lang.toLowerCase()] || '📄';
        },

        getFileIcon(filename) {
            if (!filename) return '📄';
            const ext = filename.split('.').pop().toLowerCase();
            const icons = {
                'js': '🟨', 'jsx': '⚛️', 'ts': '📘', 'tsx': '⚛️', 'php': '🐘',
                'py': '🐍', 'html': '🌐', 'css': '🎨', 'json': '📋',
                'md': '📝', 'vue': '💚', 'sql': '🗄️',
            };
            return icons[ext] || '📄';
        },

        // ─── Mobile handlers ──────────────────────────────────────
        handleResize() {
            if (window.innerWidth > 768) {
                this.mobileFileListOpen = false;
                this.mobileMenuOpen     = false;
                this.mobileFiltersOpen  = false;
            }
        },

        toggleMobileFileList() {
            this.mobileFileListOpen = !this.mobileFileListOpen;
        },

        // ─── Init ─────────────────────────────────────────────────
        init() {
            window.addEventListener('resize', () => this.handleResize());
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768 && this.mobileFileListOpen) {
                    if (!e.target.closest('aside') && !e.target.closest('button[class*="md:hidden"]')) {
                        this.mobileFileListOpen = false;
                    }
                }
            });
            this.fetchSnippets();
        }
    };
}
