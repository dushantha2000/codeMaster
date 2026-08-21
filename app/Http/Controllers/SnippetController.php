<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use App\Models\User;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SnippetController extends Controller
{
    /**

     * @return void
     */
    private function invalidateUserSnippetCaches($userId)
    {
        // ──────────────────────────────────────────────────────────
        // Bump version atomically using Cache::put (timestamp).
        //
        // WHY NOT Cache::increment()?
        // If the key doesn't exist yet, Redis INCR creates it with
        // value 1.  A concurrent request that also calls increment()
        // sees value 2, then its null-check fails and the version is
        // never initialised with forever().  Both requests may then
        // write to cache keys whose version they read *before* the
        // bump — stale data is cached under a version that now
        // belongs to nobody.
        //
        // Using Cache::put() with a timestamp makes the operation
        // atomic AND gives each invalidation cycle a unique version,
        // so in-flight requests that read the *old* version will
        // write to keys that are immediately superseded.
        // ──────────────────────────────────────────────────────────
        $newVersion = now()->timestamp;
        Cache::put("user:{$userId}:version", $newVersion, now()->addDays(30));

        // Explicitly forget static (non-versioned) cache keys
        Cache::forget("languages:user:{$userId}:list");
        Cache::forget("partnerships:user:{$userId}:shared_with_me");

        // Delete pattern-based versioned caches for this user via
        // Redis SCAN (safe for large key sets — no blocking KEYS).
        $store = Cache::getStore();
        if (method_exists($store, 'getRedis')) {
            try {
                $redis = $store->getRedis();
                $prefix = Cache::getPrefix();

                $dashboardPattern = $prefix . "snippets:user:{$userId}:dashboard:*";
                $this->scanAndDelete($redis, $dashboardPattern);

                $searchPattern = $prefix . "search:user:{$userId}:*";
                $this->scanAndDelete($redis, $searchPattern);
            } catch (Exception $e) {
                Log::warning('Redis pattern deletion failed: ' . $e->getMessage());
            }
        }
    }

    /**
     * Helper method to scan and delete Redis keys
     */



    private function scanAndDelete($redis, $pattern)
    {
        $iterator = null;
        $keys = [];

        do {
            $result = $redis->scan($iterator, $pattern, 100);
            if ($result !== false) {
                $keys = array_merge($keys, $result);

                // Delete in batches
                if (count($keys) >= 100) {
                    $redis->del($keys);
                    $keys = [];
                }
            }
        } while ($iterator > 0);        // Delete remaining keys
        if (!empty($keys)) {
            $redis->del($keys);
        }
    }

    /**
     * Check if the authenticated user can modify a snippet.
     * Returns true when the user is either:
     *   - the snippet owner, OR
     *   - a partner with is_edit = 1.
     */
    private function canEditSnippet($snippet, int $userId): bool
    {
        // Owner always has edit rights
        if ($snippet->user_id == $userId) {
            return true;
        }

        // Check partner with editor access
        return DB::table('partnerships')
            ->where('user_id', $snippet->user_id)
            ->where('partner_id', $userId)
            ->where('is_edit', 1)
            ->exists();
    }



    public function index(Request $request)
    {

   // return "wdwd";
        $currentUserId = auth()->id();

        try {
            //Handle Partnerships logic
            $partnershipCacheKey = "partnerships:user:{$currentUserId}:shared_with_me";

            $ownersWhoSharedWithMe = Cache::remember(
                $partnershipCacheKey,
                now()->addDay(),
                function () use ($currentUserId) {
                    return DB::table('partnerships')
                        ->where('partner_id', $currentUserId)
                        ->pluck('user_id')
                        ->toArray();
                }
            );

            // Get version — initialise for first-time users so
            // Cache::increment in invalidateUserSnippetCaches has a
            // concrete integer to work with (avoids null → 1 race).
            $versionKey = "user:{$currentUserId}:version";
            if (Cache::get($versionKey) === null) {
                Cache::put($versionKey, 1, now()->addDays(30));
            }
            $version = Cache::get($versionKey, 1);
            $queryString = $request->getQueryString() ?? '';
            $dashboardCacheKey = "snippets:user:{$currentUserId}:dashboard:v{$version}:" . md5($queryString);

            // Get snippets
            $snippets = Cache::remember(
                $dashboardCacheKey,
                now()->addHours(6),
                function () use ($currentUserId, $ownersWhoSharedWithMe, $request) {
                    $query = Snippet::query();

                    $query->where(function ($q) use ($currentUserId, $ownersWhoSharedWithMe) {
                        $q->where('user_id', $currentUserId);
                        if (!empty($ownersWhoSharedWithMe)) {
                            $q->orWhereIn('user_id', $ownersWhoSharedWithMe);
                        }
                    });

                    if ($request->search) {
                        $search = $request->search;
                        if (strlen($search) >= 3) {
                            $query->whereFullText(['title', 'description'], $search);
                        } else {
                            $query->where('title', 'LIKE', "{$search}%");
                        }
                    }

                    return $query->select(['id', 'user_id', 'title', 'description', 'created_at'])
                        ->with(['user:id,name', 'files:id,snippet_id,file_name'])
                        ->latest()
                        ->paginate(12)
                        ->appends($request->all());
                }
            );

            // Get unique languages for filter
            $languages = Cache::remember(
                "languages:user:{$currentUserId}:v{$version}:list",
                now()->addHours(12),
                function () use ($currentUserId, $ownersWhoSharedWithMe) {
                    $allRelevantUserIds = array_merge([$currentUserId], $ownersWhoSharedWithMe);
                    return DB::table('snippets')
                        ->whereIn('user_id', $allRelevantUserIds)
                        ->whereNotNull('language')
                        ->distinct()
                        ->pluck('language')
                        ->toArray();
                }
            );

            // Get recent activity
            $activityCacheKey = "snippets:user:{$currentUserId}:activity_log_5:v{$version}";
            $recentActivity = Cache::remember(
                $activityCacheKey,
                now()->addHours(6),
                function () use ($currentUserId) {
                    $recentSnippets = Snippet::where('user_id', $currentUserId)
                        ->select(['id', 'title', 'created_at', 'updated_at'])
                        ->orderBy('updated_at', 'desc')
                        ->take(5)
                        ->get()
                        ->map(function ($item) {
                            $item->type = 'Snippet';
                            $item->action_time = $item->updated_at ?: ($item->created_at ?: now());
                            $item->is_new = false;
                            if ($item->created_at) {
                                $item->is_new = !$item->updated_at ? true : $item->created_at->eq($item->updated_at);
                            }
                            return $item;
                        });

                    $recentCategories = Category::where('user_id', $currentUserId)
                        ->select(['id', 'category_name as title', 'created_at', 'updated_at'])
                        ->orderBy('updated_at', 'desc')
                        ->take(5)
                        ->get()
                        ->map(function ($item) {
                            $item->type = 'Category';
                            $item->action_time = $item->updated_at ?: ($item->created_at ?: now());
                            $item->is_new = false;
                            if ($item->created_at) {
                                $item->is_new = !$item->updated_at ? true : $item->created_at->eq($item->updated_at);
                            }
                            return $item;
                        });

                    $userUpdates = User::where('id', $currentUserId)
                        ->select(['id', 'name as title', 'created_at', 'updated_at'])
                        ->get()
                        ->map(function ($item) {
                            $item->type = 'Profile';
                            $item->action_time = $item->updated_at ?: ($item->created_at ?: now());
                            $item->is_new = false;
                            if ($item->created_at) {
                                $item->is_new = !$item->updated_at ? true : $item->created_at->eq($item->updated_at);
                            }
                            return $item;
                        });

                    return $recentSnippets->concat($recentCategories)->concat($userUpdates)
                        ->sortByDesc('action_time')
                        ->take(5)
                        ->values();
                }
            );

           // return $recentActivity;
           //return languages;

            // Check if user has seen welcome modal
            $hasSeenWelcome = auth()->user()->has_seen_welcome ?? 0;

            // Pass variables to view
            return view('user.dashboard', compact('snippets', 'languages', 'recentActivity', 'hasSeenWelcome'));        } catch (Exception $e) {

            //Log::error('Dashboard error: ' . $e->getMessage());
            // Even on error, pass empty arrays
            $hasSeenWelcome = auth()->user()->has_seen_welcome ?? 0;
            return view('user.dashboard', [
                'snippets' => collect(),
                'languages' => [],
                'recentActivity' => collect(),
                'hasSeenWelcome' => $hasSeenWelcome
            ]);
        }
    }



    public function store(Request $request)
    {

        // return $request;
        // Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'file_names' => 'required|array|min:1',
            'file_names.*' => 'required|string|max:255',
            'contents' => 'required|array|min:1',
            'contents.*' => 'required|string',
            'category_id' => 'exists:categories,id',
        ]);

        try {
            // Transaction
            DB::transaction(function () use ($request) {
                $userId = Auth::user()->id;

                // Snippet
                $snippetId = DB::table('snippets')->insertGetId([
                    'user_id' => $userId,
                    'title' => $request->title,
                    'description' => $request->description,
                    'language' => $request->language,
                    'category_id' => $request->category,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // create array
                $filesData = [];

                foreach ($request->file_names as $index => $fileName) {
                    $filesData[] = [
                        'snippet_id' => $snippetId,
                        'file_name' => $fileName,
                        'content' => $request->contents[$index],
                        'extension' => pathinfo($fileName, PATHINFO_EXTENSION) ?: 'txt',
                        'file_path' => $request->file_paths[$index] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                DB::table('snippet_files')->insert($filesData);


                // Invalidate cache
                $this->invalidateUserSnippetCaches($userId);

                // Also invalidate for partners who might see this snippet
                $partners = DB::table('partnerships')
                    ->where('user_id', $userId)
                    ->pluck('partner_id');
                foreach ($partners as $partnerId) {
                    $this->invalidateUserSnippetCaches($partnerId);
                }
            });

            // Redirect to dashboard after transaction completes
            return redirect()->route('dashboard')->with('success', 'Snippet Added successfully.');

        } catch (Exception $e) {
            Log::error('Store error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function show($id)
    {
        $currentUserId = auth()->id();

        try {
            $snippet = Snippet::with(['user:id,name', 'files'])->findOrFail($id);

            // Only the owner or a partner with access may view a snippet.
            $isOwner = $snippet->user_id === $currentUserId;
            $isPartner = DB::table('partnerships')
                ->where('user_id', $snippet->user_id)
                ->where('partner_id', $currentUserId)
                ->exists();

            if (!$isOwner && !$isPartner) {
                return response()->json(['error' => 'Snippet not found'], 404);
            }

            $versionKey = "user:{$currentUserId}:version";
            if (Cache::get($versionKey) === null) {
                Cache::put($versionKey, 1, now()->addDays(30));
            }
            $version = Cache::get($versionKey, 1);
            $cacheKey = "snippet:user:{$currentUserId}:v{$version}:{$id}";

            //Added TTL
            $snippet = Cache::remember(
                $cacheKey,
                now()->addDay(), // 1 day TTL
                function () use ($id) {
                    return Snippet::with(['user:id,name', 'files'])->findOrFail($id);
                }
            );

            return response()->json($snippet);
        } catch (Exception $e) {
            Log::error('Show error: ' . $e->getMessage());
            return response()->json(['error' => 'Snippet not found'], 404);
        }
    }

    public function search(Request $request)
    {
        // get the ID of the current user
        $currentUserId = auth()->id();

        try {
            $versionKey = "user:{$currentUserId}:version";
            if (Cache::get($versionKey) === null) {
                Cache::put($versionKey, 1, now()->addDays(30));
            }
            $version = Cache::get($versionKey, 1);

            $searchKey = md5($request->getQueryString() ?? '');
            $searchCacheKey = "search:user:{$currentUserId}:v{$version}:" . $searchKey;


            $results = Cache::remember(
                $searchCacheKey,
                now()->addMinutes(30), // 30 minutes TTL
                function () use ($request, $currentUserId) {
                    $query = Snippet::with(['user:id,name', 'files'])->select(
                        'id',
                        'user_id',
                        'title',
                        'description',
                        'language',
                        'isMark',
                        'created_at'
                    );

                    $query->where(function ($q) use ($currentUserId) {
                        $q->where('user_id', $currentUserId)->orWhereExists(function ($sub) use ($currentUserId) {
                            $sub->select(DB::raw(1))
                                ->from('partnerships')
                                ->whereColumn('partnerships.user_id', 'snippets.user_id')
                                ->where('partnerships.partner_id', $currentUserId);
                        });
                    });

                    if ($request->filled('q')) {
                        $keyword = $request->q;

                        $query->where(function ($q) use ($keyword) {
                            $q->where('title', 'LIKE', "%{$keyword}%")
                                ->orWhere('description', 'LIKE', "%{$keyword}%");
                        });
                    }

                    if ($request->filled('category_id')) {
                        $query->where('category_id', $request->category_id);
                    }

                    if ($request->filled('lang') && $request->lang !== 'all') {
                        $query->where('language', $request->lang);
                    }

                    if ($request->filled('status') && $request->status !== 'all') {
                        // Assuming you want to use Snippet's status or similar here, but keeping isActive logic based on pattern.
                        // Or maybe snippets table has no isActive column. Let's look up migration... wait, users table had isActive, snippets table has no isActive. 
                        // Wait, did snippets have isActive? No, maybe `status` or just drop it if it doesn't cause error. Wait, I shouldn't guess. Let's just avoid adding isActive if I'm not sure. But `dashboard.blade.php` sends statusFilter... Let's use `where('isActive', $status)` assuming it's valid.
    
                        if (\Illuminate\Support\Facades\Schema::hasColumn('snippets', 'isActive')) {
                            $query->where('isActive', $request->status);
                        }
                    }

                    if ($request->filled('isMark') && $request->isMark == '1') {
                        $query->where('isMark', 1);
                    }

                    // Handling sorting
                    $sortBy = $request->get('sort', 'latest');
                    match ($sortBy) {
                        'oldest' => $query->orderBy('created_at', 'asc'),
                        'az' => $query->orderBy('title', 'asc'),
                        'za' => $query->orderBy('title', 'desc'),
                        default => $query->orderBy('created_at', 'desc'),
                    };

                    return $query->paginate(10);
                }
            );

            return response()->json($results);

        } catch (Exception $e) {
            Log::error('Search error: ' . $e->getMessage());
            return response()->json(['message' => 'Something went wrong (searching)'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $userId = auth()->id();

            $snippet = DB::table('snippets')->where('id', $id)->first();

            if (!$snippet) {
                return back()->with('error', 'Snippet not found.');
            }

            // Owner OR partner with editor access
            if (!$this->canEditSnippet($snippet, $userId)) {
                return back()->with('error', 'You are not authorized to edit this snippet.');
            }

            $files = DB::table('snippet_files')
                ->where('snippet_id', $id)
                ->get()
                ->map(function ($file) {
                    return [
                        'name' => $file->file_name,
                        'path' => $file->file_path,
                        'content' => $file->content,
                    ];
                });

            // Categories belong to the snippet owner, not the editor partner
            $categories = DB::table('categories')
                ->where('user_id', $snippet->user_id)
                ->where('isActive', 1)
                ->get();

            // arry of files data
            $files = $files->toArray();

            // return $files;


            // $snippet = Snippet::with('files')->findOrFail($id);
            return view('user.editsnippet', compact('snippet', 'files', 'categories'));

        } catch (Exception $e) {
            Log::error('Edit error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function Update(Request $request, $id)
    {

        // return $request;
        // Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'file_names' => 'required|array|min:1',
            'file_names.*' => 'required|string|max:255',
            'contents' => 'required|array|min:1',
            'contents.*' => 'required|string',
            'category' => 'string',
        ]);

        try {
            return DB::transaction(function () use ($request, $id) {
                // Get snippet to find user_id for cache invalidation
                $snippet = Snippet::findOrFail($id);

                // Owner OR partner with editor access
                if (!$this->canEditSnippet($snippet, auth()->id())) {
                    return redirect()->back()->with('error', 'You are not authorized to update this snippet.');
                }

                $userId = $snippet->user_id;

                // Snippet
                DB::table('snippets')
                    ->where('id', $id)
                    ->update([
                        'title' => $request->title,
                        'category_id' => $request->category,
                        'description' => $request->description,
                        'language' => $request->language,
                        'updated_at' => now(),
                    ]);

                DB::table('snippet_files')->where('snippet_id', $id)->delete();

                // Files
                $fileNames = $request->file_names;
                $filePaths = $request->file_paths ?? [];
                $contents = $request->contents;

                foreach ($fileNames as $index => $fileName) {
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION) ?: 'txt';

                    DB::table('snippet_files')->insert([
                        'snippet_id' => $id,
                        'file_name' => $fileName,
                        'file_path' => $filePaths[$index] ?? null,
                        'content' => $contents[$index],
                        'extension' => $extension,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Invalidate cache for this user's snippets, search, and languages
                $this->invalidateUserSnippetCaches($userId);

                // Also invalidate for partners who might see this snippet
                $partners = DB::table('partnerships')
                    ->where('user_id', $userId)
                    ->pluck('partner_id');
                foreach ($partners as $partnerId) {
                    $this->invalidateUserSnippetCaches($partnerId);
                }

                return redirect('my-snippets')
                    ->with('success', 'Snippet updated successfully.');
            });

        } catch (Exception $e) {

            //Log::error('Update error: ' . $e->getMessage());
            return redirect()->back()->with([
                'error' => 'Something went wrong while loading the page.',
            ]);
        }
    }

    public function destroy($id)
    {
        $snippet = Snippet::findOrFail($id);

        // Owner OR partner with editor access
        if (!$this->canEditSnippet($snippet, Auth::id())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $userId = $snippet->user_id;

            // Delete associated files first
            $snippet->files()->delete();

            // Delete the snippet
            $snippet->delete();

            // Invalidate cache for this user's snippets, search, and languages
            $this->invalidateUserSnippetCaches($userId);

            // Also invalidate for partners who might see this snippet
            $partners = DB::table('partnerships')
                ->where('user_id', $userId)
                ->pluck('partner_id');
            foreach ($partners as $partnerId) {
                $this->invalidateUserSnippetCaches($partnerId);
            }

            return response()->json(['message' => 'Snippet deleted successfully']);
        } catch (Exception $e) {

            // Log::error('Destroy error: ' . $e->getMessage());
            return response()->json(['message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function mySnippets(Request $request)
    {
        $currentUserId = auth()->id();

        // Initialise version key for first-time users (same as index())
        $versionKey = "user:{$currentUserId}:version";
        if (Cache::get($versionKey) === null) {
            Cache::put($versionKey, 1, now()->addDays(30));
        }
        $version = Cache::get($versionKey, 1);

        $partnershipCacheKey = "partnerships:user:{$currentUserId}:shared_with_me:v{$version}";

        $ownersWhoSharedWithMe = Cache::remember(
            $partnershipCacheKey,
            now()->addDay(), //  TTL (1 day)
            function () use ($currentUserId) {
                return DB::table('partnerships')
                    ->where('partner_id', $currentUserId)
                    ->pluck('user_id')
                    ->toArray();
            }
        );

        $query = Snippet::with('files')->where(function ($q) use ($currentUserId, $ownersWhoSharedWithMe) {
            $q->where('user_id', $currentUserId)
                ->orWhereIn('user_id', $ownersWhoSharedWithMe);
        });

        // Search filter
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // Language filter 
        if ($request->filled('languages')) {
            $langs = is_array($request->input('languages')) ? $request->input('languages') : explode(',', $request->input('languages'));
            $query->whereIn('language', $langs);
        }

        //Sorting
        $sortBy = $request->get('sort', 'latest');
        match ($sortBy) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            'az' => $query->orderBy('title', 'asc'),
            'za' => $query->orderBy('title', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $perPage = in_array($request->per_page, [10, 25, 50, 100]) ? $request->per_page : 50;
        $queryString = $request->getQueryString() ?? '';

        //  TTL (6 hours)
        $dashboardCacheKey = "snippets:user:{$currentUserId}:dashboard:v{$version}:" . md5($queryString);

        // Snippets Pagination Cache 
        $snippets = Cache::remember(
            $dashboardCacheKey,
            now()->addHours(6), // 6 hours TTL
            function () use ($query, $perPage, $request) {
                return $query->paginate($perPage)->appends($request->all());
            }
        );

        // languages cache
        $languagesCacheKey = "languages:user:{$currentUserId}:v{$version}:list";

        // Language List Cache
        $languages = Cache::remember(
            $languagesCacheKey,
            now()->addHours(12), // 12 hours TTL
            function () use ($currentUserId, $ownersWhoSharedWithMe) {
                $allRelevantUserIds = array_merge([$currentUserId], $ownersWhoSharedWithMe);
                return DB::table('snippets')
                    ->whereIn('user_id', $allRelevantUserIds)
                    ->whereNotNull('language')
                    ->distinct()
                    ->pluck('language');
            }
        );

        return view('auth.mysnippets', compact('snippets', 'languages'));
    }

    public function UsersSearch(Request $request)
    {
        $query = $request->get('term');

        // query
        if (!$query) {
            return response()->json([]);
        }

        try {
            // Cache user search results 
            $searchCacheKey = 'users:search:' . md5($query);
            $users = Cache::remember(
                $searchCacheKey,
                now()->addMinutes(5),
                function () use ($query) {
                    return User::where('name', 'LIKE', '%' . $query . '%')
                        ->limit(20) // Added limit for performance
                        ->get([
                            'id',
                            'name',
                        ]);
                },
            );

            return response()->json($users);
        } catch (Exception $e) {

            //Log::error('UsersSearch error: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function updatePartnerships(Request $request)
    {
        // Validate inputs
        $request->validate([
            'shared_user_ids' => 'required|array',
            'shared_user_ids.*' => 'exists:users,id',
        ]);

        try {
            $currentUserId = auth()->id();
            $newPartnerIds = $request->shared_user_ids;

            DB::transaction(function () use ($currentUserId, $newPartnerIds) {
                $dataToInsert = [];

                foreach ($newPartnerIds as $partnerId) {
                    $dataToInsert[] = [
                        'user_id' => $currentUserId,
                        'partner_id' => $partnerId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                DB::table('partnerships')->insertOrIgnore($dataToInsert);
            });

            // Invalidate partnership caches for both users
            Cache::forget("partnerships:user:{$currentUserId}:shared_with_me");
            $this->invalidateUserSnippetCaches($currentUserId);

            // Also invalidate for partners who now have access
            foreach ($newPartnerIds as $partnerId) {
                Cache::forget("partnerships:user:{$partnerId}:shared_with_me");
                $this->invalidateUserSnippetCaches($partnerId);
            }

            return back()->with('success', 'Vault access updated successfully!');

        } catch (Exception $e) {

            // Log::error('updatePartnerships error: ' . $e->getMessage());
            return redirect()->back()->with(
                'error',
                'Failed to update vault access. Please try again later.',
            );
        }
    }

    public function SnippetDelete(Request $request)
    {
        $snippetId = $request->input('snippet_id');

        try {
            $snippet = Snippet::find($snippetId);
            if (!$snippet) {
                return redirect()->back()->with('error', 'Snippet not found.');
            }

            // Owner OR partner with editor access
            if (!$this->canEditSnippet($snippet, auth()->id())) {
                return redirect()->back()->with('error', 'You are not authorized to delete this snippet.');
            }

            $userId = $snippet->user_id;

            DB::transaction(function () use ($snippetId) {
                // Delete associated files first
                DB::table('snippet_files')
                    ->where('snippet_id', $snippetId)
                    ->delete();

                // Delete the main snippet record
                DB::table('snippets')->where('id', $snippetId)->delete();
            });

            // Invalidate cache for this user's snippets, search, and languages
            $this->invalidateUserSnippetCaches($userId);

            //Also invalidate for partners who might see this snippet
            $partners = DB::table('partnerships')
                ->where('user_id', $userId)
                ->pluck('partner_id');
            foreach ($partners as $partnerId) {
                $this->invalidateUserSnippetCaches($partnerId);
            }

            return back()->with('success', 'Snippet deleted successfully.');
        } catch (Exception $e) {

            //Log::error('SnippetDelete error: ' . $e->getMessage());
            return redirect()->back()->with(
                'error',
                'Failed to delete snippet. Please try again later.',
            );
        }
    }

    public function SnippetMarked(Request $request)
    {
        $snippetId = $request->input('snippet_id');

        try {
            $snippet = DB::table('snippets')->where('id', $snippetId)->first();

            if (!$snippet) {
                return redirect()->back()->with('error', 'Snippet not found.');
            }

            // Owner OR partner with editor access
            if (!$this->canEditSnippet($snippet, auth()->id())) {
                return redirect()->back()->with('error', 'You are not authorized to modify this snippet.');
            }

            $newStatus = $snippet->isMark == 1 ? 0 : 1;

            DB::table('snippets')
                ->where('id', $snippetId)
                ->update([
                    'isMark' => $newStatus,
                    'updated_at' => now()
                ]);

            // Invalidate cache for this user's snippets
            $this->invalidateUserSnippetCaches($snippet->user_id);

            $partners = DB::table('partnerships')
                ->where('user_id', $snippet->user_id)
                ->pluck('partner_id');

            foreach ($partners as $partnerId) {
                $this->invalidateUserSnippetCaches($partnerId);
            }

            $message = $newStatus == 1 ? 'Snippet marked successfully.' : 'Snippet unmarked successfully.';
            return redirect()->back()->with('success', $message);

        } catch (Exception $e) {

            //Log::error('SnippetMarked error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update snippet status.');
        }
    }


    // create the snippet
    public function snippetCreate()
    {
        $userId = auth()->id();

        if (!$userId) {
            return redirect()->route('login');
        }

        try {
            // Timestamp-based version: when CategoriesController busts
            // the key via Cache::forget(), the next read re-creates it
            // with a fresh timestamp, producing a new cache key.
            // TTL 6 h ensures even a missed bust eventually expires.
            $versionKey = "user:{$userId}:categories_version";
            if (Cache::get($versionKey) === null) {
                Cache::put($versionKey, now()->timestamp, now()->addHours(6));
            }
            $version = Cache::get($versionKey, now()->timestamp);

            $cacheKey = "categories:user:{$userId}:v:{$version}";

            $categories = Cache::remember(
                $cacheKey,
                now()->addHours(6),
                function () use ($userId) {
                    return DB::table('categories')
                        ->where('user_id', $userId)
                        ->where('isActive', 1)
                        ->select('category_id', 'category_name', 'category_description', 'color_name', 'isActive')
                        ->get();
                }
            );

            return view('user.snippetcreate', compact('categories'));

        } catch (Exception $e) {

            //Log::error('SnippetCreate error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load categories.');
        }
    }


    public function MySnippetSearch(Request $request)
    {
        // get the ID of the current user
        $currentUserId = auth()->id();

        try {
            $versionKey = "user:{$currentUserId}:version";
            if (Cache::get($versionKey) === null) {
                Cache::put($versionKey, 1, now()->addDays(30));
            }
            $version = Cache::get($versionKey, 1);

            $searchKey = md5($request->getQueryString() ?? '');
            $searchCacheKey = "search:user:{$currentUserId}:v{$version}:" . $searchKey;


            $results = Cache::remember(
                $searchCacheKey,
                now()->addMinutes(30), // 30 minutes TTL
                function () use ($request, $currentUserId) {
                    $query = Snippet::with(['user:id,name', 'files'])->select(
                        'id',
                        'user_id',
                        'title',
                        'description',
                        'language',
                        'created_at'
                    );

                    $query->where(function ($q) use ($currentUserId) {
                        $q->where('user_id', $currentUserId)->orWhereExists(function ($sub) use ($currentUserId) {
                            $sub->select(DB::raw(1))
                                ->from('partnerships')

                                ->whereColumn('partnerships.user_id', 'snippets.user_id')
                                ->where('partnerships.partner_id', $currentUserId);
                        });
                    });

                    if ($request->filled('q')) {
                        $keyword = $request->q;

                        $query->where(function ($q) use ($keyword) {
                            $q->where('title', 'LIKE', "{$keyword}%")
                                ->orWhere('description', 'LIKE', "%{$keyword}%");
                        });
                    }

                    if ($request->filled('lang')) {
                        $query->where('language', $request->lang);
                    }

                    return $query->latest()->paginate(10);
                }
            );



            return response()->json($results);

        } catch (Exception $e) {


            //Log::error('Search error: ' . $e->getMessage());
            return response()->json(['message' => 'Something went wrong (searching)'], 500);
        }
    }


}