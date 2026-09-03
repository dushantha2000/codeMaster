/**
 * ============================================================
 * CodeVault — Code Formatting Utilities
 * ============================================================
 * Smart formatting, auto-detection, tab handling, and metadata
 * for the code editor and preview components.
 * ============================================================
 */

const CodeFormatter = {

    /**
     * File extension → Prism language identifier map.
     * Duplicated from the PHP service for client-side use.
     */
    extensionMap: {
        'php': 'php', 'blade.php': 'php',
        'js': 'javascript', 'mjs': 'javascript', 'cjs': 'javascript',
        'jsx': 'jsx',
        'ts': 'typescript', 'tsx': 'tsx', 'mts': 'typescript',
        'py': 'python', 'pyw': 'python',
        'rb': 'ruby', 'erb': 'erb',
        'go': 'go', 'rs': 'rust', 'java': 'java',
        'kt': 'kotlin', 'swift': 'swift', 'dart': 'dart',
        'c': 'c', 'h': 'c', 'cpp': 'cpp', 'hpp': 'cpp', 'cc': 'cpp',
        'cs': 'csharp',
        'scala': 'scala', 'hs': 'haskell',
        'ex': 'elixir', 'exs': 'elixir',
        'erl': 'erlang',
        'clj': 'clojure', 'cljs': 'clojure',
        'fs': 'fsharp', 'fsx': 'fsharp',
        'r': 'r', 'lua': 'lua',
        'pl': 'perl', 'pm': 'perl',
        'sh': 'bash', 'bash': 'bash', 'zsh': 'bash', 'fish': 'bash',
        'ps1': 'powershell', 'bat': 'batch', 'cmd': 'batch',
        'sql': 'sql', 'plsql': 'plsql',
        'html': 'markup', 'htm': 'markup', 'xml': 'markup',
        'svg': 'markup', 'vue': 'markup', 'svelte': 'markup',
        'css': 'css', 'scss': 'scss', 'sass': 'sass', 'less': 'less',
        'json': 'json', 'json5': 'json5',
        'yaml': 'yaml', 'yml': 'yaml', 'toml': 'toml', 'ini': 'ini',
        'md': 'markdown', 'mdx': 'markdown',
        'graphql': 'graphql', 'gql': 'graphql',
        'dockerfile': 'docker', 'tf': 'hcl', 'hcl': 'hcl',
        'makefile': 'makefile', 'cmake': 'cmake', 'groovy': 'groovy',
        'nim': 'nim', 'zig': 'zig', 'cr': 'crystal',
        'ml': 'ocaml', 'scm': 'scheme',
        'tex': 'latex', 'twig': 'twig',
    },

    /**
     * Detect language from a filename.
     * @param {string} filename
     * @returns {string} Prism language identifier
     */
    detectLanguage(filename) {
        if (!filename) return 'plaintext';
        const lower = filename.toLowerCase();

        // Check compound extensions first
        for (const [ext, lang] of Object.entries(this.extensionMap)) {
            if (lower.endsWith('.' + ext)) return lang;
        }

        // Exact filename matches
        const filenameMap = {
            'dockerfile': 'docker',
            'makefile': 'makefile',
            'cmakelists.txt': 'cmake',
            '.gitignore': 'bash',
            '.env': 'bash',
        };
        if (filenameMap[lower]) return filenameMap[lower];

        return 'plaintext';
    },

    /**
     * Get human-readable language name from Prism key.
     * @param {string} prismKey
     * @returns {string}
     */
    getLanguageName(prismKey) {
        const names = {
            'markup': 'HTML', 'css': 'CSS', 'scss': 'SCSS',
            'javascript': 'JavaScript', 'typescript': 'TypeScript',
            'jsx': 'JSX', 'tsx': 'TSX', 'json': 'JSON',
            'yaml': 'YAML', 'php': 'PHP', 'python': 'Python',
            'ruby': 'Ruby', 'go': 'Go', 'rust': 'Rust',
            'java': 'Java', 'kotlin': 'Kotlin', 'swift': 'Swift',
            'dart': 'Dart', 'c': 'C', 'cpp': 'C++', 'csharp': 'C#',
            'bash': 'Bash', 'powershell': 'PowerShell', 'sql': 'SQL',
            'graphql': 'GraphQL', 'docker': 'Dockerfile',
            'hcl': 'Terraform', 'markdown': 'Markdown',
            'latex': 'LaTeX', 'lua': 'Lua', 'r': 'R',
            'perl': 'Perl', 'scala': 'Scala', 'haskell': 'Haskell',
            'elixir': 'Elixir', 'erlang': 'Erlang',
            'groovy': 'Groovy', 'makefile': 'Makefile',
            'plaintext': 'Plain Text',
        };
        return names[prismKey] || prismKey?.charAt(0).toUpperCase() + prismKey?.slice(1) || 'Unknown';
    },

    /**
     * Map a language label (DB value, display name, or Prism key)
     * to a matching logo filename in /tech_logo, or '' if none exists.
     * @param {string} lang
     * @returns {string}
     */
    getLangLogo(lang) {
        if (!lang) return '';
        const logos = {
            // CSS family
            'css': 'css.svg', 'scss': 'css.svg', 'sass': 'css.svg', 'less': 'less.svg',
            'go': 'go.svg', 'golang': 'go.svg',
            // HTML / XML
            'html': 'html-5.svg', 'html5': 'html-5.svg', 'markup': 'html-5.svg', 'xml': 'xml.svg',
            'java': 'java.svg',
            'javascript': 'javascript.svg', 'js': 'javascript.svg',
            'node': 'javascript.svg', 'nodejs': 'javascript.svg',
            // PHP family
            'php': 'php.svg',
            // Python
            'python': 'python.svg', 'py': 'python.svg',
            'laravel': 'laravel.svg',
            // Frontend frameworks
            'react': 'react.svg', 'reactjs': 'react.svg', 'jsx': 'react.svg', 'tsx': 'react.svg',
            'vue': 'vue.svg', 'vuejs': 'vue.svg', 'vue.js': 'vue.svg',
            'astro': 'astro.svg',
            'tailwind': 'tailwind.svg', 'tailwindcss': 'tailwind.svg',
            // Typed languages
            'typescript': 'typescript.svg', 'ts': 'typescript.svg',
            'kotlin': 'kotlin.svg',
            'c': 'c.svg',
            'csharp': 'c-sharp.svg', 'c#': 'c-sharp.svg',
            // Shell
            'bash': 'bash.svg', 'shell': 'bash.svg', 'sh': 'bash.svg', 'zsh': 'bash.svg',
            'ruby': 'ruby.svg', 'rails': 'ruby.svg',
            'rust': 'rust.svg',
            // Databases
            'mysql': 'mysql.svg', 'sql': 'mysql.svg',
        };
        const key = String(lang).toLowerCase().replace(/[\s-]+/g, '');
        return logos[key] || '';
    },

    /**
     * Full URL to a tech logo for a language, or '' when none exists.
     * @param {string} lang
     * @returns {string}
     */
    langLogoUrl(lang) {
        const file = this.getLangLogo(lang);
        return file ? '/tech_logo/' + file : '';
    },

    /**
     * Resolve a filename to its tech logo URL, or '' when none exists.
     * @param {string} filename
     * @returns {string}
     */
    fileLogoUrl(filename) {
        if (!filename) return '';
        const ext = filename.toLowerCase().split('.').pop();
        const file = this.getLangLogo(ext) || this.getLangLogo(this.detectLanguage(filename));
        return file ? '/tech_logo/' + file : '';
    },

    /**
     * Try to detect language from code content heuristics.
     * @param {string} code
     * @returns {string|null} Prism language key or null
     */
    detectFromContent(code) {
        const patterns = {
            'php': /<\?php|\bpublic\s+function\b|\buse\s+Illuminate\\\\/,
            'python': /^def\s+\w+\s*\(|^import\s+\w+|^from\s+\w+\s+import/,
            'javascript': /\bconst\s+\w+\s*=.*=>|import\s+.*from\s+['"]|require\s*\(/,
            'typescript': /:\s*(string|number|boolean|void|any)\b|interface\s+\w+/,
            'html': /<!DOCTYPE\s+html|<html[\s>]|<div[\s>]/,
            'css': /^\s*\.[\w-]+\s*\{|^\s*#[\w-]+\s*\{/,
            'sql': /\bSELECT\b.*\bFROM\b|\bINSERT\s+INTO\b|\bCREATE\s+TABLE\b/,
            'bash': /^#!\s*\/bin\/(ba)?sh|^echo\s|^\$|^sudo\s/,
            'go': /^package\s+\w+|^func\s+\w+\s*\(/,
            'rust': /^fn\s+\w+|^let\s+mut\b|^impl\s+\w+/,
            'java': /^public\s+class\s+\w+|^import\s+java\./,
            'ruby': /^class\s+\w+|^def\s+\w+|^require\s+['"]/,
            'docker': /^FROM\s+|^RUN\s+|^COPY\s+|^EXPOSE\s+/,
            'yaml': /^\w+:|^\s+-\s+\w+:/,
            'graphql': /^type\s+\w+\s*\{|^query\s+\w+/,
        };

        for (const [lang, regex] of Object.entries(patterns)) {
            if (regex.test(code)) return lang;
        }
        return null;
    },

    /**
     * Normalize indentation to consistent 2-space tabs.
     * @param {string} code
     * @returns {string}
     */
    normalizeIndentation(code) {
        const lines = code.split('\n');
        return lines.map(line => {
            // Detect if line uses tabs
            const tabMatch = line.match(/^(\t+)/);
            if (tabMatch) {
                const tabs = tabMatch[1].length;
                return '  '.repeat(tabs) + line.slice(tabs);
            }
            return line;
        }).join('\n');
    },

    /**
     * Get metadata about a code string.
     * @param {string} code
     * @param {string} filename
     * @returns {object}
     */
    getCodeMetadata(code, filename) {
        const lines = code.split('\n');
        const nonEmpty = lines.filter(l => l.trim() !== '');
        const bytes = new Blob([code]).size;
        const ext = filename ? filename.split('.').pop().toLowerCase() : '';
        const lang = filename ? this.detectLanguage(filename) : 'plaintext';

        return {
            lines: lines.length,
            nonEmptyLines: nonEmpty.length,
            bytes: bytes,
            chars: code.length,
            extension: ext,
            language: lang,
            languageName: this.getLanguageName(lang),
            fileSize: this.formatFileSize(bytes),
        };
    },

    /**
     * Format bytes into human-readable string.
     * @param {number} bytes
     * @returns {string}
     */
    formatFileSize(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    },

    /**
     * Handle Tab key in textarea — insert 2 spaces.
     * @param {KeyboardEvent} e
     * @param {HTMLTextAreaElement} textarea
     */
    handleTab(e, textarea) {
        if (e.key === 'Tab') {
            e.preventDefault();
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const value = textarea.value;

            if (e.shiftKey) {
                // Shift+Tab: remove indent
                const lineStart = value.lastIndexOf('\n', start - 1) + 1;
                const lineContent = value.substring(lineStart, start);
                if (lineContent.startsWith('  ')) {
                    textarea.value = value.substring(0, lineStart) + value.substring(lineStart + 2);
                    textarea.selectionStart = textarea.selectionEnd = start - 2;
                }
            } else {
                // Tab: insert 2 spaces
                textarea.value = value.substring(0, start) + '  ' + value.substring(end);
                textarea.selectionStart = textarea.selectionEnd = start + 2;
            }

            // Trigger Alpine.js reactivity
            textarea.dispatchEvent(new Event('input'));
        }
    },

    /**
     * Auto-close brackets and quotes.
     * @param {KeyboardEvent} e
     * @param {HTMLTextAreaElement} textarea
     */
    handleAutoClose(e, textarea) {
        const pairs = {
            '(': ')',
            '{': '}',
            '[': ']',
            '"': '"',
            "'": "'",
            '`': '`',
        };

        if (pairs[e.key]) {
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const value = textarea.value;

            // Only auto-close if no text is selected
            if (start === end) {
                e.preventDefault();
                const closeChar = pairs[e.key];
                textarea.value = value.substring(0, start) + e.key + closeChar + value.substring(end);
                textarea.selectionStart = textarea.selectionEnd = start + 1;
                textarea.dispatchEvent(new Event('input'));
            }
        }

        // Auto-indent on Enter
        if (e.key === 'Enter') {
            const start = textarea.selectionStart;
            const value = textarea.value;
            const lineStart = value.lastIndexOf('\n', start - 1) + 1;
            const currentLine = value.substring(lineStart, start);
            const indent = currentLine.match(/^(\s*)/)[1];

            // Check if previous char is an opening bracket
            const prevChar = value[start - 1];
            if (prevChar === '{' || prevChar === '(' || prevChar === '[') {
                e.preventDefault();
                const newIndent = indent + '  ';
                const insert = '\n' + newIndent;
                textarea.value = value.substring(0, start) + insert + value.substring(start);
                textarea.selectionStart = textarea.selectionEnd = start + insert.length;
                textarea.dispatchEvent(new Event('input'));
            }
        }
    },
};

// Make globally available
if (typeof window !== 'undefined') {
    window.CodeFormatter = CodeFormatter;
}
