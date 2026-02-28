@extends('layout.app')

@section('title', 'My Profile')

@section('content')
<div class="w-full max-w-6xl mx-auto px-4  animate-in fade-in slide-in-from-bottom-4 duration-500">

     <!-- Breadcrumb -->
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
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">Profile</a>
            </li>
            <li>
                <span class="text-gray-400">|</span>
            </li>
            <li>
                <span class="text-blue-400 font-medium">Partnerships</span>
            </li>
        </ol>
    </nav>
    {{-- Header Section --}}
     <div class="items-center gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-black text-white tracking-tight">Vault Partnerships</h1>
                <p class="text-gray-400 text-sm font-medium">Manage who can access your code snippets and collaborate with your partners.  <span class="text-blue-400">Secure Vault</span></p>
            </div>
        </div>
   

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Sidebar: Profile Card --}}
        <div class="lg:col-span-4 space-y-6">
            <div
                class="glass-card bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-indigo-600"></div>

                <div class="relative inline-block">
                    <div
                        class="w-24 h-24 rounded-3xl bg-blue-600/20 border-2 border-blue-500/50 flex items-center justify-center mx-auto mb-4 shadow-2xl shadow-blue-500/20">
                        <span class="text-4xl font-bold text-blue-500">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </div>

                <h2 class="text-xl font-bold text-white">{{ Auth::user()->name }}</h2>
                <p class="text-gray-500 text-sm mb-6">{{ Auth::user()->email }}</p>

                <div class="pt-6 border-t border-white/5 space-y-3">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500 uppercase tracking-widest font-bold">Member Since</span>
                        <span class="text-gray-300">{{ Auth::user()->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Section --}}
        <div class="lg:col-span-8 space-y-6">
            {{-- Vault Partnerships Card --}}
            <div class="glass-card bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 relative z-20">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Vault Partnerships
                </h3>

                <form action="{{ url('/user/partnerships') }}" method="POST" class="space-y-4">
                    {{ csrf_field() }}
                    <div class="grid grid-cols-1 gap-4">
                        <div class="relative">
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Search User</label>
                            <input type="text" id="user-search" placeholder="Type name..."
                                class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all"
                                autocomplete="off">

                            <div id="suggestions"
                                class="absolute left-0 right-0 z-[1000] mt-2 bg-slate-900 border border-white/20 rounded-2xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.8)] hidden max-h-56 overflow-y-auto divide-y divide-white/5 backdrop-blur-2xl">
                            </div>
                        </div>

                        {{-- Selected Users Tags --}}
                        <div id="selected-users" class="flex flex-wrap gap-2 mt-2"></div>

                        {{-- Hidden Inputs --}}
                        <div id="hidden-inputs"></div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit"
                            class="btn-primary inline-flex items-center gap-2 text-gray-300 text-sm px-6 py-3 rounded-xl font-semibold shadow-xl hover:text-white group">
                            <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-hover:scale-110 group-hover:text-white"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>

                <div class="partners-section mt-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider ml-1">
                            People who can access my snippets
                        </h3>
                        <span
                            class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            {{ count($partners) }} Partners
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @forelse($partners as $partner)
                            <div
                                class="group relative flex items-center justify-between p-3 rounded-2xl bg-white/5 border border-white/10 hover:border-blue-500/30 hover:bg-white/10 transition-all duration-300 shadow-sm">
                                <div class="flex items-center min-w-0">
                                    <div class="relative flex-shrink-0">
                                        <div
                                            class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            {{ strtoupper(substr($partner->name, 0, 1)) }}
                                        </div>
                                    </div>

                                    <div class="ml-4 overflow-hidden">
                                        <h4
                                            class="text-sm font-semibold text-gray-200 group-hover:text-white transition-colors truncate">
                                            {{ $partner->name }}
                                        </h4>
                                        <p
                                            class="text-[11px] text-blue-400/80 font-medium truncate">
                                            {{ $partner->email }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-1">
                                    <form action="{{ url('/partners/destroy', $partner->id) }}" method="POST"
                                        class="flex-shrink-0">
                                        {{ csrf_field() }}
                                        <button type="submit"
                                            class="p-2 text-gray-500 hover:text-red-500 transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>

                                    <button type="button"
                                        class="edit-partner-btn p-2 text-gray-500 hover:text-blue-500 transition-all duration-300"
                                        data-partner-name="{{ $partner->name }}" data-id="{{ $partner->id }}"
                                        data-is_read="{{ $partner->is_read }}" data-is_edit="{{ $partner->is_edit }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-lg font-medium mb-1">No partners found</p>
                                <p class="text-sm">Start adding partners using the search above</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit modal --}}
    <div id="modalOverlay"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 hidden animate-in fade-in duration-300">
        <div
            class="modal-mobile bg-[#0f1115] rounded-2xl p-6 md:p-8 w-full max-w-lg shadow-2xl border border-white/10 relative">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl md:text-2xl font-bold flex items-center gap-3 text-white">
                    <span>Partner Permissions</span>
                </h3>
                <button id="closeModal"
                    class="text-gray-500 hover:text-white transition-colors text-2xl">&times;</button>
            </div>

            <p class="text-sm text-gray-400 mb-8 -mt-2">Update permissions and access levels for this collaborator.</p>

            <div class="mb-8 flex items-center gap-4 bg-white/5 p-4 rounded-xl border border-white/5">
                <div
                    class="w-12 h-12 rounded-lg bg-blue-600/10 border border-blue-500/20 flex items-center justify-center text-blue-500 font-bold text-xl">
                    <span id="modalPartnerInitials">?</span>
                </div>
                <h4 id="modalPartnerNameDisplay" class="text-white font-medium text-lg">Partner Name</h4>
            </div>

            <form action="{{ url('/partners/update') }}" method="POST" class="space-y-6">
                {{ csrf_field() }}
                <input type="hidden" id="modalPartnerId" name="partner_id">
                <input type="hidden" id="modalisRead" name="is_read">
                <input type="hidden" id="modalisEdit" name="is_edit">

                <div class="space-y-4">
                    <label
                        class="flex items-center justify-between cursor-pointer group p-3 rounded-xl hover:bg-white/5 transition-all border border-transparent hover:border-white/10">
                        <div>
                            <span class="block text-sm font-bold text-gray-200 group-hover:text-white transition-colors">Read Only Access</span>
                            <span class="block text-[11px] text-gray-500 font-medium">Can view and copy code snippets.</span>
                        </div>
                        <div class="relative">
                            <input type="checkbox" id="readOnlyToggle" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-500 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </div>
                    </label>

                    <label
                        class="flex items-center justify-between cursor-pointer group p-3 rounded-xl hover:bg-white/5 transition-all border border-transparent hover:border-white/10">
                        <div>
                            <span class="block text-sm font-bold text-gray-200 group-hover:text-white transition-colors">Editor Access</span>
                            <span class="block text-[11px] text-gray-500 font-medium">Can modify and create new code.</span>
                        </div>
                        <div class="relative">
                            <input type="checkbox" id="editorToggle" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-400 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </div>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-[#1c1f26] hover:bg-[#252a33] border border-white/10 text-white px-6 py-3.5 rounded-xl text-base font-bold transition-all shadow-xl active:scale-[0.98]">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userSearch = document.getElementById('user-search');
        const suggestions = document.getElementById('suggestions');
        const selectedUsersContainer = document.getElementById('selected-users');
        const hiddenInputsContainer = document.getElementById('hidden-inputs');

        userSearch.addEventListener('input', function() {
            let query = this.value;

            if (query.length > 1) {
                fetch("{{ route('users.search') }}?term=" + encodeURIComponent(query))
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        suggestions.innerHTML = '';
                        if (data.length > 0) {
                            suggestions.classList.remove('hidden');
                            data.forEach(user => {
                                let div = document.createElement('div');
                                div.className =
                                    'px-4 py-3 hover:bg-white/10 cursor-pointer text-sm text-gray-200 border-b border-white/5 last:border-0 transition-colors';
                                div.textContent = user.name;
                                div.onclick = function() {
                                    addUser(user.id, user.name);
                                };
                                suggestions.appendChild(div);
                            });
                        } else {
                            suggestions.classList.add('hidden');
                        }
                    })
                    .catch(error => console.error('Error fetching users:', error));
            } else {
                suggestions.classList.add('hidden');
            }
        });

        // Click outside to hide suggestions
        document.addEventListener('click', function(e) {
            if (!userSearch.contains(e.target) && !suggestions.contains(e.target)) {
                suggestions.classList.add('hidden');
            }
        });

        function addUser(id, name) {
            if (document.getElementById(`user-input-${id}`)) {
                userSearch.value = '';
                suggestions.classList.add('hidden');
                return;
            }

            const tag = document.createElement('div');
            tag.className =
                'flex items-center gap-2 bg-blue-500/20 border border-blue-500/30 text-blue-400 px-3 py-1.5 rounded-full text-xs font-bold animate-in fade-in zoom-in duration-200';
            tag.innerHTML =
                `${name} <button type="button" class="remove-btn hover:text-white transition-colors ml-1">×</button>`;

            tag.querySelector('.remove-btn').onclick = function() {
                tag.remove();
                document.getElementById(`user-input-${id}`).remove();
            };

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'shared_user_ids[]';
            hiddenInput.value = id;
            hiddenInput.id = `user-input-${id}`;

            selectedUsersContainer.appendChild(tag);
            hiddenInputsContainer.appendChild(hiddenInput);

            userSearch.value = '';
            suggestions.classList.add('hidden');
        }
    });

    document.addEventListener('click', function(e) {
        const modal = document.getElementById('modalOverlay');
        const editBtn = e.target.closest('.edit-partner-btn');

        if (editBtn) {
            const id = editBtn.getAttribute('data-id');
            const name = editBtn.getAttribute('data-partner-name');
            const isRead = editBtn.getAttribute('data-is_read');
            const isEdit = editBtn.getAttribute('data-is_edit');

            document.getElementById('modalPartnerId').value = id;
            document.getElementById('modalPartnerNameDisplay').textContent = name;
            document.getElementById('modalPartnerInitials').textContent = name.charAt(0).toUpperCase();

            document.getElementById('modalisRead').value = isRead;
            document.getElementById('modalisEdit').value = isEdit;

            const readToggle = document.getElementById('readOnlyToggle');
            const editToggle = document.getElementById('editorToggle');

            readToggle.checked = (isRead == "1");
            editToggle.checked = (isEdit == "1");

            modal.classList.remove('hidden');
        }

        if (e.target.id === 'closeModal' || e.target === modal) {
            modal.classList.add('hidden');
        }
    });

    document.getElementById('readOnlyToggle').addEventListener('change', function() {
        document.getElementById('modalisRead').value = this.checked ? "1" : "0";
    });

    document.getElementById('editorToggle').addEventListener('change', function() {
        document.getElementById('modalisEdit').value = this.checked ? "1" : "0";
    });
</script>
@endsection