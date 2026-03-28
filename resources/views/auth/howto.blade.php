@extends('auth.master')

@section('title', 'How to Use CodeVault')

@section('content')
    <div class="w-full max-w-4xl mx-auto px-4 py-10 space-y-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ url('/dashboard') }}"
               class="group p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 text-gray-400 hover:text-white transition-all shadow-xl">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">How to Use CodeVault</h1>
                <p class="text-gray-400 text-sm font-medium">
                    A quick guide to saving, organizing, and sharing your code snippets.
                </p>
            </div>
        </div>

        <div class="glass-card rounded-[2.5rem] p-8 md:p-12 space-y-10 relative overflow-hidden">
            {{-- Decorative Glow --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-purple-500/5 blur-3xl rounded-full"></div>

            <div class="flex items-start gap-6 relative">
                <div
                    class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/30 flex items-center justify-center text-purple-400 text-lg font-black shadow-[0_0_20px_rgba(94,106,210,0.1)]">
                    1
                </div>
                <div class="flex-1">
                    <h2 class="text-xl md:text-2xl font-black text-white mb-2 tracking-tight">Identity & Access</h2>
                    <p class="text-sm text-[#A1A1AA] leading-relaxed">
                        Establish your secure vault identity via the registration protocol. Once authenticated, you will be redirected to the <span class="text-purple-400 font-black uppercase tracking-widest text-[10px]">Command Center</span> (Dashboard) to manage your global archives.
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-6 relative">
                <div
                    class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/30 flex items-center justify-center text-purple-400 text-lg font-black shadow-[0_0_20px_rgba(94,106,210,0.1)]">
                    2
                </div>
                <div class="flex-1">
                    <h2 class="text-xl md:text-2xl font-black text-white mb-2 tracking-tight">Archive Construction</h2>
                    <p class="text-sm text-[#A1A1AA] leading-relaxed mb-4">
                        Initialize a new logic stream by invoking the <span class="text-purple-400 font-bold">New Snippet</span> action. The high-performance editor allows you to:
                    </p>
                    <ul class="text-sm text-[#EDEDED] space-y-2 list-none mb-4">
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-purple-500"></div>
                            Assign an <span class="font-black">Archive Title</span> and encrypted metadata.
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-purple-500"></div>
                            Select from <span class="font-black">20+ Syntax Archetypes</span> (PHP, React, Vue, etc.).
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-purple-500"></div>
                            Incorporate <span class="font-black">Multiple Logic Nodes</span> (Files) in a single archive.
                        </li>
                    </ul>
                    <p class="text-[10px] text-[#71717A] uppercase tracking-[0.2em] font-black italic">
                        Commit your changes to secure the logic in your permanent vault.
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-6 relative">
                <div
                    class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/30 flex items-center justify-center text-purple-400 text-lg font-black shadow-[0_0_20px_rgba(94,106,210,0.1)]">
                    3
                </div>
                <div class="flex-1">
                    <h2 class="text-xl md:text-2xl font-black text-white mb-2 tracking-tight">Vault Intelligence</h2>
                    <p class="text-sm text-[#A1A1AA] leading-relaxed mb-4">
                        The Command Center provides real-time access to your entire logic collection with advanced indexing:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-white/[0.02] border border-white/5 rounded-2xl">
                            <h4 class="text-[10px] font-black text-purple-400 uppercase tracking-widest mb-1">Search Matrix</h4>
                            <p class="text-xs text-[#71717A]">Instant keyword matching across titles and descriptions.</p>
                        </div>
                        <div class="p-4 bg-white/[0.02] border border-white/5 rounded-2xl">
                            <h4 class="text-[10px] font-black text-purple-400 uppercase tracking-widest mb-1">Partner Streams</h4>
                            <p class="text-xs text-[#71717A]">Access logic shared by verified vault partners.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-6 relative">
                <div
                    class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/30 flex items-center justify-center text-purple-400 text-lg font-black shadow-[0_0_20px_rgba(94,106,210,0.1)]">
                    4
                </div>
                <div class="flex-1">
                    <h2 class="text-xl md:text-2xl font-black text-white mb-2 tracking-tight">External Integration</h2>
                    <p class="text-sm text-[#A1A1AA] leading-relaxed mb-4">
                        CodeVault leverages <span class="font-bold text-[#EDEDED]">Laravel Sanctum</span> for secure API access, enabling cross-platform logic injection:
                    </p>
                    <ul class="text-sm text-[#EDEDED] space-y-2 list-none">
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-purple-500"></div>
                            Generate <span class="font-black">Secure API Tokens</span> via user settings.
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-purple-500"></div>
                            Fetch encrypted snippets directly into your <span class="font-black">IDE or CI/CD pipelines</span>.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/5 pt-5 mt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <p class="text-xs text-gray-500 uppercase tracking-[0.2em] font-semibold">
                    TIP: You can always come back to this guide at <span class="text-gray-300">/how-to-use-codevault</span>.
                </p>
                <a href="{{ url('/dashboard') }}"
                   class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs px-4 py-2.5 rounded-xl font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 12h14M5 12l4-4m-4 4l4 4"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection

