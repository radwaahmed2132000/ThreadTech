<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\FollowerResource;
use App\Models\Follower;
use App\Models\Following;
use Illuminate\Support\Facades\DB;
use Exception;
class FollowerController extends Controller
{
    // May delete change with another priorty

    public function Delete(Request $request,$follower)
    {

        // me has follower mohamed
        // me delete mohamed
        try
        {
            DB::beginTransaction();

              Follower::where('follower_id',$follower)->where('user_id',$request->user()->id)->delete();
            // // me deleted from moha,ed following
             Following::where('following_id',$request->user()->id)->where('user_id',$follower)->delete();
          DB::commit();
        }
        catch(Exception $e)
        {
          DB::rollBack();
        }

    }
    public function index(Request $request)
    {
        return FollowerResource::collection(Follower::where('user_id',$request->user()->id)->paginate());
    }

}
