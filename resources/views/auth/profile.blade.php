@extends('layout.app')

@section('title', 'My Profile')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4  animate-in fade-in slide-in-from-bottom-4 duration-500">

        <!-- Breadcrumb -->
        <nav class="flex mb-10" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-2xs font-black uppercase tracking-[0.2em] nocaps">
                <li>
                    <a href="{{ url('/') }}" class="text-[#71717A] hover:text-[#EDEDED] transition-colors">vault</a>
                </li>
                <li class="text-[#3F3F46]">/</li>
                <li>
                    <a href="{{ url('/') }}" class="text-[#71717A] hover:text-[#EDEDED] transition-colors">profile</a>
                </li>
                <li class="text-[#3F3F46]">/</li>
                <li class="text-purple-500">partnerships</li>
            </ol>
        </nav>
        {{-- Header Section --}}
        <div class="items-center gap-4 mb-16">
            <div class="relative">
                <div class="absolute -left-8 top-0 w-1 h-12 bg-gradient-to-b from-purple-500 to-purple-500/0 rounded-full blur-sm animate-pulse"></div>
                <h1 class="text-6xl font-black text-[#EDEDED] tracking-tighter mb-4 nocaps">vault <span class="text-purple-500">partnerships</span></h1>
                <p class="text-[#3F3F46] text-2xs font-black uppercase tracking-[0.2em] nocaps">manage cross-vault access and collaborate with verified security partners.</p>
            </div>
        </div>


        {{-- Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Sidebar: Profile Card --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="sticky top-8 space-y-6">
                    <div
                        class="glass-card backdrop-blur-3xl rounded-[2.5rem] p-8 border border-white/5 text-center relative overflow-hidden shadow-2xl">

                        {{-- Decorative Background Glow --}}
                        <div class="absolute -top-24 -left-24 w-48 h-48 bg-purple-500/5 blur-3xl rounded-full"></div>

                        {{-- Profile Image Section --}}
                        <div class="relative inline-block mb-8">
                            <div
                                class="w-32 h-32 rounded-[2.5rem] bg-purple-600/5 border border-purple-500/10 flex items-center justify-center mx-auto shadow-2xl shadow-purple-500/5 overflow-hidden group">
                                @if (Auth::user()->profile_image)
                                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                        src="{{ asset('profileImages/' . Auth::user()->profile_image) }}"
                                        alt="{{ Auth::user()->name }}">
                                @else
                                    <span
                                        class="text-5xl font-black text-purple-500 opacity-40">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            {{-- Level Badge --}}
                            <div
                                class="absolute -bottom-2 -right-2 bg-purple-500 text-white text-3xs font-black px-3 py-1.5 rounded-xl border-4 border-[#030303] shadow-2xl uppercase tracking-widest nocaps">
                                vault 1
                            </div>
                        </div>

                        {{-- Name & Email --}}
                        <h2 class="text-3xl font-black text-[#EDEDED] tracking-tighter mb-1 nocaps">{{ Auth::user()->name }}</h2>
                        <p class="text-3xs font-black uppercase tracking-[0.2em] text-[#3F3F46] mb-6 nocaps">{{ Auth::user()->email }}</p>

                        {{-- Profile Bio --}}
                        <div class="mb-8">
                            @if (Auth::user()->bio)
                                <p class="text-[#A1A1AA] text-xs leading-relaxed px-4 font-medium italic">
                                    "{{ Auth::user()->bio }}"
                                </p>
                            @else
                                <p class="text-[#3F3F46] text-xs font-medium italic">No vault signature added.</p>
                            @endif
                        </div>

                        {{-- Stats Section --}}
                        <div class="pt-6 border-t border-white/5 space-y-4">
                            <div class="flex justify-between items-center text-2xs">
                                <span class="text-[#71717A] uppercase tracking-[0.2em] font-black nocaps">archive density</span>
                                <span class="text-purple-400 font-black" id="sidebarCount"></span>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        <div class="mt-8">
                            <a href="{{ url('/settings') }}"
                                class="btn-primary w-full text-xs py-3.5 rounded-xl font-black uppercase tracking-widest block nocaps">
                                vault settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Form Section --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- Vault Partnerships Card --}}
                <div class="glass-card rounded-[2.5rem] p-10 border border-white/5 relative z-20">
                    <h3 class="text-xl font-black text-[#EDEDED] mb-8 flex items-center gap-3 tracking-tighter">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center border border-purple-500/20">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Cross-Vault Access
                    </h3>

                    <form action="{{ url('/user/partnerships') }}" method="POST" class="space-y-6"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="relative">
                            <label class="block text-3xs font-black text-[#3F3F46] uppercase tracking-[0.2em] mb-4 ml-1 nocaps">search verified partners</label>

                            <div class="flex flex-col md:flex-row items-center gap-4">
                                <div class="relative group w-full">
                                    <input type="text" id="user-search" placeholder="type partner name..."
                                        class="bg-[#050505] border border-white/5 text-[#EDEDED] text-sm rounded-2xl pl-12 pr-4 py-4 focus:outline-none focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/10 transition-all w-full shadow-inner placeholder-[#3F3F46] nocaps">

                                    <svg class="w-4 h-4 text-[#3F3F46] absolute left-5 top-1/2 -translate-y-1/2 group-focus-within:text-purple-400 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>

                                    <div id="suggestions"
                                        class="absolute left-0 right-0 z-[1000] mt-3 bg-[#050505] border border-white/5 rounded-2xl shadow-2xl hidden max-h-64 overflow-y-auto divide-y divide-white/5 backdrop-blur-3xl overflow-hidden">
                                    </div>
                                </div>

                                <button type="submit"
                                    class="btn-primary inline-flex items-center gap-2 text-2xs py-4 px-10 rounded-2xl font-black uppercase tracking-[0.2em] whitespace-nowrap h-[58px] shadow-2xl shadow-purple-900/20 nocaps">
                                    execute access
                                </button>
                            </div>

                            {{-- Selected Users Tags --}}
                            <div id="selected-users" class="flex flex-wrap gap-2 mt-4 nocaps"></div>

                            {{-- Hidden Inputs --}}
                            <div id="hidden-inputs"></div>
                        </div>
                    </form>

                    {{-- Partners List Section --}}
                    <div class="partners-section mt-12 pt-10 border-t border-white/5">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xs font-black text-[#71717A] uppercase tracking-[0.2em] ml-1 nocaps">
                                active vault collaborators
                            </h3>
                            <span
                                class="px-3 py-1 rounded-full text-3xs font-black uppercase tracking-widest bg-purple-500/10 text-purple-400 border border-purple-500/20 nocaps">
                                {{ count($partners) }} entities
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($partners as $partner)
                                <div
                                    class="group relative flex items-center justify-between p-5 rounded-2xl bg-[#030303]/40 border border-white/5 hover:border-purple-500/30 hover:bg-purple-500/[0.02] transition-all duration-300 shadow-xl shadow-black/40">
                                    <div class="flex items-center min-w-0">
                                        <div class="relative flex-shrink-0">
                                            <div
                                                class="w-14 h-14 rounded-xl overflow-hidden bg-gradient-to-br from-purple-600/20 to-[#030303] flex items-center justify-center text-white font-black text-xl shadow-2xl group-hover:scale-105 transition-transform duration-500 border border-white/5">
                                                @if ($partner->profile_image)
                                                    <img src="{{ asset('profileImages/' . $partner->profile_image) }}"
                                                        alt="{{ $partner->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="opacity-40">{{ strtoupper(substr($partner->name, 0, 1)) }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ml-4 overflow-hidden">
                                            <h4 class="text-sm font-black text-[#EDEDED] transition-colors truncate">
                                                {{ $partner->name }}
                                            </h4>
                                            <div class="flex items-center gap-2">
                                                <span class="text-3xs font-black uppercase tracking-widest text-[#71717A] group-hover:text-purple-400 transition-colors nocaps">
                                                    {{ $partner->is_edit ? 'editor access' : 'vault reader' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1 opacity-40 group-hover:opacity-100 transition-opacity">
                                        <button type="button"
                                            class="edit-partner-btn p-2 text-[#71717A] hover:text-purple-400 transition-all duration-300"
                                            data-partner-name="{{ $partner->name }}" data-id="{{ $partner->id }}"
                                            data-is_read="{{ $partner->is_read }}"
                                            data-is_edit="{{ $partner->is_edit }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296-.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ url('/partners/destroy', $partner->id) }}" method="POST"
                                            class="flex-shrink-0">
                                            {{ csrf_field() }}
                                            <button type="submit"
                                                class="p-2 text-[#71717A] hover:text-red-500 transition-all duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 flex flex-col items-center justify-center py-16 text-center">
                                    <div class="w-20 h-20 bg-purple-500/5 rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-purple-500/10 shadow-2xl">
                                        <svg class="w-9 h-9 text-purple-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-3xs font-black uppercase tracking-[0.3em] text-[#3F3F46] nocaps">no active collaborators</p>
                                    <p class="text-2xs text-[#3F3F46] mt-2 font-medium nocaps">search &amp; grant vault access above.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        {{-- Edit modal --}}
        <div id="modalOverlay"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-xl p-6 hidden animate-in fade-in duration-300">
            <div
                class="glass-card rounded-[2.5rem] p-10 w-full max-w-xl shadow-2xl border border-white/5 relative">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-3xl font-black text-[#EDEDED] flex items-center gap-3 tracking-tighter">
                        Permissions
                    </h3>
                    <button id="closeModal"
                        class="text-[#71717A] hover:text-white transition-colors text-3xl">&times;</button>
                </div>

                    <div
                        class="w-20 h-20 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 font-black text-3xl shadow-2xl mt-4">
                        <span id="modalPartnerInitials">?</span>
                    </div>
                    <div>
                        <h4 id="modalPartnerNameDisplay" class="text-[#EDEDED] font-black text-2xl tracking-tighter nocaps">partner entity</h4>
                        <p class="text-3xs font-black uppercase tracking-[0.2em] text-purple-500/60 mt-1 nocaps">security group: alpha-01</p>
                    </div>

                <form action="{{ url('/partners/update') }}" method="POST" class="space-y-6">
                    {{ csrf_field() }}
                    <input type="hidden" id="modalPartnerId" name="partner_id">
                    <input type="hidden" id="modalisRead" name="is_read">
                    <input type="hidden" id="modalisEdit" name="is_edit">

                    <div class="space-y-4">
                        <label
                            class="flex items-center justify-between cursor-pointer group p-5 rounded-2xl bg-[#0A0A0A] hover:bg-purple-500/[0.03] transition-all border border-white/5 hover:border-purple-500/30">
                            <div>
                                <span class="block text-sm font-black text-[#EDEDED] tracking-tight uppercase nocaps">read only access</span>
                                <span class="block text-2xs text-[#71717A] font-medium mt-1 nocaps">can view and retrieve vault snippets.</span>
                            </div>
                            <div class="relative">
                                <input type="checkbox" id="readOnlyToggle" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-white/5 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-purple-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-[#A1A1AA] after:rounded-full after:h-5 after:w-5 after:transition-all">
                                </div>
                            </div>
                        </label>

                        <label
                            class="flex items-center justify-between cursor-pointer group p-5 rounded-2xl bg-[#0A0A0A] hover:bg-purple-500/[0.03] transition-all border border-white/5 hover:border-purple-500/30">
                            <div>
                                <span class="block text-sm font-black text-[#EDEDED] tracking-tight uppercase">Editor Access</span>
                                <span class="block text-[11px] text-[#71717A] font-medium mt-1">Can modify, create, and commit logic changes.</span>
                            </div>
                            <div class="relative">
                                <input type="checkbox" id="editorToggle" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-white/5 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-purple-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-[#A1A1AA] after:rounded-full after:h-5 after:w-5 after:transition-all">
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="btn-primary w-full py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-purple-900/20 h-14 nocaps">
                            update permissions
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
                    'flex items-center gap-2 bg-purple-500/10 border border-purple-500/20 text-purple-400 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest animate-in fade-in zoom-in duration-300';
                tag.innerHTML =
                    `${name} <button type="button" class="remove-btn hover:text-white transition-colors ml-1 font-black">×</button>`;

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
