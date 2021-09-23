<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactionRequest;
use App\Http\Resources\ReactionResource;
use App\Models\Comment;
use App\Models\Reaction;
use App\Models\Follower;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...


                 $posts=Reaction::where('user_id',$request->user()->id)->paginate(15);
                 return ReactionResource::collection( $posts);
    }
    public function show(Reaction $reaction)
    {
        # code...
        return new ReactionResource($reaction);
    }

    public function  create(ReactionRequest $request)
    {
        # code...


        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;
        $user=Comment::find($request->comment_id)->post->user;
        if($user->id !=$arr['user_id'])
        {
            $follower=Follower::where('user_id',$user->id)->where('follower_id',$arr['user_id'])->get();
            if($follower!=null || $user->privacy)
           {   $user_commenter=Comment::find($request->comment_id)->user;
                $postreaction= Reaction::create($arr);
                if($user_commenter->id!=$arr['user_id'])
             SendnotificationController::commentreactnotification($request,$postreaction,$user_commenter);
            return  new ReactionResource($postreaction );
           }
        }
        else
        {    $postreaction= Reaction::create($arr);
            return  new ReactionResource($postreaction );
        }



    }
    public function Delete(Request $request,Reaction $reaction)
    {
        $this->authorize('view',$reaction);
        $reaction->delete();

    }
    public function Update(Request $request,Reaction $reaction)
    {

      $this->authorize('view',$reaction);
      $request= $request->validate([
        'react' => 'required']);

        return  $reaction->update($request);


    }
}
