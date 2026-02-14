<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\partnershipController;
use App\Http\Controllers\SnippetController;
use Illuminate\Support\Facades\Route;

// Not login request Management
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'Login'])->name('login');

    Route::get('/fix-cache-now', function () {
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return 'All Caches Cleared!';
    });

    Route::post('user-login', [AuthController::class, 'UserLogin']);
    Route::get('register', [AuthController::class, 'register']);
    Route::post('user-register', [AuthController::class, 'UserRegister']);
    Route::post('/verify-registration', [AuthController::class, 'verifyRegistration']);
    Route::get('reset', [AuthController::class, 'ResetPassword']);
    Route::post('send-Reset-Code', [AuthController::class, 'sendResetCode']);

    // This matches the link: /reset-password/64_character_token
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'UpdatePassword']);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [SnippetController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'Logout']);
    Route::get('profile', [AuthController::class, 'Profile']);
    Route::get('/settings', [AuthController::class, 'Settings']);
    Route::get('/api/search', [SnippetController::class, 'search']);
    Route::get('/my-snippets', [SnippetController::class, 'mySnippets'])->name('snippets.index');
    Route::delete('snippets/{id}', [SnippetController::class, 'destroy']);
    Route::get('snippets/{id}/edit', [SnippetController::class, 'edit']);
    Route::post('/snippets/update/{id}', [SnippetController::class, 'Update']);
    Route::post('/partners/destroy/{id}', [partnershipController::class, 'destroyPartner']);

    Route::post('/partners/update',[partnershipController::class,'PartnerPermission']);

    Route::get('/snippets-create', function () {
        return view('user.snippetcreate');
    })->name('snippets-create');

    Route::post('/snippet-store', [SnippetController::class, 'store']);
    Route::get('/api/snippets/{id}', [SnippetController::class, 'show']);
    Route::get('/search-users', [SnippetController::class, 'UsersSearch'])->name('users.search');
    Route::post('/user/partnerships', [SnippetController::class, 'updatePartnerships']);

    Route::post('/profile-destroy', [AuthController::class, 'destroyProfile']);
    Route::post('/update-password', [AuthController::class, 'changePassword']);
    Route::post('/setting-profile', [AuthController::class, 'UpdateProfile']);

    // delete single snippet
    Route::post('/snippet-delete', [SnippetController::class, 'SnippetDelete']);

});

// Public help page – available for both guests and logged-in users
Route::get('/how-to-use-codevault', function () {
    return view('auth.howto');
})->name('howto');

// Route::get('login', function () {
//     return view('login');
// })->name('login');

// Route::get('register', function () {
//     return view('register');
// })->name('register');

// Route::get('reset', function () {
//     return view('resetpassword');
// })->name('register');
