<?php

namespace App\Http\Controllers;
use Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use App\Http\Requests\StoreCategoryRequest;


class CategoriesController extends Controller
{
    public function Show($category_id)
    {

        //return $category_id;

        // $category = Category::find($category_id);
        return view('categories.show');

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
                return Category::create([
                    'category_id' => (string) Str::uuid(),
                    'user_id' => $userId,
                    'category_name' => $request->name,
                    'category_description' => $request->description,
                    'color_name' => $request->color,
                    'isActive' => 1,
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





