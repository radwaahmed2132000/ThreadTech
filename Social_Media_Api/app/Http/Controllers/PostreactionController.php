<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostreactionRequest;
use App\Http\Resources\PostreactionResource;
use App\Models\Postreaction;
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

    public function  create(PostreactionRequest $request)
    {
        # code...


        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;

        return  new PostreactionResource( Postreaction::create($arr));

    }
    public function Delete(Request $request,Postreaction $postreaction)
    {
        $this->authorize('view',$postreaction);
        $postreaction->delete();

    }
    public function Update(PostreactionRequest $request,Postreaction $postreaction)
    {

      $this->authorize('view',$postreaction);

        return  $postreaction->update($request->validated());


    }
}
