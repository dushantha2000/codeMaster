@extends('auth.master')

@section('title', 'My Snippets')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4 py-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div class="flex items-center gap-5">
                <a href="{{ url('/dashboard') }}"
                    class="group p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 text-gray-400 hover:text-white transition-all shadow-xl">
                    <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tight">My Vault</h1>
                    <p class="text-gray-400 text-sm font-medium">Managing <span
                            class="text-blue-400">{{ $snippets->total() }}</span> saved snippets</p>
                </div>
            </div>

            <!-- Search and Actions -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative group">
                    <input type="text" placeholder="Search snippets..."
                        class="bg-white/5 border border-white/10 text-white text-sm rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all w-64">
                    <svg class="w-4 h-4 text-gray-500 absolute left-3.5 top-1/2 -translate-y-1/2 group-focus-within:text-blue-400 transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <a href="{{ route('snippets-create') }}"
                    class="inline-flex items-center gap-2 bg-white/5 border border-white/10 text-white  text-sm  px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg ">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    Create Snippet
                </a>
            </div>
        </div>

        @if ($snippets->count() > 0)
            <div
                class="glass-card rounded-[2rem] border border-white/10 overflow-hidden shadow-2xl bg-white/[0.02] backdrop-blur-md">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 bg-white/5">
                                <th class="px-6 py-5 text-[10px] uppercase tracking-[0.2em] font-black text-gray-500">
                                    Language</th>
                                <th class="px-6 py-5 text-[10px] uppercase tracking-[0.2em] font-black text-gray-500">
                                    Snippet Title</th>
                                <th class="px-6 py-5 text-[10px] uppercase tracking-[0.2em] font-black text-gray-500">Files
                                </th>
                                <th class="px-6 py-5 text-[10px] uppercase tracking-[0.2em] font-black text-gray-500">
                                    Created</th>
                                <th
                                    class="px-6 py-5 text-[10px] uppercase tracking-[0.2em] font-black text-gray-500 text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach ($snippets as $snippet)
                                <tr class="group hover:bg-white/[0.03] transition-colors">
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2.5 py-1 bg-blue-500/10 text-blue-400 text-[10px] uppercase tracking-widest font-black rounded-lg border border-blue-500/20">
                                            {{ $snippet->language ?? 'Text' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-white font-bold group-hover:text-blue-400 transition-colors">{{ $snippet->title }}</span>
                                            <span
                                                class="text-gray-500 text-xs line-clamp-1 truncate max-w-xs">{{ $snippet->description }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            {{ $snippet->files->count() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-gray-500 text-xs font-medium">{{ $snippet->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ url('snippets/' . $snippet->id . '/edit') }}"
                                                class="p-2 bg-white/5 hover:bg-yellow-500/20 hover:text-yellow-400 rounded-lg border border-white/5 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <button
                                                onclick="deleteSnippet({{ $snippet->id }}, '{{ addslashes($snippet->title) }}')"
                                                class="p-2 bg-white/5 hover:bg-red-500/20 hover:text-red-400 rounded-lg border border-white/5 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                {{ $snippets->links('pagination::tailwind') }}
            </div>
        @else
            <div class=" rounded-3xl p-20 text-center border-dashed border-white/10 shadow-inner">
                <div
                    class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/10 animate-pulse">
                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-white mb-3 tracking-tight">The Vault is Silent</h3>
                <p class="text-gray-500 mb-10 max-w-sm mx-auto leading-relaxed">No code fragments detected in your
                    collection. Start your legacy by adding your first snippet.</p>
                 <a href="{{ url('snippets-create') }}"
                    class="inline-flex items-center gap-2 bg-white/5 border border-white/10 text-white  text-sm  px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg ">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    Create Snippet
                </a>
            </div>
        @endif
    </div>

    <div id="deleteModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 transition-all duration-300 opacity-0">
        <div class="glass-card rounded-[2.5rem] p-10 max-w-sm w-full border border-white/10 shadow-2xl transform transition-all scale-90"
            id="modalContainer">
            <div
                class="w-20 h-20 bg-red-500/10 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-red-500/20">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-white text-center mb-3 tracking-tight">Erase Snippet?</h3>
            <p class="text-gray-400 text-center text-sm mb-10 leading-relaxed" id="deleteMessage">
                This operation will permanently delete the code from your vault.
            </p>

            <div class="flex flex-col gap-3">
                <button id="confirmDelete"
                    class="w-full bg-red-600 hover:bg-red-500 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-red-900/40">
                    Yes, Delete Permanently
                </button>
                <button onclick="closeDeleteModal()"
                    class="w-full py-4 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white rounded-2xl font-bold transition-colors">
                    Keep Snippet
                </button>
            </div>
        </div>
    </div>

    

    <script>
        let snippetToDelete = null;

        function deleteSnippet(id, title) {
            snippetToDelete = id;
            document.getElementById('deleteMessage').innerHTML =
                `Are you sure you want to delete "<strong>${title}</strong>"? This action cannot be undone.`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
            setTimeout(() => {
                document.getElementById('deleteModal').classList.remove('opacity-0');
                document.getElementById('modalContainer').classList.remove('scale-90');
            }, 10);
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('opacity-0');
            document.getElementById('modalContainer').classList.add('scale-90');
            setTimeout(() => {
                document.getElementById('deleteModal').classList.add('hidden');
                document.getElementById('deleteModal').classList.remove('flex');
            }, 300);
        }

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (snippetToDelete) {
                fetch(`/snippets/${snippetToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            // Show success message or reload page
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the snippet.');
                    });
            }
        });

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
