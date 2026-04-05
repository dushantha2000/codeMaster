<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\partnershipController;
use App\Http\Controllers\SnippetController;
use App\Http\Controllers\LogsController;
use Illuminate\Support\Facades\Route;

// Not login request Management
Route::middleware('guest')->group(function () {

    Route::get('/', [AuthController::class, 'Login'])->name('login');

    
    Route::get('/fix-cache-now', function () {
        // 1. Clear all application caches
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('session:table');

        // 2. Drop all tables and re-run migrations
       
        Artisan::call('migrate:fresh', ['--force' => true]);

       
        // Artisan::call('db:seed', ['--force' => true]);

        return '✅ All Caches Cleared and Database Refreshed Successfully!';
    });

    Route::post('/user-login', [AuthController::class, 'userLogin']);
    Route::get('register', [AuthController::class, 'register']);
    Route::post('user-register', [AuthController::class, 'userRegister']);
    Route::post('/verify-registration', [AuthController::class, 'verifyRegistration']);
    Route::get('/reset', [AuthController::class, 'ResetPassword']);
    Route::post('send-Reset-Code', [AuthController::class, 'sendResetCode']);

    // This matches the link: /reset-password/64_character_token
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'UpdatePassword']);


});
//searching routes
Route::get('/api/search', [SnippetController::class, 'search']);
Route::get('/api/snippets/{id}', [SnippetController::class, 'show']);
Route::get('/api/search/my-snippets', [SnippetController::class, 'MySnippetSearch']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [SnippetController::class, 'index'])->name('dashboard');
    Route::get('/logs', [LogsController::class, 'index'])->name('logs');
    Route::post('/logout', [AuthController::class, 'Logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/settings', [AuthController::class, 'Settings'])->name('settings');
    // Route::get('/api/search', [SnippetController::class,'search']);
    Route::get('/my-snippets', [SnippetController::class, 'mySnippets'])->name('snippets.index');
    Route::delete('snippets/{id}', [SnippetController::class, 'destroy']);
    Route::get('snippets/{id}/edit', [SnippetController::class, 'edit']);
    Route::post('/snippets/update/{id}', [SnippetController::class, 'Update']);
    Route::post('/partners/destroy/{id}', [partnershipController::class, 'destroyPartner']);

    Route::post('/partners/update', [partnershipController::class, 'PartnerPermission']);

    // Route::get('/snippets-create', function () {
    //     return view('user.snippetcreate');
    // })->name('snippets-create');

    Route::get('/snippets-create', [SnippetController::class, 'snippetCreate'])->name('snippets-create');


    Route::post('/snippet-store', [SnippetController::class, 'store']);

    Route::get('/search-users', [SnippetController::class, 'UsersSearch'])->name('users.search');
    Route::post('/user/partnerships', [SnippetController::class, 'updatePartnerships']);

    Route::post('/profile-destroy', [AuthController::class, 'destroyProfile']);
    Route::post('/update-password', [AuthController::class, 'changePassword']);
    Route::post('/setting-profile', [AuthController::class, 'UpdateProfile']);

    Route::post('/update-profile-image', [AuthController::class, 'UpdateProfileImage']);

    // delete single snippet
    Route::post('/snippet-delete', [SnippetController::class, 'SnippetDelete']);


    
    //category routes
    Route::post('/category-create', [CategoriesController::class, 'Create']);
    Route::get('/create-new', [CategoriesController::class, 'NewCreate']);
    Route::get('/categories.index', [CategoriesController::class, 'index'])->name('categories.index');
    Route::post('/category-store', [SnippetController::class, 'CategoryStore']);
    Route::get('/categories/{categoryId}', [CategoriesController::class, 'Show'])->name('categories.show');

    Route::get('/categories/{categoryId}/edit', [CategoriesController::class, 'EditView'])->name('categories.edit');

    Route::post('/category-update', [CategoriesController::class, 'Update']);

    
    Route::delete('/categories/{categoryId}', [CategoriesController::class, 'destroy']);

    //marked
    Route::post('/snippet-marked', [SnippetController::class, 'SnippetMarked']);    


});

// Public help page – available for both guests and logged-in users
Route::get('/how-to-use-codevault', function () {
    return view('auth.howto');
})->name('howto');

// Route::get('login', function () {
//     return view('login');
// })->name('login');



Route::get('show', function () {
    return view('categories.show');
});

Route::get('partner', function () {
    return view('partners.index');
});

Route::get('welcome', function () {
    return view('web.welcome');
})->name('register');
