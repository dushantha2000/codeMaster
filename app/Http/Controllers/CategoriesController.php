<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use App\Http\Requests\StoreCategoryRequest;


class CategoriesController extends Controller
{
    public function index()
    {
        return view('categories.index');
    }
    public function create(StoreCategoryRequest $request)
    {
        //validation StoreCategoryRequest
        // $currentUserId = auth()->id();
        try {
            // Transaction  create category
            $category = DB::transaction(function () use ($request) {
                return Category::create([
                    'category_id' => (string) Str::uuid(),
                    'user_id' => auth()->id(),
                    'category_name' => $request->name,
                    'category_description' => $request->description,
                    'color_name' => $request->color,
                    'isActive' => 1,
                ]);
            });

            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
            
        } catch (Exception $e) {

            return back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

}

