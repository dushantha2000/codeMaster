@extends('layout.app')

@section('title', 'Audit Logs')

@section('content')
<div class="w-full max-w-6xl mx-auto px-4">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
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
                <li><a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 transition">Dashboard</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><span class="text-blue-400 font-medium">Logs</span></li>
            </ol>
        </nav>



        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-12">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-4xl font-black text-white tracking-tight">Audit Logs</h1>
                    <span
                        class="bg-blue-500/20 text-blue-400 text-xs font-bold px-2.5 py-1 rounded-lg border border-blue-500/30 mt-1">
                        {{ count($logs) }}
                    </span>
                </div>
                <p class="text-gray-400 text-sm font-medium mt-1">A chronological history of resource creation, modifications, and system events.</p>
            </div>

            
        </div>

        <!-- Logs Container -->
        <div class="bg-[#0a0a0a] rounded-xl border border-white/5 overflow-hidden shadow-2xl relative">
            
            <div class="absolute inset-0 bg-gradient-to-b from-white/[0.02] to-transparent pointer-events-none"></div>

            <!-- Table Header -->
            <div class="hidden md:grid grid-cols-12 gap-6 border-b border-white/10 bg-black/40 px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-500 relative z-10">
                <div class="col-span-2">Event</div>
                <div class="col-span-5">Resource</div>
                <div class="col-span-3">Module</div>
                <div class="col-span-2 text-right">Timestamp</div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-white/[0.05] relative z-10">
                @forelse($logs as $activity)
                    <div class="flex flex-col md:grid md:grid-cols-12 gap-3 md:gap-6 px-5 md:px-8 py-5 items-start md:items-center hover:bg-white/[0.02] transition-colors group cursor-default">
                        
                        <!-- Event Action Type & Mobile Timestamp -->
                        <div class="md:col-span-2 flex items-center justify-between w-full md:w-auto mb-1 md:mb-0">
                            <div class="flex items-center gap-3">
                                @if($activity->is_new)
                                    <div class="relative flex items-center justify-center w-3 h-3">
                                        <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-500 opacity-20"></span>
                                        <span class="relative inline-flex rounded-full w-1.5 h-1.5 bg-emerald-400 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                                    </div>
                                    <span class="text-xs font-bold text-emerald-400 tracking-wide">Created</span>
                                @else
                                    <div class="relative flex items-center justify-center w-3 h-3">
                                        <span class="absolute inline-flex h-full w-full rounded-full bg-blue-500 opacity-20"></span>
                                        <span class="relative inline-flex rounded-full w-1.5 h-1.5 bg-blue-400 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></span>
                                    </div>
                                    <span class="text-xs font-bold text-blue-400 tracking-wide">Modified</span>
                                @endif
                            </div>
                            
                            <!-- Mobile Timestamp -->
                            <div class="md:hidden text-right flex flex-col justify-end items-end">
                                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                    {{ \Carbon\Carbon::parse($activity->action_time)->diffForHumans(null, true, true) }} ago
                                </span>
                            </div>
                        </div>
                        
                        <!-- Resource Title -->
                        <div class="md:col-span-5 w-full">
                            <span class="text-[15px] md:text-sm font-semibold text-gray-200 group-hover:text-white transition-colors line-clamp-2 md:line-clamp-1 block">
                                {{ $activity->title }}
                            </span>
                        </div>
                        
                        <!-- Module / Type -->
                        <div class="md:col-span-3 mt-1 md:mt-0">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-white/5 border border-white/5 text-[10px] font-bold text-gray-400 uppercase tracking-widest shadow-sm">
                                @if($activity->type == 'Snippet')
                                    <svg class="w-3.5 h-3.5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                @elseif($activity->type == 'Category')
                                    <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                @else
                                    <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                @endif
                                {{ $activity->type }}
                            </div>
                        </div>

                        <!-- Timestamp (Desktop) -->
                        <div class="hidden md:flex md:col-span-2 text-right flex-col justify-end items-end">
                            <span class="text-xs font-medium text-gray-300">
                                {{ \Carbon\Carbon::parse($activity->action_time)->diffForHumans() }}
                            </span>
                            <span class="text-[10px] text-gray-600 mt-1 uppercase tracking-widest font-mono">
                                {{ \Carbon\Carbon::parse($activity->action_time)->format('M d, Y') }}
                            </span>
                        </div>

                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-24 z-10 relative">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-2">No audit logs found</h3>
                        <p class="text-gray-500 font-medium text-sm">You haven't made any recent modifications to the system.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Table Footer / Pagination -->
            <div class="border-t border-white/5 bg-black/40 px-8 py-5 flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-4 text-xs font-black uppercase tracking-widest text-gray-500">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="flex items-center justify-center min-w-[2.5rem] h-10 px-2 rounded-xl bg-[#030303] border border-white/5 text-white shadow-inner">
                        {{ $logs->currentPage() }}
                    </span>
                    <span>of</span>
                    <span class="text-white">{{ $logs->lastPage() }}</span>
                </div>

                <div class="flex items-center gap-3">
                    @if ($logs->onFirstPage())
                        <span class="group flex items-center gap-2 px-6 py-3 bg-[#030303] border border-white/5 rounded-2xl opacity-40 cursor-not-allowed transition-all text-[10px] font-black uppercase tracking-widest text-gray-500 shadow-xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Previous</span>
                        </span>
                    @else
                        <a href="{{ $logs->previousPageUrl() }}" class="group flex items-center gap-2 px-6 py-3 bg-[#030303] border border-white/5 rounded-2xl hover:bg-white/5 transition-all text-[10px] font-black uppercase tracking-widest text-white shadow-xl">
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Previous</span>
                        </a>
                    @endif

                    @if ($logs->hasMorePages())
                        <a href="{{ $logs->nextPageUrl() }}" class="group flex items-center gap-2 px-6 py-3 bg-[#030303] border border-white/5 rounded-2xl hover:bg-white/5 transition-all text-[10px] font-black uppercase tracking-widest text-white shadow-xl">
                            <span>Next</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <span class="group flex items-center gap-2 px-6 py-3 bg-[#030303] border border-white/5 rounded-2xl opacity-40 cursor-not-allowed transition-all text-[10px] font-black uppercase tracking-widest text-gray-500 shadow-xl">
                            <span>Next</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
