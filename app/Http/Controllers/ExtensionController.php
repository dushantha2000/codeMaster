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

        // 2. User කෙනෙක් ඉන්නවාදැයි බැලීම (Email එකෙන්)
        $user = User::where('email', $request->email)->first();

        // 3. User ඉන්නවා නම් සහ Password එක හරි නම්
        if ($user && Hash::check($request->password, $user->password)) {

            // පරණ ටෝකන් මකා දැමීම (Clean-up)
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

        // 4. වැරදි නම්
        return response()->json(['message' => 'Invalid credentials'], 401);
    }


    public function index()
    {
        $userId = Auth::id();

        // 1. Snippets සහ ඒවායේ Files එකම Query එකකින් Join කරලා ගන්නවා
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

        // 2. ලැබෙන Row-by-row data ටික Snippet එක අනුව Group කරගන්නවා
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
