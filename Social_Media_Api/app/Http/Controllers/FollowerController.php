<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\FollowerResource;
use App\Models\Follower;
class FollowerController extends Controller
{
    //

    public function Delete(Request $request,$follower)
    {

        Follower::where(['follower_id',$follower])->where('user_id',$request->user()->id)->delete();
    }
    public function index(Request $request)
    {
        return FollowerResource::collection(Follower::where('user_id',$request->user()->id));
    }

}
