<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImageController;

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

// Public Routes
// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/test', [AuthController::class, 'test']);

// Images
Route::get('/image/{filename}', [ImageController::class, 'getImage']);
Route::post('/upload', [ImageController::class, 'upload']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    // Posts
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    // Like
    Route::post('/posts/like/{post_id}', [PostController::class, 'like']);

    // Comment
    Route::post('/comment/{post_id}', [PostController::class, 'comment']);

    // Users
    Route::get('/users/{search_term?}', [UserController::class, 'getUsers']);

    // Profile
    Route::get('/profile/{user_id?}', [ProfileController::class, 'getProfile']);
    Route::get('/friend-request', [ProfileController::class, 'getFriendRequests']);
    Route::get('/get-sender-friend-request/{id}', [ProfileController::class, 'getSenderFr']);
    Route::post('/friend-request', [ProfileController::class, 'sendFriendRequest']);
    Route::post('/accept-friend-request', [ProfileController::class, 'acceptFriendRequest']);
    Route::post('/reject-friend-request', [ProfileController::class, 'rejectFriendRequest']);


    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/check', [AuthController::class, 'check']);
});