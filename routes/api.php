<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// මෙතන Controller එකේ නම නිවැරදිද බලන්න (ExtensionController ද AuthController ද?)
use App\Http\Controllers\ExtensionController; 

// මේ පේළිය අනිවාර්යයෙන්ම තිබිය යුතුයි
Route::post('/login', [ExtensionController::class, 'login']);

Route::middleware('auth:sanctum')->get('/snippets', [ExtensionController::class, 'index']);