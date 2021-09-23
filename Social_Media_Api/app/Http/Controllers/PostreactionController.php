<?php

namespace App\Http\Controllers;

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


                 $posts=Postreaction::where('user_id',$request->user()->id)->paginate(15);
                 return PostreactionResource::collection( $posts);
    }
    public function show(Postreaction $postreaction)
    {
        # code...
         return new PostreactionResource($postreaction);
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
            return  new PostreactionResource($postreaction);
            }
        }
        else
        {
            // me react to me
            $postreaction= Postreaction::create($arr);
            return  new PostreactionResource($postreaction);
        }



    }
    public function Delete(Request $request,Postreaction $postreaction)
    {
        $this->authorize('view',$postreaction);
        $postreaction->delete();

    }
    public function Update(Request $request,Postreaction $postreaction)
    {

      $this->authorize('view',$postreaction);
      $request= $request->validate([
        'react' => 'required']);

        return  $postreaction->update($request);


    }
}
