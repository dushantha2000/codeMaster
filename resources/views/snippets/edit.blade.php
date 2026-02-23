{{-- 
    =================================================================
    Edit Snippet Page
    =================================================================
    Purpose: Form for editing existing code snippets with pre-filled
    data.
    
    Route: /snippets/{id}/edit
    View: snippets.edit
    =================================================================
--}}

@extends('layouts.dashboard')

@section('title', 'Edit Snippet - codeMaster')

@push('styles')
<!-- Code Editor Styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/material-darker.min.css">
@endpush

@section('header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Snippet</h1>
        <p class="mt-1 text-sm text-gray-600">Update your code snippet</p>
    </div>
    <div class="flex items-center space-x-2">
        <a href="{{ route('snippets.show', $snippet->id) }}" class="text-gray-500 hover:text-gray-700">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </a>
        <a href="{{ route('snippets.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('snippets.update', $snippet->id) }}" id="snippet-form" class="space-y-6">
    @csrf
    @method('PUT')
    
    <!-- Title & Language Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Title -->
        <div class="md:col-span-2">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                required
                value="{{ old('title', $snippet->title) }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('title') border-red-500 @enderror"
                placeholder="My awesome code snippet"
            >
            @error('title')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @endif
        </div>
        
        <!-- Language -->
        <div>
            <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
            <select 
                id="language" 
                name="language" 
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('language') border-red-500 @enderror"
            >
                <option value="">Select language</option>
                <option value="php" {{ old('language', $snippet->language) == 'php' ? 'selected' : '' }}>PHP</option>
                <option value="javascript" {{ old('language', $snippet->language) == 'javascript' ? 'selected' : '' }}>JavaScript</option>
                <option value="python" {{ old('language', $snippet->language) == 'python' ? 'selected' : '' }}>Python</option>
                <option value="java" {{ old('language', $snippet->language) == 'java' ? 'selected' : '' }}>Java</option>
                <option value="csharp" {{ old('language', $snippet->language) == 'csharp' ? 'selected' : '' }}>C#</option>
                <option value="cpp" {{ old('language', $snippet->language) == 'cpp' ? 'selected' : '' }}>C++</option>
                <option value="go" {{ old('language', $snippet->language) == 'go' ? 'selected' : '' }}>Go</option>
                <option value="rust" {{ old('language', $snippet->language) == 'rust' ? 'selected' : '' }}>Rust</option>
                <option value="ruby" {{ old('language', $snippet->language) == 'ruby' ? 'selected' : '' }}>Ruby</option>
                <option value="swift" {{ old('language', $snippet->language) == 'swift' ? 'selected' : '' }}>Swift</option>
                <option value="kotlin" {{ old('language', $snippet->language) == 'kotlin' ? 'selected' : '' }}>Kotlin</option>
                <option value="html" {{ old('language', $snippet->language) == 'html' ? 'selected' : '' }}>HTML</option>
                <option value="css" {{ old('language', $snippet->language) == 'css' ? 'selected' : '' }}>CSS</option>
                <option value="scss" {{ old('language', $snippet->language) == 'scss' ? 'selected' : '' }}>SCSS</option>
                <option value="sql" {{ old('language', $snippet->language) == 'sql' ? 'selected' : '' }}>SQL</option>
                <option value="bash" {{ old('language', $snippet->language) == 'bash' ? 'selected' : '' }}>Bash</option>
                <option value="json" {{ old('language', $snippet->language) == 'json' ? 'selected' : '' }}>JSON</option>
                <option value="yaml" {{ old('language', $snippet->language) == 'yaml' ? 'selected' : '' }}>YAML</option>
                <option value="xml" {{ old('language', $snippet->language) == 'xml' ? 'selected' : '' }}>XML</option>
                <option value="markdown" {{ old('language', $snippet->language) == 'markdown' ? 'selected' : '' }}>Markdown</option>
            </select>
            @error('language')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @endif
        </div>
    </div>
    
    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea 
            id="description" 
            name="description" 
            rows="3"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-500 @enderror"
            placeholder="Describe what this snippet does..."
        >{{ old('description', $snippet->description) }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @endif
    </div>
    
    <!-- Code Editor -->
    <div>
        <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
        <div class="mt-1 border border-gray-300 rounded-lg overflow-hidden">
            <textarea 
                id="code" 
                name="content"
                class="w-full h-96 p-4 font-mono text-sm bg-gray-900 text-gray-100 focus:outline-none"
                placeholder="// Paste or type your code here..."
            >{{ old('content', $snippet->content) }}</textarea>
        </div>
        @error('content')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @endif
    </div>
    
    <!-- Additional Options -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Category -->
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <select 
                id="category" 
                name="category_id" 
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
                <option value="">Select category</option>
                @foreach($categories ?? [] as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $snippet->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Visibility -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Visibility</label>
            <div class="mt-2 space-y-2">
                <div class="flex items-center">
                    <input 
                        id="visibility-public" 
                        name="is_public" 
                        type="radio" 
                        value="1"
                        {{ old('is_public', $snippet->is_public) == '1' ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                    >
                    <label for="visibility-public" class="ml-3 block text-sm font-medium text-gray-700">
                        Public
                        <span class="text-gray-500 font-normal">(Anyone can see)</span>
                    </label>
                </div>
                <div class="flex items-center">
                    <input 
                        id="visibility-private" 
                        name="is_public" 
                        type="radio" 
                        value="0"
                        {{ old('is_public', $snippet->is_public) == '0' ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                    >
                    <label for="visibility-private" class="ml-3 block text-sm font-medium text-gray-700">
                        Private
                        <span class="text-gray-500 font-normal">(Only you can see)</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tags -->
    <div>
        <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
        <input 
            type="text" 
            id="tags" 
            name="tags" 
            value="{{ old('tags', implode(', ', $snippet->tags ?? [])) }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            placeholder="laravel, api, authentication (comma separated)"
        >
        <p class="mt-2 text-xs text-gray-500">Separate tags with commas</p>
    </div>
    
    <!-- Submit Buttons -->
    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
        <form method="POST" action="{{ route('snippets.destroy', $snippet->id) }}" class="inline">
            @csrf
            @method('DELETE')
            <button 
                type="submit" 
                onclick="return confirm('Are you sure you want to delete this snippet?')"
                class="px-4 py-2 border border-red-300 text-red-700 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors"
            >
                Delete Snippet
            </button>
        </form>
        
        <div class="flex items-center space-x-4">
            <a href="{{ route('snippets.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button 
                type="submit" 
                class="px-6 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors"
            >
                Update Snippet
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // Simple code editor functionality
    const codeTextarea = document.getElementById('code');
    const languageSelect = document.getElementById('language');
    
    // Update language on select change
    languageSelect.addEventListener('change', function() {
        // Could integrate with a code highlighting library here
    });
    
    // Tab key handling for code editor
    codeTextarea.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            e.preventDefault();
            const start = this.selectionStart;
            const end = this.selectionEnd;
            this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);
            this.selectionStart = this.selectionEnd = start + 4;
        }
    });
</script>
@endpush
