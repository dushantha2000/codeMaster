@extends('layout.auth')

@section('title', 'Verify Account')

@section('content')
    <div
        class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5 relative">
        
        <div class="hidden md:flex md:w-1/2 relative items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow-purple">
            <div class="relative z-10 text-center">
                <div class="mb-8 inline-block p-5 bg-purple-500/10 rounded-3xl border border-purple-500/20 shadow-[0_0_30px_rgba(94,106,210,0.15)]">
                    <svg class="w-20 h-20 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 12a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a4 4 0 004 4M16 12V7m0 0h-2m2 0h2M8 21h8" />
                    </svg>
                </div>
                <h2 class="text-4xl font-bold text-white mb-4 tracking-tighter">Identity sync</h2>
                <p class="text-[#A1A1AA] leading-relaxed text-xs font-medium tracking-normal leading-relaxed">
                    Verify your secure logic archive access via the encrypted transmission sent to your terminal.
                </p>
            </div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-500/5 blur-3xl rounded-full"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-[#0A0A0A] p-2 rounded-2xl border border-white/5 text-purple-500 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-normal  text-xs">CodeVault <span class="text-purple-500 font-bold ml-1">v1.1</span></h1>
                </div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Email verification</h1>
                <p class="text-[#71717A] text-[10px] font-bold tracking-normal mt-2">
                    Security token dispatched to <span class="text-purple-400">{{ session('userEmail') ?? 'registered node' }}</span>
                </p>
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

                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-bold text-[#71717A] tracking-normal mb-4 ml-1 text-center">Verification matrix</label>

                        <div class="flex justify-between gap-3" id="otp-inputs">
                            @for ($i = 0; $i < 6; $i++)
                                <input type="text" maxlength="1"
                                    class="otp-box w-12 h-16 text-center text-xl font-black bg-[#0A0A0A] border border-white/5 rounded-2xl text-white outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/50 transition-all shadow-inner"
                                    inputmode="text"> 
                            @endfor
                        </div>

                        <input type="hidden" name="verification_code" id="verification_code">

                        @error('verification_code')
                            <p class="mt-4 ml-1 text-[10px] text-red-500 font-bold uppercase tracking-widest text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="btn-primary w-full py-5 rounded-2xl text-white text-[10px] font-bold tracking-normal transition-all shadow-xl">
                        Verify identity
                    </button>
                </div>
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
                        input.classList.add('border-purple-500/50', 'ring-4', 'ring-purple-500/10');
                        input.classList.remove('border-white/5');
                    });
                } else {
                    inputs.forEach(input => {
                        input.classList.remove('border-purple-500/50', 'ring-4', 'ring-purple-500/10');
                        input.classList.add('border-white/5');
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
