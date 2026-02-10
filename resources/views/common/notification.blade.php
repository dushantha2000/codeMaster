{{-- Unique Cyber-Orb Toast --}}
<div id="toast-container" class="fixed top-10 right-10 z-[100] flex flex-col items-end gap-6 pointer-events-none"></div>

<template id="toast-template">
    <div class="toast-wrapper relative flex items-center group pointer-events-auto cursor-pointer transition-all duration-500 translate-x-20 opacity-0">
        
        {{-- The Message Bubble (Hidden initially, expands on entry) --}}
        <div class="message-bubble overflow-hidden bg-white/5 backdrop-blur-2xl border border-white/10 px-6 py-3 rounded-2xl mr-4 shadow-[0_10px_40px_rgba(0,0,0,0.3)] max-w-xs transition-all duration-700 delay-100 scale-90 opacity-0 group-hover:border-white/20">
            <p class="message-text text-[13px] font-medium text-white/80 tracking-wide whitespace-nowrap"></p>
        </div>

        {{-- The Interactive Orb --}}
        <div class="relative flex items-center justify-center w-14 h-14">
            {{-- Sonar Rings --}}
            <div class="sonar-ring absolute inset-0 rounded-full border border-current opacity-20 animate-ping"></div>
            <div class="sonar-ring-static absolute inset-0 rounded-full border border-white/5 bg-black/40 backdrop-blur-md shadow-inner"></div>
            
            {{-- Glowing Core --}}
            <div class="orb-core w-4 h-4 rounded-full shadow-[0_0_20px_currentcolor] transition-transform duration-300 group-hover:scale-125"></div>
            
            {{-- Type Icon (Small/Subtle) --}}
            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-[#111] border border-white/10 rounded-full flex items-center justify-center p-1.5 icon-container">
                {{-- SVG Icon injected here --}}
            </div>
        </div>
    </div>
</template>

<style>
    .toast-show { transform: translateX(0); opacity: 1; }
    .toast-show .message-bubble { transform: scale(1); opacity: 1; }
    
    .toast-exit { transform: scale(0.5) translateY(-50px); opacity: 0; filter: blur(10px); }

    @keyframes orb-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .toast-wrapper { animation: orb-float 4s ease-in-out infinite; }
</style>

<script>
function showToast(message, type = 'success', duration = 4000) {
    const container = document.getElementById('toast-container');
    const template = document.getElementById('toast-template');
    if (!container || !template) return;

    const clone = template.content.cloneNode(true);
    const wrapper = clone.querySelector('.toast-wrapper');
    const core = clone.querySelector('.orb-core');
    const iconContainer = clone.querySelector('.icon-container');
    
    const themes = {
        success: { color: '#10b981', icon: '<svg class="text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
        error: { color: '#f43f5e', icon: '<svg class="text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
        warning: { color: '#f59e0b', icon: '<svg class="text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' }
    };

    const theme = themes[type] || themes.success;

    // Setup Theme
    wrapper.style.color = theme.color;
    core.style.backgroundColor = theme.color;
    iconContainer.innerHTML = theme.icon;
    wrapper.querySelector('.message-text').innerText = message;
    
    container.appendChild(wrapper);

    // Entrance Animation
    requestAnimationFrame(() => {
        wrapper.classList.add('toast-show');
    });

    // Auto Dismiss
    const dismiss = () => {
        wrapper.classList.remove('toast-show');
        wrapper.classList.add('toast-exit');
        setTimeout(() => wrapper.remove(), 600);
    };

    wrapper.onclick = dismiss;
    setTimeout(dismiss, duration);
}

// Laravel Session Bridge
document.addEventListener('DOMContentLoaded', () => {
    @if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
    @if(session('error')) showToast("{{ session('error') }}", 'error'); @endif
});
</script>