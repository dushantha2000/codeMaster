@extends('layouts.dashboard')

@section('title', 'Create Snippet - codeMaster')

@push('styles')
    <style>
        /* Clean Light Scrollbar for Code Editor */
        .code-editor::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .code-editor::-webkit-scrollbar-track {
            background: #f8fafc;
        }

        .code-editor::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .file-tab {
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .file-tab.active {
            background-color: #ffffff;
            border-bottom: 2px solid #4f46e5;
            color: #4f46e5;
            font-weight: 700;
        }

        .file-item {
            display: none;
        }

        .file-item.active {
            display: block;
        }

        .code-editor {
            font-family: 'Fira Code', 'Cascadia Code', monospace;
            tab-size: 4;
            resize: vertical;
            min-height: 500px;
        }

        .remove-file {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .file-tab:hover .remove-file {
            opacity: 1;
        }

        /* Tags Input Styles */
        .tags-input-container {
            position: relative;
        }

        .tags-display {
            min-height: 32px;
        }

        .tags-display span {
            animation: tagAppear 0.2s ease-out;
        }

        @keyframes tagAppear {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        #tags-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
    </style>
@endpush

@section('content')

    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('dashboard.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>
            </li>
            <li>
                <span class="text-gray-400">/</span>
            </li>
            <li>
                <a href="{{ route('snippets.index') }}" class="text-gray-500 hover:text-gray-700">Snippets</a>
            </li>
            <li>
                <span class="text-gray-400">/</span>
            </li>
            <li>
                <span class="text-gray-900 font-medium">Create Snippet</span>
            </li>
        </ol>
    </nav>

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Create New Snippet</h1>
    
    <form method="POST" action="{{ route('snippets.store') }}" id="snippet-form" class="max-w-7xl mx-auto pb-24 px-4 py-8">
        @csrf

        <div class="mb-10">
            <label class="block text-sm font-medium text-gray-700 mb-2">Snippet Project Title</label>
            <input type="text" name="title" required value="{{ old('title') }}"
                class="block w-full text-2xl font-extrabold border-none focus:ring-0 placeholder-gray-200 bg-transparent text-gray-900 px-0"
                placeholder="Name your masterpiece...">
            <div class="h-px bg-gray-200 w-full mt-2"></div>
        </div>

        <div class="mb-6 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <label class="block text-sm font-medium text-gray-700 mb-2">Project Description</label>
            <textarea name="description" rows="2"
                class="block w-full px-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-500/10 text-gray-600 placeholder-gray-400 transition-all"
                placeholder="Briefly explain what this logic does...">{{ old('description') }}</textarea>
        </div>

        <!-- Language Selection Dropdown -->
        <div class="mb-8 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <label class="block text-sm font-medium text-gray-700 mb-3">Programming Language</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="php" class="sr-only" {{ old('language') == 'php' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">PHP</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="javascript" class="sr-only" {{ old('language') == 'javascript' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">JavaScript</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="python" class="sr-only" {{ old('language') == 'python' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">Python</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="html" class="sr-only" {{ old('language') == 'html' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">HTML</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="css" class="sr-only" {{ old('language') == 'css' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">CSS</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="sql" class="sr-only" {{ old('language') == 'sql' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">SQL</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="java" class="sr-only" {{ old('language') == 'java' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">Java</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="csharp" class="sr-only" {{ old('language') == 'csharp' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">C#</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="ruby" class="sr-only" {{ old('language') == 'ruby' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">Ruby</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="go" class="sr-only" {{ old('language') == 'go' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">Go</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="rust" class="sr-only" {{ old('language') == 'rust' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">Rust</span>
                </label>
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="language" value="typescript" class="sr-only" {{ old('language') == 'typescript' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">TypeScript</span>
                </label>
            </div>
            @error('language')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm flex flex-col">
                    <div class="flex items-center justify-between bg-gray-50/50 border-b border-gray-100">
                        <div id="file-tabs-container" class="flex overflow-x-auto scrollbar-hide">
                        </div>
                        <button type="button" id="add-file-btn"
                            class="m-2 p-2 text-indigo-600 hover:bg-white rounded-lg transition-all shadow-sm border border-transparent hover:border-gray-100">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>

                    <div id="files-container">
                        <div class="file-item active" data-file-id="file-1">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-white border-b border-gray-50">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">File Path</label>
                                    <input type="text" name="files[0][path]" placeholder="e.g. src/utils/"
                                        class="w-full px-3 py-2 text-xs bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-indigo-500/10 font-mono">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">File Name *</label>
                                    <input type="text" name="files[0][name]" required placeholder="index.js"
                                        class="file-name w-full px-3 py-2 text-xs bg-gray-50 border-none rounded-lg focus:ring-2 focus:ring-indigo-500/10 font-bold text-indigo-600">
                                </div>
                            </div>
                            <textarea name="files[0][content]"
                                class="code-editor w-full p-6 text-sm bg-[#fafafa] text-gray-700 border-none focus:ring-0 leading-relaxed outline-none"
                                placeholder="// Write your code here...">{{ old('files.0.content') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="categoryId"
                        class="w-full rounded-xl border-none bg-gray-50 text-sm focus:ring-2 focus:ring-indigo-500/10 py-3.5 px-4 appearance-none cursor-pointer">
                        <option value="">Uncategorized</option>
                        @foreach ($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Privacy Settings</label>
                    <div class="space-y-3">
                        <label
                            class="flex items-center p-3 bg-gray-50 rounded-xl cursor-pointer group hover:bg-indigo-50 transition-colors">
                            <input type="radio" name="isPublic" value="1" checked
                                class="text-indigo-600 focus:ring-indigo-500 border-gray-200">
                            <span class="ml-3 text-sm font-bold text-gray-700">Public</span>
                        </label>
                        <label
                            class="flex items-center p-3 bg-gray-50 rounded-xl cursor-pointer group hover:bg-indigo-50 transition-colors">
                            <input type="radio" name="is_public" value="0"
                                class="text-indigo-600 focus:ring-indigo-500 border-gray-200">
                            <span class="ml-3 text-sm font-bold text-gray-700">Private</span>
                        </label>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                    <div class="tags-input-container">
                        <div class="tags-display flex flex-wrap gap-2 mb-2" id="tags-display"></div>
                        <div class="relative">
                            <input type="text" id="tags-input" placeholder="laravel, api, auth"
                                class="w-full rounded-xl border-none bg-gray-50 text-sm placeholder-gray-300 focus:ring-2 focus:ring-indigo-500/10 py-3.5 px-4">
                            <!-- Hidden inputs for array submission -->
                            <div id="tags-hidden-container"></div>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Press Enter or comma to add a tag</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-xl border-t border-gray-100 p-4 z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-end gap-6">
                <a href="{{ route('snippets.index') }}"
                    class="text-sm font-bold text-gray-400 hover:text-gray-600 px-4 transition-colors">Discard</a>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    Save Masterpiece
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ============ Tags Input Handler ============
            const tagsInput = document.getElementById('tags-input');
            const tagsDisplay = document.getElementById('tags-display');
            const tagsHiddenContainer = document.getElementById('tags-hidden-container');
            let tags = [];

            // Function to render tags
            function renderTags() {
                tagsDisplay.innerHTML = tags.map((tag, index) => `
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                        ${escapeHtml(tag)}
                        <button type="button" onclick="removeTag(${index})" class="ml-1 hover:text-indigo-900 focus:outline-none">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                `).join('');
                
                // Update hidden inputs with array notation
                tagsHiddenContainer.innerHTML = tags.map(tag => 
                    `<input type="hidden" name="tags[]" value="${escapeHtml(tag)}">`
                ).join('');
            }

            // Escape HTML to prevent XSS
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Add tag function
            window.addTag = function(tag) {
                const trimmedTag = tag.trim().toLowerCase();
                if (trimmedTag && !tags.includes(trimmedTag)) {
                    tags.push(trimmedTag);
                    renderTags();
                }
                tagsInput.value = '';
            }

            // Remove tag function
            window.removeTag = function(index) {
                tags.splice(index, 1);
                renderTags();
            }

            // Handle input events
            if (tagsInput) {
                tagsInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        const value = this.value.replace(',', '').trim();
                        if (value) {
                            addTag(value);
                        }
                    }
                });

                tagsInput.addEventListener('blur', function(e) {
                    const value = this.value.trim();
                    if (value) {
                        addTag(value);
                    }
                });
            }

            // Load existing tags from old input if any
            const existingTags = '{{ old('tags') }}';
            if (existingTags) {
                tags = existingTags.split(',').map(t => t.trim()).filter(t => t);
                renderTags();
            }

            // ============ Existing File Handling Code ============
            let fileCount = 1;
            const filesContainer = document.getElementById('files-container');
            const fileTabsContainer = document.getElementById('file-tabs-container');
            const addFileBtn = document.getElementById('add-file-btn');

            // Function to update file tabs
            function updateFileTabs() {
                const fileItems = document.querySelectorAll('.file-item');
                let tabsHtml = '';

                fileItems.forEach((item, index) => {
                    const fileId = item.dataset.fileId;
                    const fileNameInput = item.querySelector('.file-name');
                    let fileName = fileNameInput ? fileNameInput.value.trim() : '';

                    if (!fileName) {
                        fileName = `File ${index + 1}`;
                    }

                    const isActive = item.classList.contains('active') ? 'active' : '';

                    tabsHtml += `
                    <div class="relative group">
                        <button type="button" 
                            class="file-tab ${isActive} px-4 py-3 text-sm font-medium border-b-2 border-transparent hover:text-indigo-600 focus:outline-none flex items-center gap-2"
                            data-target="${fileId}">
                            <span class="truncate max-w-[150px]">${fileName}</span>
                            ${index > 0 ? `
                                            <span class="remove-file ml-1 text-gray-400 hover:text-red-600 text-lg leading-none" 
                                                onclick="event.stopPropagation(); removeFile('${fileId}')">
                                                ×
                                            </span>
                                        ` : ''}
                        </button>
                    </div>
                `;
                });

                if (fileTabsContainer) {
                    fileTabsContainer.innerHTML = tabsHtml;
                }

                // Add click event to tabs
                document.querySelectorAll('.file-tab').forEach(tab => {
                    tab.addEventListener('click', function(e) {
                        if (e.target.classList.contains('remove-file')) return;

                        const targetId = this.dataset.target;

                        // Remove active class from all tabs and file items
                        document.querySelectorAll('.file-tab').forEach(t => t.classList.remove(
                            'active'));
                        document.querySelectorAll('.file-item').forEach(f => f.classList.remove(
                            'active'));

                        // Add active class to clicked tab and corresponding file
                        this.classList.add('active');
                        const targetFile = document.querySelector(
                            `.file-item[data-file-id="${targetId}"]`);
                        if (targetFile) {
                            targetFile.classList.add('active');
                        }
                    });
                });
            }

            // Function to add new file
            function addNewFile() {
                const newIndex = fileCount;
                fileCount++;
                const fileId = `file-${fileCount}`;

                const fileHtml = `
                <div class="file-item" data-file-id="${fileId}">
                    <div class="flex flex-col sm:flex-row gap-4 p-4 bg-white border-b border-gray-100">
                        <div class="flex-1">
                            <label class="block text-xs text-gray-500 mb-1">File Path (optional)</label>
                            <input type="text" 
                                name="files[${newIndex}][path]" 
                                placeholder="e.g., src/components/"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-md focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs text-gray-500 mb-1">File Name <span class="text-red-500">*</span></label>
                            <input type="text" 
                                name="files[${newIndex}][name]" 
                                placeholder="example.js"
                                class="file-name w-full px-3 py-2 text-sm border border-gray-200 rounded-md focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                required>
                        </div>
                    </div>
                    <textarea 
                        name="files[${newIndex}][content]"
                        class="code-editor w-full min-h-[500px] p-4 text-sm bg-gray-50 text-gray-700 border-none focus:ring-0 font-mono leading-relaxed outline-none"
                        placeholder="// Start coding here..."></textarea>
                </div>
            `;

                if (filesContainer) {
                    filesContainer.insertAdjacentHTML('beforeend', fileHtml);

                    // Deactivate all files
                    document.querySelectorAll('.file-item').forEach(f => f.classList.remove('active'));

                    // Activate new file
                    const newFile = document.querySelector(`.file-item[data-file-id="${fileId}"]`);
                    if (newFile) {
                        newFile.classList.add('active');
                    }

                    updateFileTabs();

                    // Add tab handling to new textarea
                    const newTextarea = newFile.querySelector('.code-editor');
                    if (newTextarea) {
                        addTabHandling(newTextarea);
                    }
                }
            }

            // Remove file function
            window.removeFile = function(fileId) {
                const fileItem = document.querySelector(`.file-item[data-file-id="${fileId}"]`);
                const totalFiles = document.querySelectorAll('.file-item').length;

                if (fileItem && totalFiles > 1) {
                    fileItem.remove();

                    // If removed file was active, activate first file
                    if (!document.querySelector('.file-item.active')) {
                        const firstFile = document.querySelector('.file-item');
                        if (firstFile) {
                            firstFile.classList.add('active');
                        }
                    }

                    updateFileTabs();
                }
            }

            // Tab key handling for textareas
            function addTabHandling(textarea) {
                if (textarea) {
                    textarea.addEventListener('keydown', function(e) {
                        if (e.key === 'Tab') {
                            e.preventDefault();
                            const start = this.selectionStart;
                            const end = this.selectionEnd;

                            // Insert 4 spaces
                            this.value = this.value.substring(0, start) + '    ' + this.value.substring(
                                end);

                            // Move cursor position
                            this.selectionStart = this.selectionEnd = start + 4;
                        }
                    });
                }
            }

            // Add file button click handler
            if (addFileBtn) {
                addFileBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    addNewFile();
                });
            }

            // File name changes update tabs
            if (filesContainer) {
                filesContainer.addEventListener('input', function(e) {
                    if (e.target.classList.contains('file-name')) {
                        updateFileTabs();
                    }
                });
            }

            // Initialize existing textareas
            document.querySelectorAll('.code-editor').forEach(textarea => {
                addTabHandling(textarea);
            });

            // Initialize file tabs
            const firstFileItem = document.querySelector('.file-item');
            if (firstFileItem && !firstFileItem.classList.contains('active')) {
                firstFileItem.classList.add('active');
            }
            updateFileTabs();

        });
    </script>
@endpush