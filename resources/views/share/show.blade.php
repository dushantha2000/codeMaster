@extends('layout.share')

@section('title', $snippet->title)

@section('content')
    <div class="max-w-6xl mx-auto" x-data="sharedSnippet()">

        {{-- Header --}}
        <div class="flex items-center justify-between gap-4 mb-6 pt-2">
            <div class="flex items-center gap-3 min-w-0">
                <img src="{{ asset('logo/mainlogo.png') }}" alt="CodeVault Logo"
                    class="w-10 h-10 object-contain shrink-0">
                <div class="min-w-0">
                    <h1 class="text-lg md:text-2xl font-black text-white tracking-tight truncate">{{ $snippet->title }}</h1>
                    <p class="text-[10px] text-gray-500 font-mono uppercase tracking-widest">
                        {{ $snippet->language }} · {{ $snippet->files->count() }} files
                        @if ($snippet->user)
                            · by {{ $snippet->user->name }}
                        @endif
                    </p>
                </div>
            </div>
            <span
                class="shrink-0 px-3 py-1.5 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] rounded-lg font-black uppercase tracking-widest">{{ $snippet->language }}</span>
        </div>

        @if ($snippet->description)
            <p class="text-gray-400 text-sm mb-6 leading-relaxed">{{ $snippet->description }}</p>
        @endif

        @php
            $files = $snippet->files;
            $codeClass = 'language-' . strtolower((string) $snippet->language);
            $highlighter = app(\App\Services\SyntaxHighlighter::class);
            $iconFor = function ($name) use ($highlighter) {
                $logo = $highlighter->logoForFile((string) $name);
                return $logo
                    ? '<img src="' . asset('tech_logo/' . $logo) . '" alt="" class="w-4 h-4 object-contain inline-block align-middle">'
                    : '📄';
            };
        @endphp

        @if ($files->isNotEmpty())
            {{-- File Tabs --}}
            <div class="flex items-center gap-2 overflow-x-auto custom-mini-scrollbar mb-4 p-1.5 bg-black/40 rounded-2xl border border-white/5">
                @foreach ($files as $index => $file)
                    <button
                        @click="activeFileTab = {{ $index }}; $nextTick(() => { if (typeof Prism !== 'undefined') Prism.highlightAll(); })"
                        :class="activeFileTab === {{ $index }}
                            ? 'bg-blue-600/10 text-blue-400 border-blue-500/50'
                            : 'text-gray-500 border-transparent hover:text-gray-300 hover:bg-white/5'"
                        class="shrink-0 px-4 py-2 rounded-lg text-[11px] font-mono border transition-all flex items-center gap-2">
                        <span>{!! $iconFor($file->file_name) !!}</span>
                        <span>{{ $file->file_name }}</span>
                    </button>
                @endforeach
            </div>

            {{-- Code Panels (first file rendered server-side, visible without JS) --}}
            @foreach ($files as $index => $file)
                <div x-show="activeFileTab === {{ $index }}" {{ $index > 0 ? 'x-cloak' : '' }}>
                    <div
                        class="flex items-center justify-between gap-3 px-4 py-3 mb-2 rounded-xl bg-white/[0.02] border border-white/5">
                        <span class="text-xs text-gray-400 font-mono truncate">{{ $file->file_name }}</span>
                        <button @click="copyCode(files[{{ $index }}].content)"
                            class="shrink-0 px-3 py-1.5 rounded-lg border border-white/10 bg-white/5 hover:bg-white/10 transition-all flex items-center gap-2 text-[10px]">
                            <span x-show="!copyDone">📋</span>
                            <span x-show="copyDone">✅</span>
                            <span class="hidden md:inline" x-text="copyDone ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                    <pre class="!m-0 p-4 md:p-6 overflow-auto max-h-[65vh]"><code class="{{ $codeClass }} !whitespace-pre-wrap !break-words !font-mono">{{ $file->content ?: '// No content' }}</code></pre>
                </div>
            @endforeach
        @else
            <div class="glass-card rounded-2xl border border-white/5 p-12 text-center">
                <p class="text-gray-500 text-sm">No files in this snippet.</p>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function sharedSnippet() {
            return {
                files: @json($files->map(fn ($f) => ['file_name' => $f->file_name, 'content' => $f->content])),
                activeFileTab: 0,
                copyDone: false,

                copyCode(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.copyDone = true;
                        setTimeout(() => this.copyDone = false, 2000);
                    }).catch(() => {
                        const textarea = document.createElement('textarea');
                        textarea.value = text;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                        this.copyDone = true;
                        setTimeout(() => this.copyDone = false, 2000);
                    });
                }
            };
        }
    </script>
@endsection
