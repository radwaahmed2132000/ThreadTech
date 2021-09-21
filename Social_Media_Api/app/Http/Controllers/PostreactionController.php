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
        $postreaction= Postreaction::create($arr);
        if( $postreaction->post->user->id !=$arr['user_id'])
         SendnotificationController::postnotification($request,$postreaction);
        return  new PostreactionResource($postreaction);

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
