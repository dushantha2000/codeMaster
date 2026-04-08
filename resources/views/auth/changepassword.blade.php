@extends('layout.auth')

@section('title', 'Update Password')

@section('content')
    <div class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10"
        x-data="{ 
            password: '', 
            password_confirmation: '',
            get hasLetters() { return /[a-zA-Z]/.test(this.password) },
            get hasNumbers() { return /[0-9]/.test(this.password) },
            get hasSymbols() { return /[^a-zA-Z0-9]/.test(this.password) },
            get strengthLvl() {
                let score = 0;
                if (this.password.length >= 8) score++;
                if (this.hasLetters) score++;
                if (this.hasNumbers) score++;
                if (this.hasSymbols) score++;
                return score;
            },
            get isComplex() { 
                return this.hasLetters && this.hasNumbers && this.hasSymbols && this.password.length >= 8 
            },
            get passwordsMatch() {
                return this.password === this.password_confirmation && this.password.length > 0
            },
            get showWarning() {
                return this.password_confirmation.length > 0 && this.password !== this.password_confirmation
            }
        }" x-cloak>

        <div
            class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow-blue">
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-block p-4 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                        </path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Vault Recovery.</h2>
                <p class="text-gray-400 leading-relaxed">
                    Re-establish your logic stream signature via secure identity verification.
                </p>
            </div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">

            <div class="mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <!-- Logo -->
                    <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('logo/mainlogo.png') }}" alt="CodeVault Logo"
                            class="w-full h-full object-contain transform scale-125">
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight">CodeVault</h1>
                </div>
                <h1 class="text-2xl font-bold text-white"> Password Reset</h1>
                <p class="text-gray-500 text-sm mt-1">Reset your password.</p>
            </div>

            <form action="{{ url('/reset-password') }}" method="POST" class="space-y-4">
                {{ csrf_field() }}

                
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                @if (session('status'))
                    <div
                        class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 px-4 py-2.5 rounded-xl text-xs flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('status') }}
                    </div>
                @endif

                <!-- new Password -->
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">New Password</label>
                    <input type="password" name="password" x-model="password" required placeholder="••••••••"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                    
                    <!-- Modern Password Strength Meter -->
                    <div class="mt-3 space-y-2 px-0.5" x-show="password.length > 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider transition-colors duration-300" 
                                :class="strengthLvl <= 1 ? 'text-red-400' : (strengthLvl <= 3 ? 'text-amber-400' : 'text-emerald-400')"
                                x-text="strengthLvl <= 1 ? 'Vulnerable' : (strengthLvl <= 3 ? 'Protecting' : 'Secure Vault')">
                            </span>
                            <span class="text-[10px] text-gray-500 font-medium" x-text="`${Math.min(strengthLvl * 25, 100)}%`"></span>
                        </div>
                        <div class="h-1 w-full bg-white/5 rounded-full overflow-hidden flex gap-0.5">
                            <div class="h-full transition-all duration-500 rounded-full" 
                                :style="`width: ${Math.min(strengthLvl * 25, 100)}%`"
                                :class="strengthLvl <= 1 ? 'bg-red-500/60' : (strengthLvl <= 3 ? 'bg-amber-500/60' : 'bg-emerald-500/60')">
                            </div>
                        </div>
                        
                        <div class="flex gap-2 mt-2">
                            <template x-for="rule in [{met: password.length>=8, label: '8+'}, {met: hasLetters, label: 'Aa'}, {met: hasNumbers, label: '123'}, {met: hasSymbols, label: '#@!'}]">
                                <div class="h-0.5 flex-1 rounded-full transition-colors duration-300" 
                                    :class="rule.met ? 'bg-emerald-500/40' : 'bg-white/5'">
                                </div>
                            </template>
                        </div>
                    </div>

                    @error('password')
                        <p class="mt-1 ml-1 text-[10px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Confirm New Password</label>
                    <input type="password" name="password_confirmation" x-model="password_confirmation" required placeholder="••••••••"
                        :class="showWarning ? 'border-red-500/50' : (passwordsMatch ? 'border-emerald-500/50' : '')"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                    <div x-show="showWarning" x-transition class="mt-1 ml-1 text-[10px] text-red-400">
                        Passwords do not match
                    </div>
                    <div x-show="passwordsMatch" x-transition class="mt-1 ml-1 text-[10px] text-emerald-400">
                        Passwords match
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 ml-1 text-[10px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    :disabled="!passwordsMatch || !isComplex"
                    :class="(!passwordsMatch || !isComplex) ? 'opacity-50 cursor-not-allowed text-gray-500' : 'btn-primary'"
                    class="w-full py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 mt-2">
                    Update Password
                </button>
            </form>

            <div class="mt-8 text-center flex flex-col items-center gap-4">
                <a href="{{ url('/') }}"
                    class="load-btn flex items-center gap-2 text-xs font-semibold text-blue-400 hover:text-blue-300 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Return to Terminal
                </a>

                <p class="text-gray-600 text-[10px] leading-relaxed max-w-[280px]">
                    Check encrypted/spam archives if the reset transmission is not received within 300s.
                </p>
            </div>
        </div>
    </div>
@endsection