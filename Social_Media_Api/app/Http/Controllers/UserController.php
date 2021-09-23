<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        return new UserResource($request->user());
    }
    public function Delete(Request $request)
    {
        $user=$request->user();
        $request->user()->token()->revoke();
        $user->delete();
        return $this->success_response( "Your account has been deteleted successfully");

    }
    public function Update(UserRequest $request)
    {
        $user=$request->user();
        if($request->has('name'))
        {
            $user['name']=$request->name;

        }
        if($request->has('mobilephone'))
        {
            $user['mobilephone']=$request->mobilephone;
        }
        if($request->has('image'))
        {
            $user['image']=$request->image;
        }
        $user->save();
        return $this->success_response( $user);

    }
    public function ChangePassword(PasswordRequest $request )
   {
       $arr=$request->all();

       $user=$request->user();

       if($arr['password']==$arr['confrimpassword'])
       {
          $user['password']=bcrypt($arr['password']);
          $user->save();
          return $this->success_response( "Password is changed successfully");
       }

       return $this->error_response(" Passwords don't match");
   }
   public function Getposts(Request $request)
   {
       # code...
       $user=$request->user();

       return $this->success_response( $user->post);
   }
}
