@extends('auth.master')

@section('title', 'Register')

@section('content')
    <div class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10"
        x-data="registerForm()" x-cloak>

        <div
            class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow-blue">
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-block p-4 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Join CodeVault.</h2>
                <p class="text-gray-400 leading-relaxed">Start organizing your code snippets today.
                </p>
            </div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">

            <div class="mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-black-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile">
                        <a href="{{ url('/') }}">CodeVault</a> 
                        <span class="text-blue-500 text-xs font-normal">v1.1</span>
                    </h1>
                </div>
                <h1 class="text-2xl font-bold text-white">Create Account</h1>
                <p class="text-gray-500 text-sm mt-1">Join thousands of developers organizing their code.</p>
            </div>

            <form action="{{ url('/register') }}" method="POST" class="space-y-4">
                {{ csrf_field() }}

                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 animate-pulse">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-2.5 rounded-xl text-xs flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Full Name</label>
                    <input type="text" name="name" required placeholder="John Doe" value="{{ old('name') }}"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                    @error('name')
                        <p class="mt-1 ml-1 text-[10px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="dev@codevault.com" value="{{ old('email') }}"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                    @error('email')
                        <p class="mt-1 ml-1 text-[10px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                    @error('password')
                        <p class="mt-1 ml-1 text-[10px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 mt-2">
                    Create Account
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-500 text-xs">
                    Already have an account?
                    <a href="{{ route('login') }}" class="load-btn text-blue-400 hover:text-blue-300 font-semibold ml-1">Sign in</a>
                </p>
            </div>
        </div>
    </div>
@endsection
