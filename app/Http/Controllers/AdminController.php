<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Snippet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Check if user is admin.
     */
    private function isAdmin()
    {
        return Auth::check() && Auth::user()->is_admin;
    }

    /**
     * Display the admin dashboard.
     */
    public function index(Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        // Get platform statistics
        $stats = [
            'total_users' => User::count(),
            'total_snippets' => Snippet::count(),
            'total_categories' => Category::count(),
            'storage_used' => $this->calculateStorageUsed(),
        ];

        // Get recent users
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.index', compact('stats', 'recentUsers'));
    }

    /**
     * Display the users management page.
     */
    public function users(Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $users = User::latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Display the snippets management page.
     */
    public function snippets(Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $snippets = Snippet::with('user')->latest()->paginate(20);

        return view('admin.snippets', compact('snippets'));
    }

    /**
     * Display the analytics page.
     */
    public function analytics(Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        return view('admin.analytics');
    }

    /**
     * Calculate total storage used.
     */
    private function calculateStorageUsed()
    {
        // Calculate storage based on snippet content
        $totalBytes = Snippet::sum(\DB::raw('LENGTH(content)'));
        
        if ($totalBytes < 1024) {
            return $totalBytes . ' B';
        } elseif ($totalBytes < 1024 * 1024) {
            return round($totalBytes / 1024, 2) . ' KB';
        } elseif ($totalBytes < 1024 * 1024 * 1024) {
            return round($totalBytes / (1024 * 1024), 2) . ' MB';
        } else {
            return round($totalBytes / (1024 * 1024 * 1024), 2) . ' GB';
        }
    }
}
