@extends('layout.app')

@section('title', 'Create Category')

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
                <span class="text-gray-400">|</span>
            </li>
            <li>
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">Category</a>
            </li>
            <li>
                <span class="text-gray-400">|</span>
            </li>
            <li>
                <span class="text-blue-400 font-medium">Create new</span>
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-black text-white tracking-tight">Create New Category</h1>
        <p class="text-gray-400 text-xs font-medium mt-1">Organize your snippets by creating a new category</p>
    </div>

    {{-- Main Content with Preview Left and Form Right --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Left Column - Live Preview --}}
        <div class="space-y-4">
            <div class="glass-card rounded-2xl p-6 border border-white/10 sticky top-24">
                <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Live Preview
                </h3>
                
                {{-- Preview Card --}}
                <div id="livePreview" class="glass-card rounded-xl p-6 border-2 transition-all" style="border-color: rgba(59, 130, 246, 0.3);">
                    <div class="flex items-start gap-4">
                        <div id="previewIcon" class="w-16 h-16 rounded-xl bg-blue-500/20 border-2 border-blue-500/30 flex items-center justify-center">
                            <span id="previewEmoji" class="text-3xl">🟦</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h2 id="previewTitle" class="text-2xl font-bold text-white">Category Name</h2>
                                <span id="previewCount" class="text-xs px-2 py-1 bg-blue-500/10 text-blue-400 rounded-md border border-blue-500/20">0 snippets</span>
                            </div>
                            <p id="previewDescription" class="text-gray-400 text-sm">Category description will appear here</p>
                            
                          
                        </div>
                    </div>
                </div>

                

                
            </div>
        </div>

        {{-- Right Column - Form --}}
        <div class="space-y-4">
            <div class="glass-card rounded-2xl p-6 border border-white/10">
                <form action="{{ url('/category-create') }}" method="POST"  enctype="multipart/form-data" class="space-y-5" id="categoryForm">
                    {{ csrf_field() }}
                    
                    {{-- Category Name --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">
                            Category Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" id="categoryName" value="{{ old('name') }}" placeholder="e.g., JavaScript, Python, Laravel" required
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
                            placeholder="Describe what this category is for...">{{ old('description') }}</textarea>
                        <p class="text-[10px] text-gray-500 mt-1.5">Brief explanation of what kind of snippets belong here</p>
                    </div>

                    {{-- Color Selection --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Color
                        </label>
                        
                        <div class="grid grid-cols-6 md:grid-cols-12 gap-2">
                            <button type="button" data-color="blue" data-emoji="🟦" class="color-btn w-8 h-8 rounded-lg bg-blue-500 border-2 border-blue-400 ring-2 ring-blue-500/50"></button>
                            <button type="button" data-color="purple" data-emoji="🟣" class="color-btn w-8 h-8 rounded-lg bg-purple-500 border border-white/10 hover:border-purple-400 transition-all"></button>
                            <button type="button" data-color="green" data-emoji="🟢" class="color-btn w-8 h-8 rounded-lg bg-green-500 border border-white/10 hover:border-green-400 transition-all"></button>
                            <button type="button" data-color="yellow" data-emoji="🟡" class="color-btn w-8 h-8 rounded-lg bg-yellow-500 border border-white/10 hover:border-yellow-400 transition-all"></button>
                            <button type="button" data-color="red" data-emoji="🔴" class="color-btn w-8 h-8 rounded-lg bg-red-500 border border-white/10 hover:border-red-400 transition-all"></button>
                            <button type="button" data-color="pink" data-emoji="💗" class="color-btn w-8 h-8 rounded-lg bg-pink-500 border border-white/10 hover:border-pink-400 transition-all"></button>
                            <button type="button" data-color="indigo" data-emoji="🟣" class="color-btn w-8 h-8 rounded-lg bg-indigo-500 border border-white/10 hover:border-indigo-400 transition-all"></button>
                            <button type="button" data-color="teal" data-emoji="🔷" class="color-btn w-8 h-8 rounded-lg bg-teal-500 border border-white/10 hover:border-teal-400 transition-all"></button>
                            <button type="button" data-color="orange" data-emoji="🟠" class="color-btn w-8 h-8 rounded-lg bg-orange-500 border border-white/10 hover:border-orange-400 transition-all"></button>
                            <button type="button" data-color="cyan" data-emoji="🔹" class="color-btn w-8 h-8 rounded-lg bg-cyan-500 border border-white/10 hover:border-cyan-400 transition-all"></button>
                            <button type="button" data-color="emerald" data-emoji="💚" class="color-btn w-8 h-8 rounded-lg bg-emerald-500 border border-white/10 hover:border-emerald-400 transition-all"></button>
                            <button type="button" data-color="rose" data-emoji="🌹" class="color-btn w-8 h-8 rounded-lg bg-rose-500 border border-white/10 hover:border-rose-400 transition-all"></button>
                        </div>
                        
                        {{-- Hidden input for color value --}}
                        <input type="hidden" name="color" value="blue" id="selectedColor">
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/5">
                        <a href="{{ url('/categories') }}" 
                            class="px-5 py-2.5 text-xs text-gray-400 hover:text-white transition-colors font-medium">
                            Cancel
                        </a>
                        <button type="submit"
                            class="btn-primary px-6 py-2.5 rounded-xl font-bold text-xs flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Category
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tips Section --}}
            <div class="glass-card rounded-xl p-4 border border-white/10 bg-blue-500/5">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                    b.classList.remove('ring-2', 'ring-blue-500/50', 'border-2', 'border-blue-400');
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
                const colorMap = {
                    'blue': 'rgba(59, 130, 246, 0.3)',
                    'purple': 'rgba(168, 85, 247, 0.3)',
                    'green': 'rgba(34, 197, 94, 0.3)',
                    'yellow': 'rgba(234, 179, 8, 0.3)',
                    'red': 'rgba(239, 68, 68, 0.3)',
                    'pink': 'rgba(236, 72, 153, 0.3)',
                    'indigo': 'rgba(99, 102, 241, 0.3)',
                    'teal': 'rgba(20, 184, 166, 0.3)',
                    'orange': 'rgba(249, 115, 22, 0.3)',
                    'cyan': 'rgba(6, 182, 212, 0.3)',
                    'emerald': 'rgba(16, 185, 129, 0.3)',
                    'rose': 'rgba(244, 114, 182, 0.3)'
                };
                
                previewCard.style.borderColor = colorMap[color] || 'rgba(59, 130, 246, 0.3)';
                
                // Update icon background
                previewIcon.className = `w-16 h-16 rounded-xl bg-${color}-500/20 border-2 border-${color}-500/30 flex items-center justify-center`;
            });
        });
    });
</script>
@endsection