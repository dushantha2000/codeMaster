{{-- ============================================================
     Language filter chips — quick-filter pills with tech logos.
     Lives inside a snippetBrowser() Alpine scope so it can use:
       selectedLanguage, fetchSnippets(), langLogoUrl()
     Expects a $languages list (distinct DB language values).
     ============================================================ --}}
@php
    $chipLabels = [
        'laravel' => 'Laravel', 'react' => 'React', 'tailwind' => 'Tailwind CSS',
        'javascript' => 'JavaScript', 'js' => 'JavaScript', 'node' => 'Node.js',
        'typescript' => 'TypeScript', 'ts' => 'TypeScript', 'tsx' => 'TSX', 'jsx' => 'JSX',
        'python' => 'Python', 'php' => 'PHP', 'html' => 'HTML', 'markup' => 'HTML',
        'xml' => 'XML', 'css' => 'CSS', 'scss' => 'SCSS', 'sass' => 'Sass',
        'less' => 'Less', 'vue' => 'Vue', 'sql' => 'SQL', 'mysql' => 'MySQL',
        'blade' => 'Blade', 'bash' => 'Bash', 'shell' => 'Shell', 'zsh' => 'Zsh',
        'csharp' => 'C#', 'c#' => 'C#', 'c' => 'C', 'cpp' => 'C++',
        'go' => 'Go', 'golang' => 'Go', 'java' => 'Java', 'kotlin' => 'Kotlin',
        'ruby' => 'Ruby', 'rust' => 'Rust', 'astro' => 'Astro', 'svelte' => 'Svelte',
        'swift' => 'Swift', 'dart' => 'Dart', 'json' => 'JSON', 'yaml' => 'YAML',
        'docker' => 'Docker', 'markdown' => 'Markdown', 'batch' => 'Batch',
        'plaintext' => 'Text', 'text' => 'Text',
    ];
@endphp

@if (!empty($languages))
    <div class="flex flex-wrap items-center gap-2">
        {{-- All Languages chip --}}
        <button type="button" @click="selectedLanguage = 'all'; fetchSnippets()"
            :class="selectedLanguage === 'all' ? 'bg-blue-500/15 text-blue-300 border-blue-500/40' : 'text-gray-400 border-white/10 hover:text-white hover:bg-white/10 hover:border-white/20'"
            class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-full border bg-white/5 text-[11px] font-semibold transition-all">
            <span class="text-xs leading-none">🌐</span>
            <span>All Languages</span>
        </button>

        {{-- One chip per distinct language in the vault --}}
        @foreach ($languages as $language)
            @if ($language && $language !== 'all')
                @php($chipLabel = $chipLabels[strtolower($language)] ?? ucfirst($language))
                <button type="button" @click="selectedLanguage = '{{ $language }}'; fetchSnippets()"
                    :class="selectedLanguage === '{{ $language }}' ? 'bg-blue-500/15 text-blue-300 border-blue-500/40' : 'text-gray-400 border-white/10 hover:text-white hover:bg-white/10 hover:border-white/20'"
                    class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-full border bg-white/5 text-[11px] font-semibold transition-all">
                    <template x-if="langLogoUrl('{{ $language }}')">
                        <img :src="langLogoUrl('{{ $language }}')" :alt="'{{ $language }}'"
                            :title="'{{ $language }}'" class="w-4 h-4 object-contain" x-cloak>
                    </template>
                    <span>{{ $chipLabel }}</span>
                </button>
            @endif
        @endforeach
    </div>
@endif
