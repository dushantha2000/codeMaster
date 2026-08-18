@extends('layout.share')

@section('title', 'Protected Snippet')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="glass-card rounded-3xl p-8 border border-white/10">
                <div class="text-center mb-6">
                    <div
                        class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/10">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-black text-white tracking-tight">Protected Snippet</h1>
                    <p class="text-gray-500 text-sm mt-1">Enter the password to view this snippet.</p>
                </div>

                <form method="POST" action="{{ route('share.unlock', $token) }}" class="space-y-4">
                    @csrf
                    <input type="password" name="password" required placeholder="Password"
                        class="w-full input-field rounded-xl px-4 py-3 text-sm placeholder-gray-600">
                    <button type="submit"
                        class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold transition-all active:scale-[0.98]">
                        Unlock Snippet
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
