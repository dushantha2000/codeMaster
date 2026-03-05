@extends('layout.app')

@section('title', 'Edit Category')

@section('content')
    <div class="w-full max-w-full mx-auto px-4 space-y-6">
        {{-- Breadcrumb --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">
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
                    <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700">Categories</a>
                </li>
                <li>
                    <span class="text-gray-400">/</span>
                </li>
                <li>
                    <span class="text-blue-400 font-medium">Edit category</span>
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Edit Category</h1>
            <p class="text-gray-400 text-xs font-medium mt-1">Update your category details</p>
        </div>

        {{-- Main Content with Preview Left and Form Right --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Left Column - Live Preview --}}
            <div class="space-y-4">
                <div class="glass-card rounded-2xl p-6 border border-white/10 sticky top-24">
                    <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Live Preview
                    </h3>

                    {{-- Preview Card --}}
                    <div id="livePreview" class="glass-card rounded-xl p-6 border-2 transition-all"
                        style="border-color: {{ $category->color_name }}">
                        <div class="flex items-start gap-4">
                            <div id="previewIcon" class="w-16 h-16 rounded-xl flex items-center justify-center"
                                style="background-color: {{ $category->color_name }}20; border: 2px solid {{ $category->color_name }}50">
                                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="{{ $category->color_name }}"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h2 id="previewTitle" class="text-2xl font-bold text-white">
                                        {{ $category->category_name }}</h2>
                                    <span id="previewCount"
                                        class="text-xs px-2 py-1 bg-blue-500/10 text-blue-400 rounded-md border border-blue-500/20">0
                                        snippets</span>
                                </div>
                                <p id="previewDescription" class="text-gray-400 text-sm">
                                    {{ $category->category_description ?? 'Category description will appear here' }}</p>
                            </div>
                        </div>
                    </div>




                </div>
            </div>

            {{-- Right Column - Form --}}
            <div class="space-y-4">
                <div class="glass-card rounded-2xl p-6 border border-white/10">
                    <form action="{{ url('/category-update') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-5" id="categoryForm">
                        {{ csrf_field() }}

                        {{-- Hidden input for category_id --}}
                        <input type="hidden" name="category_id" value="{{ $category->category_id }}">

                        {{-- Category Name --}}
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">
                                Category Name <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="name" id="categoryName"
                                value="{{ old('name', $category->category_name) }}"
                                placeholder="e.g., JavaScript, Python, Laravel" required
                                class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
                            <p class="text-[10px] text-gray-500 mt-1.5">Choose a descriptive name for your category</p>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">
                                Description
                            </label>
                            <textarea name="description" id="categoryDescription" rows="3"
                                class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all"
                                placeholder="Describe what this category is for...">{{ old('description', $category->category_description) }}</textarea>
                            <p class="text-[10px] text-gray-500 mt-1.5">Brief explanation of what kind of snippets belong
                                here</p>
                        </div>

                        {{-- Color Selection --}}
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">
                                Color
                            </label>

                            <div class="grid grid-cols-6 md:grid-cols-12 gap-2">
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
                                <button type="button" data-color="indigo" data-emoji="🟣"
                                    class="color-btn w-8 h-8 rounded-lg bg-indigo-500 border border-white/10 hover:border-indigo-400 transition-all"></button>
                                <button type="button" data-color="teal" data-emoji="🔷"
                                    class="color-btn w-8 h-8 rounded-lg bg-teal-500 border border-white/10 hover:border-teal-400 transition-all"></button>
                                <button type="button" data-color="orange" data-emoji="🟠"
                                    class="color-btn w-8 h-8 rounded-lg bg-orange-500 border border-white/10 hover:border-orange-400 transition-all"></button>
                                <button type="button" data-color="cyan" data-emoji="🔹"
                                    class="color-btn w-8 h-8 rounded-lg bg-cyan-500 border border-white/10 hover:border-cyan-400 transition-all"></button>
                                <button type="button" data-color="emerald" data-emoji="💚"
                                    class="color-btn w-8 h-8 rounded-lg bg-emerald-500 border border-white/10 hover:border-emerald-400 transition-all"></button>
                                <button type="button" data-color="rose" data-emoji="🌹"
                                    class="color-btn w-8 h-8 rounded-lg bg-rose-500 border border-white/10 hover:border-rose-400 transition-all"></button>
                            </div>

                            {{-- Hidden input for color value --}}
                            <input type="hidden" name="color" value="{{ old('color', $category->color_name) }}"
                                id="selectedColor">
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/5">
                            <a href="{{ route('categories.index') }}"
                                class="px-5 py-2.5 text-xs text-gray-400 hover:text-white transition-colors font-medium">
                                Cancel
                            </a>
                            <button type="submit"
                                class="btn-primary px-6 py-2.5 rounded-xl font-bold text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Tips Section --}}
                <div class="glass-card rounded-xl p-4 border border-white/10 bg-blue-500/5">
                    <div class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white mb-1">Tips</h4>
                            <ul class="text-[10px] text-gray-400 space-y-1 list-disc list-inside">
                                <li>Use clear, descriptive names</li>
                                <li>Add a detailed description</li>
                                <li>Choose a representative color</li>
                                <li>Preview updates as you type</li>
                            </ul>
                        </div>
                    </div>
                </div>
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
            const previewEmoji = document.getElementById('previewEmoji');
            const previewCard = document.getElementById('livePreview');

            // Get stored color value
            const storedColor = document.getElementById('selectedColor').value || 'blue';

            // Initialize color selection based on stored value
            const colorMap = {
                'blue': {
                    emoji: '🟦',
                    border: 'rgba(59, 130, 246, 0.3)',
                    bgClass: 'bg-blue-500/20',
                    borderClass: 'border-blue-500/30'
                },
                'purple': {
                    emoji: '🟣',
                    border: 'rgba(168, 85, 247, 0.3)',
                    bgClass: 'bg-purple-500/20',
                    borderClass: 'border-purple-500/30'
                },
                'green': {
                    emoji: '🟢',
                    border: 'rgba(34, 197, 94, 0.3)',
                    bgClass: 'bg-green-500/20',
                    borderClass: 'border-green-500/30'
                },
                'yellow': {
                    emoji: '🟡',
                    border: 'rgba(234, 179, 8, 0.3)',
                    bgClass: 'bg-yellow-500/20',
                    borderClass: 'border-yellow-500/30'
                },
                'red': {
                    emoji: '🔴',
                    border: 'rgba(239, 68, 68, 0.3)',
                    bgClass: 'bg-red-500/20',
                    borderClass: 'border-red-500/30'
                },
                'pink': {
                    emoji: '💗',
                    border: 'rgba(236, 72, 153, 0.3)',
                    bgClass: 'bg-pink-500/20',
                    borderClass: 'border-pink-500/30'
                },
                'indigo': {
                    emoji: '🟣',
                    border: 'rgba(99, 102, 241, 0.3)',
                    bgClass: 'bg-indigo-500/20',
                    borderClass: 'border-indigo-500/30'
                },
                'teal': {
                    emoji: '🔷',
                    border: 'rgba(20, 184, 166, 0.3)',
                    bgClass: 'bg-teal-500/20',
                    borderClass: 'border-teal-500/30'
                },
                'orange': {
                    emoji: '🟠',
                    border: 'rgba(249, 115, 22, 0.3)',
                    bgClass: 'bg-orange-500/20',
                    borderClass: 'border-orange-500/30'
                },
                'cyan': {
                    emoji: '🔹',
                    border: 'rgba(6, 182, 212, 0.3)',
                    bgClass: 'bg-cyan-500/20',
                    borderClass: 'border-cyan-500/30'
                },
                'emerald': {
                    emoji: '💚',
                    border: 'rgba(16, 185, 129, 0.3)',
                    bgClass: 'bg-emerald-500/20',
                    borderClass: 'border-emerald-500/30'
                },
                'rose': {
                    emoji: '🌹',
                    border: 'rgba(244, 114, 182, 0.3)',
                    bgClass: 'bg-rose-500/20',
                    borderClass: 'border-rose-500/30'
                }
            };

            // Set initial color selection
            const colorData = colorMap[storedColor] || colorMap['blue'];
            document.querySelectorAll('.color-btn').forEach(btn => {
                if (btn.dataset.color === storedColor) {
                    btn.classList.add('ring-2', 'ring-blue-500/50', 'border-2', 'border-blue-400');
                    btn.classList.remove('border-white/10');
                } else {
                    btn.classList.remove('ring-2', 'ring-blue-500/50', 'border-2', 'border-blue-400');
                    btn.classList.add('border', 'border-white/10');
                }
            });

            // Set initial preview based on stored category
            previewCard.style.borderColor = colorData.border;
            previewIcon.className =
                `w-16 h-16 rounded-xl ${colorData.bgClass} border-2 ${colorData.borderClass} flex items-center justify-center`;

            // Update name in real-time
            nameInput.addEventListener('input', function() {
                previewTitle.textContent = this.value || 'Category Name';
            });

            // Update description in real-time
            descInput.addEventListener('input', function() {
                previewDesc.textContent = this.value || 'Category description will appear here';
            });

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

                    // Get color and emoji
                    const color = this.dataset.color;
                    const emoji = this.dataset.emoji;

                    // Update hidden input
                    document.getElementById('selectedColor').value = color;

                    // Update preview
                    previewEmoji.textContent = emoji;

                    // Update preview card border color
                    const selectedColorData = colorMap[color] || colorMap['blue'];

                    previewCard.style.borderColor = selectedColorData.border;

                    // Update icon background
                    previewIcon.className =
                        `w-16 h-16 rounded-xl ${selectedColorData.bgClass} border-2 ${selectedColorData.borderClass} flex items-center justify-center`;
                });
            });
        });
    </script>
@endsection
