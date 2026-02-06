<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Snippet;
use App\Models\SnippetFile;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class SnippetController extends Controller
{
    public function index(Request $request)
    {

        $currentUserId = auth()->id();
        $ownersWhoSharedWithMe = DB::table('partnerships')
            ->where('partner_id', $currentUserId)
            ->pluck('user_id')
            ->toArray(); // Array 

        $snippets = Snippet::query()
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

        //return $snippets;

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

                //Snippet 
                $snippetId = DB::table('snippets')->insertGetId([
                    'user_id' => Auth::user()->id,
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
        return response()->json($query->latest()->paginate(20));
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

        // Delete associated files first
        $snippet->files()->delete();

        // Delete the snippet
        $snippet->delete();

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
        $snippets = $query->paginate($perPage)->appends($request->all());
        $languages = DB::table('snippets')
            ->where('user_id', auth()->id())
            ->whereNotNull('language')
            ->distinct()
            ->pluck('language');

        return view('auth.mysnippets', compact('snippets', 'languages'));
    }


    public function UsersSearch(Request $request)
    {
        $query = $request->get('term');

        // query 
        if (!$query) {
            return response()->json([]);
        }

        $users = User::where('name', 'LIKE', '%' . $query . '%')

            ->get(['id', 'name']);

        return response()->json($users);
    }

    public function updatePartnerships(Request $request)
    {
        $request->validate([
            'shared_user_ids' => 'required|array',
            'shared_user_ids.*' => 'exists:users,id'
        ]);

        $currentUserId = auth()->id();
        $newPartnerIds = $request->shared_user_ids;

        DB::transaction(function () use ($currentUserId, $newPartnerIds) {
            DB::table('partnerships')
                ->where('user_id', $currentUserId)
                ->delete();
            $chunks = array_chunk($newPartnerIds, 500);

            foreach ($chunks as $chunk) {
                $dataToInsert = [];
                foreach ($chunk as $partnerId) {
                    $dataToInsert[] = [
                        'user_id' => $currentUserId,
                        'partner_id' => $partnerId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('partnerships')->insert($dataToInsert);
            }
        });

        return back()->with('success', 'Vault access updated successfully!');
    }


    public function destroyPartner($id)
    {

        try {
            //Find the partnership record while ensuring 
            $partnership = DB::table('partnerships')
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$partnership) {
                return back()->with('error', 'Partner not found or you are not authorized to perform this action.');
            }

            //Delete the partnership record from the database
            DB::table('partnerships')->where('id', $id)->delete();

            //Return success message on successful deletion
            return back()->with('success', 'Partner has been removed successfully.');

        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong while removing the partner. Please try again.');
        }


    }
}
