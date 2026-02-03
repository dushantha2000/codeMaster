<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Snippet;
use App\Models\SnippetFile;
use Illuminate\Support\Facades\DB;

class SnippetController extends Controller
{
    public function index(Request $request)
    {
        // 1. Use 'cursorPaginate' instead of 'simplePaginate' for O(1) performance at scale
        // 2. Use 'when' to keep the code clean and fluent
        $snippets = \App\Models\Snippet::query()
            ->where('user_id', auth()->id())
            ->select(['id', 'title', 'description', 'created_at'])
            ->when($request->search, function ($query, $search) {
                // 3. Optimization: Use Full-Text search if keyword is long enough
                if (strlen($search) >= 3) {
                    return $query->whereFullText(['title', 'description'], $search);
                }
                return $query->where('title', 'LIKE', "{$search}%"); // Forward-only LIKE is faster
            })
            ->with('files:id,snippet_id,file_name')
            ->latest()
            ->cursorPaginate(20);

        return view('dashboard', compact('snippets'));
    }

    public function store(Request $request)
    {
        //return $request;
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'file_names' => 'required|array|min:1',
            'file_names.*' => 'required|string|max:255',
            'file_paths' => 'nullable|array',
            'file_paths.*' => 'nullable|string|max:255',
            'contents' => 'required|array|min:1',
            'contents.*' => 'required|string',
        ]);

        // Create the snippet
        $snippet = Snippet::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'language' => $request->language,
        ]);

        // Create snippet files
        $fileNames = $request->file_names;
        $filePaths = $request->file_paths ?? [];
        $contents = $request->contents;

        foreach ($fileNames as $index => $fileName) {
            $extension = pathinfo($fileName, PATHINFO_EXTENSION) ?: 'txt';

            SnippetFile::create([
                'snippet_id' => $snippet->id,
                'file_name' => $fileName,
                'file_path' => $filePaths[$index] ?? null,
                'content' => $contents[$index],
                'extension' => $extension,
            ]);
        }

        return redirect()->back()->with('success', 'Snippet Added successfully.');
    }


    public function show($id)
    {
        $snippet = Snippet::with('files')->findOrFail($id);
        return response()->json($snippet);
    }

    public function search(Request $request)
    {
        $query = Snippet::query();

        // 1. Check if search keyword exists (Title or Description)
        if ($request->has('q') && !empty($request->q)) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }


        // If 'lang' is empty (All Languages), this block is skipped
        if ($request->has('lang') && !empty($request->lang)) {
            $query->where('language', $request->lang);
        }

        // Eager Loading (Files) and Pagination
        $snippets = $query->with('files')->latest()->paginate(12);

        return response()->json($snippets);
    }

    public function edit($id)
    {
        $snippet = Snippet::with('files')->findOrFail($id);
        return view('editsnippet', compact('snippet'));
    }

    public function Update(Request $request, $id)
    {

        //return $request;
        $snippet = Snippet::findOrFail($id);


        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'file_names' => 'required|array|min:1',
            'file_names.*' => 'required|string|max:255',
            'file_paths' => 'nullable|array',
            'file_paths.*' => 'nullable|string|max:255',
            'contents' => 'required|array|min:1',
            'contents.*' => 'required|string',
        ]);

        // Update the snippet
        $snippet->update([
            'title' => $request->title,
            'description' => $request->description,
            'language' => $request->language,
        ]);

        // Delete existing files
        $snippet->files()->delete();

        // Create new files
        $fileNames = $request->file_names;
        $filePaths = $request->file_paths ?? [];
        $contents = $request->contents;

        foreach ($fileNames as $index => $fileName) {
            $extension = pathinfo($fileName, PATHINFO_EXTENSION) ?: 'txt';

            SnippetFile::create([
                'snippet_id' => $snippet->id,
                'file_name' => $fileName,
                'file_path' => $filePaths[$index] ?? null,
                'content' => $contents[$index],
                'extension' => $extension,
            ]);
        }

        return redirect()->back()->with('success', 'Snippet updated successfully.');

    }

    public function destroy($id)
    {
        $snippet = Snippet::findOrFail($id);

        // Check if the snippet belongs to the authenticated user
        if ($snippet->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete associated files first
        $snippet->files()->delete();

        // Delete the snippet
        $snippet->delete();

        return response()->json(['message' => 'Snippet deleted successfully']);
    }

    public function mySnippets(Request $request)
    {
        // 1. Initialize query with relationships
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
        $snippets = $query->paginate($perPage)->appends($request->all());
        $languages = Snippet::where('user_id', auth()->id())
            ->select('language')
            ->whereNotNull('language')
            ->distinct()
            ->pluck('language');

        return view('auth.mysnippets', compact('snippets', 'languages'));
    }
}
