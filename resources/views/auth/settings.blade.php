@extends('layout.app')

@section('title', 'System Settings')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4 space-y-8">
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
                    <span class="text-gray-400">/</span>
                </li>
                <li>
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">Profile</a>
                </li>
                <li>
                    <span class="text-gray-400">/</span>
                </li>
                <li>
                    <span class="text-blue-400 font-medium">System Settings</span>
                </li>
            </ol>
        </nav>
        
        {{-- Header Section --}}
        <div class="items-center gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-black text-white tracking-tight">System Settings</h1>
                <p class="text-gray-400 text-sm font-medium">Manage your vault environment, security, and preferences.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Profile Image Section --}}
                <div class="rounded-3xl p-8 shadow-2xl relative overflow-hidden glass-card">
                    <h3 class="text-lg font-bold text-white mb-6">Profile Picture</h3>
                    <div class="flex items-center gap-8">
                        <div class="relative group">
                            <div class="w-24 h-24 rounded-3xl bg-blue-600/20 border-2 border-blue-500/50 flex items-center justify-center shadow-2xl shadow-blue-500/20 overflow-hidden">
                                @if(Auth::user()->profile_image)
                                    <img src="/profileImages/{{ Auth::user()->profile_image }}" 
                                         alt="{{ Auth::user()->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl font-bold text-blue-500">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <button onclick="toggleModal('profileImageModal', true)"
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center shadow-lg transition-all opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                        <div>
                            <p class="text-sm text-gray-300 mb-1">Upload a new profile picture</p>
                            <p class="text-xs text-gray-500">JPG, PNG or GIF. Max size 2MB.</p>
                            <button onclick="toggleModal('profileImageModal', true)"
                                class="mt-3 text-xs text-blue-400 hover:text-blue-300 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Change Photo
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Profile Information --}}
                <div class="rounded-3xl p-8 shadow-2xl relative overflow-hidden glass-card">
                    <h3 class="text-lg font-bold text-white mb-6">Profile Information</h3>
                    <form action="{{ url('/setting-profile') }}" method="POST" class="space-y-4">
                        {{ csrf_field() }}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-widest">User Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}"
                                    class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-widest">Primary Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" readonly
                                    class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white/60 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all cursor-not-allowed">
                            </div>
                        </div>
                        
                        {{-- Additional Profile Fields --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-widest">Full Name</label>
                                <input type="text" name="full_name" value="{{ Auth::user()->full_name ?? Auth::user()->name }}"
                                    class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-widest">Username</label>
                                <input type="text" name="username" value="{{ Auth::user()->username ?? explode(' ', Auth::user()->name)[0] }}"
                                    class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
                            </div>
                        </div>
                        
                        <div class="pt-4">
                            <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-widest">Bio</label>
                            <textarea name="bio" rows="3" 
                                class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all"
                                placeholder="Tell us a little about yourself...">{{ Auth::user()->bio ?? '' }}</textarea>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="btn-primary inline-flex items-center gap-2 text-white text-sm px-6 py-3 rounded-xl font-semibold shadow-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Notifications --}}
                <div class="rounded-3xl p-8 shadow-2xl glass-card">
                    <div class="flex items-center gap-3 mb-6">
                        <h3 class="text-lg font-bold text-white">Notifications</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                            <div>
                                <p class="text-sm font-medium text-white">Email Notifications</p>
                                <p class="text-xs text-gray-500">Get updates about your shared snippets</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="email_notifications" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                            <div>
                                <p class="text-sm font-medium text-white">Push Notifications</p>
                                <p class="text-xs text-gray-500">Browser notifications for activity</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="push_notifications" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                            <div>
                                <p class="text-sm font-medium text-white">Snippet Activity</p>
                                <p class="text-xs text-gray-500">When partners view or edit your snippets</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="snippet_activity" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
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
                <div class="glass-card rounded-3xl p-6 border border-white/10 bg-white/5 shadow-2xl">
                    <h3 class="text-sm font-bold text-white mb-4 uppercase tracking-widest text-gray-400">Security</h3>
                    <div class="space-y-3">
                        <button onclick="toggleModal('passwordModal', true)"
                            class="w-full flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl transition-all group">
                            <span class="text-xs font-medium text-gray-300">Change Password</span>
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        
                        <button onclick="toggleModal('twoFactorModal', true)"
                            class="w-full flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl transition-all group">
                            <span class="text-xs font-medium text-gray-300">Two-Factor Auth</span>
                            <span class="text-[10px] px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded-full">Recommended</span>
                        </button>
                        
                        <button onclick="toggleModal('sessionsModal', true)"
                            class="w-full flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl transition-all group">
                            <span class="text-xs font-medium text-gray-300">Active Sessions</span>
                            <span class="text-[10px] text-gray-500">3 devices</span>
                        </button>
                    </div>
                </div>

                {{-- Privacy Settings --}}
                <div class="glass-card rounded-3xl p-6 border border-white/10 bg-white/5 shadow-2xl">
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
                </div>

                <div class="glass-card rounded-3xl p-6 border border-red-500/20 bg-red-500/5 shadow-2xl">
                    <h3 class="text-sm font-bold text-red-500 mb-4 uppercase tracking-widest">Danger Zone</h3>
                    <p class="text-[11px] text-gray-500 mb-4">Once you delete your account, there is no going back.</p>
                    <button onclick="toggleModal('deleteModal', true)"
                        class="w-full py-3 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/20 rounded-xl text-xs font-bold transition-all uppercase tracking-tighter shadow-lg shadow-red-500/10">
                        Delete Vault Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Image Upload Modal --}}
    <div id="profileImageModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 opacity-0 transition-opacity duration-300">
        <div class="glass-card rounded-[2.5rem] p-8 max-w-md w-full border border-white/10 shadow-2xl transform scale-90 transition-transform duration-300">
            <h3 class="text-2xl font-black text-white mb-2 tracking-tight text-center">Update Profile Picture</h3>
            <p class="text-gray-400 text-xs text-center mb-6">Choose a new image for your profile</p>

            <form action="{{ url('/update-profile-image') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                {{ csrf_field() }}
                
                <div class="flex flex-col items-center justify-center">
                    <div class="w-32 h-32 rounded-3xl bg-blue-600/20 border-2 border-blue-500/50 flex items-center justify-center mb-4 overflow-hidden" id="imagePreview">
                        @if(Auth::user()->profile_image)
                            <img src="/profileImages/{{ Auth::user()->profile_image }}" 
                                 alt="Preview" class="w-full h-full object-cover">
                        @else
                            <span class="text-5xl font-bold text-blue-500">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                    
                    <label for="profile_image" class="cursor-pointer">
                        <div class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-sm text-gray-300 transition-all">
                            Choose File
                        </div>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden" onchange="previewImage(this)">
                    </label>
                    <p class="text-[10px] text-gray-500 mt-2">JPG, PNG or GIF. Max 2MB</p>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="toggleModal('profileImageModal', false)"
                        class="flex-1 py-3 text-gray-400 rounded-xl font-bold transition-all hover:text-white">Cancel</button>
                    <button type="submit"
                        class="flex-1 py-3 btn-primary text-white rounded-xl font-bold transition-all">Upload</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Two-Factor Authentication Modal --}}
    <div id="twoFactorModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 opacity-0 transition-opacity duration-300">
        <div class="glass-card rounded-[2.5rem] p-8 max-w-md w-full border border-white/10 shadow-2xl transform scale-90 transition-transform duration-300">
            <h3 class="text-2xl font-black text-white mb-2 tracking-tight text-center">Two-Factor Authentication</h3>
            <p class="text-gray-400 text-xs text-center mb-6">Add an extra layer of security to your account</p>

            <div class="space-y-4">
                <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-white">Status</span>
                        <span class="text-xs px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded-full">Not Enabled</span>
                    </div>
                    <p class="text-xs text-gray-500">Secure your account with 2FA authentication</p>
                </div>

                <button class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-all">
                    Enable Two-Factor
                </button>
                <button onclick="toggleModal('twoFactorModal', false)"
                    class="w-full py-2 text-gray-500 hover:text-white text-xs font-bold transition-all">Later</button>
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
        <div class="glass-card rounded-[2.5rem] p-8 max-w-md w-full border border-white/10 shadow-2xl transform scale-90 transition-transform duration-300">
            <h3 class="text-2xl font-black text-white mb-2 tracking-tight text-center">Security Update</h3>
            <p class="text-gray-400 text-xs text-center mb-6">Enter your current and new passwords below.</p>

            <form action="{{ url('/update-password') }}" method="POST" class="space-y-4">
                {{ csrf_field() }}
                @if(session('error'))
                    <div class="text-red-400 text-sm mb-4">{{ session('error') }}</div>
                @endif
                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1 block">Current Password</label>
                    <input type="password" name="current_password" required
                        class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500/50 outline-none">
                    @error('current_password')
                        <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1 block">New Password</label>
                    <input type="password" name="password" required
                        class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500/50 outline-none">
                    @error('password')
                        <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1 block">Confirm New Password</label>
                    <input type="password" name="password_confirmation" required
                        class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500/50 outline-none">
                    @error('password_confirmation')
                        <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="toggleModal('passwordModal', false)"
                        class="flex-1 py-3 text-gray-400 rounded-xl font-bold transition-all hover:text-white">Cancel</button>
                    <button type="submit"
                        class="flex-1 py-3 btn-primary text-white rounded-xl font-bold transition-all">Update Now</button>
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