<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
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
//User Profile Middleware
Route::group(['middleware'=>'auth:api','prefix'=>'Profile'],function()
{
    Route::get('myprofile',[UserController::class,'index']);
    Route::put('editprofile',[UserController::class,'Update']);
    Route::delete('deleteaccount', [UserController::class,'Delete']);
    Route::put('Changepassword', [UserController::class,'ChangePassword']);

});
// Posts
Route::group(['middleware'=>'auth:api'],function()
{
    Route::get('posts',[PostController::class,'index']);
    Route::put('posts/{id}',[PostController::class,'Update']);
    Route::delete('posts/{id}', [PostController::class,'Delete']);
    Route::post('posts', [PostController::class,'create']);
    Route::get('posts/Myposts',[UserController::class,'Getposts']);
    // Route::post('getpostsofuser/{', function ($id) {

    // });
});
//Comments
Route::group(['middleware'=>'auth:api'],function()
{
    Route::get('Comments',[CommentController::class,'index']);
    Route::put('Comments/{id}',[CommentController::class,'Update']);
    Route::delete('Comments/{id}', [CommentController::class,'Delete']);
    Route::post('Comments', [CommentController::class,'create']);
});
//Extra:Email Verification & Forget Password & Gmail Api & Noftication & chat & stories & privacy
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
