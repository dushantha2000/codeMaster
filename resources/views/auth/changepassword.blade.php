@extends('auth.master')

@section('title', 'Set New Password')

@section('content')
    <div class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5" 
         x-data="resetForm()" x-cloak>
        
        <div class="hidden md:flex md:w-1/2 relative items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow-purple">
            <div class="relative z-10 text-center">
                <div class="mb-8 inline-block p-5 bg-purple-500/10 rounded-3xl border border-purple-500/20 shadow-[0_0_30px_rgba(94,106,210,0.15)]">
                    <svg class="w-20 h-20 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-white mb-4 tracking-tighter">Secure <span class="text-purple-500">Node</span></h2>
                <p class="text-[#A1A1AA] leading-relaxed text-xs font-medium uppercase tracking-widest">Choose a high-entropy credential to protect your logic archives.</p>
            </div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-500/5 blur-3xl rounded-full"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            
            <div class="mb-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-[#0A0A0A] p-2 rounded-2xl border border-white/5 text-purple-500 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-black text-white tracking-widest uppercase text-xs">CodeVault <span class="text-purple-500 font-bold ml-1">LOCKED</span></h1>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Reset Password</h1>
                <p class="text-[#71717A] text-[10px] font-black uppercase tracking-[0.2em] mt-2">Choose a new password for your account.</p>
            </div>

            <form action="{{ url('update-password') }}" method="POST" class="space-y-5">
                {{ csrf_field() }}
                
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="space-y-6">
                    <div>
                        <label for="reset-email" class="block text-[10px] font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 ml-1">Email Address</label>
                        <input type="email" id="reset-email" name="email" required placeholder="dev@codevault.com" 
                            class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-sm text-[#EDEDED] outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/50 transition-all shadow-inner placeholder-[#3F3F46]">
                        @error('email')
                            <p class="text-[10px] text-red-500 mt-2 font-bold uppercase tracking-widest ml-1">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div>
                        <label class="block text-[10px] font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 ml-1">New Password</label>
                        <input type="password" name="password" required placeholder="••••••••" 
                            class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-sm text-[#EDEDED] outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/50 transition-all shadow-inner placeholder-[#3F3F46]">
                    </div>
    
                    <div>
                        <label for="reset-password-confirm" class="block text-[10px] font-black text-[#71717A] uppercase tracking-[0.2em] mb-3 ml-1">Confirm New Password</label>
                        <input type="password" id="reset-password-confirm" name="password_confirmation" required placeholder="••••••••" 
                            class="w-full bg-[#0A0A0A] border border-white/5 rounded-2xl px-5 py-4 text-sm text-[#EDEDED] outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/50 transition-all shadow-inner placeholder-[#3F3F46]">
                        @error('password')
                            <p class="text-[10px] text-red-500 mt-2 font-bold uppercase tracking-widest ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit" 
                    class="btn-primary w-full py-5 rounded-2xl text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl mt-6">
                    Update Password
                </button>
            </form>
        </div>
    </div>
@endsection