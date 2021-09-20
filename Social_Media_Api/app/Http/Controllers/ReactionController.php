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

    public function  create(ReactionRequest $request)
    {
        # code...


        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;

        return  new ReactionResource( Reaction::create($arr));

    }
    public function Delete(Request $request,Reaction $reaction)
    {
        $this->authorize('view',$reaction);
        $reaction->delete();

    }
    public function Update(ReactionRequest $request,Reaction $reaction)
    {

      $this->authorize('view',$reaction);

        return  $reaction->update($request->validated());


    }
}
