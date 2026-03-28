@extends('layout.app')

@section('title', 'System Settings')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4 space-y-8">
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
                <li class="text-purple-500">system settings</li>
            </ol>
        </nav>
        
        {{-- Header Section --}}
        <div class="items-center gap-4 mb-16">
            <div class="relative">
                <div class="absolute -left-8 top-0 w-1 h-12 bg-purple-500 rounded-full blur-sm"></div>
                <h1 class="text-6xl font-black text-[#EDEDED] tracking-tighter mb-4 nocaps">account <span class="text-purple-500">settings</span></h1>
                <p class="text-[#3F3F46] text-2xs font-bold tracking-normal nocaps">manage your profile, security, and notification preferences.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Profile Image Section --}}
                <div class="rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden glass-card border border-white/5">
                    <h3 class="text-3xs font-bold tracking-normal text-[#3F3F46] mb-10 ml-1 nocaps">profile photo</h3>
                    <div class="flex items-center gap-12">
                        <div class="relative group">
                            <div class="w-36 h-36 rounded-[2.5rem] bg-purple-600/5 border border-purple-500/10 flex items-center justify-center shadow-2xl shadow-purple-500/5 overflow-hidden">
                                @if(Auth::user()->profile_image)
                                    <img src="/profileImages/{{ Auth::user()->profile_image }}" 
                                         alt="{{ Auth::user()->name }}"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <span class="text-6xl font-black text-purple-500 opacity-40">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <button onclick="toggleModal('profileImageModal', true)"
                                class="absolute -bottom-2 -right-2 w-11 h-11 bg-purple-600 hover:bg-purple-500 rounded-2xl flex items-center justify-center shadow-2xl transition-all border-4 border-[#030303]"
                                aria-label="Change profile photo">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                        <div>
                            <p class="text-lg font-black text-[#EDEDED] mb-1 tracking-tight nocaps">update profile photo</p>
                            <p class="text-3xs font-bold tracking-normal text-[#3F3F46] nocaps">max size 2mb. 1:1 aspect ratio recommended.</p>
                            <button onclick="toggleModal('profileImageModal', true)"
                                class="mt-6 text-2xs font-bold tracking-normal text-purple-400 hover:text-purple-300 transition-colors flex items-center gap-3 nocaps"
                                aria-label="Change profile photo">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                change profile photo
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Profile Information --}}
                <div class="rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden glass-card border border-white/5">
                    <h3 class="text-3xs font-bold text-[#3F3F46] mb-10 tracking-normal ml-1 nocaps">profile information</h3>
                    <form action="{{ url('/setting-profile') }}" method="POST" class="space-y-6">
                        {{ csrf_field() }}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="name" class="block text-3xs font-bold text-[#3F3F46] mb-3 tracking-normal ml-1 nocaps">display name</label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                                    class="bg-[#050505] border border-white/5 w-full rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/50 transition-all shadow-inner nocaps">
                            </div>
                            <div>
                                <label for="email" class="block text-3xs font-bold text-[#3F3F46] mb-3 tracking-normal ml-1 nocaps">email address</label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" readonly
                                    class="bg-[#050505] border border-white/5 w-full rounded-2xl px-5 py-4 text-sm text-[#3F3F46] cursor-not-allowed shadow-inner font-bold tracking-normal nocaps">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="full_name" class="block text-2xs font-black text-[#71717A] mb-2 uppercase tracking-widest ml-1 nocaps">full name</label>
                                <input type="text" id="full_name" name="full_name" value="{{ Auth::user()->full_name ?? Auth::user()->name }}"
                                    class="bg-[#0A0A0A] border border-white/5 w-full rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/50 transition-all shadow-inner nocaps">
                            </div>
                            <div>
                                <label for="username" class="block text-2xs font-bold text-[#71717A] mb-2 tracking-normal ml-1 nocaps">username</label>
                                <input type="text" id="username" name="username" value="{{ Auth::user()->username ?? explode(' ', Auth::user()->name)[0] }}"
                                    class="bg-[#0A0A0A] border border-white/5 w-full rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/50 transition-all shadow-inner nocaps">
                            </div>
                        </div>
                        
                        <div>
                            <label for="bio" class="block text-3xs font-bold text-[#3F3F46] mb-3 tracking-normal ml-1 nocaps">bio</label>
                            <textarea id="bio" name="bio" rows="4" 
                                class="bg-[#050505] border border-white/5 w-full rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/50 transition-all shadow-inner resize-none placeholder-[#3F3F46]"
                                placeholder="Tell others about yourself and your work...">{{ Auth::user()->bio ?? '' }}</textarea>
                        </div>

                        <div class="flex justify-end pt-6">
                            <button type="submit"
                                class="btn-primary inline-flex items-center gap-3 text-2xs py-4 px-12 rounded-2xl font-bold tracking-normal shadow-2xl shadow-purple-900/20 nocaps">
                                save changes
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Notifications --}}
                <div class="rounded-[2.5rem] p-10 shadow-2xl glass-card border border-white/5">
                    <h3 class="text-3xs font-bold text-[#3F3F46] mb-10 tracking-normal ml-1 nocaps">notifications</h3>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between p-6 bg-[#030303]/40 rounded-2xl border border-white/5 shadow-inner">
                            <div>
                                <p class="text-xs font-bold text-[#EDEDED] tracking-normal mb-1 nocaps">email notifications</p>
                                <p class="text-2xs font-bold tracking-normal text-[#3F3F46] nocaps">updates about shared snippets and activity</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="email_notifications" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-white/5 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-purple-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-[#3F3F46] after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-6 bg-[#030303]/40 rounded-2xl border border-white/5 shadow-inner">
                            <div>
                                <p class="text-xs font-bold text-[#EDEDED] tracking-normal mb-1 nocaps">push notifications</p>
                                <p class="text-2xs font-bold tracking-normal text-[#3F3F46] nocaps">real-time browser notifications</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="push_notifications" class="sr-only peer">
                                <div class="w-11 h-6 bg-white/5 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-purple-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-[#3F3F46] after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Appearance Settings --}}
                {{-- <div class="rounded-3xl p-8 shadow-2xl glass-card">
                    <h3 class="text-lg font-bold text-white mb-6">Appearance</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 block">Theme Preference</label>
                            <div class="grid grid-cols-3 gap-3">
                                <button class="p-4 bg-white/5 border border-white/10 rounded-xl text-center hover:bg-white/10 transition-all group">
                                    <span class="block text-2xl mb-2">🌙</span>
                                    <span class="text-xs text-gray-400 group-hover:text-white">Dark</span>
                                </button>
                                <button class="p-4 bg-blue-600/10 border border-blue-500/30 rounded-xl text-center hover:bg-blue-600/20 transition-all group">
                                    <span class="block text-2xl mb-2">☀️</span>
                                    <span class="text-xs text-blue-400">Light</span>
                                </button>
                                <button class="p-4 bg-white/5 border border-white/10 rounded-xl text-center hover:bg-white/10 transition-all group">
                                    <span class="block text-2xl mb-2">💻</span>
                                    <span class="text-xs text-gray-400 group-hover:text-white">System</span>
                                </button>
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 block">Editor Font Size</label>
                            <select class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
                                <option value="12">Small (12px)</option>
                                <option value="14" selected>Medium (14px)</option>
                                <option value="16">Large (16px)</option>
                                <option value="18">Extra Large (18px)</option>
                            </select>
                        </div>
                    </div>
                </div> --}}
            </div>

            {{-- Right Column --}}
            <div class="space-y-6">
                <div class="glass-card rounded-[2rem] p-10 border border-white/5 bg-[#030303]/40 shadow-2xl">
                    <h3 class="text-3xs font-bold text-[#3F3F46] mb-8 tracking-normal ml-1 nocaps">security</h3>
                    <div class="space-y-4">
                        <button onclick="toggleModal('passwordModal', true)"
                            class="w-full flex items-center justify-between p-6 bg-[#030303] hover:bg-purple-500/5 group border border-white/5 rounded-2xl transition-all shadow-inner nocaps">
                            <span class="text-2xs font-bold text-[#EDEDED] tracking-normal">change password</span>
                            <div class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center group-hover:bg-purple-500/20 transition-colors">
                                <svg class="w-3.5 h-3.5 text-[#3F3F46] group-hover:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </button>
                        
                        <button onclick="toggleModal('twoFactorModal', true)"
                            class="w-full flex items-center justify-between p-6 bg-[#030303] hover:bg-purple-500/5 group border border-white/5 rounded-2xl transition-all shadow-inner nocaps">
                            <span class="text-2xs font-bold text-[#EDEDED] tracking-normal">two-factor authentication</span>
                            <span class="text-3xs font-black px-3 py-1 bg-purple-500/20 text-purple-400 rounded-lg uppercase tracking-widest border border-purple-500/20 nocaps">secure</span>
                        </button>
                    </div>
                </div>

                {{-- Privacy Settings --}}
                {{-- <div class="glass-card rounded-3xl p-6 border border-white/10 bg-white/5 shadow-2xl">
                    <h3 class="text-sm font-bold text-white mb-4 uppercase tracking-widest text-gray-400">Privacy</h3>
                    <div class="space-y-3">
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-xs text-gray-300">Profile Visibility</span>
                            <select class="bg-white/5 border border-white/10 rounded-lg px-3 py-1.5 text-xs text-white">
                                <option>Public</option>
                                <option>Private</option>
                                <option selected>Partners Only</option>
                            </select>
                        </label>
                        
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-xs text-gray-300">Show Email</span>
                            <input type="checkbox" class="rounded bg-white/5 border-white/10">
                        </label>
                        
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-xs text-gray-300">Allow Search Engines</span>
                            <input type="checkbox" checked class="rounded bg-white/5 border-white/10">
                        </label>
                    </div>
                </div> --}}

                <div class="glass-card rounded-[2.5rem] p-8 border border-red-500/20 bg-red-500/[0.03] shadow-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-red-500/10 flex items-center justify-center border border-red-500/20">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xs font-black text-red-500 uppercase tracking-[0.2em] nocaps">danger zone</h3>
                    </div>
                    <p class="text-[#71717A] text-2xs font-black uppercase tracking-widest mb-6 nocaps">once you delete your account, there is no going back.</p>
                    <button onclick="toggleModal('deleteModal', true)"
                        class="w-full py-3.5 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/20 rounded-2xl text-2xs font-black uppercase tracking-widest transition-all shadow-lg shadow-red-500/10 nocaps">
                        delete vault account
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Image Upload Modal --}}
    <div id="profileImageModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 opacity-0 transition-opacity duration-300">
        <div class="glass-card rounded-[2.5rem] p-10 max-w-md w-full border border-white/5 shadow-2xl transform scale-90 transition-transform duration-300">
            <h3 class="text-2xl font-bold text-[#EDEDED] mb-1 tracking-tighter text-center">Update profile photo</h3>
            <p class="text-[#71717A] text-[9px] font-bold tracking-normal text-center mb-8">Choose a new profile photo</p>

            <form action="{{ url('/update-profile-image') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                {{ csrf_field() }}
                
                <div class="flex flex-col items-center justify-center">
                    <div class="w-32 h-32 rounded-[2rem] bg-purple-600/5 border-2 border-purple-500/20 flex items-center justify-center mb-6 overflow-hidden shadow-2xl shadow-purple-500/10" id="imagePreview">
                        @if(Auth::user()->profile_image)
                            <img src="/profileImages/{{ Auth::user()->profile_image }}" 
                                 alt="Preview" class="w-full h-full object-cover">
                        @else
                            <span class="text-5xl font-black text-purple-500 opacity-40">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                    
                    <label for="profile_image" class="cursor-pointer group">
                        <div class="px-6 py-3 bg-white/5 hover:bg-purple-500/10 border border-white/5 hover:border-purple-500/30 rounded-2xl text-[10px] font-black uppercase tracking-widest text-[#71717A] hover:text-purple-400 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Choose File
                        </div>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden" onchange="previewImage(this)">
                    </label>
                    <p class="text-[9px] font-black uppercase tracking-widest text-[#3F3F46] mt-3">JPG, PNG or GIF. Max 2MB</p>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="toggleModal('profileImageModal', false)"
                        class="flex-1 py-3.5 text-[#71717A] hover:text-[#EDEDED] rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all border border-white/5 hover:bg-white/5">Cancel</button>
                    <button type="submit"
                        class="flex-1 py-3.5 btn-primary rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all">Upload</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Two-Factor Authentication Modal --}}
    <div id="twoFactorModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 opacity-0 transition-opacity duration-300">
        <div class="glass-card rounded-[2.5rem] p-10 max-w-md w-full border border-white/5 shadow-2xl transform scale-90 transition-transform duration-300">
            <h3 class="text-2xl font-bold text-[#EDEDED] mb-2 tracking-tighter text-center">Two-factor authentication</h3>
            <p class="text-[#71717A] text-[9px] font-bold tracking-normal text-center mb-8">Add an extra layer of security to your account</p>

            <div class="space-y-4">
                <div class="p-5 bg-[#030303] rounded-2xl border border-white/5 shadow-inner">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-black text-[#EDEDED] uppercase tracking-widest">Status</span>
                        <span class="text-[9px] px-3 py-1 bg-yellow-500/10 text-yellow-400 rounded-lg uppercase tracking-widest border border-yellow-500/20 font-black">Not Enabled</span>
                    </div>
                    <p class="text-[10px] font-medium text-[#71717A]">Secure your account with 2FA authentication</p>
                </div>

                <button class="w-full py-4 btn-primary rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all">
                    Enable Two-Factor
                </button>
                <button onclick="toggleModal('twoFactorModal', false)"
                    class="w-full py-3 text-[#71717A] hover:text-[#EDEDED] text-[10px] font-black uppercase tracking-widest transition-all">Later</button>
            </div>
        </div>
    </div>

    {{-- Active Sessions Modal --}}
    <div id="sessionsModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 opacity-0 transition-opacity duration-300">
        <div class="glass-card rounded-[2.5rem] p-8 max-w-md w-full border border-white/10 shadow-2xl transform scale-90 transition-transform duration-300">
            <h3 class="text-2xl font-black text-white mb-6 tracking-tight text-center">Active Sessions</h3>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-600/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">Chrome on macOS</p>
                            <p class="text-[10px] text-gray-500">Current session • San Francisco, USA</p>
                        </div>
                    </div>
                    <span class="text-[10px] text-green-500">Active</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-600/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">Safari on iPhone</p>
                            <p class="text-[10px] text-gray-500">Last active 2 hours ago</p>
                        </div>
                    </div>
                    <button class="text-[10px] text-red-400 hover:text-red-300">Revoke</button>
                </div>

                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-600/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">Firefox on Windows</p>
                            <p class="text-[10px] text-gray-500">Last active yesterday</p>
                        </div>
                    </div>
                    <button class="text-[10px] text-red-400 hover:text-red-300">Revoke</button>
                </div>

                <button class="w-full mt-4 py-2 text-xs text-red-400 hover:text-red-300 font-medium transition-all">
                    Sign Out All Devices
                </button>
                
                <button onclick="toggleModal('sessionsModal', false)"
                    class="w-full py-2 text-gray-500 hover:text-white text-xs font-bold transition-all">Close</button>
            </div>
        </div>
    </div>

    {{-- 1. Change Password Modal --}}
    <div id="passwordModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 opacity-0 transition-opacity duration-300">
        <div class="glass-card rounded-[2.5rem] p-10 max-w-md w-full border border-white/5 shadow-2xl transform scale-90 transition-transform duration-300">
            <h3 class="text-2xl font-bold text-[#EDEDED] mb-2 tracking-tighter text-center">Change password</h3>
            <p class="text-[#71717A] text-[9px] font-bold tracking-normal text-center mb-8">Enter your current password and choose a new one.</p>

            <form action="{{ url('/update-password') }}" method="POST" class="space-y-5">
                {{ csrf_field() }}
                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest">{{ session('error') }}</div>
                @endif
                <div>
                    <label for="current_password" class="text-[9px] font-bold text-[#3F3F46] tracking-normal mb-3 ml-1 block">Current password</label>
                    <input type="password" id="current_password" name="current_password" required
                        class="bg-[#050505] border border-white/5 w-full rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/40 transition-all placeholder-[#3F3F46] shadow-inner">
                    @error('current_password')
                        <p class="text-[10px] text-red-400 mt-2 ml-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="text-[9px] font-bold text-[#3F3F46] tracking-normal mb-3 ml-1 block">New password</label>
                    <input type="password" id="password" name="password" required
                        class="bg-[#050505] border border-white/5 w-full rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/40 transition-all placeholder-[#3F3F46] shadow-inner">
                    @error('password')
                        <p class="text-[10px] text-red-400 mt-2 ml-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="text-[9px] font-bold text-[#3F3F46] tracking-normal mb-3 ml-1 block">Confirm new password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="bg-[#050505] border border-white/5 w-full rounded-2xl px-5 py-4 text-sm text-[#EDEDED] focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/40 transition-all placeholder-[#3F3F46] shadow-inner">
                    @error('password_confirmation')
                        <p class="text-[10px] text-red-400 mt-2 ml-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="toggleModal('passwordModal', false)"
                        class="flex-1 py-4 text-[#71717A] hover:text-[#EDEDED] rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all border border-white/5 hover:bg-white/5">Cancel</button>
                    <button type="submit"
                        class="flex-1 py-4 btn-primary rounded-2xl font-bold text-[10px] tracking-normal transition-all">Update password</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 2. Delete Account Modal (With Verification) --}}
    <div id="deleteModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 opacity-0 transition-opacity duration-300">
        <div class="glass-card rounded-[2.5rem] p-10 max-w-sm w-full border border-white/10 shadow-2xl transform scale-90 transition-transform duration-300">
            <div class="w-16 h-16 bg-red-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-red-500/20">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-white text-center mb-2 tracking-tight">Final Warning</h3>
            <p class="text-gray-400 text-center text-[11px] mb-6 leading-relaxed">To confirm deletion, please enter your
                password. This action is irreversible.</p>

            <form action="{{ url('/profile-destroy') }}" method="POST" class="space-y-4">
                {{ csrf_field() }}
                <input type="password" name="password_confirmation" placeholder="Enter your password" required
                    class="bg-red-500/5 border border-red-500/20 w-full rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-red-500/50 outline-none text-center">

                <div class="flex flex-col gap-2">
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-500 text-white py-4 rounded-2xl font-bold transition-all">Confirm Erase</button>
                    <button type="button" onclick="toggleModal('deleteModal', false)"
                        class="w-full py-3 text-gray-500 hover:text-white text-xs font-bold transition-all">Wait, Keep My Account</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id, show) {
            const modal = document.getElementById(id);
            const container = modal.querySelector('.glass-card');

            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modal.classList.add('opacity-100');
                    container.classList.remove('scale-90');
                    container.classList.add('scale-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.remove('opacity-100');
                container.classList.add('scale-90');
                container.classList.remove('scale-100');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.style.overflow = 'auto';
                }, 300);
            }
        }

        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection