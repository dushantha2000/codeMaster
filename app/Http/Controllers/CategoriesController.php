<?php

namespace App\Http\Controllers;
use Auth;
use Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Snippet;
use Illuminate\Support\Str;use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreCategoryRequest;

class CategoriesController extends Controller
{
    /**
     * Safely scan and delete Redis keys matching a pattern.
     * Uses SCAN instead of KEYS to avoid blocking Redis.
     */
    private function scanAndDelete($redis, $pattern)
    {
        $iterator = null;
        $keys = [];

        do {
            $result = $redis->scan($iterator, $pattern, 100);
            if ($result !== false) {
                $keys = array_merge($keys, $result);
                if (count($keys) >= 100) {
                    $redis->del($keys);
                    $keys = [];
                }
            }
        } while ($iterator > 0);

        if (!empty($keys)) {
            $redis->del($keys);
        }
    }

    public function Update(StoreCategoryRequest $request)
    {
        // return $request;

        try {
            $userId = auth()->id();


            $category = DB::transaction(function () use ($request, $userId) {
                return DB::table('categories')
                    ->where('category_id', $request->category_id)
                    ->update([
                        'user_id' => $userId,
                        'category_id' => $request->category_id,
                        'category_name' => $request->name,
                        'category_description' => $request->description,
                        'color_name' => $request->color,
                        'isActive' => 1,
                        'updated_at' => now(),
                    ]);
            });

            // Bust categories cache — new version will be created on
            // next read via Cache::put (see index/EditView).
            Cache::forget("user:{$userId}:categories_version");
            $store = Cache::getStore();
            if (method_exists($store, 'getRedis')) {
                try {
                    $redis = $store->getRedis();
                    $prefix = Cache::getPrefix();
                    $this->scanAndDelete($redis, $prefix . "categories:user:{$userId}:*");
                    $this->scanAndDelete($redis, $prefix . "category:*:user:{$userId}:*");
                } catch (Exception $e) {
                    Log::warning('Categories cache pattern deletion failed: ' . $e->getMessage());
                }
            }

            return redirect()
                ->route('categories.index')
                ->with('success', 'Category updated successfully.');

        } catch (Exception $e) {
            
            // Log::error(" Error: " . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong while saving.']);
        }



    }
    public function Show($category_id)
    {
        $userId = auth()->id();

        if (!$userId) {
            return redirect()->route('login');
        }

        try {
            //category data
            $categories = DB::table('categories')
                ->where('category_id', $category_id)
                ->where('user_id', $userId)
                ->where('isActive', 1)
                ->first();

            if (!$categories) {
                return redirect()->route('categories.index')->with('error', 'Category not found.');
            }

            //count total snippets
            $totalSnippets = DB::table('snippets')
                ->where('category_id', $category_id)
                ->where('user_id', $userId)
                ->count();

            //language
            $uniqueLanguages = DB::table('snippets')
                ->where('category_id', $category_id)
                ->where('user_id', $userId)
                ->whereNotNull('language')
                ->distinct()
                ->count('language');

            //snippets
            $snippets = DB::table('snippets')
                ->where('user_id', $userId)
                ->where('category_id', $category_id)
                ->where('isActive', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return view('categories.show', compact('snippets', 'categories', 'totalSnippets', 'uniqueLanguages'));


        } catch (Exception $e) {

            // Log::error(" Error: " . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again later.');
        }


    }

    public function EditView($categoryId)
    {
        try {
            $userId = auth()->id();

            $versionKey = "user:{$userId}:categories_version";
            if (Cache::get($versionKey) === null) {
                Cache::put($versionKey, now()->timestamp, now()->addHours(6));
            }
            $version = Cache::get($versionKey, now()->timestamp);

            $cacheKey = "category:{$categoryId}:user:{$userId}:v:{$version}";

            $category = Cache::remember(
                $cacheKey,
                now()->addHours(6),
                function () use ($userId, $categoryId) {
                    return DB::table('categories')
                        ->where('user_id', $userId)
                        ->where('category_id', $categoryId)
                        ->where('isActive', 1)
                        ->select('category_id', 'category_name', 'category_description', 'color_name', 'isActive')
                        ->first();
                }
            );

            // return $category;

            if (!$category) {
                return back()->with('error', 'Category not found.');
            }

            return view('categories.edit', compact('category'));

        } catch (Exception $e) {

            //Log::error(" Error: " . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function NewCreate()
    {
        try {
            $userId = auth()->id();

            if (!$userId) {
                return redirect()->route('login');
            }

            return view('categories.create');
        } catch (Exception $e) {

            // Log::error(" Error: " . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }
    public function index(Request $request)
    {
        try {
            $userId = auth()->id();
            $search = $request->query('q');
            $page = $request->query('page', 1);

            // Version — TTL-based so a Cache::forget() bust on
            // create/update/delete forces a fresh timestamp on next read.
            $versionKey = "user:{$userId}:categories_version";
            if (Cache::get($versionKey) === null) {
                Cache::put($versionKey, now()->timestamp, now()->addHours(6));
            }
            $version = Cache::get($versionKey, now()->timestamp);

            // Build dynamic cache key including search and page
            $searchHash = md5($search ?? '');
            $cacheKey = "categories:user:{$userId}:v:{$version}:q:{$searchHash}:p:{$page}";

            $categories = Cache::remember($cacheKey, now()->addHours(6), function () use ($userId, $search) {
                $query = Category::where('user_id', $userId)
                    ->where('isActive', 1);

                if (!empty($search)) {
                    $query->where(function ($q) use ($search) {
                        $q->where('category_name', 'LIKE', "%{$search}%")
                            ->orWhere('category_description', 'LIKE', "%{$search}%");
                    });
                }

                return $query->withCount([
                    'snippets' => function ($q) use ($userId) {
                        $q->where('user_id', $userId)->where('isActive', 1);
                    }
                ])
                    ->orderBy('category_name', 'asc') //  default A-Z for consistency
                    ->paginate(12)

                    ->appends(['q' => $search]); // Ensure search persists across pages

            });

            // Aggregate stat for the page header strip
            $totalSnippets = DB::table('snippets')
                ->where('user_id', $userId)
                ->where('isActive', 1)
                ->whereNotNull('category_id')
                ->count();

            return view('categories.index', compact('categories', 'search', 'totalSnippets'));

        } catch (Exception $e) {

            //Log::error("Store Error: " . $e->getMessage());
            return back()->with(['error' => 'Unable to load categories.']);
        }
    }
    public function create(StoreCategoryRequest $request)
    {
        try {
            $userId = auth()->id();

            $category = DB::transaction(function () use ($request, $userId) {
                return DB::table('categories')
                    ->insert([
                        'category_id' => (string) Str::uuid(),
                        'user_id' => $userId,
                        'category_name' => $request->name,
                        'category_description' => $request->description,
                        'color_name' => $request->color,
                        'isActive' => 1,
                        'created_at' => now(),
                    ]);
            });

            // Bust categories cache
            Cache::forget("user:{$userId}:categories_version");
            $store = Cache::getStore();
            if (method_exists($store, 'getRedis')) {
                try {
                    $redis = $store->getRedis();
                    $prefix = Cache::getPrefix();
                    $this->scanAndDelete($redis, $prefix . "categories:user:{$userId}:*");
                } catch (Exception $e) {
                    Log::warning('Categories cache pattern deletion failed: ' . $e->getMessage());
                }
            }

            return redirect()
                ->route('categories.index')
                ->with('success', 'Category created successfully.');

        } catch (Exception $e) {


            // Log::error(" Error: " . $e->getMessage());
            return back()->withInput()->with(['error', 'Something went wrong while saving.']);
        }
    }

    public function destroy($categoryId)
    {

        $userId = auth()->id();

        if (!$userId) {
            return redirect()->route('login');
        }

        try {
            $updated = DB::table('categories')
                ->where('user_id', $userId)
                ->where('category_id', $categoryId)
                ->update(['isActive' => 0]);

            if ($updated) {

                // Bust categories cache
                Cache::forget("user:{$userId}:categories_version");
                $store = Cache::getStore();
                if (method_exists($store, 'getRedis')) {
                    try {
                        $redis = $store->getRedis();
                        $prefix = Cache::getPrefix();
                        $this->scanAndDelete($redis, $prefix . "categories:user:{$userId}:*");
                    } catch (Exception $e) {
                        Log::warning('Categories cache pattern deletion failed: ' . $e->getMessage());
                    }
                }

                return redirect()->route('categories.index')->with('success', 'Deleted successfully.');
            }

            return redirect()->route('categories.index')->with('error', 'Category not found or already deleted.');

        } catch (Exception $e) {

            // Log::error(" Error: " . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

}





