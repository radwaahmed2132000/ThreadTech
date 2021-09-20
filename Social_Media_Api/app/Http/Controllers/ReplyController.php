<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Http\Resources\RepliesResource;
use App\Http\Resources\ReplyResource;
use Illuminate\Http\Request;
use App\Models\Reply;
class ReplyController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...


                 $Reply=Reply::where('user_id',$request->user()->id)->paginate(15);
                 return RepliesResource::collection( $Reply);
    }

    public function  create(ReplyRequest $request)
    {
        # code...

        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;


        return  new ReplyResource(  Reply::create($arr));

    }
    public function Delete(Request $request,Reply $reply)
    {
        $this->authorize('view',$reply);
        $reply->delete();


    }
    public function Update(UpdateReplyRequest  $request,Reply $reply)
    {
        $this->authorize('view',$reply);

        return  $reply->update($request->validated());
    }
}
