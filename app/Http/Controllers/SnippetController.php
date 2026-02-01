<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Snippet;
use App\Models\SnippetFile;

class SnippetController extends Controller
{
    public function index(Request $request)
    {
        $query = Snippet::query();

        // Check if search keyword exists
        if ($request->has('search') && !empty($request->search)) {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // Eager Loading (Files) and Pagination
        $snippets = $query->with('files')->latest()->paginate(12);

        // Send data to Dashboard
        return view('dashboard', compact('snippets'));
    }

    public function store(Request $request)
    {

        // return $request;
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

        return response()->json([
            'message' => 'Snippet created successfully',
            'snippet_id' => $snippet->id,
        ], 201);
    }


    public function show($id)
    {
        $snippet = Snippet::with('files')->findOrFail($id);
        return response()->json($snippet);
    }

    public function search(Request $request)
    {
        $query = Snippet::query();

        // Check if search keyword exists
        if ($request->has('q') && !empty($request->q)) {
            $keyword = $request->q;

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // Eager Loading (Files) and Pagination
        $snippets = $query->with('files')->latest()->paginate(12);

        // Return JSON for AJAX requests
        return response()->json($snippets);
    }
}
