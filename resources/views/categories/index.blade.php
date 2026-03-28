@extends('layout.app')

@section('title', 'Categories')

<style>
    /* Your existing animations */
    @keyframes menuPopIn {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes slideInLeft {
        0% {
            opacity: 0;
            transform: translateX(-20px);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

@section('content')
    <div id="main-page-content" class="w-full max-w-6xl mx-auto px-4">

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
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">Category</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><span class="text-blue-400 font-medium">Categories</span></li>
            </ol>
        </nav>

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-12">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-4xl font-black text-white tracking-tight">Categories</h1>
                    <span class="bg-blue-500/20 text-blue-400 text-xs font-bold px-2.5 py-1 rounded-lg border border-blue-500/30 mt-1">
                        {{ $categories->count() }}
                    </span>
                </div>
                <p class="text-gray-400 text-sm font-medium mt-1">Organize your snippets into categories</p>
            </div>

            <button type="button" onclick="openCreateModal()"
                class="btn-primary px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Category
            </button>
        </div>

        {{-- Categories Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @forelse($categories as $category)
                @php
                    $colorMap = [
                        'blue' => 'blue',
                        'purple' => 'purple',
                        'green' => 'green',
                        'yellow' => 'yellow',
                        'red' => 'red',
                        'pink' => 'pink'
                    ];
                    $colorClass = $colorMap[$category->color_name] ?? 'blue';
                @endphp
                
                <div onclick="openActionMenu('{{ $category->category_id }}', '{{ addslashes($category->category_name) }}', '{{ $category->color_name }}', '{{ addslashes($category->category_description) }}')"
                    class="group relative bg-gray-800/30 rounded-xl p-4 border border-white/10 hover:border-{{ $colorClass }}-500/30 hover:bg-{{ $colorClass }}-500/5 transition-all cursor-pointer">

                    <div class="absolute -top-2 -right-2 z-10">
                        <span class="text-[10px] px-2 py-1 bg-{{ $colorClass }}-500/20 text-{{ $colorClass }}-400 rounded-full border border-{{ $colorClass }}-500/30">
                            {{ $category->snippets_count ?? 0 }}
                        </span>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 mb-3 relative">
                            <svg class="w-16 h-16 text-{{ $colorClass }}-500/70 group-hover:text-{{ $colorClass }}-400 transition-colors"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                            </svg>
                            <div class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-{{ $colorClass }}-500 border-2 border-black">
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-1 truncate w-full">{{ $category->category_name }}</h3>
                        <p class="text-[10px] text-gray-500 line-clamp-2">
                            {{ $category->category_description ?? 'No description' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center pt-8 pb-16 text-center">
                    <div class="bg-gray-800/50 p-6 rounded-full mb-4">
                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-white font-bold text-lg">No categories yet</h3>
                    <p class="text-gray-500 text-center max-w-lg">Click "New Category" to create your first category</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Create Category Modal --}}
    <div id="create-category-modal" class="hidden fixed inset-0 z-[99999] bg-black/60 flex items-center justify-center p-4">
        <div onclick="event.stopPropagation()" class="relative w-full max-w-2xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-[menuPopIn_0.4s_cubic-bezier(0.34,1.56,0.64,1)]">
            <button onclick="closeCreateModal()" class="absolute top-5 right-5 z-50 text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-black text-white tracking-tight">New Category</h1>
                    <p class="text-gray-500 text-xs mt-1">Fill in the details to create a folder.</p>
                </div>

                <form action="{{ url('/category-create') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-widest ml-1">Name *</label>
                        <input type="text" name="name" id="categoryName" placeholder="e.g. JavaScript" required
                            class="input-field w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-widest ml-1">Description</label>
                        <textarea name="description" id="categoryDescription" rows="3" placeholder="What's inside?"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-widest ml-1">Color Theme</label>
                        <div class="flex gap-3">
                            @foreach (['blue', 'purple', 'green', 'yellow', 'red', 'pink'] as $color)
                                <button type="button" data-color="{{ $color }}"
                                    class="color-btn w-8 h-8 rounded-lg bg-{{ $color }}-500 border-2 {{ $color == 'blue' ? 'border-white' : 'border-transparent' }} hover:scale-110 transition-transform"></button>
                            @endforeach
                        </div>
                        <input type="hidden" name="color" value="blue" id="selectedColor">
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" onclick="closeCreateModal()"
                            class="flex-1 py-3 text-sm font-bold text-gray-400 hover:text-white transition">Cancel</button>
                        <button type="submit"
                            class="flex-[2] py-3 rounded-xl btn-primary text-white font-bold ">
                            Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Category Modal --}}
    <div id="update-category-modal" class="hidden fixed inset-0 z-[99999] bg-black/60 flex items-center justify-center p-4">
        <div onclick="event.stopPropagation()" class="relative w-full max-w-2xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-[menuPopIn_0.4s_cubic-bezier(0.34,1.56,0.64,1)]">
            <button onclick="closeUpdateModal()" class="absolute top-5 right-5 z-50 text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-black text-white tracking-tight">Update Category</h1>
                    <p class="text-gray-500 text-xs mt-1">Update your category details.</p>
                </div>

                <form id="update-form" method="POST" class="space-y-4">
                    @csrf
                    
                    <input type="hidden" name="category_id" id="updateCategoryId">

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-widest ml-1">Name *</label>
                        <input type="text" name="name" id="updateCategoryName" placeholder="e.g. JavaScript" required
                            class="input-field w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-widest ml-1">Description * </label>
                        <textarea name="description" id="updateCategoryDescription" rows="3" placeholder="What's inside?"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-widest ml-1">Color Theme</label>
                        <div class="flex gap-3">
                            @foreach (['blue', 'purple', 'green', 'yellow', 'red', 'pink'] as $color)
                                <button type="button" data-update-color="{{ $color }}"
                                    class="update-color-btn w-8 h-8 rounded-lg bg-{{ $color }}-500 border-2 border-transparent hover:scale-110 transition-transform"></button>
                            @endforeach
                        </div>
                        <input type="hidden" name="color" id="updateSelectedColor">
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" onclick="closeUpdateModal()"
                            class="flex-1 py-3 text-sm font-bold text-gray-400 hover:text-white transition">Cancel</button>
                        <button type="submit"
                            class="flex-[2] py-3 font-black rounded-xl btn-primary text-white ">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Action Menu Modal --}}
    <div id="action-menu" class="hidden fixed inset-0 z-[9999] bg-black/40 flex items-center justify-center p-4">
        <div onclick="event.stopPropagation()" class="glass-card rounded-3xl p-8 flex flex-col gap-4 min-w-[340px] border border-white/10 shadow-2xl animate-[menuPopIn_0.3s_cubic-bezier(0.34,1.56,0.64,1)]">
            <div id="selected-category-name" class="text-white text-3xl font-extrabold text-center mb-2">Category</div>
            <div id="selected-category-desc" class="text-gray-400 text-sm text-center mb-4"></div>

            <div class="flex flex-col gap-3">
                <a href="#" id="view-link" class="group py-5 px-8 rounded-2xl font-bold text-center bg-white text-black hover:bg-gray-200 transition text-sm flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Snippets
                </a>

                <button type="button" onclick="openUpdateModalFromAction()"
                    class="group py-3 px-8 rounded-2xl font-bold text-center input-field hover:bg-white/10 transition text-xs flex items-center justify-center gap-3 text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Update Category
                </button>

                <button type="button" onclick="showDeleteConfirmation()"
                    class="group w-full py-4 px-8 rounded-2xl font-bold text-center text-red-300 hover:text-red-500 transition text-xs flex items-center justify-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Category
                </button>
            </div>

            <button onclick="closeActionMenu()" class="text-gray-500 hover:text-white text-sm font-medium transition-colors mt-4">Dismiss</button>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="delete-confirmation-modal" class="hidden fixed inset-0 z-[99999] bg-black/70 flex items-center justify-center p-4">
        <div onclick="event.stopPropagation()" class="glass-card rounded-3xl p-8 flex flex-col gap-5 min-w-[340px] max-w-md border border-white/10 shadow-2xl animate-[menuPopIn_0.3s_cubic-bezier(0.34,1.56,0.64,1)]">
            <div class="flex justify-center">
                <div class="w-16 h-16 rounded-full bg-red-500/20 flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>

            <div class="text-center">
                <h3 class="text-white text-xl font-extrabold mb-2">Delete Category</h3>
                <p id="delete-confirmation-message" class="text-gray-400 text-sm">Are you sure you want to delete this category?</p>
                <p class="text-gray-500 text-xs mt-2">This action cannot be undone.</p>
            </div>

            <div class="flex flex-col gap-3 mt-2">
                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="category_id" id="deleteCategoryId">
                    <button type="submit" class="w-full py-3 px-8 rounded-2xl font-bold bg-red-600 text-white hover:bg-red-700 transition text-sm flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>

                <button onclick="closeDeleteConfirmation()" class="w-full py-3 px-8 rounded-2xl font-bold input-field hover:bg-white/10 transition text-sm text-gray-300 hover:text-white">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentCategoryId = null;
        let currentCategoryName = null;
        let currentCategoryDesc = null;
        let currentCategoryColor = null;

        // Create Modal Functions
        function openCreateModal() {
            document.getElementById('create-category-modal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('create-category-modal').classList.add('hidden');
            document.getElementById('categoryName').value = '';
            document.getElementById('categoryDescription').value = '';
        }

        // Action Menu Functions
        function openActionMenu(categoryId, categoryName, colorName, categoryDesc) {
            currentCategoryId = categoryId;
            currentCategoryName = categoryName;
            currentCategoryDesc = categoryDesc;
            currentCategoryColor = colorName;

            document.getElementById('selected-category-name').textContent = categoryName;
            document.getElementById('selected-category-desc').textContent = categoryDesc || 'No description';
            document.getElementById('view-link').href = `/categories/${categoryId}`;
            document.getElementById('action-menu').classList.remove('hidden');
        }

        function closeActionMenu() {
            document.getElementById('action-menu').classList.add('hidden');
        }

        // Update Modal Functions
        function openUpdateModalFromAction() {
            if (currentCategoryId) {
                // Fill update form with current category data
                document.getElementById('updateCategoryId').value = currentCategoryId;
                document.getElementById('updateCategoryName').value = currentCategoryName;
                document.getElementById('updateCategoryDescription').value = currentCategoryDesc || '';
                document.getElementById('updateSelectedColor').value = currentCategoryColor;
                
                // Set form action
                document.getElementById('update-form').action = `/category-update`;
                
                // Update color buttons UI
                document.querySelectorAll('.update-color-btn').forEach(btn => {
                    btn.classList.remove('border-white');
                    btn.classList.add('border-transparent');
                    if (btn.dataset.updateColor === currentCategoryColor) {
                        btn.classList.remove('border-transparent');
                        btn.classList.add('border-white');
                    }
                });
                
                // Close action menu and open update modal
                closeActionMenu();
                document.getElementById('update-category-modal').classList.remove('hidden');
            }
        }

        function closeUpdateModal() {
            document.getElementById('update-category-modal').classList.add('hidden');
        }

        // Delete Confirmation Functions
        function showDeleteConfirmation() {
            document.getElementById('delete-confirmation-message').textContent = 
                `Are you sure you want to delete "${currentCategoryName}"?`;
            document.getElementById('deleteCategoryId').value = currentCategoryId;
            document.getElementById('delete-form').action = `/categories/${currentCategoryId}`;
            closeActionMenu();
            document.getElementById('delete-confirmation-modal').classList.remove('hidden');
        }

        function closeDeleteConfirmation() {
            document.getElementById('delete-confirmation-modal').classList.add('hidden');
        }

        // Color Selection for Create Modal
        document.addEventListener('DOMContentLoaded', function() {
            // Create modal color selection
            document.querySelectorAll('.color-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const color = this.dataset.color;
                    document.getElementById('selectedColor').value = color;
                    
                    document.querySelectorAll('.color-btn').forEach(b => {
                        b.classList.remove('border-white');
                        b.classList.add('border-transparent');
                    });
                    this.classList.remove('border-transparent');
                    this.classList.add('border-white');
                });
            });
            
            // Update modal color selection
            document.querySelectorAll('.update-color-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const color = this.dataset.updateColor;
                    document.getElementById('updateSelectedColor').value = color;
                    
                    document.querySelectorAll('.update-color-btn').forEach(b => {
                        b.classList.remove('border-white');
                        b.classList.add('border-transparent');
                    });
                    this.classList.remove('border-transparent');
                    this.classList.add('border-white');
                });
            });
        });

        // Close modals on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateModal();
                closeActionMenu();
                closeUpdateModal();
                closeDeleteConfirmation();
            }
        });
    </script>
@endsection