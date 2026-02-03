@extends('auth.master')

@section('title', 'System Settings')

@section('content')
<div class="w-full max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ url('/dashboard') }}" class="group p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 text-gray-400 hover:text-white transition-all shadow-xl">
            <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-black text-white tracking-tight">Settings</h1>
            <p class="text-gray-400 text-sm font-medium">Configure your account preferences and report system issues.</p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="glass-card rounded-3xl p-8 border border-white/10 relative overflow-hidden">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-blue-500/10 rounded-lg text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-white">Email Address</h3>
            </div>

            <form action="" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5 ml-1 uppercase tracking-wider">Current Email</label>
                        <input type="text" disabled value="{{ Auth::user()->email }}" 
                               class="input-field w-full rounded-xl px-4 py-3 text-sm text-gray-500 cursor-not-allowed bg-white/5">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1 uppercase tracking-wider">New Email Address</label>
                        <input type="email" name="new_email" required placeholder="new-email@example.com"
                               class="input-field w-full rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500/20">
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="load-btn bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20">
                        Update Email
                    </button>
                </div>
            </form>
        </div>

        {{-- <div class="glass-card rounded-3xl p-8 border border-white/10 relative overflow-hidden">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-amber-500/10 rounded-lg text-amber-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-white">Report a Bug</h3>
            </div>

            <form action="{{ url('settings') }}" method="POST">
               {{ csrf_field() }}
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1 uppercase tracking-wider">Issue Title</label>
                        <input type="text" name="title" required placeholder="Brief description of the glitch"
                               class="input-field w-full rounded-xl px-4 py-3 text-sm text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1 uppercase tracking-wider">Detailed Description</label>
                        <textarea name="description" rows="4" required placeholder="How can we reproduce the error?"
                                  class="input-field w-full rounded-xl px-4 py-3 text-sm text-white resize-none"></textarea>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1 uppercase tracking-wider">Severity</label>
                            <select name="severity" class="input-field w-full rounded-xl px-4 py-3 text-sm text-white bg-black">
                                <option value="low">Low - Visual Glitch</option>
                                <option value="medium">Medium - Functionality Issue</option>
                                <option value="high">High - Critical Error</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="load-btn bg-white/10 hover:bg-white/20 text-white px-6 py-2.5 rounded-xl font-bold text-sm border border-white/10 transition-all">
                        Submit Report
                    </button>
                </div>
            </form>
        </div> --}}
    </div>
</div>
@endsection