@extends('auth.master')

@section('title', 'System Settings')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4 py-8 space-y-8">
        {{-- Header Section --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ url('/dashboard') }}"
                class="group p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 text-gray-400 hover:text-white transition-all shadow-xl">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-white tracking-tight">System Settings</h1>
                <p class="text-gray-400 text-sm font-medium">Manage your vault environment, security, and preferences.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">
                <div
                    class=" rounded-3xl p-8  shadow-2xl relative overflow-hidden">
                    <h3 class="text-lg font-bold text-white mb-6">Profile Information</h3>
                    <form action="{{ url('/setting-profile') }}" method="POST" class="space-y-4">
                         {{ csrf_field() }}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-widest">User
                                    Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}"
                                    class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-widest">Primary
                                    Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" readonly
                                    class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
                            </div>
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="btn-primary  inline-flex items-center gap-2 text-white text-sm px-6 py-3 rounded-xl font-semibold shadow-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                {{-- 2. Notifications --}}
                <div class=" rounded-3xl p-8  hadow-2xl">
                    <div class="flex items-center gap-3 mb-6">
                        <h3 class="text-lg font-bold text-white">Notifications</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                            <div>
                                <p class="text-sm font-medium text-white">Email Notifications</p>
                                <p class="text-xs text-gray-500">Get updates about your shared snippets</p>
                            </div> <label class="relative inline-flex items-center cursor-pointer"> <input type="checkbox"
                                    checked class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
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

    {{-- 1. Change Password Modal --}}
    <div id="passwordModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 opacity-0 transition-opacity duration-300">
        <div
            class="glass-card rounded-[2.5rem] p-8 max-w-md w-full border border-white/10 shadow-2xl transform scale-90 transition-transform duration-300">
            <h3 class="text-2xl font-black text-white mb-2 tracking-tight text-center">Security Update</h3>
            <p class="text-gray-400 text-xs text-center mb-6">Enter your current and new passwords below.</p>

            <form action="{{ url('/update-password') }}" method="POST" class="space-y-4">
                 {{ csrf_field() }}
                @if(session('error'))
                    <div class="text-red-400 text-sm mb-4">{{ session('error') }}</div>
                @endif
                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1 block">Current
                        Password</label>
                    <input type="password" name="current_password" required
                        class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500/50 outline-none">
                    @error('current_password')
                        <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1 block">New
                        Password</label>
                    <input type="password" name="password" required
                        class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500/50 outline-none">
                    @error('password')
                        <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1 block">Confirm New
                        Password</label>
                    <input type="password" name="password_confirmation" required
                        class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500/50 outline-none">
                    @error('password_confirmation')
                        <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="toggleModal('passwordModal', false)"
                        class="flex-1 py-3  text-gray-400 rounded-xl font-bold  transition-all">Cancel</button>
                    <button type="submit"
                        class="flex-1 py-3 btn-primary text-white rounded-xl font-bold  transition-all">Update
                        Now</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 2. Delete Account Modal (With Verification) --}}
    <div id="deleteModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 opacity-0 transition-opacity duration-300">
        <div
            class="glass-card rounded-[2.5rem] p-10 max-w-sm w-full border border-white/10 shadow-2xl transform scale-90 transition-transform duration-300">
            <div
                class="w-16 h-16 bg-red-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-red-500/20">
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
                        class="w-full bg-red-600 hover:bg-red-500 text-white py-4 rounded-2xl font-bold transition-all">Confirm
                        Erase</button>
                    <button type="button" onclick="toggleModal('deleteModal', false)"
                        class="w-full py-3 text-gray-500 hover:text-white text-xs font-bold transition-all">Wait, Keep My
                        Account</button>
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
    </script>
@endsection
