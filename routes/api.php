<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NumberController;
use App\Http\Controllers\API\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('login',[UserController::class,'userLogin']);
Route::post('/register', [UserController::class, 'register']);
Route::get('profile-details',[UserController::class,'userDetails']);

Route::middleware('auth:api')->post('/numbers', [NumberController::class,'store']);

// Route::post('register', [UserController::class, 'register']);
// Route::post('login', [UserController::class, 'login']);

// Route::middleware('auth:api')->group(function () {
//     Route::get('get-user', [UserController::class, 'userInfo']);
// });
