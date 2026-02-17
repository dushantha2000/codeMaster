<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SnippetController extends Controller
{
    /**
     * Invalidate all snippet-related caches for a user
     *
     * @return void
     */
    private function invalidateUserSnippetCaches($userId)
    {
        //Update the Version 
        Cache::forever("user:{$userId}:version", time());
        // Forget specific static keys
        Cache::forget("languages:user:{$userId}:list");
        // Forget partnership caches
        Cache::forget("partnerships:user:{$userId}:shared_with_me");
    }

    public function index(Request $request)
    {
        //return $request;
        $currentUserId = auth()->id();
        // 1. Handle Partnerships (Shared with me) logic
        $partnershipCacheKey = "partnerships:user:{$currentUserId}:shared_with_me";

        //return $partnershipCacheKey;

        $ownersWhoSharedWithMe = Cache::get($partnershipCacheKey);

       // return $ownersWhoSharedWithMe;

        if (!$ownersWhoSharedWithMe) {

      //  return $ownersWhoSharedWithMe;
            try {
                // Fetching from DB if not in Cache
                $ownersWhoSharedWithMe = DB::table('partnerships')
                    ->where('partner_id', $currentUserId)
                    ->pluck('user_id')
                    ->toArray();

                // Store in Cache for 15 minutes
                Cache::put($partnershipCacheKey, $ownersWhoSharedWithMe, now()->addMinutes(15));
               // return $ownersWhoSharedWithMe;


            } catch (Exception $e) {
               $ownersWhoSharedWithMe = [];
            }
        }

        //Prepare Cache Key for Snippets Dashboard
        $queryString = $request->getQueryString() ?? '';

        $dashboardCacheKey = "snippets:user:{$currentUserId}:dashboard:" . md5($queryString);

       // return $dashboardCacheKey;

        // 3. Handle Snippets Data Retrieval with Cache Check
        $snippets = Cache::get($dashboardCacheKey);

       // return $snippets;

        if (!$snippets) {
            // Build the Snippet Query
            $query = Snippet::query();

            // Filter: Own snippets OR snippets shared by partners
            $query->where(function ($q) use ($currentUserId, $ownersWhoSharedWithMe) {
                $q->where('user_id', $currentUserId);
                if (!empty($ownersWhoSharedWithMe)) {
                    $q->orWhereIn('user_id', $ownersWhoSharedWithMe);
                }
            });

          //  return $query;



            // Search Logic: Apply when search query exists
            if ($request->search) {
                $search = $request->search;
                if (strlen($search) >= 3) {
                    $query->whereFullText(['title', 'description'], $search);
                } else {
                    $query->where('title', 'LIKE', "{$search}%");
                }
            }

            //$query = Snippet::query();

            // Finalize query with relations and pagination
            $snippets = $query->select(['id', 'user_id', 'title', 'description', 'created_at'])
                ->with(['user:id,name', 'files:id,snippet_id,file_name'])
                ->latest()
                ->cursorPaginate(20);


           // return $snippets;

            // Store fetched snippets in Cache for 5 minutes
            Cache::put($dashboardCacheKey, $snippets, now()->addMinutes(5));
        }

        // 4. Return the View with Data
        return view('user.dashboard', compact('snippets'));
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'file_names' => 'required|array|min:1',
            'file_names.*' => 'required|string|max:255',
            'contents' => 'required|array|min:1',
            'contents.*' => 'required|string',
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


                // $fileNames = $request->file_names;
                // $filePaths = $request->file_paths ?? [];
                // $contents = $request->contents;

                // foreach ($fileNames as $index => $fileName) {
                //     $extension = pathinfo($fileName, PATHINFO_EXTENSION) ?: 'txt';

                //     DB::table('snippet_files')->insert([
                //         'snippet_id' => $snippetId,
                //         'file_name' => $fileName,
                //         'file_path' => $filePaths[$index] ?? null,
                //         'content' => $contents[$index],
                //         'extension' => $extension,
                //         'created_at' => now(),
                //         'updated_at' => now(),
                //     ]);
                // }

                // Invalidate cache
                $this->invalidateUserSnippetCaches($userId);
            });

            // Redirect to dashboard after transaction completes
            return redirect()->route('dashboard')->with('success', 'Snippet Added successfully.');

            

        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function show($id)
    {
        $currentUserId = auth()->id();
        $cacheKey = "snippet:user:{$currentUserId}:{$id}";

        $snippet = Cache::remember($cacheKey, now()->addMinutes(2), function () use ($id) {
            return Snippet::with(['user:id,name', 'files'])->findOrFail($id);
        });

         return response()->json($snippet);


        // try {

        //     $snippet = Snippet::with('files')->findOrFail($id);
        //     return response()->json($snippet);

        // } catch (Exception $e) {
        //     return back()->with('error', 'Something went wrong. Please try again later.');
        // }
    }




    public function search(Request $request)
    {
        // get the ID of the current user
        $currentUserId = auth()->id();

        //give Version Number to user to invalidate cache
        $version = Cache::rememberForever("user:{$currentUserId}:version", fn() => time());

        //  return $version;

        // Create a unique code for the current search
        $searchKey = md5($request->getQueryString() ?? '');
        // v:{$version} 
        $searchCacheKey = "search:user:{$currentUserId}:v:{$version}:" . $searchKey;

        $results = Cache::remember(
            $searchCacheKey,
            now()->addMinutes(2),
            function () use ($request, $currentUserId) {
                $query = Snippet::with(['user:id,name', 'files'])->select(
                    'id',
                    'user_id',
                    'title',
                    'description',
                    'language',
                    'created_at',
                );

                $query->where(function ($q) use ($currentUserId) {
                    $q->where('user_id', $currentUserId)->orWhereExists(
                        function ($sub) use ($currentUserId) {
                            $sub->select(DB::raw(1))
                                ->from('partnerships')
                                ->whereColumn(
                                    'partnerships.user_id',
                                    'snippets.user_id',
                                )
                                ->where(
                                    'partnerships.partner_id',
                                    $currentUserId,
                                );
                        },
                    );
                });

                // Keyword Search - Full-text search
                if ($request->filled('q')) {
                    $keyword = $request->q;
                    $query->where(function ($q) use ($keyword) {
                        $q->where('title', 'LIKE', "{$keyword}%")->orWhere(
                            'description',
                            'LIKE',
                            "%{$keyword}%",
                        );
                    });
                }

                if ($request->filled('lang')) {
                    $query->where('language', $request->lang);
                }

                return $query->latest()->paginate(20);
            },
        );

         //return $results;

        return response()->json($results);
    }

    public function edit($id)
    {
        try {
            $snippet = Snippet::with('files')->findOrFail($id);
            return view('user.editsnippet', compact('snippet'));

        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function Update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'file_names' => 'required|array|min:1',
            'file_names.*' => 'required|string|max:255',
            'contents' => 'required|array|min:1',
            'contents.*' => 'required|string',
        ]);

        try {
            return DB::transaction(function () use ($request, $id) {
                // Get snippet to find user_id for cache invalidation
                $snippet = Snippet::findOrFail($id);
                $userId = $snippet->user_id;

                // Snippet
                DB::table('snippets')
                    ->where('id', $id)
                    ->update([
                        'title' => $request->title,
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
                    $extension =
                        pathinfo($fileName, PATHINFO_EXTENSION) ?: 'txt';

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
            return back()->with([
                'error' => 'Something went wrong while loading the page.',
            ]);
        }
    }

    public function destroy($id)
    {
        $snippet = Snippet::findOrFail($id);

        // Check if the snippet belongs to the authenticated user
        if ($snippet->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

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
    }

    public function mySnippets(Request $request)
    {
        $currentUserId = auth()->id();

        $version = Cache::rememberForever("user:{$currentUserId}:version", fn() => time());
        // 1. Cache partnership lookups
        $partnershipCacheKey = "partnerships:user:{$currentUserId}:shared_with_me:v:{$version}";
        $ownersWhoSharedWithMe = Cache::remember(
            $partnershipCacheKey,
            now()->addMinutes(15),
            function () use ($currentUserId) {
                return DB::table('partnerships')
                    ->where('partner_id', $currentUserId)
                    ->pluck('user_id')
                    ->toArray();
            },
        );

        $query = Snippet::with('files')->where(function ($q) use ($currentUserId, $ownersWhoSharedWithMe) {
            $q->where('user_id', $currentUserId)
                ->orWhereIn('user_id', $ownersWhoSharedWithMe);
        });

        // 3. Search filter
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // 4. Language filter (Multiple Support)
        if ($request->filled('languages')) {
            $langs = is_array($request->input('languages')) ? $request->input('languages') : explode(',', $request->input('languages'));
            $query->whereIn('language', $langs);
        }

        // 5. Sorting
        $sortBy = $request->get('sort', 'latest');
        match ($sortBy) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            'az' => $query->orderBy('title', 'asc'),
            'za' => $query->orderBy('title', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $perPage = in_array($request->per_page, [10, 25, 50, 100]) ? $request->per_page : 50;
        $queryString = $request->getQueryString() ?? '';
        // 6. Cache snippets (Added 5 min TTL instead of 0)
        $dashboardCacheKey = "snippets:user:{$currentUserId}:dashboard:v:{$version}:" . md5($queryString);

        $snippets = Cache::remember($dashboardCacheKey, now()->addMinutes(5), function () use ($query, $perPage, $request) {
            return $query->paginate($perPage)->appends($request->all());
        });

        // 7. Language List Cache (Include shared owners so filters show their languages too)
        $languagesCacheKey = "languages:user:{$currentUserId}:list";
        $languages = Cache::remember($languagesCacheKey, now()->addHour(), function () use ($currentUserId, $ownersWhoSharedWithMe) {
            $allRelevantUserIds = array_merge([$currentUserId], $ownersWhoSharedWithMe);

            return DB::table('snippets')
                ->whereIn('user_id', $allRelevantUserIds)
                ->whereNotNull('language')
                ->distinct()
                ->pluck('language');
        });

        return view('auth.mysnippets', compact('snippets', 'languages'));
    }

    public function UsersSearch(Request $request)
    {
        $query = $request->get('term');

        // query
        if (!$query) {
            return response()->json([]);
        }

        // Cache user search results (5 minutes TTL)
        $searchCacheKey = 'users:search:' . md5($query);
        $users = Cache::remember(
            $searchCacheKey,
            now()->addMinutes(5),
            function () use ($query) {
                return User::where('name', 'LIKE', '%' . $query . '%')->get([
                    'id',
                    'name',
                ]);
            },
        );

        return response()->json($users);
    }

    public function updatePartnerships(Request $request)
    {
        // Validate inputs
        $request->validate([
            'shared_user_ids' => 'required|array',
            'shared_user_ids.*' => 'exists:users,id',
        ]);

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
    }

    public function SnippetDelete(Request $request)
    {
        $snippetId = $request->input('snippet_id');

        try {
            // Get snippet before deletion to find user_id for cache invalidation
            $snippet = Snippet::find($snippetId);
            $userId = $snippet ? $snippet->user_id : auth()->id();

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

            // Also invalidate for partners who might see this snippet
            $partners = DB::table('partnerships')
                ->where('user_id', $userId)
                ->pluck('partner_id');
            foreach ($partners as $partnerId) {
                $this->invalidateUserSnippetCaches($partnerId);
            }

            return back()->with('success', 'Snippet deleted successfully.');
        } catch (Exception $e) {
            return back()->with(
                'error',
                'Failed to delete snippet. Please try again later.',
            );
        }
    }
}
