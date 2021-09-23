<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Http\Resources\RepliesResource;
use App\Http\Resources\ReplyResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Follower;
class ReplyController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...


                 $Reply=Reply::where('user_id',$request->user()->id)->paginate(15);
                 return RepliesResource::collection( $Reply);
    }

    public function  create(ReplyRequest $request)
    {
        # code...

        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;
        $user=Comment::find($request->comment_id)->post->user;
        if( $user->id !=$arr['user_id'])
       {
          $follower=Follower::where('user_id',$user->id)->where('follower_id',$arr['user_id'])->get();
          if($follower!=null || $user->privacy)
         { $postreaction= Reply::create($arr);
            $user_replier=Comment::find($request->comment_id)->user;
            if($user_replier->id!=$arr['user_id'])
           SendnotificationController::replynotification($request,$postreaction,$user_replier);
           return  new ReplyResource(   $postreaction);
         }

       }
       else
       {
        $postreaction= Reply::create($arr);
        return  new ReplyResource(   $postreaction);
       }



    }
    public function Delete(Request $request,Reply $reply)
    {
        $this->authorize('view',$reply);
        $reply->delete();


    }
    public function Update(UpdateReplyRequest  $request,Reply $reply)
    {
        $this->authorize('view',$reply);

        return  $reply->update($request->validated());
    }
    public function show(Reply $reply)
    {
        # code...
        return new ReplyResource($reply);
    }
}
