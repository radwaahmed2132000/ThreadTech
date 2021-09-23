<?php
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostreactionController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReplyreactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailVerificationNotificationController ;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\FollowingController;
use App\Http\Controllers\FollowrequestController;
use App\Http\Controllers\VerifyEmailController;
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
Route::group(['middleware'=>'auth:api'],function()
{
    //Comments
    Route::get('Comments',[CommentController::class,'index']);
    Route::get('Comments/{comment}',[CommentController::class,'show']);
    Route::put('Comments/{comment}',[CommentController::class,'Update']);
    Route::delete('Comments/{comment}', [CommentController::class,'Delete']);
    Route::post('Comments', [CommentController::class,'create'])->middleware('verified');;
    // Posts
    Route::get('posts',[PostController::class,'index']);
    Route::get('posts/{post}',[PostController::class,'show']);
    Route::put('posts/{post}',[PostController::class,'Update']);
    Route::delete('posts/{post}', [PostController::class,'Delete']);
    Route::post('posts', [PostController::class,'create'])->middleware('verified');
    Route::get('posts/Myposts',[UserController::class,'Getposts']);
    //Replies
    Route::get('Reply',[ReplyController::class,'index']);
    Route::get('Reply/{reply}',[ReplyController::class,'show']);
    Route::put('Reply/{reply}',[ReplyController::class,'Update']);
    Route::delete('Reply/{reply}', [ReplyController::class,'Delete']);
    Route::post('Reply', [ReplyController::class,'create'])->middleware('verified');
    // Reactions on comements
    Route::get('Reaction',[ReactionController::class,'index']);
    Route::get('Reaction/{reaction}',[ReactionController::class,'show']);
    Route::put('Reaction/{reaction}',[ReactionController::class,'Update']);
    Route::delete('Reaction/{reaction}', [ReactionController::class,'Delete']);
    Route::post('Reaction', [ReactionController::class,'create'])->middleware('verified');;
    // Reactions on posts
    Route::get('Postreaction',[PostreactionController::class,'index']);
    Route::get('Postreaction/{postreaction}',[PostreactionController::class,'show']);
    Route::put('Postreaction/{postreaction}',[PostreactionController::class,'Update']);
    Route::delete('Postreaction/{postreaction}', [PostreactionController::class,'Delete']);
    Route::post('Postreaction', [PostreactionController::class,'create'])->middleware('verified');;
    // Reactions on replies
    Route::get('Replyreaction',[ReplyreactionController::class,'index']);
    Route::get('Replyreaction/{replyreaction}',[ReplyreactionController::class,'show']);
    Route::put('Replyreaction/{replyreaction}',[ReplyreactionController::class,'Update']);
    Route::delete('Replyreaction/{replyreaction}', [ReplyreactionController::class,'Delete']);
    Route::post('Replyreaction', [ReplyreactionController::class,'create'])->middleware('verified');
    //Follower
    Route::get('Follower',[FollowerController::class,'index']);
    Route::delete('Follower/{follower}', [FollowerController::class,'Delete']);
    //Following
    Route::get('Following',[FollowingController::class,'index']);
    Route::delete('Following/{following}', [FollowingController::class,'Delete']);
    //FollowRequest
    Route::get('FollowRequest',[FollowrequestController::class,'index']);
    Route::put('FollowRequest/{FollowRequest}',[FollowrequestController::class,'Update'])->middleware('verified');
    Route::delete('FollowRequest/{FollowRequest}', [FollowrequestController::class,'Delete']);
    Route::post('FollowRequest/{FollowRequest}', [FollowrequestController::class,'create'])->middleware('verified');
    // Followers
    Route::get('Follower',[FollowerController::class,'index']);
    Route::delete('Follower/{follower}', [FollowerController::class,'Delete']);
    // Followings
    Route::get('Following',[FollowingController::class,'index']);
    Route::delete('Following/{following}', [FollowingController::class,'Delete']);



});
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

//email verification
// Verify email
Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke']);
Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke']);
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store']);

// Priacy of User,block user, Forget Password ,Email verification
//Extra: Gmail Api, Filter,chat ,story Search as feature
// Exception handler , more middle ware for json response, Base64 for images
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
