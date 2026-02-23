{{-- 
    =================================================================
    Snippet Card Component
    =================================================================
    Purpose: Reusable card component for displaying snippet preview
    in grid or list view.
    
    Props:
    - snippet: Snippet model instance
    - viewMode: 'grid' or 'list'
    =================================================================
--}}

@props([
    'snippet',
    'viewMode' => 'grid',
])

@if($viewMode === 'grid')
    <!-- Grid View Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
        <!-- Card Header -->
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <a href="{{ route('snippets.show', $snippet->id) }}" class="block">
                        <h3 class="text-lg font-semibold text-gray-900 truncate hover:text-indigo-600 transition-colors">
                            {{ $snippet->title }}
                        </h3>
                    </a>
                    <p class="mt-1 text-sm text-gray-500 line-clamp-2">
                        {{ $snippet->description ?? 'No description provided' }}
                    </p>
                </div>
                
                <!-- Language Badge -->
                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 flex-shrink-0">
                    {{ $snippet->language ?? 'Plain Text' }}
                </span>
            </div>
        </div>
        
        <!-- Code Preview -->
        <div class="bg-gray-900 p-4 overflow-hidden">
            <pre class="text-xs text-gray-300 font-mono line-clamp-4 overflow-hidden"><code>{{ Str::limit($snippet->content ?? '', 200) }}</code></pre>
        </div>
        
        <!-- Card Footer -->
        <div class="px-5 py-3 bg-gray-50 flex items-center justify-between">
            <div class="flex items-center space-x-4 text-xs text-gray-500">
                <span class="flex items-center">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ $snippet->files_count ?? 1 }} files
                </span>
                <span>{{ $snippet->created_at->diffForHumans() }}</span>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center space-x-2">
                <button 
                    onclick="copySnippet({{ $snippet->id }})"
                    class="p-1.5 text-gray-400 hover:text-indigo-600 transition-colors"
                    title="Copy code"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
                
                @auth
                    @if(Auth::id() === $snippet->user_id)
                        <a 
                            href="{{ route('snippets.edit', $snippet->id) }}"
                            class="p-1.5 text-gray-400 hover:text-indigo-600 transition-colors"
                            title="Edit snippet"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@else
    <!-- List View Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 p-4">
        <div class="flex items-center">
            <!-- Language Icon -->
            <div class="flex-shrink-0">
                <div class="h-12 w-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
            </div>
            
            <!-- Snippet Info -->
            <div class="ml-4 flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <a href="{{ route('snippets.show', $snippet->id) }}" class="block">
                        <h3 class="text-lg font-semibold text-gray-900 hover:text-indigo-600 transition-colors">
                            {{ $snippet->title }}
                        </h3>
                    </a>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        {{ $snippet->language ?? 'Plain Text' }}
                    </span>
                </div>
                <p class="mt-1 text-sm text-gray-500 truncate">
                    {{ $snippet->description ?? 'No description provided' }}
                </p>
                <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                    <span class="flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ $snippet->files_count ?? 1 }} files
                    </span>
                    <span>{{ $snippet->created_at->diffForHumans() }}</span>
                    @if($snippet->category)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $snippet->category->name }}
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="ml-4 flex items-center space-x-2">
                <button 
                    onclick="copySnippet({{ $snippet->id }})"
                    class="p-2 text-gray-400 hover:text-indigo-600 transition-colors"
                    title="Copy code"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
                
                @auth
                    @if(Auth::id() === $snippet->user_id)
                        <a 
                            href="{{ route('snippets.edit', $snippet->id) }}"
                            class="p-2 text-gray-400 hover:text-indigo-600 transition-colors"
                            title="Edit snippet"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endif
