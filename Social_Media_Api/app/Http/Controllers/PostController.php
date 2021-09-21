<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...


                 $posts=Post::where('user_id',$request->user()->id)->paginate(15);
                 return PostsResource::collection( $posts);
    }
    public function show(Post $post)
    {
        # code...
        return new PostResource($post);
    }
    public function  create(PostRequest $request)
    {
        # code...


        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;

        return  new PostResource( Post::create($arr));

    }
    public function Delete(Request $request,Post $post)
    {
        $this->authorize('view',$post);
        $post->delete();

    }
    public function Update(PostRequest $request,Post $post)
    {

      $this->authorize('view',$post);

        return  $post->update($request->validated());


    }
    public function  Getallposts(Request $request)
    {
        # code...

    }
}
