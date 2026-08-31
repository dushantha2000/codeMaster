@extends('layout.share')

@section('title', 'Protected Snippet')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="glass-card rounded-3xl p-8 border border-white/10">
                <div class="text-center mb-6">
                    <div
                        class=" flex items-center justify-center mx-auto mb-4 ">
                        <img src="{{ asset('logo/mainlogo.png') }}" alt="Logo" class="w-24 h-24 object-contain">
                    </div>
                    <h1 class="text-xl font-black text-white tracking-tight">Protected Snippet</h1>
                    <p class="text-gray-500 text-sm mt-1">Enter the password to view this snippet.</p>
                </div>

                <form method="POST" action="{{ route('share.unlock', $token) }}" class="space-y-4">
                    @csrf
                    <input type="password" name="password" required placeholder="Password"
                        class="w-full input-field rounded-xl px-4 py-3 text-sm placeholder-gray-600">
                    <button type="submit"
                        class="w-full py-3 rounded-xl btn-primary text-sm font-bold transition-all active:scale-[0.98]">
                        Unlock Snippet
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
