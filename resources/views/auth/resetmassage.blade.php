@extends('layout.auth')

@section('title', 'Transmission Sent')

@push('styles')
<style>
    .status-glow { 
        background: radial-gradient(circle at center, rgba(94, 106, 210, 0.1) 0%, transparent 70%); 
    }
</style>
@endpush

@section('content')
    <div class="w-full max-w-md glass-card rounded-[3rem] p-12 text-center shadow-2xl relative overflow-hidden">
        <div class="status-glow absolute inset-0 z-0 opacity-50"></div>
        
        <div class="relative z-10">
            <div class="mb-10 inline-block p-6 bg-purple-500/10 rounded-[2.5rem] border border-purple-500/20 shadow-[0_0_40px_rgba(94,106,210,0.2)] animate-pulse">
                <svg class="w-14 h-14 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v10a2 2 0 002 2z"></path>
                </svg>
            </div>

            <h2 class="text-3xl font-black text-white mb-3 tracking-tighter">Transmission Secured</h2>
            <p class="text-[#71717A] mb-12 text-xs font-medium uppercase tracking-[0.2em] leading-relaxed px-4">
                We've dispatched a recovery node to your terminal. Verify your identity via the secure link to reset your vault access.
            </p>

            <div class="space-y-4">
                <a href="https://mail.google.com" target="_blank" 
                   class="btn-primary block w-full py-5 rounded-2xl text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl">
                    Access Terminal
                </a>
                
                <a href="{{ url('/') }}" class="load-btn block text-[10px] font-black text-[#3F3F46] hover:text-white uppercase tracking-widest transition-all">
                    Return to Login
                </a>
            </div>
        </div>
    </div>
@endsection