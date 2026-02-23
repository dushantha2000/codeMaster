<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance | CodeVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #0a0a0a;
            overflow-y: auto;
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .image-glow-orange {
            background: radial-gradient(circle at center, rgba(249, 115, 22, 0.15) 0%, transparent 70%);
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(249, 115, 22, 0.2);
            }
            50% {
                box-shadow: 0 0 40px rgba(249, 115, 22, 0.4);
            }
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="text-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-lg">
        <div class="glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10">
            <!-- Left Side - Visual -->
            <div class="relative bg-black/40 p-12 overflow-hidden image-glow-orange">
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-orange-600/10 rounded-full blur-3xl"></div>
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-600/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 text-center">
                    <div class="mb-6 inline-block p-5 bg-orange-500/10 rounded-2xl border border-orange-500/20 pulse-glow">
                        <svg class="w-20 h-20 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-4">We'll Be Back Soon!</h2>
                    <p class="text-gray-400 leading-relaxed">We're currently performing some scheduled maintenance to improve your experience.</p>
                </div>
            </div>

            <!-- Right Side - Content -->
            <div class="p-8 md:p-10 text-center">
                <!-- Logo -->
                <div class="flex items-center justify-center gap-2 mb-6">
                    <div class="w-10 h-10 bg-black-600 rounded-lg flex items-center justify-center shadow-lg shadow-orange-600/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight">CodeVault</h1>
                </div>

                <!-- Status Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-orange-500/10 border border-orange-500/30 rounded-full mb-6">
                    <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                    <span class="text-xs font-medium text-orange-400 uppercase tracking-wider">Under Maintenance</span>
                </div>

                <!-- Message -->
                <p class="text-gray-400 text-sm mb-8 max-w-sm mx-auto">
                    Our team is working hard to bring you an even better experience. This should only take a few moments.
                </p>

                <!-- Estimated Time -->
                @if(isset($retryAfter) && $retryAfter > 0)
                    <div class="bg-white/5 rounded-xl p-4 mb-6">
                        <p class="text-xs text-gray-500 mb-1">Estimated Time</p>
                        <p class="text-lg font-semibold text-white">{{ $retryAfter }} minutes</p>
                    </div>
                @endif

                <!-- Contact Link -->
                <div class="text-sm text-gray-500">
                    <p>Need urgent assistance?</p>
                    <a href="mailto:support@codevault.com" class="text-orange-400 hover:text-orange-300 transition-colors">
                        Contact Support
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-gray-600 text-xs mt-6">
            © {{ date('Y') }} CodeVault. All rights reserved.
        </p>
    </div>

</body>

</html>
