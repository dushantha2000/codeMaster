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
            // Log::error("Store Error: " . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong while saving.']);
        }



    }
    public function Show($category_id)
    {
        $userId = auth()->id();

        if (!$userId) {
            return redirect()->route('login');

        }

        $categories = DB::table('categories')
            ->where('category_id', $category_id)
            ->where('user_id', $userId)
            ->where('isActive', 1)
            ->first();


        $snippets = Snippet::with('files')
            ->where('user_id', auth()->id())
            ->where('category_id', $category_id)
            ->where('isActive', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(20);


        //return $snippets;

        return view('categories.show', compact('snippets', 'categories'));


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
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function NewCreate()
    {
        try {
            $userId = auth()->id();

            return view('categories.create');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }
    public function index()
    {
        try {
            $userId = auth()->id();

            // Get categories from cache
            $versionKey = "user:{$userId}:categories_version";
            $version = Cache::rememberForever($versionKey, fn() => time());

            $cacheKey = "categories:user:{$userId}:v:{$version}";

            $categories = Cache::rememberForever($cacheKey, function () use ($userId) {
                return DB::table('categories')
                    ->where('user_id', $userId)
                    ->where('isActive', 1)
                    ->select('category_id', 'category_name', 'category_description', 'color_name', 'isActive')
                    ->get();
            });

            //return $categories;

            return view('categories.index', compact('categories'));

        } catch (Exception $e) {
            // dd($e->getMessage());
            return back()->withErrors(['error' => 'Unable to load categories.']);
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
            // Log::error("Store Error: " . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong while saving.']);
        }
    }

    public function destroy($categoryId)
    {
        $userId = auth()->id();

        $updated = DB::table('categories')
            ->where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->update(['isActive' => 0]);

        if ($updated) {

            Cache::forget("user:{$userId}:categories_version");

            return redirect()->route('categories.index')->with('success', 'Deleted successfully.');
        }

        return redirect()->route('categories.index')->with('error', 'Category not found or already deleted.');
    }

}





