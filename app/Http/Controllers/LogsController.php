<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class LogsController extends Controller
{
    public function index(Request $request)
    {
        $currentUserId = auth()->id();

        try {
            // Define the base query for snippets
            $snippets = DB::table('snippets')
                ->select(
                    'id',
                    'title',
                    'created_at',
                    'updated_at',
                    DB::raw("'Snippet' as type"),
                    DB::raw("COALESCE(updated_at, created_at, NOW()) as action_time"),
                    DB::raw("CASE WHEN updated_at IS NULL OR created_at = updated_at THEN 1 ELSE 0 END as is_new")
                )
                ->where('user_id', $currentUserId);

            // Define the base query for categories
            $categories = DB::table('categories')
                ->select(
                    'id',
                    'category_name as title',
                    'created_at',
                    'updated_at',
                    DB::raw("'Category' as type"),
                    DB::raw("COALESCE(updated_at, created_at, NOW()) as action_time"),
                    DB::raw("CASE WHEN updated_at IS NULL OR created_at = updated_at THEN 1 ELSE 0 END as is_new")
                )
                ->where('user_id', $currentUserId);

            // Define the base query for the user profile
            $profile = DB::table('users')
                ->select(
                    'id',
                    'name as title',
                    'created_at',
                    'updated_at',
                    DB::raw("'Profile' as type"),
                    DB::raw("COALESCE(updated_at, created_at, NOW()) as action_time"),
                    DB::raw("CASE WHEN updated_at IS NULL OR created_at = updated_at THEN 1 ELSE 0 END as is_new")
                )
                ->where('id', $currentUserId);

            // Combine the queries using unionAll and paginate at the database level
            $logs = $snippets->unionAll($categories)
                ->unionAll($profile)
                ->orderBy('action_time', 'desc')
                ->paginate(15);

            return view('user.logs', compact('logs'));
        } catch (Exception $e) {
            //Log::error('LogsController DB Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
