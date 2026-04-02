@extends('layout.auth')

@section('title', 'Register')

@section('content')
    <div class="flex flex-col md:flex-row-reverse w-full max-w-4xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10"
        x-data="registerForm()" x-cloak>

        <div
            class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-l border-white/5 image-glow-blue">
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-block p-4 ">
                    <div class="w-10 h-10 md:w-20 md:h-20 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('logo/mainlogo.png') }}" alt="CodeVault Logo"
                            class="w-full h-full object-contain transform scale-125">
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Code Storage Redefined.</h2>
                <p class="text-gray-400 leading-relaxed text-sm">Join thousands of developers keeping their logic safe and
                    organized.</p>
            </div>
            <div class="absolute w-64 h-64 border border-white/5 rounded-full -top-20 -right-20"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col justify-center">

            <div class="mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <!-- Logo -->
                    <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('logo/mainlogo.png') }}" alt="CodeVault Logo"
                            class="w-full h-full object-contain transform scale-125">
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile"><a
                            href="{{ url('/') }}">CodeVault</a> 
                    </h1>
                </div>
                <h1 class="text-2xl font-bold text-white">Create Account</h1>
                <p class="text-gray-500 text-sm mt-1">Start your journey with us today.</p>
            </div>

            {{-- @if (session('message'))
                <div
                    class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 px-4 py-3 rounded-xl text-sm mb-4 flex items-center gap-2 shadow-lg shadow-emerald-900/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('message') }}
                </div>
            @endif --}}

            <form action="{{ url('user-register') }}" method="POST" class="space-y-3.5">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1 ml-1">Email</label>
                    <input type="email" name="email" required placeholder="name@company.com"
                        class="input-field w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600">

                    @error('email')
                        <p class="text-[10px] text-red-400 mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1 ml-1">Username</label>
                    <input type="text" name="userName" required placeholder="JohnDoe_1"
                        class="input-field w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600">

                    @error('userName')
                        <p class="text-[10px] text-red-400 mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>



                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1 ml-1">Password</label>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="input-field w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1 ml-1">Confirm</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••"
                            class="input-field w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600">

                    </div>

                    @error('password')
                        <div class="col-span-full">
                            <p class="text-[10px] text-red-400 mt-1 ml-1">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="flex items-center py-1">
                    <input type="checkbox" id="terms" required
                        class="w-3.5 h-3.5 rounded border-gray-700 bg-black text-blue-600 focus:ring-0">
                    <label for="terms" class="ml-2 text-[11px] text-gray-500">
                        I agree to the <a href="#" class="text-blue-400 hover:underline">Terms of Service</a>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 mt-2">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center border-t border-white/5 pt-4">
                <p class="text-gray-500 text-xs">
                    Already have an account?
                    <a href="{{ url('/') }}"
                        class=" load-btn text-blue-400 hover:text-blue-300 font-semibold ml-1">Sign in</a>
                </p>
            </div>
        </div>
    </div>
