{{-- Modern Cyber-Linear Toast --}}
<div id="toast-container" class="fixed top-6 right-6 z-[100] flex flex-col items-end gap-4 pointer-events-none"></div>

<template id="toast-template">
    <div class="toast-wrapper group pointer-events-auto cursor-pointer transition-all duration-500 translate-x-10 opacity-0">
        <div class="relative overflow-hidden bg-[#0a0a0a]/80 backdrop-blur-xl border border-white/10 px-6 py-4 rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] flex items-center gap-4 min-w-[320px] max-w-md group-hover:border-white/20">
            
            {{-- Left Accent Neon Bar --}}
            <div class="absolute left-0 top-0 bottom-0 w-1 accent-bar shadow-[0_0_15px_currentcolor]"></div>
            
            {{-- Icon Section --}}
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center icon-bg">
                <div class="icon-container w-5 h-5"></div>
            </div>

            {{-- Text Section --}}
            <div class="flex-grow">
                <p class="text-xs uppercase tracking-[0.2em] font-bold opacity-50 type-label mb-0.5">Notification</p>
                <p class="message-text text-[14px] font-medium text-white/90 leading-relaxed break-words"></p>
            </div>

            {{-- Close Indicator --}}
            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                <svg class="w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            
            {{-- Progress Scan Line --}}
            <div class="absolute bottom-0 left-0 h-[1px] bg-current opacity-30 scan-line"></div>
        </div>
    </div>
</template>

<style>
    .toast-show { transform: translateX(0); opacity: 1; }
    .toast-exit { transform: translateX(20px); opacity: 0; filter: blur(5px); }

    .scan-line {
        animation: scan 4s linear forwards;
        width: 100%;
    }

    @keyframes scan {
        from { width: 100%; }
        to { width: 0%; }
    }
</style>

<script>
function showToast(message, type = 'success', duration = 4000) {
    const container = document.getElementById('toast-container');
    const template = document.getElementById('toast-template');
    if (!container || !template) return;

    const clone = template.content.cloneNode(true);
    const wrapper = clone.querySelector('.toast-wrapper');
    const accent = clone.querySelector('.accent-bar');
    const label = clone.querySelector('.type-label');
    const iconContainer = clone.querySelector('.icon-container');
    const scanLine = clone.querySelector('.scan-line');
    
    const themes = {
        success: { 
            color: '#00ffcc', 
            label: 'System Success',
            icon: '<svg class="w-full h-full text-[#00ffcc]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' 
        },
        error: { 
            color: '#ff3366', 
            label: 'System Error',
            icon: '<svg class="w-full h-full text-[#ff3366]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' 
        },
        warning: { 
            color: '#ffcc00', 
            label: 'System Warning',
            icon: '<svg class="w-full h-full text-[#ffcc00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' 
        }
    };

    const theme = themes[type] || themes.success;

    wrapper.style.color = theme.color;
    label.innerText = theme.label;
    iconContainer.innerHTML = theme.icon;
    wrapper.querySelector('.message-text').innerText = message;
    scanLine.style.animationDuration = duration + 'ms';
    
    container.appendChild(wrapper);

    requestAnimationFrame(() => wrapper.classList.add('toast-show'));

    const dismiss = () => {
        wrapper.classList.remove('toast-show');
        wrapper.classList.add('toast-exit');
        setTimeout(() => wrapper.remove(), 500);
    };

    wrapper.onclick = dismiss;
    setTimeout(dismiss, duration);
}

document.addEventListener('DOMContentLoaded', () => {
    @if(session('success') || isset($success)) 
        showToast("{{ session('success') ?? $success }}", 'success'); 
    @endif
    @if(session('error') || isset($error)) 
        showToast("{{ session('error') ?? $error }}", 'error'); 
    @endif
    @if($errors->any())
        showToast("{{ $errors->first() }}", 'error');
    @endif
});
</script>