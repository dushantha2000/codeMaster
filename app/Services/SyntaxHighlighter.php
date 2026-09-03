<?php

namespace App\Services;

/**
 * SyntaxHighlighter — Maps file extensions and language names
 * to Prism.js language identifiers.
 *
 * Provides:
 * - File extension → Prism language detection
 * - Language display name mapping
 * - Auto-detection heuristics for content
 * - Supported languages list for UI dropdowns
 */
class SyntaxHighlighter
{
    /**
     * File extension → Prism language identifier.
     * Covers 50+ languages and frameworks.
     */
    protected array $extensionMap = [
        // PHP
        'php' => 'php',
        'blade.php' => 'php',
        'phtml' => 'php',

        // JavaScript / TypeScript
        'js' => 'javascript',
        'mjs' => 'javascript',
        'cjs' => 'javascript',
        'jsx' => 'jsx',
        'ts' => 'typescript',
        'tsx' => 'tsx',
        'mts' => 'typescript',
        'cts' => 'typescript',

        // Python
        'py' => 'python',
        'pyw' => 'python',
        'pyi' => 'python',

        // Ruby
        'rb' => 'ruby',
        'erb' => 'erb',
        'rake' => 'ruby',
        'gemspec' => 'ruby',

        // Go
        'go' => 'go',

        // Rust
        'rs' => 'rust',

        // Java
        'java' => 'java',
        'jsp' => 'java',

        // Kotlin
        'kt' => 'kotlin',
        'kts' => 'kotlin',

        // Swift
        'swift' => 'swift',

        // Dart
        'dart' => 'dart',

        // C / C++
        'c' => 'c',
        'h' => 'c',
        'cpp' => 'cpp',
        'hpp' => 'cpp',
        'cc' => 'cpp',
        'cxx' => 'cpp',
        'hxx' => 'cpp',

        // C#
        'cs' => 'csharp',

        // Objective-C
        'm' => 'objectivec',

        // Scala
        'scala' => 'scala',
        'sc' => 'scala',

        // Haskell
        'hs' => 'haskell',
        'lhs' => 'haskell',

        // Elixir
        'ex' => 'elixir',
        'exs' => 'elixir',

        // Erlang
        'erl' => 'erlang',
        'hrl' => 'erlang',

        // Clojure
        'clj' => 'clojure',
        'cljs' => 'clojure',
        'cljc' => 'clojure',

        // F#
        'fs' => 'fsharp',
        'fsx' => 'fsharp',

        // R
        'r' => 'r',
        'R' => 'r',

        // Lua
        'lua' => 'lua',

        // Perl
        'pl' => 'perl',
        'pm' => 'perl',
        't' => 'perl',

        // Shell / Bash
        'sh' => 'bash',
        'bash' => 'bash',
        'zsh' => 'bash',
        'fish' => 'bash',
        'bashrc' => 'bash',

        // PowerShell
        'ps1' => 'powershell',
        'psm1' => 'powershell',

        // Batch
        'bat' => 'batch',
        'cmd' => 'batch',

        // SQL
        'sql' => 'sql',
        'mysql' => 'sql',
        'pgsql' => 'sql',
        'plsql' => 'plsql',

        // Web
        'html' => 'markup',
        'htm' => 'markup',
        'xml' => 'markup',
        'svg' => 'markup',
        'vue' => 'markup',
        'svelte' => 'markup',
        'astro' => 'markup',
        'css' => 'css',
        'scss' => 'scss',
        'sass' => 'sass',
        'less' => 'less',
        'styl' => 'stylus',

        // Config / Data
        'json' => 'json',
        'jsonc' => 'json',
        'json5' => 'json5',
        'yaml' => 'yaml',
        'yml' => 'yaml',
        'toml' => 'toml',
        'ini' => 'ini',
        'env' => 'bash',
        'env.example' => 'bash',

        // Documentation
        'md' => 'markdown',
        'mdx' => 'markdown',
        'txt' => 'plaintext',
        'rst' => 'plaintext',

        // DevOps
        'dockerfile' => 'docker',
        'docker-compose' => 'yaml',
        'tf' => 'hcl',
        'hcl' => 'hcl',
        'tfvars' => 'hcl',

        // GraphQL
        'graphql' => 'graphql',
        'gql' => 'graphql',

        // Build / Config
        'makefile' => 'makefile',
        'cmake' => 'cmake',
        'gradle' => 'groovy',

        // Nim
        'nim' => 'nim',

        // Zig
        'zig' => 'zig',

        // V
        'v' => 'v',

        // Crystal
        'cr' => 'crystal',

        // OCaml
        'ml' => 'ocaml',
        'mli' => 'ocaml',

        // Scheme
        'scm' => 'scheme',

        // Common Lisp
        'lisp' => 'lisp',
        'el' => 'emacs-lisp',

        // LaTeX
        'tex' => 'latex',
        'sty' => 'latex',
        'cls' => 'latex',

        // Twig
        'twig' => 'twig',

        // Blade
        'blade' => 'php',
    ];

    /**
     * Language label / file extension → tech logo filename in /public/tech_logo.
     * Keys are normalized (lowercase, spaces & hyphens removed) before lookup.
     */
    protected array $logoMap = [
        // PHP family
        'php' => 'php.svg',
        'laravel' => 'laravel.svg',
        'blade' => 'php.svg',

        // JavaScript / TypeScript
        'javascript' => 'javascript.svg',
        'js' => 'javascript.svg',
        'node' => 'javascript.svg',
        'nodejs' => 'javascript.svg',
        'jsx' => 'react.svg',
        'tsx' => 'react.svg',
        'typescript' => 'typescript.svg',
        'ts' => 'typescript.svg',

        // Frontend frameworks & styling
        'react' => 'react.svg',
        'reactjs' => 'react.svg',
        'vue' => 'vue.svg',
        'vuejs' => 'vue.svg',
        'astro' => 'astro.svg',
        'tailwind' => 'tailwind.svg',
        'tailwindcss' => 'tailwind.svg',
        'html' => 'html-5.svg',
        'html5' => 'html-5.svg',
        'markup' => 'html-5.svg',
        'xml' => 'xml.svg',
        'css' => 'css.svg',
        'scss' => 'css.svg',
        'sass' => 'css.svg',
        'less' => 'less.svg',

        // Backend languages
        'python' => 'python.svg',
        'py' => 'python.svg',
        'ruby' => 'ruby.svg',
        'rails' => 'ruby.svg',
        'rb' => 'ruby.svg',
        'go' => 'go.svg',
        'golang' => 'go.svg',
        'rust' => 'rust.svg',
        'rs' => 'rust.svg',
        'java' => 'java.svg',
        'kotlin' => 'kotlin.svg',
        'kt' => 'kotlin.svg',
        'c' => 'c.svg',
        'csharp' => 'c-sharp.svg',
        'cs' => 'c-sharp.svg',

        // Shell
        'bash' => 'bash.svg',
        'shell' => 'bash.svg',
        'sh' => 'bash.svg',
        'zsh' => 'bash.svg',

        // Databases
        'mysql' => 'mysql.svg',
        'sql' => 'mysql.svg',
    ];

    /**
     * Prism language identifier → human-readable display name.
     */
    protected array $languageNames = [
        'markup' => 'HTML / Markup',
        'css' => 'CSS',
        'scss' => 'SCSS',
        'sass' => 'Sass',
        'less' => 'Less',
        'stylus' => 'Stylus',
        'javascript' => 'JavaScript',
        'typescript' => 'TypeScript',
        'jsx' => 'JSX',
        'tsx' => 'TSX',
        'json' => 'JSON',
        'json5' => 'JSON5',
        'yaml' => 'YAML',
        'toml' => 'TOML',
        'ini' => 'INI',
        'xml' => 'XML',
        'svg' => 'SVG',
        'php' => 'PHP',
        'python' => 'Python',
        'ruby' => 'Ruby',
        'erb' => 'ERB',
        'go' => 'Go',
        'rust' => 'Rust',
        'java' => 'Java',
        'kotlin' => 'Kotlin',
        'swift' => 'Swift',
        'dart' => 'Dart',
        'c' => 'C',
        'cpp' => 'C++',
        'csharp' => 'C#',
        'objectivec' => 'Objective-C',
        'scala' => 'Scala',
        'haskell' => 'Haskell',
        'elixir' => 'Elixir',
        'erlang' => 'Erlang',
        'clojure' => 'Clojure',
        'fsharp' => 'F#',
        'r' => 'R',
        'lua' => 'Lua',
        'perl' => 'Perl',
        'bash' => 'Bash / Shell',
        'powershell' => 'PowerShell',
        'batch' => 'Batch',
        'sql' => 'SQL',
        'plsql' => 'PL/SQL',
        'graphql' => 'GraphQL',
        'docker' => 'Dockerfile',
        'hcl' => 'HCL / Terraform',
        'makefile' => 'Makefile',
        'cmake' => 'CMake',
        'groovy' => 'Groovy',
        'markdown' => 'Markdown',
        'latex' => 'LaTeX',
        'nim' => 'Nim',
        'zig' => 'Zig',
        'v' => 'V',
        'crystal' => 'Crystal',
        'ocaml' => 'OCaml',
        'scheme' => 'Scheme',
        'lisp' => 'Common Lisp',
        'emacs-lisp' => 'Emacs Lisp',
        'twig' => 'Twig',
        'vue' => 'Vue',
        'svelte' => 'Svelte',
        'astro' => 'Astro',
        'plaintext' => 'Plain Text',
    ];

    /**
     * Map file extension → Prism language identifier.
     */
    public function detectLanguage(string $filename): string
    {
        $lower = strtolower($filename);

        // Check compound extensions first (e.g. "blade.php")
        foreach ($this->extensionMap as $ext => $lang) {
            if (str_ends_with($lower, '.' . $ext)) {
                return $lang;
            }
        }

        // Check exact filename matches (e.g. "Dockerfile", "Makefile")
        $filenameMap = [
            'dockerfile' => 'docker',
            'makefile' => 'makefile',
            'cmakelists.txt' => 'cmake',
            '.gitignore' => 'bash',
            '.env' => 'bash',
            '.env.example' => 'bash',
        ];

        if (isset($filenameMap[$lower])) {
            return $filenameMap[$lower];
        }

        return 'plaintext';
    }

    /**
     * Get display name for a Prism language identifier.
     */
    public function getLanguageName(string $prismKey): string
    {
        return $this->languageNames[$prismKey] ?? ucfirst($prismKey);
    }

    /**
     * Tech logo filename for a language label or file extension, or '' if none exists.
     */
    public function getLangLogo(string $lang): string
    {
        if ($lang === '') {
            return '';
        }
        $key = strtolower(str_replace([' ', '-'], '', $lang));
        return $this->logoMap[$key] ?? '';
    }

    /**
     * Tech logo filename for a filename (extension first, then detection), or '' if none exists.
     */
    public function logoForFile(string $filename): string
    {
        if ($filename === '') {
            return '';
        }
        $lower = strtolower($filename);
        $ext = str_contains($lower, '.') ? substr($lower, strrpos($lower, '.') + 1) : $lower;
        return $this->getLangLogo($ext) ?: $this->getLangLogo($this->detectLanguage($filename));
    }

    /**
     * Get all supported languages as [prism_key => display_name].
     * Ordered alphabetically by display name.
     */
    public function getSupportedLanguages(): array
    {
        $languages = $this->languageNames;
        // Remove plaintext from the selectable list
        unset($languages['plaintext']);
        asort($languages);
        return $languages;
    }

    /**
     * Try to detect language from code content heuristics.
     * Returns Prism language key or null if uncertain.
     */
    public function detectFromContent(string $code): ?string
    {
        $patterns = [
            'php' => '/<\?php|\bpublic\s+function\b|\bartisan\b|\buse\s+Illuminate\\\\/',
            'python' => '/^def\s+\w+\s*\(|^import\s+\w+|^from\s+\w+\s+import|^\s*class\s+\w+.*:/',
            'javascript' => '/\bconst\s+\w+\s*=.*=>|import\s+.*from\s+[\'"]|require\s*\(|module\.exports/',
            'typescript' => '/:\s*(string|number|boolean|void|any)\b|interface\s+\w+|type\s+\w+\s*=|<\w+>/',
            'html' => '/<!DOCTYPE\s+html|<html[\s>]|<div[\s>]|<span[\s>]/',
            'css' => '/^\s*\.[\w-]+\s*\{|^\s*#[\w-]+\s*\{|^\s*@media\b/',
            'sql' => '/\bSELECT\b.*\bFROM\b|\bINSERT\s+INTO\b|\bCREATE\s+TABLE\b|\bALTER\s+TABLE\b/',
            'bash' => '/^#!\s*\/bin\/(ba)?sh|^echo\s|^\$|^sudo\s|^apt\s|^npm\s|^yarn\s/',
            'go' => '/^package\s+\w+|^func\s+\w+\s*\(|^import\s*\(/',
            'rust' => '/^fn\s+\w+|^let\s+mut\b|^impl\s+\w+|^pub\s+fn\b|^use\s+std::/',
            'java' => '/^public\s+class\s+\w+|^import\s+java\./',
            'ruby' => '/^class\s+\w+|^def\s+\w+|^require\s+[\'"]|^module\s+\w+/',
            'csharp' => '/^using\s+\w+|^namespace\s+\w+|^\[.*\]\s*(public|private)/',
            'swift' => '/^import\s+\w+|^func\s+\w+|^var\s+\w+\s*:\s*\w+/i',
            'kotlin' => '/^fun\s+\w+|^val\s+\w+|^var\s+\w+|^class\s+\w+/i',
            'scala' => '/^object\s+\w+|^val\s+\w+|^def\s+\w+/',
            'docker' => '/^FROM\s+|^RUN\s+|^COPY\s+|^EXPOSE\s+|^CMD\s+\[/',
            'yaml' => '/^\w+:|^\s+-\s+\w+:|^---/',
            'graphql' => '/^type\s+\w+\s*\{|^query\s+\w+|^mutation\s+\w+/',
        ];

        foreach ($patterns as $lang => $regex) {
            if (preg_match($regex, $code)) {
                return $lang;
            }
        }

        return null;
    }

}
