@extends('layout.share')

@section('title', 'Link Unavailable')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="glass-card rounded-3xl p-10 text-center border border-white/10">
                <div
                    class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-white/10">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636a9 9 0 010 12.728m-12.728 0a9 9 0 010-12.728m9.9 2.829a5 5 0 010 7.07m-7.072 0a5 5 0 010-7.07M13 12h.01" />
                    </svg>
                </div>
                <h1 class="text-2xl font-black text-white tracking-tight mb-2">This link is no longer available</h1>
                <p class="text-gray-500 text-sm leading-relaxed">
                    @if (isset($reason) && $reason === 'expired')
                        This share link has expired. Please ask the owner to generate a new one.
                    @else
                        This share link may have been revoked or the snippet no longer exists.
                    @endif
                </p>
                <a href="{{ url('/') }}"
                    class="inline-block mt-8 px-6 py-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-sm font-bold transition-all">
                    Go to CodeVault
                </a>
            </div>
        </div>
    </div>
@endsection
