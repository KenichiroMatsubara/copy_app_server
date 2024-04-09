<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

function rand_str(){
    $str_array = str_split("ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz0123456789あいうえおかきくけこさしすせそたちつてとなにぬねアイウエオカキクケコサシスセソタチツテトナニヌネ");
    $str = "";
    for($i=0;$i<=100;$i++){
        $str+= $str_array[rand(0, strlen($str_array)-1)];
    }
    return $str;
}

class ApiAuthController extends Controller
{
    public function register(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->token = rand_str();
        $user->save();
        return response()->json([
            'status'=>true,
            'message'=>'User Created successfully!',
            'data'=>$user,
        ],201);

    }
    public function login(Request $request){
        $user = User::where('email',$request->email)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                return response()->json([
                    'status'=>true,
                    'message'=> 'Login success!',
                    'token'=>$user->token,
                ],200);
            }
            else {
                return response()->json([
                    'status'=>false,
                    'message'=> 'Password is wrong',
                ],404);
            }
        }
        else {
            return response()->json([
                'status'=>false,
                'message'=> 'User not found'
            ],404);
        }
    }
    public function user(Request $request){
        $user = User::where('token',$request->token)->first();
        return response()->json([
            'status'=>true,
            'message'=> 'You get user data Successfully!',
            'data'=>$user
        ],200);
    }
    public function logout(Request $request){
        $user = User::where('token',$request->token)->first();
        $user->token = rand_str();
        $user->update();
        return response()->json([
            "status"=>true,
            "message"=> "You logout successfully!",
            "data"=>$user
        ],200);
    }
}
