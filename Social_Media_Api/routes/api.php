<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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
// Auth
Route::post('Signup',[AuthController::class,'Signup']);
Route::post('Login', [AuthController::class,'Login']);
Route::post('Logout', [AuthController::class,'Logout'])->middleware('auth:api');

Route::group(['middleware'=>'auth:api','prefix'=>'Profile'],function()
{
    Route::get('myprofile',[UserController::class,'index']);
    //Route::put('editprofile',[UserController::class,'update']);

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
