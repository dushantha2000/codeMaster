<!DOCTYPE html>
<html lang="en" class="scroll-smooth antialiased dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>CodeVault | The Intelligent Snippet Engine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">


    <style>
        body {
            background-color: #0a0a0a;
            color: #ffffff;
            overflow-x: hidden;
             font-family: 'Space Grotesk', sans-serif;
        }

        /* The Google / Gemini Aurora Background */
        .aurora-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            overflow: hidden;
            background: #000;
        }

        .aurora-blob {
            position: absolute;
            filter: blur(80px);
            opacity: 0.4;
            animation: aurora-move 20s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
        }

        .blob-1 {
            width: 80vw;
            height: 80vh;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.25) 0%, rgba(0, 0, 0, 0) 70%);
            top: -20%;
            left: -10%;
            animation-delay: 0s;
        }

        .blob-2 {
            width: 70vw;
            height: 70vh;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.15) 0%, rgba(0, 0, 0, 0) 70%);
            bottom: -20%;
            right: -10%;
            animation-delay: -5s;
        }

        .blob-3 {
            width: 60vw;
            height: 60vh;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, rgba(0, 0, 0, 0) 70%);
            top: 40%;
            left: 40%;
            animation-delay: -10s;
        }

        @keyframes aurora-move {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(5%, 5%) scale(1.1);
            }

            100% {
                transform: translate(-5%, -5%) scale(0.95);
            }
        }

        /* Typography Mastery */
        .text-hero {
            font-size: clamp(3rem, 8vw, 6.5rem);
            line-height: 1.05;
            letter-spacing: -0.04em;
            background: linear-gradient(180deg, #FFFFFF 0%, #A1A1AA 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-hero-blue {
            background: linear-gradient(135deg, #60A5FA 0%, #2563EB 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* High-End Glassmorphism */
        .glass-panel {
            background: rgba(10, 10, 10, 0.5);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .glass-card {
            background: linear-gradient(145deg, rgba(20, 20, 20, 0.6) 0%, rgba(5, 5, 5, 0.8) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.8), 0 0 40px rgba(59, 130, 246, 0.1);
        }

        /* Premium Buttons */
        .btn-super {
            position: relative;
            background: #ffffff;
            color: #000000;
            border-radius: 100px;
            font-weight: 700;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.1), 0 4px 14px 0 rgba(255, 255, 255, 0.15);
        }

        .btn-super:hover {
            transform: scale(1.02);
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.4);
            background: #f8fafc;
        }

        .btn-ghost {
            color: #ffffff;
            border-radius: 100px;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Grid floor */
        .floor-grid {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50vh;
            background-size: 50px 50px;
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            transform: perspective(500px) rotateX(60deg) translateY(100px);
            mask-image: linear-gradient(to top, black, transparent);
            -webkit-mask-image: linear-gradient(to top, black, transparent);
            z-index: -1;
            pointer-events: none;
        }

        /* Editor Chrome */
        .editor-chrome {
            background: #0A0A0A;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .editor-header {
            background: rgba(255, 255, 255, 0.02);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 12px 16px;
            display: flex;
            align-items: center;
        }

        /* Pricing Card Glow */
        .pricing-glow {
            position: absolute;
            inset: 0;
            border-radius: 24px;
            padding: 2px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6, #0ea5e9);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .pro-tier:hover .pricing-glow {
            opacity: 1;
        }

        .code-typing::after {
            content: '|';
            animation: blink 1s step-end infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }
    </style>
</head>

<body class="selection:bg-blue-500/30 selection:text-white">

    <!-- Aurora Background -->
    <div class="aurora-container">
        <div class="aurora-blob blob-1"></div>
        <div class="aurora-blob blob-2"></div>
        <div class="aurora-blob blob-3"></div>
        <div class="floor-grid"></div>
    </div>

    <!-- Smart Header -->
    <header class="fixed top-0 w-full z-50 transition-all duration-300" id="main-nav">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <!-- Logo -->
                <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('logo/mainlogo.png') }}" alt="CodeVault Logo"
                        class="w-full h-full object-contain transform scale-125">
                </div>

                <h1 class="text-base md:text-xl font-bold text-white tracking-tight ">
                    CodeVault

                </h1>
            </a>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-super px-6 py-2.5 text-sm">
                        Open Vault
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-gray-300 hover:text-white transition-colors mr-2">
                        Sign in
                    </a>
                    <a href="{{ url('register') }}" class="btn-super px-6 py-2.5 text-sm">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="relative z-10">

        <!-- Hero Section -->
        <section class="min-h-screen flex flex-col items-center justify-center pt-24 px-6 text-center relative"
            id="hero">
            <div class="max-w-5xl mx-auto">

                <!-- backgound image add -->
                <img src="{{ asset('logo/hero.png') }}" alt=""
                    class="absolute inset-0 w-full h-full object-cover opacity-30">

                <h1 class="text-hero font-black mb-6 gs-reveal">
                    Code intelligence.<br />
                    <span class="text-hero-blue drop-shadow-2xl">Perfectly organized.</span>
                </h1>

                <p class="text-xl md:text-2xl text-gray-400 mb-12 max-w-2xl mx-auto font-medium gs-reveal">
                    A world-class snippet engine engineered for elite developers. Store, optimize, and search your
                    engineering knowledge instantly.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 gs-reveal">
                    <a href="{{ url('register') }}"
                        class="btn-super px-10 py-4 text-lg flex items-center justify-center gap-2 group">
                        Start building for free
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#interface" class="btn-ghost px-10 py-4 text-lg">
                        See how it works
                    </a>
                </div>
            </div>


        </section>

        <!-- Social Proof Section -->
        <section class="py-12 border-y border-white/5 bg-black/40 backdrop-blur-lg relative z-10" id="metrics">
            <div class="max-w-7xl mx-auto px-6">
                <p class="text-center text-sm font-semibold text-gray-500 uppercase tracking-widest mb-8">Trusted by
                    elite developers worldwide</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-white/10">
                    <div class="px-4 gs-metric">
                        <div class="text-3xl font-black text-white mb-1">1000+</div>
                        <div class="text-sm font-medium text-gray-400">Snippets Indexed</div>
                    </div>
                    <div class="px-4 gs-metric">
                        <div class="text-3xl font-black text-white mb-1">12ms</div>
                        <div class="text-sm font-medium text-gray-400">Avg Search Latency</div>
                    </div>
                    <div class="px-4 gs-metric">
                        <div class="text-3xl font-black text-white mb-1">99.99%</div>
                        <div class="text-sm font-medium text-gray-400">Uptime SLA</div>
                    </div>
                    <div class="px-4 gs-metric">
                        <div class="text-3xl font-black text-white mb-1">250+</div>
                        <div class="text-sm font-medium text-gray-400">Active Users</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Full Interface Preview Section -->
        <section id="interface" class="py-32 relative bg-[#050505]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16 max-w-4xl mx-auto gs-reveal">
                    <h2 class="text-4xl md:text-5xl font-black tracking-tight mb-4">A workstation, <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">not a
                            website.</span></h2>
                    <p class="text-lg text-gray-400">CodeVault is engineered to feel like a native desktop application.
                        Instant navigation, deeply integrated shortcuts, and a distraction-free dark mode.</p>
                </div>

                <!-- Massive Interface Mockup -->
                <div class="glass-panel rounded-2xl overflow-hidden gs-reveal">
                    <div class="flex h-[600px]">
                        <!-- image -->
                        <img src="{{ asset('logo/main.png') }}" alt="CodeVault Logo" class="w-full h-full object-contain ">
                    </div>
                </div>
            </div>
        </section>

        <!-- Sticky Scroll Features Section -->
        <section id="features" class="relative bg-black pt-32 pb-32 border-t border-white/5">
            <div class="max-w-7xl mx-auto px-6">

                <div class="text-center mb-24 max-w-4xl mx-auto gs-reveal">
                    <h2 class="text-4xl md:text-6xl font-black tracking-tight mb-6">Designed for speed.<br /><span
                            class="text-gray-600">Engineered for scale.</span></h2>
                    <p class="text-xl text-gray-400">Everything you need to write better code, faster. Integrated
                        directly into your workflow.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center mb-32 gs-feature">
                    <div class="order-2 lg:order-1">


                        <h3 class="text-4xl font-black mb-6 tracking-tight">AI-Powered Refactoring</h3>
                        <p class="text-xl text-gray-400 leading-relaxed mb-8">
                            Stop debating best practices. Select any snippet and our intelligence engine will instantly
                            refactor it for performance, security, and readability.
                        </p>
                        <ul class="space-y-4 font-medium text-lg text-gray-300">
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center"><svg
                                        class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg></div> Automatic error handling
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center"><svg
                                        class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg></div> Cyclomatic complexity reduction
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center"><svg
                                        class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg></div> Inline documentation generation
                            </li>
                        </ul>
                    </div>
                    <div
                        class="order-1 lg:order-2  rounded-3xl p-2 h-[450px] relative overflow-hidden flex items-center justify-center group">
                        <img src="{{ asset('logo/bot.png') }}" alt=""
                            class="absolute inset-0 w-full h-full object-cover">
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center gs-feature">
                <!-- image -->
                 <img src="{{ asset('logo/bot.png') }}" alt="CodeVault Logo" class="w-full h-full object-contain ">
                <div>
                    <div
                        class="w-16 h-16 rounded-2xl  flex items-center justify-center mb-8  shadow-[0_0_20px_rgba(139,92,246,0.1)]">
                        <img src="{{ asset('logo/mainlogo.png') }}" alt="CodeVault Logo"
                            class="w-full h-full object-contain ">
                    </div>
                    <h3 class="text-4xl font-black mb-6 tracking-tight">Instant Discovery</h3>
                    <p class="text-xl text-gray-400 leading-relaxed mb-8">
                        A global command palette built for speed. Instantly search across your personal vault and shared
                        team repositories with millisecond latency.
                    </p>
                    <ul class="space-y-4 font-medium text-lg text-gray-300">
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-purple-500/20 flex items-center justify-center"><svg
                                    class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg></div> Fuzzy search algorithms
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-purple-500/20 flex items-center justify-center"><svg
                                    class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg></div> Language-specific filtering
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-purple-500/20 flex items-center justify-center"><svg
                                    class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg></div> Full AST parsing
                        </li>
                    </ul>
                </div>
            </div>

            </div>
        </section>

        <!-- The Bento Grid -->
        <section class="py-32 bg-[#050505] border-t border-white/5 relative z-10">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 gs-reveal">

                    <div class="glass-card rounded-3xl p-10 flex flex-col justify-between group h-[320px]">
                        <div>
                            <div
                                class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black mb-3">Military-grade Security</h3>
                            <p class="text-gray-400 font-medium">All snippets are encrypted at rest using AES-256.
                                Zero-knowledge architecture ensures your IP stays yours.</p>
                        </div>
                    </div>

                    <div class="glass-card rounded-3xl p-10 flex flex-col justify-between group h-[320px]">
                        <div>
                            <div
                                class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black mb-3">Team Collaboration</h3>
                            <p class="text-gray-400 font-medium">Share specific folders with granular RBAC permissions.
                                Collaborate on massive codebases flawlessly.</p>
                        </div>
                    </div>

                    <div class="glass-card rounded-3xl p-10 flex flex-col justify-between group h-[320px]">
                        <div>
                            <div
                                class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black mb-3">Syntax Perfection</h3>
                            <p class="text-gray-400 font-medium">Automatic syntax highlighting for over 50 languages
                                with custom themes and intelligent formatting.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="py-32 bg-black border-t border-white/5 relative">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-20 gs-reveal">
                    <h2 class="text-4xl md:text-5xl font-black tracking-tight mb-4">Simple, transparent pricing.</h2>
                    <p class="text-lg text-gray-400">Start for free, scale when you need to.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 gs-reveal">
                    <!-- Free Tier -->
                    <div class="glass-card rounded-3xl p-8 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-300 mb-2">Hobby</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-black text-white">$0</span>
                            <span class="text-gray-500">/mo</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-8 pb-8 border-b border-white/10">Perfect for individual
                            developers building side projects.</p>
                        <ul class="space-y-4 mb-8 flex-1 text-gray-300 text-sm font-medium">
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> Up to 500 snippets</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> Basic search</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> Community support</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn-ghost w-full py-3 text-center text-sm">Get
                            Started</a>
                    </div>

                    <!-- Pro Tier -->
                    <div
                        class="glass-card rounded-3xl p-8 flex flex-col relative pro-tier transform md:-translate-y-4 shadow-2xl border-blue-500/30">
                        <div class="pricing-glow pointer-events-none"></div>
                        <div class="absolute top-0 right-8 transform -translate-y-1/2">
                            <span
                                class="bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Most
                                Popular</span>
                        </div>
                        <h3 class="text-xl font-bold text-blue-400 mb-2">Pro</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-black text-white">$12</span>
                            <span class="text-gray-500">/mo</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-8 pb-8 border-b border-white/10">For professional engineers
                            who want AI-powered tools.</p>
                        <ul class="space-y-4 mb-8 flex-1 text-gray-200 text-sm font-medium">
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-blue-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> Unlimited snippets</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-blue-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> Instant global search</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-blue-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> AI Refactoring Engine</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-blue-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> Priority support</li>
                        </ul>
                        <a href="{{ route('register') }}"
                            class="btn-super w-full py-3 text-center text-sm shadow-[0_0_15px_rgba(59,130,246,0.4)]">Start
                            14-Day Free Trial</a>
                    </div>

                    <!-- Enterprise Tier -->
                    <div class="glass-card rounded-3xl p-8 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-300 mb-2">Enterprise</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-black text-white">Custom</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-8 pb-8 border-b border-white/10">Dedicated infrastructure for
                            engineering teams.</p>
                        <ul class="space-y-4 mb-8 flex-1 text-gray-300 text-sm font-medium">
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-purple-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> Team Collaboration features</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-purple-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> Custom RBAC & SSO</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-purple-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg> On-premise deployment options</li>
                        </ul>
                        <a href="#" class="btn-ghost w-full py-3 text-center text-sm">Contact Sales</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Huge CTA Section -->
        <section class="py-40 bg-[#050505] relative overflow-hidden border-t border-white/5">
            <!-- Aurora glow specifically for CTA -->
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-600/20 rounded-full blur-[120px] pointer-events-none">
            </div>

            <div class="max-w-4xl mx-auto px-6 text-center relative z-10 gs-reveal">
                <h2 class="text-5xl md:text-7xl font-black tracking-tight mb-8 drop-shadow-lg">Ready to elevate
                    <br />your workflow?
                </h2>
                <p class="text-xl md:text-2xl text-gray-400 mb-12 font-medium">Join thousands of developers centralizing
                    their knowledge.</p>
                <a href="{{ url('register') }}"
                    class="btn-super px-12 py-5 text-xl inline-flex items-center justify-center gap-3 shadow-[0_0_40px_rgba(59,130,246,0.3)] hover:shadow-[0_0_60px_rgba(59,130,246,0.5)]">
                    Create Your Free Vault
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="border-t border-white/10 bg-black pt-16 pb-8 relative z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-white flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-white">CodeVault</span>
                </div>
                <div class="flex gap-8 text-sm font-semibold text-gray-400">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                    <a href="#" class="hover:text-white transition-colors">Documentation</a>
                </div>
            </div>
            <div
                class="pt-8 border-t border-white/10 text-center md:text-left flex flex-col md:flex-row justify-between text-sm font-semibold text-gray-600">
                <p>&copy; {{ date('Y') }} CodeVault. All rights reserved.</p>
                <p class="mt-2 md:mt-0">Engineered for perfection.</p>
            </div>
        </div>
    </footer>

    <!-- GSAP Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            // Navbar scroll effect
            window.addEventListener('scroll', () => {
                const nav = document.getElementById('main-nav');
                if (window.scrollY > 50) {
                    nav.classList.add('glass-panel');
                    nav.style.borderBottom = '1px solid rgba(255,255,255,0.05)';
                } else {
                    nav.classList.remove('glass-panel');
                    nav.style.borderBottom = 'none';
                }
            });

            // Hero Animation
            const heroTl = gsap.timeline();
            heroTl.fromTo(".gs-reveal",
                { y: 40, opacity: 0 },
                { y: 0, opacity: 1, duration: 1, stagger: 0.1, ease: "power3.out" }
            )
                .fromTo(".gs-mockup",
                    { y: 100, opacity: 0, scale: 0.95 },
                    { y: 0, opacity: 1, scale: 1, duration: 1.5, ease: "power4.out" },
                    "-=0.6"
                );

            // Metrics
            gsap.fromTo(".gs-metric",
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: "#metrics",
                        start: "top 85%",
                    }
                }
            );

            // General section reveal
            gsap.utils.toArray('.gs-reveal').forEach(elem => {
                // skip if already animated by hero
                if (elem.closest('#hero')) return;

                gsap.fromTo(elem,
                    { y: 50, opacity: 0 },
                    {
                        y: 0,
                        opacity: 1,
                        duration: 1,
                        ease: "power3.out",
                        scrollTrigger: {
                            trigger: elem,
                            start: "top 85%",
                        }
                    }
                );
            });

            // Feature Sections scroll animations
            gsap.utils.toArray('.gs-feature').forEach(feature => {
                gsap.fromTo(feature,
                    { y: 80, opacity: 0 },
                    {
                        y: 0,
                        opacity: 1,
                        duration: 1,
                        ease: "power3.out",
                        scrollTrigger: {
                            trigger: feature,
                            start: "top 80%",
                        }
                    }
                );
            });
        });
    </script>
</body>

</html>