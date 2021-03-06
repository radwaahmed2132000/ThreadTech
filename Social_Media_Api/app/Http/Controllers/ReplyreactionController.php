<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Http\Requests\ReplyreactionRequest;
use App\Http\Resources\ReplyreactionResource;
use App\Models\Reply;
use App\Models\Follower;
use Illuminate\Http\Request;
use App\Models\Replyreaction;
class ReplyreactionController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...


                 $posts=Replyreaction::where('user_id',$request->user()->id)->paginate(Config::PAGINATION_LIMIT);
                 return $this->success_response( ReplyreactionResource::collection( $posts));
    }

    public function  create(ReplyreactionRequest $request)
    {
        # code...


        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;
        $user=Reply::find($request->reply_id)->comment->post->user;

        if( $user->id!=$arr['user_id'])
        {
            $follower=Follower::where('user_id',$user->id)->where('follower_id',$arr['user_id'])->get();
            if($follower!=null || $user->privacy)
         {   $postreaction= Replyreaction::create($arr);
            $user_replyier=Reply::find($request->reply_id)->user;
            if($user_replyier->id!=$arr['user_id'])
            SendnotificationController::replyreactnotification($request,$postreaction,$user_replyier);
            return $this->success_response( new ReplyreactionResource(  $postreaction));
         }
         return $this->error_response('Failed');

        }
        else
        {
            $postreaction= Replyreaction::create($arr);

            return $this->success_response( new ReplyreactionResource(  $postreaction));

        }

    }
    public function Delete(Request $request,Replyreaction $replyreaction)
    {
        $this->authorize('view',$replyreaction);
       return $this->success_response( $replyreaction->delete());

    }
    public function Update(Request $request,Replyreaction $replyreaction)
    {

      $this->authorize('view',$replyreaction);
      $request= $request->validate([
        'react' => 'required']);
        return $this->success_response( $replyreaction->update($request));


    }
}
