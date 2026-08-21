@props(['show' => false])

@if($show)
<div x-data="welcomeModal()" x-init="show = true" x-show="show" x-cloak
    class="fixed inset-0 z-[999] flex items-center justify-center p-4"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="dismiss()"></div>

    {{-- Modal Content --}}
    <div class="relative w-full max-w-4xl glass-card rounded-3xl shadow-2xl overflow-hidden"
        x-transition:enter="transition ease-out duration-500 delay-100"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">

        {{-- Close Button --}}
        <button @click="dismiss()" class="absolute top-5 right-5 z-50 w-8 h-8 rounded-full flex items-center justify-center bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="flex flex-col lg:flex-row min-h-[480px]">
            {{-- Left Side: Hero --}}
            <div class="lg:w-2/5 p-8 flex flex-col justify-center items-center text-center relative overflow-hidden" style="background: var(--color-bg-base);">
                {{-- Background Pattern --}}
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, var(--color-accent) 1px, transparent 0); background-size: 24px 24px;"></div>
                </div>

                {{-- Logo --}}
                <div class="relative z-10 mb-6">
                    <div class="w-24 h-24 flex items-center justify-center relative overflow-hidden">
                        <img src="{{ asset('logo/mainlogo.png') }}" alt="CodeVault Logo" class="w-24 h-24 object-contain">
                        {{-- Pulse Ring --}}
                        <div class="absolute inset-0 rounded-3xl animate-ping" style="background: var(--color-accent-subtle); opacity: 0.3;"></div>
                    </div>
                </div>

                <h2 class="text-2xl font-black mb-2 relative z-10" style="color: var(--color-text-primary);">Welcome to<br/>CodeVault!</h2>
                <p class="text-sm relative z-10" style="color: var(--color-text-secondary);">Your secure code snippet manager</p>

                {{-- Step Indicators --}}
                <div class="flex items-center gap-2 mt-8 relative z-10">
                    <template x-for="(step, index) in steps" :key="index">
                        <button @click="currentStep = index"
                            class="w-2 h-2 rounded-full transition-all duration-300"
                            :style="currentStep === index ? 'background: var(--color-accent); width: 24px;' : 'background: var(--color-border-subtle);'">
                        </button>
                    </template>
                </div>
            </div>

            {{-- Right Side: Steps Content --}}
            <div class="lg:w-3/5 p-8 flex flex-col">
                {{-- Step 1: What is CodeVault --}}
                <div x-show="currentStep === 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="flex-1 flex flex-col">
                    <div class="flex items-center gap-3 mb-6">
                        
                        <h3 class="text-2xl font-bold" style="color: var(--color-text-primary);">What is CodeVault ?</h3>
                    </div>

                    <p class="text-sm leading-relaxed mb-6" style="color: var(--color-text-secondary);">
                        CodeVault is a <span class="font-semibold" style="color: var(--color-accent);">smart code snippet manager</span> that helps developers organize, store, and share their code securely.
                    </p>

                    {{-- Quick Stats --}}
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div class="text-center p-3 rounded-xl" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                            <div class="text-xl font-black" style="color: var(--color-accent);">∞</div>
                            <div class="text-[10px] font-medium mt-1" style="color: var(--color-text-muted);">Unlimited Snippets</div>
                        </div>
                        <div class="text-center p-3 rounded-xl" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                            <div class="text-xl font-black" style="color: var(--color-accent);">🔒</div>
                            <div class="text-[10px] font-medium mt-1" style="color: var(--color-text-muted);">Encrypted Storage</div>
                        </div>
                        <div class="text-center p-3 rounded-xl" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                            <div class="text-xl font-black" style="color: var(--color-accent);">⚡</div>
                            <div class="text-[10px] font-medium mt-1" style="color: var(--color-text-muted);">Instant Search</div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <button @click="currentStep = 1" class="btn-primary w-full py-3.5 px-6 text-sm rounded-xl">
                            Next →
                        </button>
                    </div>
                </div>

                {{-- Step 2: Key Features --}}
                <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="flex-1 flex flex-col">
                    <div class="flex items-center gap-3 mb-6">
                        
                        <h3 class="text-lg font-bold" style="color: var(--color-text-primary);">Key Features</h3>
                    </div>

                    <div class="space-y-3 mb-6">
                        {{-- Feature 1 --}}
                        <div class="flex items-center gap-4 p-3.5 rounded-xl transition-all hover:translate-x-1" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                            <div class="w-10 h-10 shrink-0 rounded-xl flex items-center justify-center" style="background: var(--color-accent-subtle); border: 1px solid var(--color-accent-border);">
                                <svg class="w-5 h-5" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold" style="color: var(--color-text-primary);">Create & Organize</h4>
                                <p class="text-xs mt-0.5" style="color: var(--color-text-muted);">Multi-file snippets with categories & language tags</p>
                            </div>
                            <svg class="w-4 h-4 shrink-0" style="color: var(--color-text-faint);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>

                        {{-- Feature 2 --}}
                        <div class="flex items-center gap-4 p-3.5 rounded-xl transition-all hover:translate-x-1" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                            <div class="w-10 h-10 shrink-0 rounded-xl flex items-center justify-center" style="background: var(--color-accent-subtle); border: 1px solid var(--color-accent-border);">
                                <svg class="w-5 h-5" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold" style="color: var(--color-text-primary);">AI-Powered Optimization</h4>
                                <p class="text-xs mt-0.5" style="color: var(--color-text-muted);">Improve code quality with smart AI suggestions</p>
                            </div>
                            <svg class="w-4 h-4 shrink-0" style="color: var(--color-text-faint);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>

                        {{-- Feature 3 --}}
                        <div class="flex items-center gap-4 p-3.5 rounded-xl transition-all hover:translate-x-1" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                            <div class="w-10 h-10 shrink-0 rounded-xl flex items-center justify-center" style="background: var(--color-accent-subtle); border: 1px solid var(--color-accent-border);">
                                <svg class="w-5 h-5" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold" style="color: var(--color-text-primary);">Secure Share Links</h4>
                                <p class="text-xs mt-0.5" style="color: var(--color-text-muted);">Password-protected links with expiration dates</p>
                            </div>
                            <svg class="w-4 h-4 shrink-0" style="color: var(--color-text-faint);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>

                        {{-- Feature 4 --}}
                        <div class="flex items-center gap-4 p-3.5 rounded-xl transition-all hover:translate-x-1" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                            <div class="w-10 h-10 shrink-0 rounded-xl flex items-center justify-center" style="background: var(--color-accent-subtle); border: 1px solid var(--color-accent-border);">
                                <svg class="w-5 h-5" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold" style="color: var(--color-text-primary);">Partner Collaboration</h4>
                                <p class="text-xs mt-0.5" style="color: var(--color-text-muted);">Invite team members to access your vault</p>
                            </div>
                            <svg class="w-4 h-4 shrink-0" style="color: var(--color-text-faint);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-auto">
                        <button @click="currentStep = 0" class="flex-1 py-3.5 px-6 text-sm font-bold rounded-xl transition-all" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle); color: var(--color-text-secondary);">
                            ← Back
                        </button>
                        <button @click="currentStep = 2" class="btn-primary flex-[2] py-3.5 px-6 text-sm rounded-xl">
                            Next →
                        </button>
                    </div>
                </div>

                {{-- Step 3: Get Started --}}
                <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="flex-1 flex flex-col">
                    <div class="flex items-center gap-3 mb-6">
                        
                        <h3 class="text-lg font-bold" style="color: var(--color-text-primary);">You're All Set..!</h3>
                    </div>

                    <div class="flex-1 flex flex-col justify-center">
                        {{-- Quick Action Cards --}}
                        <div class="space-y-3 mb-6">
                            <a href="{{ route('snippets-create') }}" class="flex items-center gap-4 p-4 rounded-xl transition-all hover:translate-x-1 no-underline" style="background: var(--color-bg-elevated); border: 1px solid var(--color-accent-border);">
                                <div class="w-12 h-12 shrink-0 rounded-xl flex items-center justify-center" style="background: var(--color-accent-subtle);">
                                    <svg class="w-6 h-6" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold" style="color: var(--color-text-primary);">Create Your First Snippet</h4>
                                    <p class="text-xs mt-0.5" style="color: var(--color-text-muted);">Start saving your code snippets</p>
                                </div>
                                <svg class="w-5 h-5 shrink-0" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>

                            <a href="{{ route('howto') }}" class="flex items-center gap-4 p-4 rounded-xl transition-all hover:translate-x-1 no-underline" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                                <div class="w-12 h-12 shrink-0 rounded-xl flex items-center justify-center" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                                    <svg class="w-6 h-6" style="color: var(--color-text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold" style="color: var(--color-text-primary);">How to Use CodeVault</h4>
                                    <p class="text-xs mt-0.5" style="color: var(--color-text-muted);">Read the quick start guide</p>
                                </div>
                                <svg class="w-5 h-5 shrink-0" style="color: var(--color-text-faint);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-auto">
                        <button @click="currentStep = 1" class="flex-1 py-3.5 px-6 text-sm font-bold rounded-xl transition-all" style="background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle); color: var(--color-text-secondary);">
                            ← Back
                        </button>
                        <button @click="dismiss()" class="btn-primary flex-[2] py-3.5 px-6 text-sm rounded-xl">
                            Get Started 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>

<script>
function welcomeModal() {
    return {
        show: false,
        currentStep: 0,
        steps: [0, 1, 2],
        dismiss() {
            this.show = false;
            fetch('/api/welcome/dismiss', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
        }
    }
}
</script>
@endif
