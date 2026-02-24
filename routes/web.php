<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SnippetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;

// Public Routes
Route::get('/', function () {
    return redirect()->route('snippets.index');
})->name('home');

Route::get('/howto', function () {
    return view('auth.howto');
})->name('howto');



// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'userLogin']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'userRegister']);
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetCode'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
});

// Dashboard Routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'Logout'])->name('logout');
    
    // Snippet Routes
    Route::resource('snippets', SnippetController::class);
    Route::get('/snippets/{id}/copy', [SnippetController::class, 'copy'])->name('snippets.copy');
    
    // Category Routes (auth)
     Route::resource('categories', CategoryController::class);

     


    
    // Admin Routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/snippets', [AdminController::class, 'snippets'])->name('admin.snippets');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    });
});

// Public Snippet Routes (read-only for browsing)
Route::get('/snippets', [SnippetController::class, 'index'])->name('snippets.index');
Route::get('/snippets/{snippet}', [SnippetController::class, 'show'])->name('snippets.show');