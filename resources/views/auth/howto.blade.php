@extends('auth.master')

@section('title', 'How to Use CodeVault')

@section('content')
    <div class="w-full max-w-4xl mx-auto px-4 py-10 space-y-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ url('/dashboard') }}"
               class="group p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 text-gray-400 hover:text-white transition-all shadow-xl">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">How to Use CodeVault</h1>
                <p class="text-gray-400 text-sm font-medium">
                    A quick guide to saving, organizing, and sharing your code snippets.
                </p>
            </div>
        </div>

        <div class="glass-card rounded-3xl p-6 md:p-8 space-y-6">
            <div class="flex items-start gap-4">
                <div
                    class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400 text-sm font-black">
                    1
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-white mb-1">Sign up and log in</h2>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Create an account from the register page, then log in with your email and password.
                        After login you will land on the <span class="text-blue-400 font-semibold">Dashboard</span>,
                        which is your main view of all snippets.
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div
                    class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400 text-sm font-black">
                    2
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-white mb-1">Create a new snippet</h2>
                    <p class="text-sm text-gray-400 leading-relaxed mb-2">
                        From the Dashboard or My Snippets, click the
                        <span class="text-blue-400 font-semibold">New / Create Snippet</span> button.
                        You will see the snippet editor where you can:
                    </p>
                    <ul class="text-sm text-gray-300 space-y-1 list-disc list-inside">
                        <li>Give the snippet a <span class="font-semibold">title</span> and short description.</li>
                        <li>Choose a <span class="font-semibold">language</span> (Laravel, PHP, JS, etc.).</li>
                        <li>Add one or more <span class="font-semibold">files</span> to the snippet
                            (e.g. <code class="text-xs bg-white/10 px-1 rounded">web.php</code>,
                            <code class="text-xs bg-white/10 px-1 rounded">Controller.php</code>).
                        </li>
                    </ul>
                    <p class="text-sm text-gray-400 mt-2">
                        When you are ready, click <span class="text-green-400 font-semibold">Save</span> to store the
                        snippet in your vault.
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div
                    class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400 text-sm font-black">
                    3
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-white mb-1">Browse and search your vault</h2>
                    <p class="text-sm text-gray-400 leading-relaxed mb-2">
                        The Dashboard shows your snippets as interactive cards. You can:
                    </p>
                    <ul class="text-sm text-gray-300 space-y-1 list-disc list-inside">
                        <li>Use the <span class="font-semibold">search bar</span> to find snippets by title or description.</li>
                        <li>Filter by <span class="font-semibold">language</span> using the language dropdown.</li>
                        <li>Click a card to open the <span class="font-semibold">preview panel</span> and inspect all files.</li>
                        <li>Copy code for a file using the <span class="font-semibold">Copy Code</span> button.</li>
                    </ul>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div
                    class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400 text-sm font-black">
                    4
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-white mb-1">Manage your snippets</h2>
                    <p class="text-sm text-gray-400 leading-relaxed mb-2">
                        Open the <span class="text-blue-400 font-semibold">My Snippets</span> page to see a table view
                        of only your own snippets.
                    </p>
                    <ul class="text-sm text-gray-300 space-y-1 list-disc list-inside">
                        <li>Click the <span class="font-semibold">edit</span> icon to update the title, description,
                            language, or files.</li>
                        <li>Use the <span class="font-semibold">delete</span> button to remove a snippet (with a safety
                            confirmation modal).</li>
                        <li>Use the built-in <span class="font-semibold">pagination and filters</span> to navigate large
                            collections.</li>
                    </ul>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div
                    class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400 text-sm font-black">
                    5
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-white mb-1">Share access with partners</h2>
                    <p class="text-sm text-gray-400 leading-relaxed mb-2">
                        From your <span class="text-blue-400 font-semibold">Profile / Partnerships</span> page you can
                        give other users access to your vault:
                    </p>
                    <ul class="text-sm text-gray-300 space-y-1 list-disc list-inside">
                        <li>Search for users by name and add them as partners.</li>
                        <li>Partners can see snippets you have shared with them in their Dashboard.</li>
                        <li>Remove a partner at any time to revoke access.</li>
                    </ul>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div
                    class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400 text-sm font-black">
                    6
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-white mb-1">Use CodeVault from an extension</h2>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        CodeVault exposes a secure API using Laravel Sanctum. Extensions or external tools can:
                    </p>
                    <ul class="text-sm text-gray-300 space-y-1 list-disc list-inside mt-1">
                        <li>Send a login request to get an <span class="font-semibold">API token</span>.</li>
                        <li>Call the <span class="font-semibold">snippets API</span> to fetch your snippets and files
                            directly inside your editor or browser.</li>
                    </ul>
                    <p class="text-sm text-gray-400 mt-2">
                        This lets you reuse your CodeVault snippets wherever you work, without copying them manually.
                    </p>
                </div>
            </div>

            <div class="border-t border-white/5 pt-5 mt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <p class="text-xs text-gray-500 uppercase tracking-[0.2em] font-semibold">
                    TIP: You can always come back to this guide at <span class="text-gray-300">/how-to-use-codevault</span>.
                </p>
                <a href="{{ url('/dashboard') }}"
                   class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs px-4 py-2.5 rounded-xl font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 12h14M5 12l4-4m-4 4l4 4"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection

