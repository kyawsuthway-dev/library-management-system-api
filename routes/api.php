<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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