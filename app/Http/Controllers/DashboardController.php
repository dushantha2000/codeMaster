<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use App\Models\Category;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

    /**
     * Display the dashboard index.
     */
    public function index(Request $request)
    {

   // return $request;
        $user = Auth::user();
        
        // Get statistics
        $totalSnippets = Snippet::where('user_id', $user->id)->count();
        $totalCategories = Category::where('user_id', $user->id)->count();
        $totalFiles = \App\Models\SnippetFile::whereHas('snippet', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();
        
        // Get recent snippets
        $recentSnippets = Snippet::where('user_id', $user->id)
            ->with(['user:id,name', 'files'])
            ->latest()
            ->take(5)
            ->get();
        
        // Get top languages
        $topLanguages = Snippet::where('user_id', $user->id)
            ->select('language')
            ->groupBy('language')
            ->selectRaw('language, count(*) as count')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'language')
            ->toArray();
        
        return view('dashboard.index', compact(
            'totalSnippets',
            'totalCategories', 
            'totalFiles',
            'recentSnippets',
            'topLanguages'
        ));
    }

    /**
     * Display the user profile.
     */
    public function profile(Request $request)
    {
        $user = Auth::user();
        $totalSnippets = Snippet::where('user_id', $user->id)->count();
        
        return view('dashboard.profile', compact('totalSnippets'));
    }

    /**
     * Display the settings page.
     */
    public function settings(Request $request)
    {
        $user = Auth::user();
        $apiKeys = $user->apiKeys()->orderBy('created_at', 'desc')->get();
        
        return view('dashboard.settings', compact('apiKeys'));
    }
    
    /**
     * Update user settings.
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'theme' => 'nullable|in:light,dark,system',
            'editor_theme' => 'nullable|string|max:50',
            'tab_size' => 'nullable|integer|min:2|max:8',
            'email_notifications' => 'nullable|boolean',
            'comment_notifications' => 'nullable|boolean',
            'marketing_emails' => 'nullable|boolean',
            'public_profile' => 'nullable|boolean',
            'public_snippets' => 'nullable|boolean',
            'usage_analytics' => 'nullable|boolean',
        ]);
        
        // Update user settings
        $user->update([
            'theme' => $validated['theme'] ?? $user->theme ?? 'system',
            'editor_theme' => $validated['editor_theme'] ?? $user->editor_theme ?? 'github-dark',
            'tab_size' => (int) ($validated['tab_size'] ?? $user->tab_size ?? 2),
            'email_notifications' => $request->has('email_notifications'),
            'comment_notifications' => $request->has('comment_notifications'),
            'marketing_emails' => $request->has('marketing_emails'),
            'public_profile' => $request->has('public_profile'),
            'public_snippets' => $request->has('public_snippets'),
            'usage_analytics' => $request->has('usage_analytics'),
        ]);
        
        return redirect()->route('dashboard.settings')->with('success', 'Settings updated successfully!');
    }
    
    /**
     * Create a new API key.
     */
    public function createApiKey(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        
        $user = Auth::user();
        
        // Generate the API key
        $plainKey = ApiKey::generateKey();
        $prefix = ApiKey::generatePrefix();
        $keyHash = ApiKey::hashKey($plainKey);
        
        // Create the API key record
        $apiKey = ApiKey::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'key_prefix' => $prefix,
            'key_hash' => $keyHash,
            'is_active' => true,
        ]);
        
        return redirect()->route('dashboard.settings')
            ->with('success', 'API key created successfully!')
            ->with('api_key', $plainKey)
            ->with('api_key_id', $apiKey->id);
    }
    
    /**
     * Delete an API key.
     */
    public function deleteApiKey(Request $request, $id)
    {
        $user = Auth::user();
        
        $apiKey = ApiKey::where('user_id', $user->id)->findOrFail($id);
        $apiKey->delete();
        
        return redirect()->route('dashboard.settings')->with('success', 'API key deleted successfully!');
    }
    
    /**
     * Toggle API key status.
     */
    public function toggleApiKey(Request $request, $id)
    {
        $user = Auth::user();
        
        $apiKey = ApiKey::where('user_id', $user->id)->findOrFail($id);
        $apiKey->update([
            'is_active' => !$apiKey->is_active
        ]);
        
        return redirect()->route('dashboard.settings')->with('success', 'API key status updated!');
    }
}
