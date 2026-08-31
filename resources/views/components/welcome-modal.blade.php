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
                {{--What is CodeVault --}}
                <div x-show="currentStep === 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="flex-1 flex flex-col">
                    <h3 class="text-2xl font-bold mb-6" style="color: var(--color-text-primary);">What is CodeVault ?</h3>

                    <p class="text-sm leading-relaxed mb-6" style="color: var(--color-text-secondary);">
                        CodeVault is a <span class="font-semibold" style="color: var(--color-accent);">smart code snippet manager</span> that helps developers organize, store, and share their code securely.
                    </p>

                    

                    

                   

                    <div class="mt-auto flex justify-end">
                        <button @click="currentStep = 1" class="btn-primary w-1/2 py-3.5 px-6 text-sm rounded-xl">
                            Next →
                        </button>
                    </div>
                </div>

                {{--Key Features --}}
                <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="flex-1 flex flex-col">
                    <h3 class="text-lg font-bold mb-6" style="color: var(--color-text-primary);">Key Features</h3>

                    <ul class="list-disc list-inside space-y-1 mb-6 text-sm" style="color: var(--color-text-secondary);">
                        <li>Multi-file snippets with categories & language tags</li>
                        <li><span class="font-semibold" style="color: var(--color-accent);">AI-powered code</span> optimization & suggestions</li>
                        <li>Password-protected <span class="font-semibold" style="color: var(--color-accent);">share links</span> with expiration</li>
                        <li>Invite <span class="font-semibold" style="color: var(--color-accent);">team members to collaborate</span></li>

                       

                        <li>CodeVault is <span class="font-semibold" style="color: var(--color-accent);">free open-source</span> open-source a with a focus on security and privacy</li>

                        

    

                    </ul>

                    <div class="mt-auto flex justify-end">
                        <button @click="currentStep = 2" class="btn-primary w-1/2 py-3.5 px-6 text-sm rounded-xl">
                            Next →
                        </button>
                    </div>
                </div>

                {{-- Step 3: Get Started --}}
                <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="flex-1 flex flex-col">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" style="color: #22c55e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold" style="color: var(--color-text-primary);">You're All Set..!</h3>
                    </div>

                    <div class="flex-1 flex flex-col justify-center">
                        <div class="space-y-2 mb-6">
                            <a href="{{ route('snippets-create') }}" class="block p-3 rounded-lg no-underline transition-all" style="color: var(--color-text-primary); background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                                <span class="text-sm font-bold">Create Your First Snippet</span>
                                <p class="text-xs mt-0.5" style="color: var(--color-text-muted);">Start saving your code snippets</p>
                            </a>
                            <a href="{{ route('howto') }}" class="block p-3 rounded-lg no-underline transition-all" style="color: var(--color-text-primary); background: var(--color-bg-elevated); border: 1px solid var(--color-border-subtle);">
                                <span class="text-sm font-bold">How to Use CodeVault</span>
                                <p class="text-xs mt-0.5" style="color: var(--color-text-muted);">Read the quick start guide</p>
                            </a>
                        </div>
                    </div>

                    <div class="mt-auto flex justify-end">
                        <button @click="dismiss()" class="btn-primary w-1/2 py-3.5 px-6 text-sm rounded-xl">
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
