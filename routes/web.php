<?php

use App\Http\Controllers\SnippetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SnippetController::class, 'index'])->name('dashboard');
Route::get('/api/search', [SnippetController::class, 'search'])->name('api.search');
Route::get('/snippets-create', function () {
    return view('welcome');
})->name('snippets-create');
Route::post('snippet-store',[SnippetController::class, 'store']);
Route::get('/api/snippets/{id}', [SnippetController::class, 'show']);

Route::get('login', function () {
    return view('login');
})->name('login');   


Route::get('register', function () {
    return view('register');
})->name('register'); 

Route::get('reset', function () {
    return view('resetpassword');
})->name('register');


