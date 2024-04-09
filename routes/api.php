<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('/posts',App\Http\Controllers\ApiPostController::class);
Route::apiResource('/users',App\Http\Controllers\ApiUserController::class);

Route::post('/register',[App\Http\Controllers\ApiAuthController::class,'register'])->name('register');
Route::post('/login',[App\Http\Controllers\ApiAuthController::class,'login'])->name('login');
Route::get('/user',[App\Http\Controllers\ApiAuthController::class,'user'])->name('user');
Route::post('/logout',[App\Http\Controllers\ApiAuthController::class,'logout'])->name('logout');
