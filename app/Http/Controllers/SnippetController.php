<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Snippet;
use App\Models\SnippetFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class SnippetController extends Controller
{
    /**
     * Invalidate all snippet-related caches for a user
     * 
     * @param int $userId
     * @return void
     */
    private function invalidateUserSnippetCaches(int $userId)
    {
        // Delete specific known cache keys
        Cache::forget("languages:user:{$userId}:list");
        
        // Try to delete snippet and search caches by pattern if Redis is available
        $store = Cache::getStore();
        if (method_exists($store, 'getRedis')) {
            try {
                $redis = $store->getRedis();
                $prefix = Cache::getPrefix();
                
                // Delete snippet caches
                $pattern = $prefix . "snippets:user:{$userId}:*";
                $keys = $redis->keys($pattern);
                if (!empty($keys)) {
                    $redis->del($keys);
                }
                
                // Delete search caches
                $pattern = $prefix . "search:user:{$userId}:*";
                $keys = $redis->keys($pattern);
                if (!empty($keys)) {
                    $redis->del($keys);
                }
            } catch (Exception $e) {
                // If Redis pattern matching fails, just continue
                // Cache will expire naturally via TTL
            }
        }
    }

    public function index(Request $request)
    {
        $currentUserId = auth()->id();
        
        // Cache partnership lookups (15 minutes TTL)
        $partnershipCacheKey = "partnerships:user:{$currentUserId}:shared_with_me";
        $ownersWhoSharedWithMe = Cache::remember($partnershipCacheKey, now()->addMinutes(15), function () use ($currentUserId) {
            return DB::table('partnerships')
                ->where('partner_id', $currentUserId)
                ->pluck('user_id')
                ->toArray();
        });

        // Cache dashboard snippets (5 minutes TTL, includes search params in key)
        $queryString = $request->getQueryString() ?? '';
        $dashboardCacheKey = "snippets:user:{$currentUserId}:dashboard:" . md5($queryString);
        
        $snippets = Cache::remember($dashboardCacheKey, now()->addMinutes(5), function () use ($currentUserId, $ownersWhoSharedWithMe, $request) {
                return Snippet::query()
                    ->where(function ($query) use ($currentUserId, $ownersWhoSharedWithMe) {
                        $query->where('user_id', $currentUserId);
                        if (!empty($ownersWhoSharedWithMe)) {
                            $query->orWhereIn('user_id', $ownersWhoSharedWithMe);
                        }
                    })
                    ->where(function ($query) use ($request) {
                        $query->when($request->search, function ($subQuery, $search) {
                            if (strlen($search) >= 3) {
                                $subQuery->whereFullText(['title', 'description'], $search);
                            } else {
                                $subQuery->where('title', 'LIKE', "{$search}%");
                            }
                        });
                    })
                    ->select(['id', 'user_id', 'title', 'description', 'created_at'])
                    ->with(['user:id,name', 'files:id,snippet_id,file_name'])
                    ->latest()
                    ->cursorPaginate(20);
            });

        return view('user.dashboard', compact('snippets'));
    }



    public function store(Request $request)
    {

        //return $request;
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
            return DB::transaction(function () use ($request) {
                $userId = Auth::user()->id;

                //Snippet 
                $snippetId = DB::table('snippets')->insertGetId([
                    'user_id' => $userId,
                    'title' => $request->title,
                    'description' => $request->description,
                    'language' => $request->language,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                //Snippet Files 
                $fileNames = $request->file_names;
                $filePaths = $request->file_paths ?? [];
                $contents = $request->contents;

                foreach ($fileNames as $index => $fileName) {
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION) ?: 'txt';

                    DB::table('snippet_files')->insert([
                        'snippet_id' => $snippetId,
                        'file_name' => $fileName,
                        'file_path' => $filePaths[$index] ?? null,
                        'content' => $contents[$index],
                        'extension' => $extension,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Invalidate cache for this user's snippets and languages
                $this->invalidateUserSnippetCaches($userId);

                return redirect()->back()->with('success', 'Snippet Added successfully.');
            });

        } catch (Exception $e) {
            return back()->with(['error' => 'Something went wrong while loading the page.']);
        }
    }


    public function show($id)
    {
        $snippet = Snippet::with('files')->findOrFail($id);
        return response()->json($snippet);
    }

    public function search(Request $request)
    {
        $currentUserId = auth()->id();
        
        // Cache search results (2 minutes TTL)
        $searchKey = md5($request->getQueryString() ?? '');
        $searchCacheKey = "search:user:{$currentUserId}:" . $searchKey;
        
        $results = Cache::remember($searchCacheKey, now()->addMinutes(2), function () use ($request, $currentUserId) {
                $query = Snippet::with(['user:id,name', 'files'])
                    ->select('id', 'user_id', 'title', 'description', 'language', 'created_at');

                $query->where(function ($q) use ($currentUserId) {
                    $q->where('user_id', $currentUserId)
                        ->orWhereExists(function ($sub) use ($currentUserId) {
                            $sub->select(DB::raw(1))
                                ->from('partnerships')
                                ->whereColumn('partnerships.user_id', 'snippets.user_id')
                                ->where('partnerships.partner_id', $currentUserId);
                        });
                });

                //Keyword Search - Full-text search 
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
                
                return $query->latest()->paginate(20);
            });
            
        return response()->json($results);
    }

    public function edit($id)
    {
        $snippet = Snippet::with('files')->findOrFail($id);
        return view('user.editsnippet', compact('snippet'));
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

                //Snippet 
                DB::table('snippets')
                    ->where('id', $id)
                    ->update([
                        'title' => $request->title,
                        'description' => $request->description,
                        'language' => $request->language,
                        'updated_at' => now(),
                    ]);

                DB::table('snippet_files')->where('snippet_id', $id)->delete();

                //Files 
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

                return redirect()->back()->with('success', 'Snippet updated successfully.');
            });

        } catch (Exception $e) {
            return back()->with(['error' => 'Something went wrong while loading the page.']);
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
        //Initialize query with relationships
        $query = Snippet::with('files')
            ->where('user_id', auth()->id());

        //Search filter 
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        $perPage = $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        // 5. Sorting Logic
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $allowedSorts = ['title', 'language', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }
        $userId = auth()->id();
        
        // Cache my snippets query (5 minutes TTL)
        $mySnippetsCacheKey = "snippets:user:{$userId}:my_snippets:" . md5($request->getQueryString() ?? '');
        $snippets = Cache::remember($mySnippetsCacheKey, now()->addMinutes(5), function () use ($query, $perPage, $request) {
            return $query->paginate($perPage)->appends($request->all());
        });
        
        // Cache language list (1 hour TTL)
        $languagesCacheKey = "languages:user:{$userId}:list";
        $languages = Cache::remember($languagesCacheKey, now()->addHour(), function () use ($userId) {
                return DB::table('snippets')
                    ->where('user_id', $userId)
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
        $searchCacheKey = "users:search:" . md5($query);
        $users = Cache::remember($searchCacheKey, now()->addMinutes(5), function () use ($query) {
                return User::where('name', 'LIKE', '%' . $query . '%')
                    ->get(['id', 'name']);
            });

        return response()->json($users);
    }

    public function updatePartnerships(Request $request)
    {
        // Validate inputs
        $request->validate([
            'shared_user_ids' => 'required|array',
            'shared_user_ids.*' => 'exists:users,id'
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


    public function destroyPartner($id)
    {

        // return $id;

        try {
            //Find the partnership record while ensuring 
            $partnership = DB::table('partnerships')
                ->where('partner_id', $id)
                ->where('user_id', auth()->id())
                ->first();

            //return $partnership;
            
            if (!$partnership) {
                return back()->with('error', 'Partner not found or you are not authorized to perform this action.');
            }

            $userId = auth()->id();
            
            //Delete the partnership record from the database
            DB::table('partnerships')->where('partner_id', $id)->where('user_id', $userId)->delete();

            // Invalidate partnership caches for both users
            Cache::forget("partnerships:user:{$userId}:shared_with_me");
            Cache::forget("partnerships:user:{$id}:shared_with_me");
            $this->invalidateUserSnippetCaches($userId);
            $this->invalidateUserSnippetCaches($id);

            //Return success message on successful deletion
            return back()->with('success', 'Partner has been removed successfully.');

        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong while removing the partner. Please try again.');
        }


    }


    public function SnippetDelete(Request $request)
    {

        $snippetId = $request->input('snippet_id');

        try {
            // Get snippet before deletion to find user_id for cache invalidation
            $snippet = Snippet::find($snippetId);
            $userId = $snippet ? $snippet->user_id : auth()->id();

            DB::transaction(function () use ($snippetId) {
                //Delete associated files first
                DB::table('snippet_files')->where('snippet_id', $snippetId)->delete();

                //Delete the main snippet record
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
            return back()->with('error', 'Failed to delete snippet. Please try again later.');
        }



    }
}
