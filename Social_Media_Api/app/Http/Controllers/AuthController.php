<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Auth\Events\Registered;
class AuthController extends Controller
{

    public function  Login(LoginRequest $request)    {
        # code...
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);



     if(!Auth::attempt($credentials))
    {
       return $this->error_response( " User not found");
    }
     $user=User::where('email',$request->email)->first();
     $token=$user->createToken('Backend')->accessToken;


       event(new Registered($user));
     return $this->success_response(["token"=>$token,"user"=>$user]);
    }
    public function  Signup(SignUpRequest $request)
    {
        # code...
        $request['password']=bcrypt($request->password);


          $user=User::create( $request->all());
           event(new Registered($user));
        $token=$user->createToken('Backend')->accessToken;
        return $this->success_response( ["token"=>$token,"user"=>$user]);


    }
    public function Logout(Request $request)
    {
        $request->user()->token()->revoke();
       return $this->success_response( "You logged out successfully");
    }
}
