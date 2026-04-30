@extends('layout.auth')

@section('title', 'Enable Two-Factor Authentication')

@section('content')
    <div class="flex flex-col md:flex-row w-full max-w-4xl   overflow-hidden shadow-2xl"
        >

        <div class="w-full p-8 md:p-12 flex flex-col justify-center">

            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-white">Enable Two-Factor Authentication</h1>
                <p class="text-gray-500 text-sm mt-2">Scan the QR code below with your Google Authenticator app and enter the 6-digit code to verify.</p>
            </div>

            <div class="flex justify-center mb-6">
                <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-200">
                    {!! $qrCodeImage !!}
                </div>
            </div>
            
            <div class="text-center mb-6">
                <p class="text-xs text-gray-400">Secret Key: <span class="text-white font-mono tracking-widest">{{ $secret }}</span></p>
                <p class="text-[10px] text-gray-500 mt-1">If you can't scan the QR code, manually enter the secret key above into your app.</p>
            </div>

            <form action="{{ route('2fa.verify') }}" method="POST" class="space-y-4 max-w-sm mx-auto w-full">
                {{ csrf_field() }}

                @if (session('error'))
                    <div
                        class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 animate-pulse">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Verification Code</label>
                    <input type="text" name="code" required placeholder="123456"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 text-center font-mono tracking-[0.5em]">
                    @error('code')
                        <p class="mt-1 ml-1 text-[10px] text-red-400 ">{{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full btn-primary py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 mt-4">
                    Verify & Enable
                </button>
            </form>
            
            <div class="mt-8 text-center">
                <a href="{{ route('settings') }}" class="text-gray-500 text-xs hover:text-white transition-colors">Cancel</a>
            </div>
        </div>
    </div>
@endsection
