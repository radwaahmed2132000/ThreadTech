<?php

namespace App\Http\Controllers;
use App\Http\Resources\FollowrequestResource;
use App\Models\Followrequest;
use Exception;
use App\Models\Follower;
use App\Models\Following;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowrequestController extends Controller
{
    //add  with not respone
    public function create(Request $request,$FollowRequest)
    {
        # code...
        $arr= $FollowRequest;
        $arr['user_id']=$request->user()->id;
        $arr['request']=false;
        new FollowrequestResource(  Followrequest::create($arr));
    }
    // decline  follow request
    public function Delete(Request $request,$FollowRequest)
    {

        Followrequest::where('requester_id',$FollowRequest)->where('user_id',$request->user()->id)->delete();
    }
    // show follow request
    public function index(Request $request)
    {
        return FollowrequestResource::collection(Followrequest::where('user_id',$request->user()->id));
    }
    //accept
    public function Update(Request $request,$FollowRequest)
    {
        $requester_id=$FollowRequest;
        $arr=[
            'requester_id'=>$requester_id,
            'user_id'=>$request->user()->id
        ];



        try
        {
            DB::beginTransaction();



            Followrequest::where($arr)->update(['request'=>true]);
            Follower::create(['user_id'=>$request->user()->id,'follower_id'=>$requester_id]);
            Following::create(['user_id'=>$requester_id,'following_id'=>$request->user()->id]);

            DB::commit();
            return" done";

        }
        catch(Exception $e)
        {
          DB::rollBack();
        }


    }
}
