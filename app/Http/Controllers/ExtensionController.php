<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;


class ExtensionController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // User
        $user = User::where('email', $request->email)->first();

        // User
        if ($user && Hash::check($request->password, $user->password)) {

            // (Clean-up)
            $user->tokens()->delete();

            // අලුත් Sanctum Token එකක් සෑදීම
            $token = $user->createToken('extension-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);
        }

        
        return response()->json(['message' => 'Invalid credentials'], 401);
    }


    public function index()
    {
        $userId = Auth::id();

        // 1. Snippets 
        $rawSnippets = DB::table('snippets')
            ->leftJoin('snippet_files', 'snippets.id', '=', 'snippet_files.snippet_id')
            ->where('snippets.user_id', $userId)
            ->select(
                'snippets.id as snippet_id',
                'snippets.title',
                'snippets.description',
                'snippets.language',
                'snippet_files.id as file_id',
                'snippet_files.file_name',
                'snippet_files.content',
                'snippet_files.extension'
            )
            ->get();

        // Row-by-row data  Snippet  Group 
        $snippets = $rawSnippets->groupBy('snippet_id')->map(function ($items) {
            $firstItem = $items->first();
            return [
                'id' => $firstItem->snippet_id,
                'title' => $firstItem->title,
                'description' => $firstItem->description,
                'language' => $firstItem->language,
                'files' => $items->whereNotNull('file_id')->map(function ($file) {
                    return [
                        'file_name' => $file->file_name,
                        'content' => $file->content,
                        'extension' => $file->extension
                    ];
                })->values()
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => $snippets
        ]);
    }
}
