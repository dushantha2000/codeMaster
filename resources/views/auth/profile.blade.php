@extends('auth.master')

@section('title', 'My Profile')

@section('content')
<div class="w-full max-w-4xl animate-in fade-in zoom-in duration-300">
    {{-- Header Section: Fixed Nesting --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 px-2 gap-4">
        <div class="flex items-center gap-5">
            <a href="{{ url('/dashboard') }}" class="group p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 text-gray-400 hover:text-white transition-all shadow-xl">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-white tracking-tight">Account Settings</h1>
                <p class="text-gray-400 text-sm font-medium">Manage your vault identity and security. <span class="text-blue-400">Secure Vault</span></p>
            </div>
        </div> {{-- Closed the title group --}}
      
        
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Sidebar: Profile Card --}}
        <div class="md:col-span-1 space-y-6">
            <div class="glass-card bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                
                <div class="relative inline-block">
                    <div class="w-24 h-24 rounded-3xl bg-blue-600/20 border-2 border-blue-500/50 flex items-center justify-center mx-auto mb-4 shadow-2xl shadow-blue-500/20">
                        <span class="text-4xl font-bold text-blue-500">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <button class="absolute -bottom-1 -right-1 p-2 bg-slate-800 border border-white/10 rounded-xl hover:bg-slate-700 transition-all text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </button>
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
        <div class="md:col-span-2 space-y-6">
            <div class="glass-card bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Personal Information
                </h3>

                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">User Name</label>
                            <input type="text" value="{{ Auth::user()->name }}" class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Email Address</label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled class="bg-white/5 border border-white/10 w-full rounded-xl px-4 py-3 text-sm text-gray-500 cursor-not-allowed opacity-50">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 btn-primary  text-sm  px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg">

                            
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            {{-- Security Section --}}
            <div class="glass-card bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Security & Password
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-white/5 border border-white/5 rounded-2xl">
                        <div>
                            <p class="text-sm font-medium text-white">Password Protection</p>
                            <p class="text-xs text-gray-500">Keep your account secure</p>
                        </div>
                        <button class="text-blue-400 hover:text-blue-300 text-xs font-bold uppercase tracking-widest">Update</button>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-red-500/5 border border-red-500/10 rounded-2xl">
                        <div>
                            <p class="text-sm font-medium text-red-400">Two-Factor Authentication</p>
                            <p class="text-xs text-gray-500">Add an extra layer of security.</p>
                        </div>
                        <button class="bg-red-500/20 text-red-400 px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-red-500/30 transition-all">Enable</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection