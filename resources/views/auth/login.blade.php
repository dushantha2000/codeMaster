@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="flex flex-col md:flex-row w-full max-w-4xl bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100"
        x-data="loginForm()" x-cloak>

        <div
            class="hidden md:flex md:w-1/2 relative bg-gradient-to-br from-indigo-50 to-white items-center justify-center p-12 overflow-hidden border-r border-gray-200">
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-block p-4 bg-indigo-100 rounded-2xl">
                    <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Secure Your Code.</h2>
                <p class="text-gray-500 leading-relaxed">The ultimate vault for your snippets and architectural patterns.
                </p>
            </div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-200 rounded-full blur-3xl opacity-30"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white">

            <div class="mb-8">
                <div class="flex items-center gap-2 mb-2">
                     <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-800 tracking-tight hide-on-mobile"><a
                            href="{{ url('/') }}">CodeVault</a> <span class="text-indigo-500 text-xs font-normal">v1.1</span>
                    </h1>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Welcome Back</h1>
                <p class="text-gray-500 text-sm mt-1">Please enter your details to sign in.</p>
            </div>

            <form action="{{ url('/login') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                {{ csrf_field() }}

                @if(session('error'))
                    <div
                        class="bg-red-50 border border-red-200 text-red-600 px-4 py-2.5 rounded-xl text-xs flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div
                        class="bg-red-50 border border-red-200 text-red-600 px-4 py-2.5 rounded-xl text-xs flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="dev@codevault.com" value="{{ old('email') }}"
                        class="w-full rounded-xl px-4 py-3 text-sm bg-gray-50 border border-gray-200 text-gray-800 placeholder-gray-400 focus:border-indigo-300 focus:outline-none focus:ring-1 focus:ring-indigo-300 transition-all">
                    @error('email')
                        <p class="mt-1 ml-1 text-[10px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5 ml-1">
                        <label class="block text-xs font-medium text-gray-600">Password</label>
                        <a href="{{ route('password.request') }}" class="load-btn text-[11px] text-indigo-500 hover:text-indigo-600 hover:underline">Forgot?</a>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full rounded-xl px-4 py-3 text-sm bg-gray-50 border border-gray-200 text-gray-800 placeholder-gray-400 focus:border-indigo-300 focus:outline-none focus:ring-1 focus:ring-indigo-300 transition-all">

                    @error('password')
                        <p class="mt-1 ml-1 text-[10px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center py-1">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="remember" class="ml-2 text-xs text-gray-600">Keep me logged in</label>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-indigo-200 mt-2">
                    Sign In
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-500 text-xs">
                    New to CodeVault?
                    <a href="{{ route('register') }}"
                        class="load-btn text-indigo-600 hover:text-indigo-700 font-semibold ml-1">Create an account</a>
                </p>
            </div>
        </div>
    </div>
@endsection