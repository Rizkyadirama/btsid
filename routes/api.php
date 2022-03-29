<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\shoppingController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function($router) {
    Route::post('/signup', [JWTController::class, 'register']);
    Route::post('/signin', [JWTController::class, 'login']);
    Route::get('/users', [JWTController::class, 'allUser']);
    Route::get('/shopping', [shoppingController::class, 'index']);
    Route::post('/shopping/add', [shoppingController::class, 'store']);
    Route::get('/shopping/{id}', [shoppingController::class, 'show']);
    Route::put('/shopping/{id}', [shoppingController::class, 'update']);
    Route::delete('/shopping/{id}', [shoppingController::class, 'delete']);
});