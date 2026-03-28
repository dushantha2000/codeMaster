@extends('layout.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5" 
         x-data="forgotPassword()" x-cloak>
        
        <div class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow-purple">
            <div class="relative z-10 text-center">
                <div class="mb-8 inline-block p-5 bg-purple-500/10 rounded-3xl border border-purple-500/20 shadow-[0_0_30px_rgba(94,106,210,0.15)]">
                    <svg class="w-20 h-20 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-white mb-4 tracking-tighter">Vault <span class="text-purple-500">Recovery</span></h2>
                <p class="text-[#A1A1AA] leading-relaxed text-xs font-medium uppercase tracking-widest">Re-establish your logic stream signature via secure identity verification.</p>
            </div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-purple-500/5 blur-3xl rounded-full"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            
            <div class="mb-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-[#0A0A0A] p-2 rounded-2xl border border-white/5 text-purple-500 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-black text-white tracking-widest uppercase text-xs">CodeVault <span class="text-purple-500 font-bold ml-1">SECURE</span></h1>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Access Recovery</h1>
                <p class="text-[#71717A] text-[10px] font-black uppercase tracking-[0.2em] mt-2">Initialize the signature reset protocol.</p>
            </div>

            @if (session('error'))
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-xl text-[11px] mb-4 flex items-center gap-2">
                    {{ session('error') }}
                </div>
            @endif

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 ml-1">Identity Email</label>
                        <input type="email" name="email" required placeholder="dev@codevault.com" 
                            class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-sm text-[#EDEDED] outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/50 transition-all shadow-inner placeholder-[#3F3F46]">
                        @error('email')
                            <p class="text-[10px] text-red-500 mt-2 font-bold uppercase tracking-widest ml-1">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <button type="submit" 
                        class="btn-primary w-full py-5 rounded-2xl text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl mt-2">
                        Request Reset Node
                    </button>
                </div>

            <div class="mt-8 flex flex-col items-center gap-4 text-center">
                <a href="{{ url('/') }}" class="load-btn flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-[#71717A] hover:text-white transition-all">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Return to Terminal
                </a>
                
                <p class="text-[#3F3F46] text-[9px] font-black uppercase tracking-widest leading-relaxed max-w-[280px]">
                    Index delay may occur. Check encrypted/spam archives if transmission is not received within 300s.
                </p>
            </div>
        </div>
    </div>
@endsection

