<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Http\Requests\PostreactionRequest;
use App\Http\Resources\PostreactionResource;
use App\Models\Follower;
use App\Models\Following;
use App\Models\Postreaction;
use App\Models\Post;
use Illuminate\Http\Request;

class PostreactionController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...


                 $posts=Postreaction::where('user_id',$request->user()->id)->paginate(Config::PAGINATION_LIMIT);
                 return $this->success_response( PostreactionResource::collection( $posts));
    }
    public function show(Postreaction $postreaction)
    {
        # code...
         return $this->success_response(new PostreactionResource($postreaction));
    }

    public function  create(PostreactionRequest $request)
    {
        # code...


        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;
        $post=Post::find($request->post_id);

        $user=$post->user;
        if( $user->id !=$arr['user_id'])
        {
            $follower=Follower::where('user_id',$user->id)->where('follower_id',$arr['user_id'])->get();
            if($follower!=null || $user->privacy)
            { $postreaction= Postreaction::create($arr);
            SendnotificationController::postnotification($request,$postreaction);
            return $this->success_response( new PostreactionResource($postreaction));
            }
            return $this->error_response("Failed");
        }
        else
        {
            // me react to me
            $postreaction= Postreaction::create($arr);
            return $this->success_response( new PostreactionResource($postreaction));
        }



    }
    public function Delete(Request $request,Postreaction $postreaction)
    {
        $this->authorize('view',$postreaction);
       $this->success_response( $postreaction->delete());

    }
    public function Update(Request $request,Postreaction $postreaction)
    {

      $this->authorize('view',$postreaction);
      $request= $request->validate([
        'react' => 'required']);

        return $this->success_response( $postreaction->update($request));


    }
}
