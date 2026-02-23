{{-- 
    =================================================================
    Snippet Show Page
    =================================================================
    Purpose: Display single snippet details with code content,
    metadata, tags, and action buttons.
    
    Route: /snippets/{id}
    View: snippets.show
    =================================================================
--}}

@extends('layouts.app')

@section('title', $snippet->title . ' - codeMaster')

@push('styles')
<style>
    /* Syntax highlighting styles */
    pre {
        counter-reset: line;
    }
    pre code .line {
        display: block;
    }
    pre code .line::before {
        counter-increment: line;
        content: counter(line);
        display: inline-block;
        width: 2em;
        margin-right: 1em;
        text-align: right;
        color: #6b7280;
    }
</style>
@endpush

@php
    $relatedSnippets = $relatedSnippets ?? collect();
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('snippets.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </a>
            </li>
            <li class="text-gray-400">/</li>
            <li>
                <a href="{{ route('snippets.index', ['language' => $snippet->language]) }}" class="text-gray-500 hover:text-gray-700 text-sm">
                    {{ $snippet->language }}
                </a>
            </li>
            <li class="text-gray-400">/</li>
            <li class="text-gray-900 text-sm font-medium truncate max-w-xs">
                {{ $snippet->title }}
            </li>
        </ol>
    </nav>
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Snippet Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $snippet->title }}</h1>
                            @if($snippet->description)
                                <p class="mt-2 text-gray-600">{{ $snippet->description }}</p>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-2 ml-4">
                            <button 
                                onclick="copyAllCode()"
                                class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors"
                            >
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                Copy All
                            </button>
                            
                            @auth
                                @if(Auth::id() === $snippet->user_id)
                                    <a 
                                        href="{{ route('snippets.edit', $snippet->id) }}"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors"
                                    >
                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    
                                    <form method="POST" action="{{ route('snippets.destroy', $snippet->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            onclick="return confirm('Are you sure you want to delete this snippet?')"
                                            class="inline-flex items-center px-3 py-2 border border-red-300 text-red-700 text-sm font-medium rounded-lg hover:bg-red-50 transition-colors"
                                        >
                                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                    
                    <!-- Tags -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            {{ $snippet->language ?? 'Plain Text' }}
                        </span>
                        @if($snippet->category)
                            <a href="{{ route('categories.show', $snippet->category->id) }}" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors">
                                {{ $snippet->category->name }}
                            </a>
                        @endif
                        @if(is_array($snippet->tags))
                            @foreach($snippet->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>
                
                <!-- Code Files -->
                @if($snippet->files && $snippet->files->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($snippet->files as $index => $file)
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $file->filename }}</span>
                                        @if($file->extension)
                                            <span class="ml-2 text-xs text-gray-500">.{{ $file->extension }}</span>
                                        @endif
                                    </div>
                                    <button 
                                        onclick="copyCode('file-{{ $index }}')"
                                        class="inline-flex items-center px-2 py-1 text-xs text-gray-500 hover:text-indigo-600 transition-colors"
                                    >
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        Copy
                                    </button>
                                </div>
                                <div class="relative">
                                    <pre class="bg-gray-900 rounded-lg p-4 overflow-x-auto"><code id="file-{{ $index }}" class="language-{{ $file->extension ?? 'plaintext' }} text-sm text-gray-100 font-mono">{{ $file->content }}</code></pre>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6">
                        <pre class="bg-gray-900 rounded-lg p-4 overflow-x-auto"><code class="language-{{ strtolower($snippet->language ?? 'plaintext') }} text-sm text-gray-100 font-mono">{{ $snippet->content }}</code></pre>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Snippet Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Snippet Info</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Author</dt>
                        <dd class="mt-1 flex items-center">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium text-sm">
                                {{ substr($snippet->user->name ?? 'U', 0, 1) }}
                            </div>
                            <span class="ml-2 text-sm text-gray-900">{{ $snippet->user->name ?? 'Unknown' }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $snippet->created_at->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $snippet->updated_at->format('M d, Y') }}</dd>
                    </div>
                    @if($snippet->files)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Files</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $snippet->files->count() }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Visibility</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $snippet->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $snippet->is_public ? 'Public' : 'Private' }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
            
            <!-- Related Snippets -->
            @if($relatedSnippets && $relatedSnippets->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Snippets</h3>
                    <ul class="space-y-3">
                        @foreach($relatedSnippets as $related)
                            <li>
                                <a href="{{ route('snippets.show', $related->id) }}" class="block group">
                                    <p class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors">
                                        {{ $related->title }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $related->language }} • {{ $related->created_at->diffForHumans() }}
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyCode(elementId) {
        const codeElement = document.getElementById(elementId);
        navigator.clipboard.writeText(codeElement.textContent).then(() => {
            alert('Code copied to clipboard!');
        });
    }
    
    function copyAllCode() {
        const allCode = document.querySelectorAll('pre code');
        let combinedCode = '';
        allCode.forEach(code => {
            combinedCode += code.textContent + '\n\n';
        });
        navigator.clipboard.writeText(combinedCode).then(() => {
            alert('All code copied to clipboard!');
        });
    }
</script>
@endpush
