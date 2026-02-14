@extends('auth.master')

@section('title', 'Reset Password')

@section('content')
    <div class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/5" 
         x-data="forgotPassword()" x-cloak>
        
        <div class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow-red">
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-block p-4 bg-red-500/10 rounded-2xl border border-red-500/20">
                    <svg class="w-16 h-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Password Recovery</h2>
                <p class="text-gray-400 leading-relaxed text-sm">Don't worry, it happens to the best of us. Let's get you back into your vault.</p>
            </div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-red-600/5 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <div class="bg-white/10 p-1.5 rounded-lg border border-white/10 text-blue-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight">CodeVault <span class="text-blue-500 text-xs font-normal">v1.1</span></h1>
                </div>
                <h1 class="text-2xl font-bold text-white">Forgot Password?</h1>
                <p class="text-gray-500 text-sm mt-1">Enter your email and we'll send reset instructions.</p>
            </div>

            @if (session('error'))
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-xl text-[11px] mb-4 flex items-center gap-2">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ url('send-Reset-Code') }}" method="POST" class="space-y-6">
                {{ csrf_field() }}
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="dev@codevault.com" 
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                    @error('email')
                        <p class="text-[10px] text-red-400 mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 mt-2">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-8 flex flex-col items-center gap-4 text-center">
                <a href="{{ url('/') }}" class="load-btn flex items-center gap-2 text-xs text-gray-400 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Login
                </a>
                
                <p class="text-gray-600 text-[11px] max-w-[250px]">
                    If you don't receive an email within 5 minutes, please check your spam folder.
                </p>
            </div>
        </div>
    </div>
@endsection

