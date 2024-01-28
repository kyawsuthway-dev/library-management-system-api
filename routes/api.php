<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Models\Author;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function() {
    Route::get('me', [AuthController::class, 'authUser'])->middleware('auth:sanctum');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// user routes
Route::get('users', [UserController::class, 'index'])->middleware('auth:sanctum')->can('viewAny', User::class);
Route::post('users', [UserController::class, 'store'])->middleware('auth:sanctum')->can('create', User::class);
Route::get('users/{user}', [UserController::class, 'show'])->middleware('auth:sanctum')->can('view', User::class);
Route::put('users/{user}', [UserController::class, 'update'])->middleware('auth:sanctum')->can('update', User::class);
Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('auth:sanctum')->can('delete', User::class);

// author routes
Route::get('authors', [AuthorController::class, 'index']);
Route::post('authors', [AuthorController::class, 'store'])->middleware('auth:sanctum')->can('create', Author::class);
Route::get('authors/{author}', [AuthorController::class, 'show']);
Route::put('authors/{author}', [AuthorController::class, 'update'])->middleware('auth:sanctum')->can('update', Author::class);
Route::delete('authors/{author}', [AuthorController::class, 'destroy'])->middleware('auth:sanctum')->can('delete', Author::class);

// category routes
Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store'])->middleware('auth:sanctum')->can('create', Category::class);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::put('categories/{category}', [CategoryController::class, 'update'])->middleware('auth:sanctum')->can('update', Category::class);
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->middleware('auth:sanctum')->can('delete', Category::class);