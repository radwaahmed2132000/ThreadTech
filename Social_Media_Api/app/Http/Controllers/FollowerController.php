<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
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
        return $this->success_response( FollowerResource::collection(Follower::where('user_id',$request->user()->id)->paginate(Config::PAGINATION_LIMIT)));
    }

}
