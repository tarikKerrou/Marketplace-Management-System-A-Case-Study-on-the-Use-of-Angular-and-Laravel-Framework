<?php

namespace App\Http\Controllers;
use App\Models;
use Illuminate\Http\Request;

class UtulisateurController extends Controller
{
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
        'email'=>'required|unique:users',
        'password'=>'required',
        
        
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->all()],409);
        }
        $usr=new User();
        $usr->name=$request->name;
        $usr->email=$request->email;
        $usr->password=encrypte($request->passwod);
        
        $usr->save();
        return response()->json(['message'=>'Successfully register']);
}
   public function login (Request $request){
    $validator=Validator::make($request->all(),[
        'email'=>'required|unique:users',
        'password'=>'required',
        
        
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->all()],409);
        };
        $user=User::where('email',$request->email)->get();
        $password =decrypt($user->password);
        if($user&&$password->$request->password){return response()->json(['error'=>$user]);}
        else return response()->json(['error'=>'Something Going Wrong']);
   }
}