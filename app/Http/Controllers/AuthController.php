<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
      
    } 

    public function login(Request $request)
    {
        $credentials = Validator::make($request->all(),[
            'email' => ['required', 'email'],
            'password' => ['required'],
        ],[
            'email.required'=>'L\'email est obligatoire',
            'password.required'=>'mot de passe est obligatoire',
            'email.email' => 'format de l\'email est incorrect'
        
        ]); 

        if ($credentials->fails()) {
            return response()->json([$credentials->messages()], 401);
        }

        $validated = $credentials->validated();
 
        $user = User::where('email', $validated['email'])->first();

        if($user && Hash::check($validated['password'],$user->password))
        {
            return response()->json([
                'user'=> $user,
                'token' => $user->createToken(time())->plainTextToken
            ],200);
            
        }

        return response()->json([
             ['messages'=> "email ou mot de passe est incorrect"]
        ],422);
      
    }

    public function getRole(Request $request)
    {   
         return response()->json([
            'is_admin' => auth()->user()->is_admin
         ]);
        
    }
}
