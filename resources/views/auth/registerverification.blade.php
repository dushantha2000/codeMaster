@extends('auth.master')

@section('title', 'Verify Account')

@section('content')
    <div
        class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10">

        <div
            class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow-blue">
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-block p-4 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 12a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a4 4 0 004 4M16 12V7m0 0h-2m2 0h2M8 21h8" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Verify Your Account.</h2>
                <p class="text-gray-400 leading-relaxed">
                    Enter the verification code we sent to your email to activate your CodeVault account.
                </p>
            </div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <div
                        class="w-8 h-8 bg-black-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile"><a
                            href="{{ url('/') }}">CodeVault</a> <span
                            class="text-blue-500 text-xs font-normal">v1.0</span>
                    </h1>
                </div>
                <h1 class="text-2xl font-bold text-white">Email Verification
                </h1>
                <p class="text-gray-500 text-sm mt-1">Please enter the verification code sent to <span
                        class="text-blue-400 font-medium">{{ session('userEmail') ?? 'your email' }}</span> to complete your
                    registration.</p>
            </div>

            <form method="POST" action="{{ url('/verify-registration') }}"  class="space-y-6" id="otp-form">
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
                    <label class="block text-xs font-medium text-gray-400 mb-4 ml-1">Verification Code</label>

                    <div class="flex justify-between gap-2" id="otp-inputs">
                        @for ($i = 0; $i < 6; $i++)
                            <input type="text" maxlength="1"
                                class="otp-box w-12 h-14 text-center text-xl font-bold bg-white/5 border border-white/10 rounded-xl text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all"
                                inputmode="text"> 
                        @endfor
                    </div>

                    <input type="hidden" name="verification_code" id="verification_code">

                    @error('verification_code')
                        <p class="mt-2 ml-1 text-[10px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 mt-2">
                    Verify Account
                </button>
            </form>
        </div>
    </div>

    <style>
        /* Add this to your CSS or a style block */
        .otp-box.border-green-500 {
            border-color: #10b981 !important;
            /* Tailwind green-500 */
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.2);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('#otp-inputs .otp-box');
            const hiddenInput = document.getElementById('verification_code');
            const form = document.getElementById('otp-form');

            if (!inputs.length || !hiddenInput || !form) return;

            const updateHiddenValue = () => {
                const code = Array.from(inputs).map(i => i.value || '').join('');
                hiddenInput.value = code;

                if (code.length === 6) {
                    inputs.forEach(input => {
                        input.classList.add('border-green-500');
                        input.classList.remove('border-white/10', 'focus:border-blue-500');
                    });
                } else {
                    inputs.forEach(input => {
                        input.classList.remove('border-green-500');
                        input.classList.add('border-white/10', 'focus:border-blue-500');
                    });
                }
            };

            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    // REMOVED: this.value = this.value.replace(/\D/g, ''); 
                    // This allows letters now.

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

                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    // REMOVED: .replace(/\D/g, '')
                    const pasteData = e.clipboardData.getData('text').trim().split('');

                    pasteData.forEach((char, i) => {
                        if (inputs[i] && i < 6) {
                            inputs[i].value = char;
                        }
                    });

                    const nextIndex = Math.min(pasteData.length, inputs.length - 1);
                    if (inputs[nextIndex]) inputs[nextIndex].focus();

                    updateHiddenValue();
                });
            });

            form.addEventListener('submit', updateHiddenValue);
        });
    </script>
@endsection
