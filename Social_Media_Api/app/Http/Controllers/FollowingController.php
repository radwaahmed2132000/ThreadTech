<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Http\Resources\FollowingResource;
use App\Models\Following;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class FollowingController extends Controller
{
    //

    public function Delete(Request $request,$following)
    {
        try
        {
        DB::beginTransaction();

        Following::where('following_id',$following)->where('user_id',$request->user()->id)->delete();

       Follower::where('user_id',$following)->where('follower_id',$request->user()->id)->delete();
        DB::commit();
        return $this->success_response('Deleted Successfully');
    }
    catch(Exception $e)
    {
      DB::rollBack();
      return $this->error_response("Failed Process");
    }
    }
    public function index(Request $request)
    {
        return $this->success_response( FollowingResource::collection(Following::where('user_id',$request->user()->id)->paginate(Config::PAGINATION_LIMIT)));
    }

}
