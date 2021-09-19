<?php

namespace App\Http\Controllers;

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
                 return $posts;
    }
    
    public function  create(Request $request)
    {
        # code...

        $arr=$request->all();
        $arr['user_id']=$request->user()->id;

        return  Post::create($arr);

    }
    public function Delete(Request $request,$id)
    {

        $post=Post::where('user_id',$request->user()->id)->where('id',$id)->first();
        if($post!=null)
        $post->delete();
    }
    public function Update(Request $request,$id)
    {
        $post=Post::where('user_id',$request->user()->id)->where('id',$id)->first();
        if($post!=null)
        return  $post->update($request->all());

    }
    public function  Getallposts(Request $request)
    {
        # code...

    }
}
