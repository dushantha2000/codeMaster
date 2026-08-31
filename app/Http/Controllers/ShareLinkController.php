<?php

namespace App\Http\Controllers;

use App\Models\ShareLink;
use App\Models\Snippet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ShareLinkController extends Controller
{
    /**
     * Create a new public share link for a snippet (owner only).
     */
    public function create(Request $request, $snippetId)
    {
        $snippet = Snippet::findOrFail($snippetId);

        abort_unless($snippet->user_id === auth()->id(), 403);

        $request->validate([
            'password' => 'nullable|string|min:4|max:255',
            'expires_in_days' => 'nullable|integer|min:1|max:365',
        ]);

        try {
            // The raw token is the credential (capability URL) — only its hash is stored.
            $token = Str::random(32);

            $link = ShareLink::create([
                'snippet_id' => $snippet->id,
                'token_hash' => hash('sha256', $token),
                'password' => $request->filled('password') ? Hash::make($request->password) : null,
                'expires_at' => $request->filled('expires_in_days')
                    ? now()->addDays((int) $request->expires_in_days)
                    : null,
            ]);

            return response()->json([
                'id' => $link->id,
                'url' => route('share.show', $token),
                'expires_at' => $link->expires_at,
                'has_password' => $link->password !== null,
            ]);
        } catch (Exception $e) {
            Log::error('Share link create error: '.$e->getMessage());

            return response()->json(['message' => 'Failed to create share link.'], 500);
        }
    }

    /**
     * List the share links for a snippet (owner only).
     */
    public function index($snippetId)
    {
        $snippet = Snippet::findOrFail($snippetId);

        abort_unless($snippet->user_id === auth()->id(), 403);

        $links = ShareLink::where('snippet_id', $snippet->id)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($link) => [
                'id' => $link->id,
                'created_at' => $link->created_at,
                'expires_at' => $link->expires_at,
                'views_count' => $link->views_count,
                'has_password' => $link->password !== null,
                'expired' => $link->isExpired(),
            ]);

        return response()->json($links);
    }

    /**
     * Revoke a share link (owner only).
     */
    public function destroy($id)
    {
        $link = ShareLink::findOrFail($id);

        abort_unless($link->snippet->user_id === auth()->id(), 403);

        $link->delete();

        return response()->json(['message' => 'Share link revoked successfully.']);
    }

    /**
     * Public view of a shared snippet. The token itself is the credential,
     * so no authentication is required to reach this route.
     */
    public function show($token)
    {
        $link = ShareLink::where('token_hash', hash('sha256', $token))->first();

        if (! $link || ! $link->snippet || ! $link->snippet->isActive) {
            return response()->view('share.expired', ['reason' => 'revoked'], 404);
        }

        if ($link->isExpired()) {
            return response()->view('share.expired', ['reason' => 'expired'], 404);
        }

        // Password gate — unlocked once per browser session.
        if ($link->password && ! session('share_access:'.$token)) {
            return view('share.password', ['token' => $token]);
        }

        $link->increment('views_count');

        // Key the cache on the snippet's own updated_at: editing the snippet
        // changes the key automatically, so visitors always see fresh content.
        $cacheKey = 'share:'.$token.':v'.$link->snippet->updated_at->timestamp;

        $snippet = Cache::remember($cacheKey, now()->addDay(), function () use ($link) {
            return $link->snippet()->with(['user:id,name', 'files'])->first();
        });

        return view('share.show', ['snippet' => $snippet, 'token' => $token]);
    }

    /**
     * Verify the password for a protected share link.
     */
    public function unlock(Request $request, $token)
    {
        $request->validate(['password' => 'required|string']);

        $link = ShareLink::where('token_hash', hash('sha256', $token))->first();

        if (! $link || $link->isExpired() || ! $link->snippet) {
            return redirect()->route('share.show', $token);
        }

        if ($link->password && Hash::check($request->password, $link->password)) {
            session(['share_access:'.$token => true]);

            return redirect()->route('share.show', $token);
        }

        return back()->with('error', 'Incorrect password. Please try again.');
    }
}
