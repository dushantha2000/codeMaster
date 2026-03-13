@extends('layout.app')

@section('title', 'Categories')

@section('content')
    {{-- 1. WRAPPER FOR BLURRABLE CONTENT --}}
    <div id="main-page-content" class="w-full max-w-6xl mx-auto px-4  animate-in fade-in slide-in-from-bottom-4 duration-500">

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
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">Category</a>
                </li>
                <li>
                    <span class="text-gray-400">/</span>
                </li>
                <li>
                    <span class="text-blue-400 font-medium">Categories</span>
                </li>
            </ol>
        </nav>


        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-12">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-4xl font-black text-white tracking-tight">Categories</h1>
                    <span
                        class="bg-blue-500/20 text-blue-400 text-xs font-bold px-2.5 py-1 rounded-lg border border-blue-500/30 mt-1">
                        {{ $categories->count() }}
                    </span>
                </div>
                <p class="text-gray-400 text-sm font-medium mt-1">Organize your snippets into categories</p>
            </div>

            <a href="{{ url('/create-new') . '?type=category' }}"
                class="btn-primary px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Category
            </a>
        </div>

        {{-- Categories Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @forelse($categories as $category)
                <div onclick="triggerActionMenu('{{ $category->category_id }}', '{{ $category->category_name }}', '{{ $category->color_name }}')"
                    class="group relative bg-gray-800/30 backdrop-blur-sm rounded-xl p-4 border border-white/10 hover:border-{{ $category->color_name }}-500/30 hover:bg-{{ $category->color_name }}-500/5 transition-all cursor-pointer">

                    <div class="absolute -top-2 -right-2 z-10">
                        <span
                            class="text-[10px] px-2 py-1 bg-{{ $category->color_name }}-500/20 text-{{ $category->color_name }}-400 rounded-full border border-{{ $category->color_name }}-500/30">
                            0
                        </span>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 mb-3 relative">
                            <svg class="w-16 h-16 text-{{ $category->color_name }}-500/70 group-hover:text-{{ $category->color_name }}-400 transition-colors"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                            </svg>
                            <div
                                class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-{{ $category->color_name }}-500 border-2 border-black">
                            </div>
                        </div>

                        <h3
                            class="text-sm font-bold text-white mb-1 group-hover:text-{{ $category->color_name }}-400 transition-colors truncate w-full">
                            {{ $category->category_name }}
                        </h3>

                        <p class="text-[10px] text-gray-500 line-clamp-2">
                            {{ $category->category_description }}
                        </p>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-2 sm:col-span-3 md:col-span-4 lg:col-span-5 xl:col-span-6 flex flex-col items-center justify-center pt-8 pb-16 w-full text-center">
                    <div class="bg-gray-800/50 p-6 rounded-full mb-4">
                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-white font-bold text-lg">No categories yet</h3>
                    <p class="text-gray-500 text-center mb-10 max-w-lg leading-relaxed mx-auto px-4">Your collection of
                        categories is currently empty. Start organizing your development workflow by creating specialized
                        folders for your snippets. A well-structured library helps you find code faster and boosts your
                        daily productivity.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- FLOATING ACTION MENU --}}
    <div id="action-menu" onclick="closeActionMenu()"
        class="hidden fixed inset-0 z-[9999] backdrop-blur-md bg-black/60 flex items-center justify-center p-4">

        {{-- Using a deep dark background --}}
        <div onclick="event.stopPropagation()"
            class="   rounded-3xl p-8 flex flex-col gap-4 min-w-[340px] shadow-[0_20px_50px_rgba(0,0,0,0.5)] 
               scale-90 animate-[menuPopIn_0.3s_cubic-bezier(0.34,1.56,0.64,1)_forwards]">

            <div id="selected-category-name"
                class="text-white text-3xl font-extrabold text-center mb-6 tracking-tight animate-[glowPulse_2s_infinite]">
                Category
            </div>

            <div class="flex flex-col gap-3">

                {{-- View Snippets (Main Action) --}}
                <a href="{{ url('/View-snippets-{$id}') }}" id="view-link"
                    class="group relative py-5 px-8 rounded-2xl font-bold text-center transition-all duration-300 
                        text-sm  flex items-center justify-center gap-3 overflow-hidden
                       bg-white text-black hover:bg-black hover:text-white
                       animate-[slideInLeft_0.3s_ease-out_0.1s_both]">

                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Snippets
                </a>

                {{-- Update (Dark Style) --}}
                <a href="#" id="update-link"
                    class="group py-3 px-8 rounded-2xl font-bold text-center transition-all duration-300 
                        text-xs  flex items-center justify-center gap-3
                       bg-[#1e1e1e] text-gray-300 border border-white/5
                       hover:bg-[#2a2a2a] hover:text-white hover:border-white/20
                       animate-[slideInLeft_0.3s_ease-out_0.2s_both]">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Update Category
                </a>

                {{-- Delete (Dark Red Style) --}}
                <button type="button" onclick="showDeleteConfirmation()"
                    class="group w-full py-4 px-8 rounded-2xl font-bold text-center transition-all duration-300 
                            text-xs flex items-center justify-center gap-3
                            text-red-300 
                            hover:text-red-500 
                           animate-[slideInLeft_0.3s_ease-out_0.3s_both]">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Category
                </button>
            </div>

            {{-- CLOSE BUTTON --}}
            <button onclick="closeActionMenu()"
                class="text-gray-500 hover:text-white text-sm font-medium transition-colors mt-4
                   animate-[fadeIn_0.3s_ease-out_0.4s_both]">
                Dismiss
            </button>
        </div>
    </div>

    {{-- DELETE CONFIRMATION MODAL --}}
    <div id="delete-confirmation-modal" onclick="closeDeleteConfirmation(event)"
        class="hidden fixed inset-0 z-[99999] backdrop-blur-md bg-black/70 flex items-center justify-center p-4">

        <div onclick="event.stopPropagation()"
            class="bg-[#0a0a0a] rounded-3xl p-8 flex flex-col gap-5 min-w-[340px] max-w-md shadow-[0_20px_50px_rgba(0,0,0,0.6)] 
               border border-red-500/30 scale-90 animate-[menuPopIn_0.3s_cubic-bezier(0.34,1.56,0.64,1)_forwards]">

            {{-- Warning Icon --}}
            <div class="flex justify-center">
                <div class="w-16 h-16 rounded-full bg-red-500/20 flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>

            {{-- Title --}}
            <div class="text-center">
                <h3 class="text-white text-xl font-extrabold mb-2">Delete Category</h3>
                <p id="delete-confirmation-message" class="text-gray-400 text-sm">
                    Are you sure you want to delete this category?
                </p>
                <p class="text-gray-500 text-xs mt-2">This action cannot be undone.</p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col gap-3 mt-2">
                <form id="delete-form" action="{{ url('/categories') }}" method="POST" class="block"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @method('DELETE')

                    {{-- Hidden input for category_id --}}
                    <input type="hidden" name="category_id" id="CategoryId">

                    <button type="submit"
                        class="group w-full py-3 px-8 rounded-2xl font-bold text-center transition-all duration-300 
                            text-sm flex items-center justify-center gap-3
                            bg-red-600 text-white 
                            hover:bg-red-700 
                            animate-[slideInLeft_0.3s_ease-out_0.1s_both]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>

                <button onclick="closeDeleteConfirmation()"
                    class="w-full py-3 px-8 rounded-2xl font-bold text-center transition-all duration-300 
                        text-sm flex items-center justify-center gap-3
                        bg-[#1e1e1e] text-gray-300 border border-white/10
                        hover:bg-[#2a2a2a] hover:text-white hover:border-white/20
                        animate-[slideInLeft_0.3s_ease-out_0.2s_both]">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <style>
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

        @keyframes glowPulse {

            0%,
            100% {
                text-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            }

            50% {
                text-shadow: 0 0 30px rgba(59, 130, 246, 0.7);
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

        @keyframes iconPulse {

            0%,
            100% {
                transform: scale(1.1) rotate(5deg);
            }

            50% {
                transform: scale(1.2) rotate(8deg);
            }
        }
    </style>

    <script>
        function triggerActionMenu(categoryId, categoryName, colorName) {
            const content = document.getElementById('main-page-content');
            const menu = document.getElementById('action-menu');

            // Update category name display
            document.getElementById('selected-category-name').textContent = categoryName;

            // Update links with the category ID
            document.getElementById('view-link').href = `/categories/${categoryId}`;
            document.getElementById('update-link').href = `/categories/${categoryId}/edit`;

            // Update delete form action
            const deleteForm = document.getElementById('delete-form');
            deleteForm.action = `/categories/${categoryId}`;

            // Apply blur and show menu
            content.classList.add('is-blurred');
            menu.style.display = 'flex';
        }

        function closeActionMenu() {
            const content = document.getElementById('main-page-content');
            const menu = document.getElementById('action-menu');

            content.classList.remove('is-blurred');
            menu.style.display = 'none';
        }

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") {
                closeActionMenu();
            }
        });

        // Prevent scrolling when menu is open
        document.getElementById('action-menu').addEventListener('wheel', (e) => {
            e.preventDefault();
        }, {
            passive: false
        });

        // Delete Confirmation Modal Functions
        function showDeleteConfirmation() {
            const modal = document.getElementById('delete-confirmation-modal');
            const actionMenu = document.getElementById('action-menu');
            const categoryName = document.getElementById('selected-category-name').textContent;
            const messageEl = document.getElementById('delete-confirmation-message');

            // Update the message with the category name
            messageEl.textContent = `Are you sure you want to delete "${categoryName}"?`;

            // Hide action menu and show confirmation modal
            actionMenu.style.display = 'none';
            modal.style.display = 'flex';
        }

        function closeDeleteConfirmation(event) {
            const modal = document.getElementById('delete-confirmation-modal');
            const actionMenu = document.getElementById('action-menu');

            // Only close if clicking outside the modal content or on cancel button
            if (!event || event.target === modal || event.target.tagName === 'DIV') {
                modal.style.display = 'none';
                actionMenu.style.display = 'flex';
            }
        }

        // Close delete modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") {
                const modal = document.getElementById('delete-confirmation-modal');
                if (modal.style.display === 'flex') {
                    closeDeleteConfirmation();
                }
            }
        });
    </script>
@endsection
