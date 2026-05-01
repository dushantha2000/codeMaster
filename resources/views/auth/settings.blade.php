@extends('layout.app')

@section('title', 'System Settings')

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
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </a>
                </li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700 transition">Profile</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><span class="text-blue-400 font-medium">System Settings</span></li>
            </ol>
        </nav>
        
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-12">
            <div>
                <h1 class="text-4xl font-black text-white tracking-tight">System Settings</h1>
                <p class="text-gray-400 text-sm font-medium mt-1">Manage your profile, security, and notification preferences.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Profile Image Section --}}
                <div class=" relative overflow-hidden group">
                    <h3 class="text-lg font-bold text-white mb-6">Profile Photo</h3>
                    <div class="flex items-center gap-8">
                        <div class="relative">
                            <div class="w-32 h-32 rounded-3xl bg-blue-500/5 border border-blue-500/20 flex items-center justify-center shadow-lg overflow-hidden transition-transform duration-500 group-hover:scale-[1.02]">
                                @if(Auth::user()->profile_image)
                                    <img src="/profileImages/{{ Auth::user()->profile_image }}" 
                                         alt="{{ Auth::user()->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-6xl font-black text-blue-500 opacity-40">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <button onclick="openModal('profileImageModal')"
                                class="absolute -bottom-2 -right-2 w-10 h-10 bg-blue-600 hover:bg-blue-500 rounded-xl flex items-center justify-center shadow-2xl transition-all border-2 border-black"
                                aria-label="Change profile photo">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white mb-1">Update Profile Photo</p>
                            <p class="text-[10px] text-gray-500">Max size 2MB. 1:1 aspect ratio recommended.</p>
                            <button onclick="openModal('profileImageModal')"
                                class="mt-4 text-xs font-bold text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Change Profile Photo
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Profile Information --}}
                <div class=" rounded-3xl p-8 border border-white/10 shadow-2xl relative overflow-hidden group">
                    <h3 class="text-lg font-bold text-white mb-6">Profile Information</h3>
                    <form action="{{ url('/setting-profile') }}" method="POST" class="space-y-6">
                        {{ csrf_field() }}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-[10px] font-bold text-gray-400 mb-1  tracking-widest ml-1">Display Name</label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                                    class="bg-[#050505] border border-white/5 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-all">
                            </div>
                            <div>
                                <label for="email" class="block text-[10px] font-bold text-gray-400 mb-1  tracking-widest ml-1">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" readonly
                                    class="bg-[#050505] border border-white/5 w-full rounded-xl px-4 py-3 text-sm text-white cursor-not-allowed opacity-70 transition-all">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="full_name" class="block text-[10px] font-bold text-gray-400 mb-1  tracking-widest ml-1">Full Name</label>
                                <input type="text" id="fullName" name="fullName" value="{{ Auth::user()->fullName ?? Auth::user()->name }} "
                                    class="bg-[#050505] border border-white/5 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-all">
                            </div>
                            <div>
                                <label for="username" class="block text-[10px] font-bold text-gray-400 mb-1  tracking-widest ml-1">Username</label>
                                <input type="text" id="username" name="username" value="{{ Auth::user()->username ?? explode(' ', Auth::user()->name)[0] }}"
                                    class="bg-[#050505] border border-white/5 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-all">
                            </div>
                        </div>
                        
                        <div>
                            <label for="bio" class="block text-[10px] font-bold text-gray-400 mb-1  tracking-widest ml-1">Bio</label>
                            <textarea id="bio" name="bio" rows="4" 
                                class="bg-[#050505] border border-white/5 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none resize-none transition-all"
                                placeholder="Tell others about yourself and your work...">{{ Auth::user()->bio ?? '' }}</textarea>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="btn-primary py-2 px-8 rounded-xl font-bold  transition flex items-center gap-2 text-sm">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Notifications --}}
                <div class="glass-card rounded-3xl p-8 border border-white/10 shadow-2xl relative overflow-hidden group">
                    <h3 class="text-lg font-bold text-white mb-6">Notifications</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-2xl border border-white/5 transition-all">
                            <div>
                                <p class="text-sm font-bold text-white mb-1">Email Notifications</p>
                                <p class="text-xs text-gray-500">Updates about shared snippets and activity</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="email_notifications" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-2xl border border-white/5 transition-all">
                            <div>
                                <p class="text-sm font-bold text-white mb-1">Push Notifications</p>
                                <p class="text-xs text-gray-500">Real-time browser notifications</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="push_notifications" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="space-y-6">
                {{-- Security --}}
                <div class=" rounded-2xl p-8 border border-white/10 shadow-2xl relative overflow-hidden group">
                    <h3 class="text-lg font-bold text-white mb-6">Security</h3>
                    <div class="space-y-3">
                        <button onclick="openModal('passwordModal')"
                            class="w-full flex items-center justify-between p-4 input-field hover:bg-white/5 rounded-2xl transition text-sm">
                            <span class="font-bold text-white">Change Password</span>
                            <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-gray-400 group-hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </button>
                        
                        <button onclick="openModal('twoFactorModal')"
                            class="w-full flex items-center justify-between p-4 input-field hover:bg-white/5 rounded-2xl transition text-sm">
                            <span class="font-bold text-white">Two-Factor Auth</span>
                            <span class="text-[10px] font-bold px-2 py-1  text-blue-400 rounded uppercase tracking-widest ">Secure</span>
                        </button>
                    </div>
                </div>

                {{-- Danger Zone --}}
                <div class="glass-card rounded-3xl p-8 border border-red-500/20 bg-red-500/5 shadow-2xl relative overflow-hidden group">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center border border-red-500/20">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-red-500 uppercase tracking-widest">Danger Zone</h3>
                    </div>
                    <p class="text-xs text-gray-400 mb-6">Once you delete your account, there is no going back.</p>
                    <button onclick="openModal('deleteModal')"
                        class="w-full py-3 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/20 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2">
                        Delete Vault Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    
    {{-- Profile Image Upload Modal --}}
    <div id="profileImageModal" class="hidden fixed inset-0 z-[99999] bg-black/60 flex items-center justify-center p-4">
        <div onclick="event.stopPropagation()" class="relative w-full max-w-md glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-[menuPopIn_0.4s_cubic-bezier(0.34,1.56,0.64,1)]">
            <button onclick="closeModal('profileImageModal')" class="absolute top-5 right-5 z-50 text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-8">
                <div class="mb-6">
                    <h3 class="text-2xl font-black text-white tracking-tight text-center">Update Profile Photo</h3>
                    <p class="text-gray-500 text-xs mt-1 text-center">Choose a new profile photo</p>
                </div>

                <form action="{{ url('/update-profile-image') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    {{ csrf_field() }}
                    
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-32 h-32 rounded-3xl bg-blue-500/5 border border-blue-500/20 flex items-center justify-center mb-6 overflow-hidden shadow-lg" id="imagePreview">
                            @if(Auth::user()->profile_image)
                                <img src="/profileImages/{{ Auth::user()->profile_image }}" 
                                     alt="Preview" class="w-full h-full object-cover">
                            @else
                                <span class="text-5xl font-black text-blue-500 opacity-40">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            @endif
                        </div>
                        
                        <label for="profile_image" class="cursor-pointer group">
                            <div class="px-6 py-3 input-field rounded-xl text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-white transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Choose File
                            </div>
                            <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden" onchange="previewImage(this)">
                        </label>
                        <p class="text-[9px] font-bold text-gray-500 mt-4 uppercase tracking-widest">JPG, PNG or GIF. Max 2MB</p>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeModal('profileImageModal')"
                            class="flex-1 py-3 text-sm font-bold text-gray-400 hover:text-white transition">Cancel</button>
                        <button type="submit"
                            class="flex-1 py-3 btn-primary rounded-xl font-bold  transition">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Two-Factor Authentication Modal --}}
    <div id="twoFactorModal" class="hidden fixed inset-0 z-[99999] bg-black/60 flex items-center justify-center p-4">
        <div onclick="event.stopPropagation()" class="relative w-full max-w-md glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-[menuPopIn_0.4s_cubic-bezier(0.34,1.56,0.64,1)]">
            <button onclick="closeModal('twoFactorModal')" class="absolute top-5 right-5 z-50 text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-8">
                <div class="mb-6">
                    <h3 class="text-2xl font-black text-white tracking-tight text-center">Two-Factor Auth</h3>
                    <p class="text-gray-500 text-xs mt-1 text-center">Add an extra layer of security</p>
                </div>

                <div class="space-y-4">
                    <div class="p-5 bg-gray-800/30 rounded-2xl border border-white/5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-bold text-white uppercase tracking-widest">Status</span>
                            @if(Auth::user()->two_factor_enabled)
                                <span class="text-[9px] px-2 py-1  text-green-400 rounded uppercase tracking-widest  font-bold">Enabled</span>
                            @else
                                <span class="text-[9px] px-2 py-1  text-yellow-400 rounded uppercase tracking-widest font-bold">Not Enabled</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400">Secure your account with 2FA authentication</p>
                    </div>

                    @if(Auth::user()->two_factor_enabled)
                        <form action="{{ route('2fa.disable') }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="w-full py-3 bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 rounded-xl font-bold transition text-sm mb-3">
                                Disable Two-Factor
                            </button>
                        </form>
                    @else
                        <a href="{{ route('2fa.enable') }}" class="block text-center w-full py-3 btn-primary rounded-xl font-bold transition text-sm mb-3">
                            Enable Two-Factor
                        </a>
                    @endif
                    <button onclick="closeModal('twoFactorModal')"
                        class="w-full py-3 text-sm font-bold text-gray-400 hover:text-white transition">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Change Password Modal --}}
    <div id="passwordModal" class="hidden fixed inset-0 z-[99999] bg-black/60 flex items-center justify-center p-4">
        <div onclick="event.stopPropagation()" class="relative w-full max-w-md glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-[menuPopIn_0.4s_cubic-bezier(0.34,1.56,0.64,1)]">
            <button onclick="closeModal('passwordModal')" class="absolute top-5 right-5 z-50 text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-8">
                <div class="mb-6">
                    <h3 class="text-2xl font-black text-white tracking-tight text-center">Change Password</h3>
                    <p class="text-gray-500 text-xs mt-1 text-center">Update your security credentials</p>
                </div>

                <form action="{{ url('/update-password') }}" method="POST" class="space-y-4">
                    {{ csrf_field() }}
                    @if(session('error'))
                        <div class="bg-red-500/10 border border-red-500/30 text-red-500 px-4 py-3 rounded-xl text-xs font-bold">{{ session('error') }}</div>
                    @endif
                    <div>
                        <label for="current_password" class="block text-[10px] font-bold text-gray-400 mb-1  tracking-widest ml-1">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required
                            class="bg-[#050505] border border-white/5 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-all">
                        @error('current_password')
                            <p class="text-[10px] text-red-400 mt-1 ml-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-[10px] font-bold text-gray-400 mb-1  tracking-widest ml-1">New Password</label>
                        <input type="password" id="password" name="password" required
                            class="bg-[#050505] border border-white/5 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-all">
                        @error('password')
                            <p class="text-[10px] text-red-400 mt-1 ml-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-[10px] font-bold text-gray-400 mb-1  tracking-widest ml-1">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="bg-[#050505] border border-white/5 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-all">
                        @error('password_confirmation')
                            <p class="text-[10px] text-red-400 mt-1 ml-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeModal('passwordModal')"
                            class="flex-1 py-3 text-sm font-bold text-gray-400 hover:text-white transition">Cancel</button>
                        <button type="submit"
                            class="flex-[2] py-3 btn-primary rounded-xl font-bold  transition">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Account Modal --}}
    <div id="deleteModal" class="hidden fixed inset-0 z-[99999] bg-black/60 flex items-center justify-center p-4">
        <div onclick="event.stopPropagation()" class="relative w-full max-w-md glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-[menuPopIn_0.4s_cubic-bezier(0.34,1.56,0.64,1)]">
            <button onclick="closeModal('deleteModal')" class="absolute top-5 right-5 z-50 text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-8">
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center border border-red-500/20">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mb-6">
                    <h3 class="text-2xl font-black text-white text-center tracking-tight">Final Warning</h3>
                    <p class="text-gray-400 text-xs mt-2 text-center leading-relaxed">To confirm deletion, please enter your password. This action is irreversible.</p>
                </div>

                <form action="{{ url('/profile-destroy') }}" method="POST" class="space-y-4">
                    {{ csrf_field() }}
                    <div>
                        <input type="password" name="password_confirmation" placeholder="Enter your password" required
                            class="bg-[#050505] border border-white/5 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none text-center">
                    </div>

                    <div class="flex flex-col gap-3 pt-4">
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-500 text-white py-3 rounded-xl font-bold transition flex justify-center items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Confirm Delete
                        </button>
                        <button type="button" onclick="closeModal('deleteModal')"
                            class="w-full py-3 text-sm font-bold text-gray-400 hover:text-white transition">Keep My Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal on outside click
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id$="Modal"]').forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        closeModal(modal.id);
                    }
                });
            }
        });

        // Image Preview logic
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