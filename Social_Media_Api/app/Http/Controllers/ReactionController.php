<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactionRequest;
use App\Http\Resources\ReactionResource;
use App\Models\Reaction;
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
        $postreaction= Reaction::create($arr);
        if( $postreaction->comment->user->id !=$arr['user_id'])
         SendnotificationController::commentreactnotification($request,$postreaction);


        return  new ReactionResource($postreaction );

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
