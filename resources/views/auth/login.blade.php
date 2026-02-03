@extends('auth.master')

@section('title', 'Login')

@section('content')
    <div class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10"
        x-data="loginForm()" x-cloak>

        <div
            class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow-blue">
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-block p-4 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Secure Your Code.</h2>
                <p class="text-gray-400 leading-relaxed">The ultimate vault for your snippets and architectural patterns.
                </p>
            </div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">

            <div class="mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <div class="bg-white/10 p-1.5 rounded-lg border border-white/10 text-blue-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight">CodeVault <span
                            class="text-blue-500 text-xs font-normal">v1.0</span></h1>
                </div>
                <h1 class="text-2xl font-bold text-white">Welcome Back</h1>
                <p class="text-gray-500 text-sm mt-1">Please enter your details to sign in.</p>
            </div>

            <form action="{{ url('user-login') }}" method="POST" class="space-y-4">
                {{ csrf_field() }}

                @if (session('error'))
                    <div
                        class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 animate-pulse">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="dev@codevault.com"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                    @error('email')
                        <p class="mt-1 ml-1 text-[10px] text-red-400 ">{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5 ml-1">
                        <label class="block text-xs font-medium text-gray-400">Password</label>
                        <a href="{{ url('reset') }}" class=" load-btn text-[11px] text-blue-400 hover:underline">Forgot?</a>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">

                    @error('password')
                        <p class="mt-1 ml-1 text-[10px] text-red-400 uppercase tracking-widest font-bold">{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center py-1">
                    <input type="checkbox" id="remember" name="remember" required
                        class="w-4 h-4 rounded border-gray-700 bg-black/50 text-blue-600 focus:ring-0">
                    <label for="remember" class="ml-2 text-xs text-gray-500 selection:bg-none">Keep me logged in</label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 mt-2">
                    Sign In
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-500 text-xs">
                    New to CodeVault?
                    <a href="{{ url('register') }}"
                        class=" load-btn text-blue-400 hover:text-blue-300 font-semibold ml-1">Create an account</a>
                </p>
            </div>
        </div>
    </div>
