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
    public function show(Comment $comment)
    {
        # code...
        return new CommentResource($comment);
    }

    public function  create(CommentRequest $request)
    {
        # code...

        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;

        return  new CommentResource ( Comment::create($arr));

    }
    public function Delete(Request $request,Comment $comment)
    {

        $this->authorize('view',$comment);
        $comment->delete();
    }
    public function Update(UpdateCommentRequest $request,Comment $comment)
    {
         $this->authorize('view',$comment);

        return  $comment->update($request->validated());
    }
}
