<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\LikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    /**
     * TODO - Implement password reset link to api
     */
    // Route::post('/forgot-password', [PasswordResetLinkController::class, 'forgotPassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

/* Movie Endpoints */
Route::group([
    'prefix' => 'movie'
], function ($router) {
    Route::get('/', [MovieController::class, 'list']);
    Route::get('/{id}', [MovieController::class, 'find']);

    /* Crud */
    Route::post('/', [MovieController::class, 'create'])->middleware('auth:api');
    Route::put('/{id}', [MovieController::class, 'update'])->middleware('auth:api');
    Route::patch('/{id}', [MovieController::class, 'update'])->middleware('auth:api');
    Route::delete('/{id}', [MovieController::class, 'delete'])->middleware('auth:api');

    /* Like */
    Route::post('/{id}/like', [LikeController::class, 'like'])->middleware('auth:api');
    Route::delete('/{id}/like', [LikeController::class, 'dislike'])->middleware('auth:api');
});

/* Movie Log Endpoint */
Route::group([
    'prefix' => 'log'
], function ($router) {
    Route::get('/movie', [LogController::class, 'list'])->middleware('auth:api');
    Route::get('/movie/{id}', [LogController::class, 'findByMovie'])->middleware('auth:api');
});
