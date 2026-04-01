@extends('layout.app')

@section('title', 'Ms. Hollie Reichel - Profile')

@section('content')
<div class="w-full max-w-5xl mx-auto px-4 space-y-6">
    {{-- Breadcrumb --}}
    <nav class="flex mb-2" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ url('/dashboard') }}" class="text-gray-500 hover:text-blue-400 transition-colors text-xs">Dashboard</a>
            </li>
            <li>
                <span class="text-gray-600">/</span>
            </li>
            <li>
                <a href="{{ url('/profile') }}" class="text-gray-500 hover:text-blue-400 transition-colors text-xs">Profile</a>
            </li>
            <li>
                <span class="text-gray-600">/</span>
            </li>
            <li>
                <span class="text-blue-400 text-xs">Ms. Hollie Reichel</span>
            </li>
        </ol>
    </nav>

    {{-- Back Button --}}
    <a href="javascript:history.back()" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors text-sm mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back
    </a>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Left Column - Profile Card --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Profile Card --}}
            <div class="glass-card rounded-2xl p-6 border border-white/10 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-purple-600"></div>
                
                {{-- Avatar with Status --}}
                <div class="relative inline-block mb-4">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center mx-auto shadow-2xl">
                        <span class="text-4xl font-bold text-white">H</span>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-black"></div>
                </div>

                <h2 class="text-xl font-bold text-white mb-1">Ms. Hollie Reichel</h2>
                <p class="text-gray-400 text-sm mb-4">howe.ismael@example.com</p>
                
                {{-- Partnership Status --}}
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-500/10 rounded-full border border-blue-500/20 mb-4">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    <span class="text-xs text-blue-400">Partner</span>
                </div>

                {{-- Member Since --}}
                <div class="pt-4 border-t border-white/5">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500 uppercase tracking-widest font-bold">Member Since</span>
                        <span class="text-gray-300">Feb 2026</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions Card --}}
            <div class="glass-card rounded-2xl p-5 border border-white/10">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Quick Actions</h3>
                <div class="space-y-2">
                    <button class="w-full flex items-center justify-between p-3 bg-white/5 hover:bg-blue-500/10 rounded-xl border border-white/5 transition-all group">
                        <span class="text-sm text-gray-300 group-hover:text-blue-400">Send Message</span>
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </button>
                    
                    <button class="w-full flex items-center justify-between p-3 bg-white/5 hover:bg-blue-500/10 rounded-xl border border-white/5 transition-all group">
                        <span class="text-sm text-gray-300 group-hover:text-blue-400">Share Snippet</span>
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                    </button>
                    
                    <button class="w-full flex items-center justify-between p-3 bg-white/5 hover:bg-red-500/10 rounded-xl border border-white/5 transition-all group">
                        <span class="text-sm text-gray-300 group-hover:text-red-400">Remove Partner</span>
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Access Level Card --}}
            <div class="glass-card rounded-2xl p-5 border border-white/10">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Access Level</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-300">Read Access</span>
                        <span class="text-xs px-2 py-1 bg-green-500/20 text-green-400 rounded-full">Granted</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-300">Edit Access</span>
                        <span class="text-xs px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded-full">Pending</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-300">Share Access</span>
                        <span class="text-xs px-2 py-1 bg-gray-500/20 text-gray-400 rounded-full">None</span>
                    </div>
                    
                    <button class="w-full mt-2 py-2 text-xs bg-white/5 hover:bg-white/10 rounded-lg text-gray-400 hover:text-white transition-colors">
                        Update Permissions
                    </button>
                </div>
            </div>
        </div>

        {{-- Right Column - Content --}}
        <div class="lg:col-span-8 space-y-6">
            {{-- Bio Card --}}
            <div class="glass-card rounded-2xl p-6 border border-white/10">
                <h3 class="text-lg font-bold text-white mb-3">About</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Full-stack developer with 5+ years of experience in Laravel and React. 
                    Passionate about clean code and sharing knowledge with the community. 
                    Currently working on several open-source projects.
                </p>
                
                {{-- Tags --}}
                <div class="flex flex-wrap gap-2 mt-4">
                    <span class="text-[10px] px-3 py-1.5 bg-blue-500/10 text-blue-400 rounded-full border border-blue-500/20">Laravel</span>
                    <span class="text-[10px] px-3 py-1.5 bg-purple-500/10 text-purple-400 rounded-full border border-purple-500/20">React</span>
                    <span class="text-[10px] px-3 py-1.5 bg-green-500/10 text-green-400 rounded-full border border-green-500/20">Vue</span>
                    <span class="text-[10px] px-3 py-1.5 bg-yellow-500/10 text-yellow-400 rounded-full border border-yellow-500/20">Tailwind</span>
                    <span class="text-[10px] px-3 py-1.5 bg-red-500/10 text-red-400 rounded-full border border-red-500/20">Docker</span>
                </div>
            </div>

            {{-- Shared Snippets Card --}}
            <div class="glass-card rounded-2xl p-6 border border-white/10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Shared Snippets</h3>
                    <span class="text-xs px-3 py-1 bg-blue-500/10 text-blue-400 rounded-full border border-blue-500/20">8 snippets</span>
                </div>

                {{-- Snippets Grid --}}
                <div class="space-y-3">
                    {{-- Snippet 1 --}}
                    <div class="group flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5 hover:border-blue-500/30 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                <span class="text-lg">🟦</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white group-hover:text-blue-400 transition-colors">Laravel Authentication</h4>
                                <p class="text-[10px] text-gray-500">Shared 2 days ago • 3 files</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] px-2 py-1 bg-green-500/10 text-green-400 rounded-full border border-green-500/20">Read</span>
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    {{-- Snippet 2 --}}
                    <div class="group flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5 hover:border-purple-500/30 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center">
                                <span class="text-lg">🟣</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white group-hover:text-purple-400 transition-colors">React Custom Hooks</h4>
                                <p class="text-[10px] text-gray-500">Shared 5 days ago • 5 files</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] px-2 py-1 bg-yellow-500/10 text-yellow-400 rounded-full border border-yellow-500/20">Edit</span>
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    {{-- Snippet 3 --}}
                    <div class="group flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5 hover:border-green-500/30 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                                <span class="text-lg">🟢</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white group-hover:text-green-400 transition-colors">Python Data Processing</h4>
                                <p class="text-[10px] text-gray-500">Shared 1 week ago • 2 files</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] px-2 py-1 bg-green-500/10 text-green-400 rounded-full border border-green-500/20">Read</span>
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    {{-- Snippet 4 --}}
                    <div class="group flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5 hover:border-yellow-500/30 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                                <span class="text-lg">🟡</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white group-hover:text-yellow-400 transition-colors">Docker Configurations</h4>
                                <p class="text-[10px] text-gray-500">Shared 2 weeks ago • 4 files</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] px-2 py-1 bg-green-500/10 text-green-400 rounded-full border border-green-500/20">Read</span>
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- View All Link --}}
                <div class="mt-4 text-center">
                    <a href="#" class="text-xs text-gray-500 hover:text-blue-400 transition-colors inline-flex items-center gap-1">
                        View all shared snippets
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Activity Timeline --}}
            <div class="glass-card rounded-2xl p-6 border border-white/10">
                <h3 class="text-lg font-bold text-white mb-4">Recent Activity</h3>
                
                <div class="space-y-4">
                    {{-- Activity 1 --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">Created a new snippet <span class="text-blue-400">"Laravel API Resource"</span></p>
                            <p class="text-[10px] text-gray-500">2 hours ago</p>
                        </div>
                    </div>

                    {{-- Activity 2 --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">Viewed your snippet <span class="text-green-400">"React Context Setup"</span></p>
                            <p class="text-[10px] text-gray-500">Yesterday</p>
                        </div>
                    </div>

                    {{-- Activity 3 --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">Commented on <span class="text-purple-400">"Database Migrations"</span></p>
                            <p class="text-[10px] text-gray-500">3 days ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection