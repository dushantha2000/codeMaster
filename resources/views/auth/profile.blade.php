@extends('layout.app')

@section('title', 'My Profile')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4">

        {{-- Breadcrumb --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </a>
                </li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ url('/mysnippets') }}" class="text-gray-500 hover:text-gray-700 transition font-medium">Vault</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><span class="text-gray-500 font-medium">Profile</span></li>
                <li><span class="text-gray-400">/</span></li>
                <li><span class="text-blue-400 font-medium">Partnerships</span></li>
            </ol>
        </nav>

        {{-- Header Section --}}
        <div class="mb-12">
            <h1 class="text-4xl font-black text-white tracking-tight mb-2">Vault Partnerships</h1>
            <p class="text-gray-400 text-sm font-medium">Manage cross-vault access and collaborate with verified security partners.</p>
        </div>

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pb-12">
            
            {{-- Sidebar: Profile Card --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="sticky top-20 space-y-6">
                    <div class="glass-card rounded-3xl p-8 border border-white/10 shadow-2xl relative overflow-hidden text-center group">
                        
                        {{-- Profile Image Section --}}
                        <div class="relative inline-block mb-6">
                            <div class="w-32 h-32 rounded-3xl bg-blue-500/5 border border-blue-500/20 flex items-center justify-center mx-auto shadow-lg overflow-hidden transition-transform duration-500 group-hover:scale-[1.05]">
                                @if (Auth::user()->profile_image)
                                    <img src="{{ asset('profileImages/' . Auth::user()->profile_image) }}"
                                        alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-5xl font-black text-blue-500 opacity-40">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-blue-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl border-4 border-[#09090b] shadow-2xl tracking-widest uppercase">
                                Vault 1
                            </div>
                        </div>

                        {{-- Name & Email --}}
                        <h2 class="text-2xl font-black text-white tracking-tight mb-1">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-500 text-xs font-bold mb-6">{{ Auth::user()->email }}</p>

                        {{-- Profile Bio --}}
                        <div class="mb-6">
                            @if (Auth::user()->bio)
                                <p class="text-gray-400 text-sm leading-relaxed px-4 font-medium italic">
                                    "{{ Auth::user()->bio }}"
                                </p>
                            @else
                                <p class="text-gray-500 text-xs font-medium italic">No vault signature added.</p>
                            @endif
                        </div>

                        {{-- Action Button --}}
                        <div class="mt-6 pt-6 border-t border-white/5">
                            <a href="{{ url('/settings') }}" class="btn-primary w-full text-sm font-bold py-2 rounded-xl block transition">
                                Vault Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Section --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- Vault Partnerships Card --}}
                <div class=" rounded-3xl p-8 border border-white/10 relative z-20">
                    <h3 class="text-xl font-black text-white mb-6 flex items-center gap-3 tracking-tight">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Cross-Vault Access
                    </h3>

                    <form action="{{ url('/user/partnerships') }}" method="POST" class="space-y-6">
                        {{ csrf_field() }}

                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-400 tracking-widest  mb-3 ml-1">Search Verified Partners</label>

                            <div class="flex flex-col md:flex-row items-center gap-4">
                                <div class="relative group w-full">
                                    <input type="text" id="user-search" placeholder="Type partner name..."
                                        class="bg-[#050505] border border-white/5 text-white text-sm rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/50 transition-all w-full shadow-inner placeholder-gray-500">

                                    <svg class="w-4 h-4 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-blue-400 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>

                                    {{-- Suggestions --}}
                                    <div id="suggestions" class="absolute left-0 right-0 z-[1000] mt-2 bg-[#0A0A0A] border border-white/10 rounded-xl shadow-2xl hidden max-h-64 overflow-y-auto divide-y divide-white/5 backdrop-blur-xl"></div>
                                </div>

                                <button type="submit" class="btn-primary inline-flex items-center justify-center gap-2 text-sm py-2 px-8 rounded-xl font-bold whitespace-nowrap shadow-lg">
                                    Execute Access
                                </button>
                            </div>

                            {{-- Selected Users Tags --}}
                            <div id="selected-users" class="flex flex-wrap gap-2 mt-4"></div>

                            {{-- Hidden Inputs --}}
                            <div id="hidden-inputs"></div>
                        </div>
                    </form>

                    {{-- Partners List Section --}}
                    <div class="mt-10 pt-8 border-t border-white/5">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xs font-bold text-gray-400 tracking-widest  ml-1">
                                Active Vault Collaborators
                            </h3>
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                {{ count($partners) }} Entities
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($partners as $partner)
                                <div class="group relative flex items-center justify-between p-4 rounded-xl glass-card border-white/5 hover:border-blue-500/30 transition-all duration-300 shadow-sm">
                                    <div class="flex items-center min-w-0">
                                        <div class="relative flex-shrink-0">
                                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-blue-500/10 flex items-center justify-center text-blue-400 font-black text-xl border border-blue-500/20">
                                                @if ($partner->profile_image)
                                                    <img src="{{ asset('profileImages/' . $partner->profile_image) }}"
                                                        alt="{{ $partner->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span>{{ strtoupper(substr($partner->name, 0, 1)) }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ml-4 overflow-hidden">
                                            <h4 class="text-sm font-bold text-white truncate">{{ $partner->name }}</h4>
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mt-0.5 block">
                                                {{ $partner->is_edit ? 'Editor Access' : 'Vault Reader' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button"
                                            class="edit-partner-btn p-2 text-gray-400 hover:text-blue-400 transition-colors"
                                            data-partner-name="{{ $partner->name }}" data-id="{{ $partner->id }}"
                                            data-is_read="{{ $partner->is_read }}"
                                            data-is_edit="{{ $partner->is_edit }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296-.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ url('/partners/destroy', $partner->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full flex flex-col items-center justify-center py-10 text-center">
                                    <div class="w-16 h-16 bg-blue-500/5 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-blue-500/10">
                                        <svg class="w-8 h-8 text-blue-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">No Active Collaborators</p>
                                    <p class="text-xs text-gray-400 mt-2 font-medium">Search and grant access above.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Partner Modal --}}
        <div id="modalOverlay" class="hidden fixed inset-0 z-[99999] bg-black/80 flex items-center justify-center p-4">
            <div onclick="event.stopPropagation()" class="relative w-full max-w-lg glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-[menuPopIn_0.4s_cubic-bezier(0.34,1.56,0.64,1)]">
                
                <button id="closeModal" class="absolute top-5 right-5 z-50 text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="p-8">
                    <h3 class="text-2xl font-black text-white tracking-tight mb-6">Permissions</h3>
                    
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-16 h-16 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 font-black text-2xl shadow-sm">
                            <span id="modalPartnerInitials">?</span>
                        </div>
                        <div>
                            <h4 id="modalPartnerNameDisplay" class="text-white font-black text-lg tracking-tight">Partner Entity</h4>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mt-1">Security Group</p>
                        </div>
                    </div>

                    <form action="{{ url('/partners/update') }}" method="POST" class="space-y-6">
                        {{ csrf_field() }}
                        <input type="hidden" id="modalPartnerId" name="partner_id">
                        <input type="hidden" id="modalisRead" name="is_read">
                        <input type="hidden" id="modalisEdit" name="is_edit">

                        <div class="space-y-3">
                            <label class="flex items-center justify-between cursor-pointer group p-4 rounded-xl bg-[#050505] border border-white/5 hover:border-blue-500/30 transition-all">
                                <div>
                                    <span class="block text-sm font-bold text-white tracking-tight">Read Only Access</span>
                                    <span class="block text-xs text-gray-500 font-medium mt-1">Can view and retrieve vault snippets.</span>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" id="readOnlyToggle" class="sr-only peer">
                                    <div class="w-11 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </div>
                            </label>

                            <label class="flex items-center justify-between cursor-pointer group p-4 rounded-xl bg-[#050505] border border-white/5 hover:border-blue-500/30 transition-all">
                                <div>
                                    <span class="block text-sm font-bold text-white tracking-tight">Editor Access</span>
                                    <span class="block text-xs text-gray-500 font-medium mt-1">Can modify, create, and commit logic changes.</span>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" id="editorToggle" class="sr-only peer">
                                    <div class="w-11 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </div>
                            </label>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="btn-primary w-full py-4 rounded-xl font-bold text-sm transition">
                                Update Permissions
                            </button>
                        </div>
                    </form>
                </div>
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
                                    div.className = 'px-4 py-3 hover:bg-white/10 cursor-pointer text-sm text-gray-200 border-b border-white/5 last:border-0 transition-colors';
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
                tag.className = 'flex items-center gap-2 bg-blue-500/10 border border-blue-500/20 text-blue-400 px-3 py-1.5 rounded-lg text-xs font-bold animate-[menuPopIn_0.2s_ease-out]';
                tag.innerHTML = `${name} <button type="button" class="remove-btn hover:text-white transition-colors ml-1 font-black">&times;</button>`;

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
