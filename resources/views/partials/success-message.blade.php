{{-- 
    =================================================================
    Success Message Partial
    =================================================================
    Purpose: Display success flash messages with close functionality.
    Shown when session has 'success' flash data.
    =================================================================
--}}

@if(session('success'))
    <div 
        x-data="{ show: true }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="fixed top-4 right-4 z-50 max-w-sm w-full bg-green-50 border-l-4 border-green-500 shadow-lg rounded-r-lg"
        role="alert"
        aria-labelledby="success-title"
    >
        <div class="flex items-start p-4">
            <!-- Success Icon -->
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <!-- Message Content -->
            <div class="ml-3 flex-1">
                <p id="success-title" class="text-sm font-medium text-green-800">
                    {{ session('success') }}
                </p>
            </div>
            
            <!-- Close Button -->
            <button 
                @click="show = false"
                class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 inline-flex h-8 w-8"
                aria-label="Close"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Auto-dismiss Progress Bar -->
        <div class="h-1 bg-green-200 rounded-b-lg overflow-hidden">
            <div 
                x-init="setTimeout(() => show = false, 5000)"
                x-bind:style="`width: ${5 - (Date.now() - {{ time() }}000) / 1000}%`"
                class="h-full bg-green-500 transition-all duration-[5000ms] linear"
            ></div>
        </div>
    </div>
@endif
