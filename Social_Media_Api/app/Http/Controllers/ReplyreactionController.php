<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyreactionRequest;
use App\Http\Resources\ReplyreactionResource;
use Illuminate\Http\Request;
use App\Models\Replyreaction;
class ReplyreactionController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...


                 $posts=Replyreaction::where('user_id',$request->user()->id)->paginate(15);
                 return ReplyreactionResource::collection( $posts);
    }

    public function  create(ReplyreactionRequest $request)
    {
        # code...


        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;

        $postreaction= Replyreaction::create($arr);

        if( $postreaction->reply->user_id !=$arr['user_id'])
         SendnotificationController::replyreactnotification($request,$postreaction);

        return  new ReplyreactionResource(  $postreaction);

    }
    public function Delete(Request $request,Replyreaction $replyreaction)
    {
        $this->authorize('view',$replyreaction);
        $replyreaction->delete();

    }
    public function Update(Request $request,Replyreaction $replyreaction)
    {

      $this->authorize('view',$replyreaction);
      $request= $request->validate([
        'react' => 'required']);
        return  $replyreaction->update($request);


    }
}
