<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentsResource;
use Illuminate\Http\Request;
use App\Models\Comment;
class CommentController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...


                 $Comment=Comment::where('user_id',$request->user()->id)->paginate(15);
                 return CommentsResource::collection( $Comment);
    }

    public function  create(CommentRequest $request)
    {
        # code...

        $arr=$request->all();
        $arr['user_id']=$request->user()->id;

        return  new CommentResource ( Comment::create($arr));

    }
    public function Delete(Request $request,$id)
    {

        $Comment=Comment::where('user_id',$request->user()->id)->where('id',$id)->first();
        if($Comment!=null)
        $Comment->delete();
    }
    public function Update(UpdateCommentRequest $request,$id)
    {
        $Comment=Comment::where('user_id',$request->user()->id)->where('id',$id)->first();
        if($Comment!=null)
        return  $Comment->update($request->all());

    }
}
