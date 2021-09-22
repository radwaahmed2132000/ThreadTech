<?php

namespace App\Http\Controllers;

use App\Http\Resources\FollowingResource;
use App\Models\Following;
use Illuminate\Http\Request;

class FollowingController extends Controller
{
    //

    public function Delete(Request $request,$following)
    {

        Following::where('following_id',$following)->where('user_id',$request->user()->id)->delete();
    }
    public function index(Request $request)
    {
        return FollowingResource::collection(Following::where('user_id',$request->user()->id));
    }

}
