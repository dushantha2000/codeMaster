{{-- 
    =================================================================
    Error Message Partial
    =================================================================
    Purpose: Display error flash messages with close functionality.
    Shown when session has 'error' flash data or validation errors exist.
    =================================================================
--}}

@if(session('error') || $errors->any())
    <div 
        x-data="{ show: true }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="fixed top-4 right-4 z-50 max-w-sm w-full bg-red-50 border-l-4 border-red-500 shadow-lg rounded-r-lg"
        role="alert"
        aria-labelledby="error-title"
    >
        <div class="flex items-start p-4">
            <!-- Error Icon -->
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <!-- Message Content -->
            <div class="ml-3 flex-1">
                @if(session('error'))
                    <p id="error-title" class="text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </p>
                @endif
                
                @if($errors->any())
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            
            <!-- Close Button -->
            <button 
                @click="show = false"
                class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-100 inline-flex h-8 w-8"
                aria-label="Close"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif
