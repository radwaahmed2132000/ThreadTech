<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...


                 $Reply=Reaction::where('user_id',$request->user()->id)->paginate(15);
                 return RepliesResource::collection( $Reply);
    }

    public function  create(ReplyRequest $request)
    {
        # code...

        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;


        return  new ReplyResource(  Reaction::create($arr));

    }
    public function Delete(Request $request,$id)
    {

        $Reply=Reaction::where('user_id',$request->user()->id)->where('id',$id)->first();
        if($Reply!=null)
        $Reply->delete();
    }
    public function Update(UpdateReplyRequest  $request,$id)
    {
        $Reply=Reaction::where('user_id',$request->user()->id)->where('id',$id)->first();
        if($Reply!=null)
        return  $Reply->update($request->all());

    }
}
