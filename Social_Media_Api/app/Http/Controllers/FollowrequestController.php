<?php

namespace App\Http\Controllers;
use App\Http\Resources\FollowrequestResource;
use App\Models\Followrequest;
use Exception;
use App\Models\Follower;
use App\Models\Following;
use App\Notifications\FollowrequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowrequestController extends Controller
{
    //add  with not respone
    public function create(Request $request,$FollowRequest)
    {
        # code...
        $arr=[];
        $arr['requester_id']= $FollowRequest;
        $arr['user_id']=$request->user()->id;
        $arr['request']=false;
        new FollowrequestNotification($request->user()->name);
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

        return FollowrequestResource::collection(Followrequest::where('user_id',$request->user()->id)->paginate());
    }
    //accept
    // example:
       // 1        2
    // ahmed send to mohmaed   request
    // user_id         requester_id  false
    //mohamed accept ahmed

    public function Update(Request $request,$FollowRequest)
    {
        $requester_id=$FollowRequest;
        $arr=[
            //ahmed 1
            'user_id'=>$requester_id,
            //mohamed         2
            'requester_id'=>$request->user()->id
        ];



        try
        {
            DB::beginTransaction();
            // accept done
            Followrequest::where($arr)->update(['request'=>true]);
            // ahmed has a follower mohamed
            Following::create(['user_id'=>$arr['user_id'],'following_id'=>$arr['requester_id']]);
            // mohamed has a following ahmed
            Follower::create(['user_id'=>$arr['requester_id'],'follower_id'=>$arr['user_id']]);

            DB::commit();
            return" done";

        }
        catch(Exception $e)
        {
          DB::rollBack();
        }


    }
}
