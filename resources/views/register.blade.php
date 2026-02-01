<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | CodeVault</title>
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
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        }
    </style>
</head>
<body class="text-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="flex flex-col md:flex-row-reverse w-full max-w-4xl glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10" x-data="registerForm()" x-cloak>
        
        <div class="hidden md:flex md:w-1/2 relative bg-black/40 items-center justify-center p-12 overflow-hidden border-l border-white/5 image-glow">
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-block p-4 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0014 4c-5.523 0-10 4.477-10 10 0 1.253.23 2.452.65 3.558L4 20l3.558-.65a9.963 9.963 0 003.558.65l.054-.09"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">Code Storage Redefined.</h2>
                <p class="text-gray-400 leading-relaxed text-sm">Join thousands of developers keeping their logic safe and organized.</p>
            </div>
            <div class="absolute w-64 h-64 border border-white/5 rounded-full -top-20 -right-20"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col justify-center">
            
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <div class="bg-white/10 p-1.5 rounded-lg border border-white/10 text-blue-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight hide-on-mobile">CodeVault <span
                    class="text-blue-500 text-xs font-normal">v1.0</span></h1>
                </div>
                <h1 class="text-2xl font-bold text-white">Create Account</h1>
                <p class="text-gray-500 text-sm mt-1">Start your journey with us today.</p>
            </div>

            <form action="" method="POST" class="space-y-3.5">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1 ml-1">Username</label>
                    <input type="text" placeholder="JohnDoe_1" class="input-field w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1 ml-1">Email</label>
                    <input type="email" placeholder="name@company.com" class="input-field w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1 ml-1">Password</label>
                        <input type="password" placeholder="••••••••" class="input-field w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1 ml-1">Confirm</label>
                        <input type="password" placeholder="••••••••" class="input-field w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600">
                    </div>
                </div>

                <div class="flex items-center py-1">
                    <input type="checkbox" id="terms" class="w-3.5 h-3.5 rounded border-gray-700 bg-black text-blue-600 focus:ring-0">
                    <label for="terms" class="ml-2 text-[11px] text-gray-500">
                        I agree to the <a href="#" class="text-blue-400 hover:underline">Terms of Service</a>
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 mt-2">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center border-t border-white/5 pt-4">
                <p class="text-gray-500 text-xs">
                    Already have an account? 
                    <a href="#" class="text-blue-400 hover:text-blue-300 font-semibold ml-1">Sign in</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function registerForm() {
            return {
                // Alpine.js logic
            }
        }
    </script>
</body>
</html>