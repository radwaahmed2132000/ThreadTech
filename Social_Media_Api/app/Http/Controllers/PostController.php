<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...


                 $posts=Post::where('user_id',$request->user()->id)->paginate(Config::PAGINATION_LIMIT);
                 return $this->success_response( PostsResource::collection( $posts));
    }
    public function show(Request $request,Post $post)
    {
        # code...
         if( $this->authorize('view',$post))
        return $this->success_response(new PostResource($post));
        else
        {
            $user=$post->user();
            $follower=Follower::where('user_id',$user->id)->where('follower_id',$request->user()->id)->get();
            if($follower!=null)
            {
                return $this->success_response(new PostResource($post));
            }
            return $this->error_response('Failed');

        }
    }
    public function  create(PostRequest $request)
    {
        # code...


        $arr=$request->validated();
        $arr['user_id']=$request->user()->id;

        return $this->success_response( new PostResource( Post::create($arr)));

    }
    public function Delete(Request $request,Post $post)
    {
        $this->authorize('view',$post);
       return $this->success_response($post->delete());

    }
    public function Update(PostRequest $request,Post $post)
    {

      $this->authorize('view',$post);

        return $this->success_response( $post->update($request->validated()));


    }
    public function  Getallposts(Request $request)
    {
        # code...

    }
}
