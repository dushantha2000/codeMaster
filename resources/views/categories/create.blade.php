@extends('layout.auth')

@section('title', 'Create Category')

@section('content')
    <div
        class="flex flex-col md:flex-row w-full max-w-6xl glass-card rounded-3xl overflow-hidden shadow-2xl ">
        {{-- Left Side - Preview --}}
        <div
            class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-8 overflow-hidden border-r border-white/5">
            <div class="relative z-10 w-full flex flex-col items-center">

                {{-- Preview Header --}}
                <h2 class="text-2xl font-bold text-white mb-8 text-center">Live Preview</h2>

                {{-- Preview Card - Centered --}}
                <div class="flex justify-center w-full">
                    <div id="livePreview"
                        class="group relative glass-card rounded-xl p-6 border-2 transition-all bg-gray-800/30 backdrop-blur-sm hover:border-blue-500/30 hover:bg-blue-500/5 cursor-pointer w-64">

                        {{-- Counter Badge --}}
                        <div class="absolute -top-2 -right-2 z-10">
                            <span id="previewCount"
                                class="text-[10px] px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full border border-blue-500/30">
                                0
                            </span>
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-col items-center text-center">
                            {{-- Icon with dot --}}
                            <div class="w-16 h-16 mb-3 relative">
                                <div id="previewIcon"
                                    class="w-16 h-16 text-blue-500/70 group-hover:text-blue-400 transition-colors">
                                    <svg class="w-16 h-16" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                                    </svg>
                                </div>
                                <div id="previewDot"
                                    class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-blue-500 border-2 border-black">
                                </div>
                            </div>

                            {{-- Category Name --}}
                            <h3 id="previewTitle"
                                class="text-sm font-bold text-white mb-1 group-hover:text-blue-400 transition-colors truncate w-full">
                                Category Name
                            </h3>

                            {{-- Category Description --}}
                            <p id="previewDescription" class="text-[10px] text-gray-500 line-clamp-2">
                                Category Description
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tips Section --}}
                {{-- <div class="mt-8 glass-card rounded-xl p-4 border border-white/10 bg-blue-500/5 w-full max-w-sm">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-white mb-1">Quick Tips</h4>
                    <ul class="text-[10px] text-gray-400 space-y-1 list-disc list-inside">
                        <li>Use clear, descriptive names</li>
                        <li>Add a detailed description</li>
                        <li>Choose a representative color</li>
                        <li>Preview updates as you type</li>
                    </ul>
                </div>
            </div>
        </div> --}}
            </div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-600/10 rounded-full blur-3xl"></div>
        </div>

        {{-- Right Side - Form --}}
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">

            {{-- Header --}}
            {{-- Header --}}
            <div class="mb-8">
                {{-- Top row with back button and logo --}}
                <div class="flex items-center justify-between mb-4">
                    {{-- Back button --}}

                    {{-- Logo --}}
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 bg-black-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-white tracking-tight">
                            <a href="{{ url('/') }}">CodeVault</a>
                            <span class="text-blue-500 text-xs font-normal">v1.1</span>
                        </h1>
                    </div>

                    {{-- Back button --}}
                    <a href="{{ route('categories.index') }}"
                        class="flex items-center gap-1 text-gray-400 hover:text-white transition-colors group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="text-sm">Back</span>
                    </a>
                </div>

                {{-- Page title --}}
                <h1 class="text-2xl font-bold text-white">Create Category</h1>
                <p class="text-gray-500 text-sm mt-1">Organize your snippets by creating a new category</p>
            </div>

            {{-- Form --}}
            <form action="{{ url('/category-create') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                {{ csrf_field() }}

                @if (session('error'))
                    <div
                        class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-2.5 rounded-xl text-xs flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Category Name --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-widest">
                        Category Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" id="categoryName" value="{{ old('name') }}"
                        placeholder="e.g., JavaScript, Python, Laravel" required
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                    @error('name')
                        <p class="mt-1 ml-1 text-[10px] text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="text-[10px] text-gray-500 mt-1.5 ml-1">Choose a descriptive name for your category</p>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-widest">Description
                        <span class="text-red-400">*</span></label>
                    <textarea name="description" id="categoryDescription" rows="3"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 resize-none"
                        placeholder="Describe what this category is for...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 ml-1 text-[10px] text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="text-[10px] text-gray-500 mt-1.5 ml-1">Brief explanation of what kind of snippets belong here
                    </p>
                </div>

                {{-- Color Selection --}}
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-2 ml-1">Color</label>

                    <div class="grid grid-cols-6 gap-2">
                        <button type="button" data-color="blue" data-emoji="🟦"
                            class="color-btn w-8 h-8 rounded-lg bg-blue-500 border-2 border-blue-400 ring-2 ring-blue-500/50"></button>
                        <button type="button" data-color="purple" data-emoji="🟣"
                            class="color-btn w-8 h-8 rounded-lg bg-purple-500 border border-white/10 hover:border-purple-400 transition-all"></button>
                        <button type="button" data-color="green" data-emoji="🟢"
                            class="color-btn w-8 h-8 rounded-lg bg-green-500 border border-white/10 hover:border-green-400 transition-all"></button>
                        <button type="button" data-color="yellow" data-emoji="🟡"
                            class="color-btn w-8 h-8 rounded-lg bg-yellow-500 border border-white/10 hover:border-yellow-400 transition-all"></button>
                        <button type="button" data-color="red" data-emoji="🔴"
                            class="color-btn w-8 h-8 rounded-lg bg-red-500 border border-white/10 hover:border-red-400 transition-all"></button>
                        <button type="button" data-color="pink" data-emoji="💗"
                            class="color-btn w-8 h-8 rounded-lg bg-pink-500 border border-white/10 hover:border-pink-400 transition-all"></button>
                    </div>

                    {{-- Hidden input for color value --}}
                    <input type="hidden" name="color" value="blue" id="selectedColor">
                    @error('color')
                        <p class="mt-1 ml-1 text-[10px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/5 mt-6">
                    <a href="{{ route('categories.index') }}"
                        class="px-5 py-2.5 text-xs text-gray-400 hover:text-white transition-colors font-medium">
                        Cancel
                    </a>
                    <button type="submit"
                        class="btn-primary inline-flex items-center gap-2 text-white text-sm px-6 py-3 rounded-xl font-semibold shadow-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Create Category
                    </button>
                </div>
            </form>

            {{-- Mobile Preview Note --}}
            <div class="mt-6 text-center md:hidden">
                <p class="text-gray-500 text-xs">
                    <span class="text-blue-400"></span>
                    Preview updates as you type on desktop
                </p>
            </div>
        </div>
    </div>

    <script>
        // Live Preview Updates
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('categoryName');
            const descInput = document.getElementById('categoryDescription');
            const previewTitle = document.getElementById('previewTitle');
            const previewDesc = document.getElementById('previewDescription');
            const previewIcon = document.getElementById('previewIcon');
            const previewDot = document.getElementById('previewDot');
            const previewCount = document.getElementById('previewCount');
            const previewCard = document.getElementById('livePreview');

            // Update name in real-time
            if (nameInput) {
                nameInput.addEventListener('input', function() {
                    previewTitle.textContent = this.value || 'Category Name';
                });
            }

            // Update description in real-time
            if (descInput) {
                descInput.addEventListener('input', function() {
                    previewDesc.textContent = this.value || 'Category Description';
                });
            }

            // Color selection with live preview
            document.querySelectorAll('.color-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update button styles
                    document.querySelectorAll('.color-btn').forEach(b => {
                        b.classList.remove('ring-2', 'ring-blue-500/50', 'border-2',
                            'border-blue-400');
                        b.classList.add('border', 'border-white/10');
                    });
                    this.classList.add('ring-2', 'ring-blue-500/50', 'border-2', 'border-blue-400');
                    this.classList.remove('border-white/10');

                    // Get color
                    const color = this.dataset.color;

                    // Update hidden input
                    document.getElementById('selectedColor').value = color;

                    // Update preview card styles
                    if (previewCard) {
                        previewCard.classList.remove('hover:border-blue-500/30',
                            'hover:border-purple-500/30',
                            'hover:border-green-500/30', 'hover:border-yellow-500/30',
                            'hover:border-red-500/30',
                            'hover:border-pink-500/30');
                        previewCard.classList.add(`hover:border-${color}-500/30`);

                        previewCard.classList.remove('hover:bg-blue-500/5', 'hover:bg-purple-500/5',
                            'hover:bg-green-500/5', 'hover:bg-yellow-500/5',
                            'hover:bg-red-500/5',
                            'hover:bg-pink-500/5');
                        previewCard.classList.add(`hover:bg-${color}-500/5`);
                    }

                    // Update icon color
                    if (previewIcon) {
                        previewIcon.className =
                            `w-16 h-16 text-${color}-500/70 group-hover:text-${color}-400 transition-colors`;
                    }

                    // Update dot color
                    if (previewDot) {
                        previewDot.className =
                            `absolute bottom-0 right-0 w-4 h-4 rounded-full bg-${color}-500 border-2 border-black`;
                    }

                    // Update badge
                    if (previewCount) {
                        previewCount.className =
                            `text-[10px] px-2 py-1 bg-${color}-500/20 text-${color}-400 rounded-full border border-${color}-500/30`;
                    }
                });
            });
        });
    </script>
@endsection
