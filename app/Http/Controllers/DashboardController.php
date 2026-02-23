<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard index.
     */
    public function index(Request $request)
    {
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
        return view('dashboard.settings');
    }
}
