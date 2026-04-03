<?php

namespace App\Http\Controllers;
use Auth;
use Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Snippet;
use Illuminate\Support\Str;
use Exception;
use App\Http\Requests\StoreCategoryRequest;


class CategoriesController extends Controller
{

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

            //  Forget categories_version
            Cache::forget("user:{$userId}:categories_version");

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

            // Version 
            $versionKey = "user:{$userId}:categories_version";
            $version = Cache::rememberForever($versionKey, fn() => time());

            // Cache Key create
            $cacheKey = "category:{$categoryId}:user:{$userId}:v:{$version}";

            $category = Cache::rememberForever($cacheKey, function () use ($userId, $categoryId) {
                return DB::table('categories')
                    ->where('user_id', $userId)
                    ->where('category_id', $categoryId)
                    ->where('isActive', 1)
                    ->select('category_id', 'category_name', 'category_description', 'color_name', 'isActive')
                    ->first();
            });

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

            // Get categories version
            $versionKey = "user:{$userId}:categories_version";
            $version = Cache::rememberForever($versionKey, fn() => time());

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

            return view('categories.index', compact('categories', 'search'));

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

            //  Forget categories_version
            Cache::forget("user:{$userId}:categories_version");

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

                //  Forget categories_version
                Cache::forget("user:{$userId}:categories_version");

                return redirect()->route('categories.index')->with('success', 'Deleted successfully.');
            }

            return redirect()->route('categories.index')->with('error', 'Category not found or already deleted.');

        } catch (Exception $e) {

            // Log::error(" Error: " . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

}





