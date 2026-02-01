<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | CodeVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #0a0a0a;
            overflow-y: auto;
        }

        [x-cloak] { display: none !important; }

        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.2s ease;
        }

        .input-field:focus {
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(255, 255, 255, 0.07);
            outline: none;
        }

        .image-glow {
            background: radial-gradient(circle at center, rgba(239, 68, 68, 0.08) 0%, transparent 70%);
        }
    </style>
</head>
<body class="text-gray-100 flex items-center justify-center min-h-screen p-4" x-data="forgotPassword()" x-cloak>

    <div class="flex flex-col md:flex-row w-full max-w-4xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10">
        
        <div class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-r border-white/5 image-glow">
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-block p-4 bg-red-500/10 rounded-2xl border border-red-500/20">
                    <svg class="w-16 h-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Password Recovery</h2>
                <p class="text-gray-400 leading-relaxed">Don't worry, it happens to the best of us. Let's get you back into your vault.</p>
            </div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-red-600/5 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <div class="bg-white/10 p-1.5 rounded-lg border border-white/10 text-blue-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile">CodeVault <span
                    class="text-blue-500 text-xs font-normal">v1.0</span></h1>
                </div>
                <h1 class="text-2xl font-bold text-white">Forgot Password?</h1>
                <p class="text-gray-500 text-sm mt-1">Enter your email and we'll send reset instructions.</p>
            </div>

            <form action="" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="dev@codevault.com" 
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600">
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 mt-2">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-8 flex flex-col items-center gap-4">
                <a href="{{ route('login') }}" class="flex items-center gap-2 text-xs text-gray-400 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Login
                </a>
                
                <p class="text-gray-600 text-[11px] text-center max-w-[250px]">
                    If you don't receive an email within 5 minutes, please check your spam folder.
                </p>
            </div>
        </div>
    </div>

    <script>
        function forgotPassword() {
            return {
                // Alpine.js logic can be added here
            }
        }
    </script>
</body>
</html>