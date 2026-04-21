<!-- AI Optimizer Modal -->
<div x-show="showAiModal" x-cloak
    class="fixed inset-0 z-[200] flex flex-col bg-[#030303] animate-in fade-in duration-300">
    <header class="h-16 md:h-20 flex items-center justify-between px-4 md:px-8 glass-card border-b border-white/5 shrink-0">
        <div class="flex items-center gap-3 md:gap-4">
            <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg bg-blue-500/10 flex items-center justify-center border border-blue-500/20 shrink-0">
                <span class="text-lg md:text-xl"><img src="{{ asset('logo/mainlogo.png') }}" alt="CodeVault Logo" class="w-full h-full object-contain transform scale-125"></span>
            </div>
            <div class="min-w-0">
                <h2 class="text-base md:text-lg font-bold text-white truncate">AI Code Optimizer</h2>
                <p class="text-[10px] md:text-xs text-gray-500 truncate">Powered by CodeVault</p>
            </div>
        </div>
        <div class="flex items-center gap-2 md:gap-4 shrink-0">
            <button type="button" @click="closeAiOptimizer()"
                class="px-3 md:px-6 py-2 md:py-2.5 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-xs md:text-sm font-bold transition-all">
                Cancel
            </button>
            <button type="button" @click="applyOptimizedCode()" x-show="aiOptimizedCode"
                class="btn-primary px-3 md:px-6 py-2 md:py-2.5 rounded-lg font-bold text-xs md:text-sm flex items-center gap-2 shadow-lg shadow-blue-900/20">
                <svg class="w-4 h-4 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="hidden md:inline">Use Optimized Code</span>
                <span class="md:hidden">Use Code</span>
            </button>
        </div>
    </header>

    <div class="flex-1 p-3 md:p-6 flex flex-col gap-4 md:gap-6 overflow-hidden">
        <div class="flex flex-col md:flex-row items-stretch md:items-end gap-3 md:gap-4 shrink-0">
            <div class="flex-1 w-full">
                <label class="text-xs font-bold text-gray-500 mb-1.5 md:mb-2 block ml-1">Custom Instructions (Optional)</label>
                <input type="text" x-model="aiInstruction" @keyup.enter="runAiOptimization"
                    placeholder="e.g. Optimize for performance, Convert to PHP 8..."
                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 md:py-3 text-sm text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-700">
            </div>
            <div class="relative group w-full md:w-auto shrink-0" :class="{'opacity-50 pointer-events-none': isOptimizing}">
                <!-- Animated glowing background -->
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 rounded-lg blur opacity-40 group-hover:opacity-100 transition duration-500"></div>
                
                <!-- Button -->
                <button type="button" @click="runAiOptimization()" :disabled="isOptimizing"
                    class="relative w-full md:w-auto h-[42px] md:h-[46px] px-8 flex items-center justify-center gap-2 bg-[#030303] hover:bg-black/50 rounded-lg border border-white/10 transition-all duration-300 shadow-[inset_0_1px_1px_rgba(255,255,255,0.1)]">
                    <span x-show="!isOptimizing" class="text-sm font-bold bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 bg-clip-text text-transparent group-hover:from-white group-hover:via-white group-hover:to-white transition-all duration-500 tracking-wide">
                        Generate 
                    </span>
                    <span x-show="isOptimizing" class="flex items-center gap-2 text-sm font-bold bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 bg-clip-text text-transparent">
                        <svg class="animate-spin h-4 w-4 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Thinking...
                    </span>
                </button>
            </div>
        </div>

        <div class="flex-1 flex flex-col md:flex-row gap-4 md:gap-6 min-h-0">
            <!-- Original Code -->
            <div class="flex-1 flex flex-col glass-card border border-white/5 rounded-xl overflow-hidden min-h-[150px]">
                <div class="px-3 md:px-4 py-2 md:py-3 border-b border-white/5 bg-white/[0.02]">
                    <h3 class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider">Original Code</h3>
                </div>
                <div class="flex-1 relative bg-black/40">
                    <textarea readonly x-model="aiOriginalCode"
                        class="absolute inset-0 w-full h-full bg-transparent p-3 md:p-4 code-font text-[12px] md:text-[13px] text-gray-500 outline-none resize-none scrollbar-hide"></textarea>
                </div>
            </div>
            
            <!-- Optimized Code -->
            <div class="flex-1 flex flex-col glass-card border border-blue-500/20 rounded-xl overflow-hidden relative shadow-[0_0_30px_rgba(59,130,246,0.05)] min-h-[150px]">
                <div class="px-3 md:px-4 py-2 md:py-3 border-b border-blue-500/20 bg-blue-500/[0.02] flex justify-between items-center">
                    <h3 class="text-[10px] md:text-xs font-bold text-blue-400 uppercase tracking-wider">AI Optimized</h3>
                    <span x-show="aiError" class="text-[10px] md:text-xs text-red-400 font-bold" x-text="aiError"></span>
                </div>
                <div class="flex-1 relative bg-black/20">
                    <textarea readonly x-model="aiOptimizedCode" placeholder="Optimized code will appear here..."
                        class="absolute inset-0 w-full h-full bg-transparent p-3 md:p-4 code-font text-[12px] md:text-[13px] text-gray-300 outline-none resize-none scrollbar-hide"></textarea>
                    
                    <!-- Empty State -->
                    <div x-show="!aiOptimizedCode && !isOptimizing && !aiError" class="absolute inset-0 flex flex-col items-center justify-center text-center p-4 md:p-6">
                        <div class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-blue-500/5 flex items-center justify-center mb-3 md:mb-4">
                            <span class="text-xl md:text-2xl opacity-50"><img src="{{ asset('logo/mainlogo.png') }}" alt="CodeVault Logo" class="w-full h-full object-contain transform scale-125"></span>
                        </div>
                        <p class="text-xs md:text-sm text-gray-500 max-w-[200px] md:max-w-xs">Click generate to let AI analyze and optimize your code.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
