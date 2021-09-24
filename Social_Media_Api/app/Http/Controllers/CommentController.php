<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentsResource;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Follower;
use App\Http\Misc\Helpers\Config;
use App\Http\Misc\Helpers\Errors;
use App\Http\Misc\Helpers\Success;

class CommentController extends Controller
{
    //

    public function index(Request $request)
    {
        # code...


                 $Comment=Comment::where('user_id',$request->user()->id)->paginate(Config::PAGINATION_LIMIT);
                 return  $this->success_response(CommentsResource::collection( $Comment));
    }
    public function show(Comment $comment)
    {
        # code...
        return  $this->success_response( new CommentResource($comment));
    }

    public function  create(CommentRequest $request)
    {
        # code...

        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;
        $post=Post::find($request->post_id);
         $user=$post->user;

        if($user->id !=$arr['user_id'])
      {
        $follower=Follower::where('user_id',$user->id)->where('follower_id',$arr['user_id'])->get();
            if($follower!=null)
            {   $postreaction=  Comment::create($arr);
                SendnotificationController::commentnotification($request,$postreaction);
                return $this->success_response(  new CommentResource ($postreaction));
            }
            return $this->error_response("Failed");
      }
      else
      {
        $postreaction=  Comment::create($arr);
        return   $this->success_response( new CommentResource ($postreaction));
      }



    }
    public function Delete(Request $request,Comment $comment)
    {

        $this->authorize('view',$comment);
        $this->success_response( $comment->delete());
    }
    public function Update(UpdateCommentRequest $request,Comment $comment)
    {
         $this->authorize('view',$comment);

        return  $this->success_response( $comment->update($request->validated()));
    }

}
