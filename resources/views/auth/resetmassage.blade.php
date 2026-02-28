@extends('layout.auth')

@section('title', 'Check Your Email')

@push('styles')
<style>
    .success-glow { 
        background: radial-gradient(circle at center, rgba(34, 197, 94, 0.1) 0%, transparent 70%); 
    }
</style>
@endpush

@section('content')
    <div class="w-full max-w-md glass-card rounded-3xl p-8 md:p-12 text-center shadow-2xl relative overflow-hidden">
        <div class="success-glow absolute inset-0 z-0"></div>
        
        <div class="relative z-10">
            <div class="mb-6 inline-block p-4 bg-green-500/10 rounded-full border border-green-500/20 animate-bounce">
                <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v10a2 2 0 002 2z"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-white mb-2 tracking-tight">Check your Inbox</h2>
            <p class="text-gray-400 mb-8 text-sm leading-relaxed">
                We've sent a recovery link to your Gmail. Please click the link to verify your identity and reset your vault password.
            </p>

            <div class="space-y-4">
                <a href="https://mail.google.com" target="_blank" 
                   class="block w-full bg-blue-600 hover:bg-blue-500 text-white py-3 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20">
                    Open Gmail
                </a>
                
                <a href="{{ url('/') }}" class="load-btn block text-[11px] text-gray-500 hover:text-white transition-colors">
                    Back to Login
                </a>
            </div>
        </div>
    </div>
@endsection