@extends('layout.auth')

@section('title', 'Verify Account')

@section('content')
    <div class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10"
        x-data="verifyForm()" x-cloak>

        <div
            class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow-blue">
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-block p-4 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Identity Sync.</h2>
                <p class="text-gray-400 leading-relaxed">
                    Verify your access to the secure logic vault via the encrypted token sent to your terminal.
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
                <h1 class="text-2xl font-bold text-white">Email Verification</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Token dispatched to <span class="text-blue-400">{{ session('userEmail') ?? 'registered node' }}</span>
                </p>
            </div>

            <form method="POST" action="{{ url('/verify-registration') }}" class="space-y-6" id="otp-form">
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

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-4 ml-1">Verification Matrix</label>
                        <div class="flex justify-between gap-2 sm:gap-3" id="otp-inputs">
                            @for ($i = 0; $i < 6; $i++)
                                <input type="text" maxlength="1"
                                    class="otp-box w-full h-14 text-center text-xl font-bold bg-black/50 border border-white/10 rounded-xl text-white outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all shadow-inner"
                                    inputmode="text">
                            @endfor
                        </div>
                        <input type="hidden" name="verification_code" id="verification_code">

                        @error('verification_code')
                            <p class="mt-3 ml-1 text-[10px] text-red-400 uppercase tracking-widest font-bold text-center">
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-500 text-white py-3 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20">
                        Verify Identity
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-500 text-xs">
                    Didn't receive a code?
                    <a href="#" class="text-blue-400 hover:text-blue-300 font-semibold ml-1">Resend Token</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('#otp-inputs .otp-box');
            const hiddenInput = document.getElementById('verification_code');
            const form = document.getElementById('otp-form');

            const updateHiddenValue = () => {
                const code = Array.from(inputs).map(i => i.value || '').join('');
                hiddenInput.value = code;
            };

            inputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (this.value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    updateHiddenValue();
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });
        });
    </script>
@endsection
