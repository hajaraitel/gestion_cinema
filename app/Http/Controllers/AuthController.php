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

        $credentials = Validator::make($request->all(),[
            'email' => ['required', 'email','unique:users'],
            'password' => ['required','min:5'],
            'nom' => ['required', 'regex:/^[a-zA-Z\s]*$/','max:20'],
            'prenom' => ['required', 'regex:/^[a-zA-Z\s]*$/','max:20'],
            'sexe' => ['string'],
            'photo'=>['string']
        ],[
            'email.required'=>'L\'email est obligatoire',
            'password.required'=>'Mot de passe est obligatoire',
            'password.min'=>'Mot de passe doit être au moins 5 caractères',
            'nom.required'=>'Nom est obligatoire',
            'nom.max' => 'Le nom ne doit pas dépasser 20 caractères',
            'nom.regex' => 'Le nom ne doit pas contenir des nombres',
            'prenom.required'=>'Prénom est obligatoire',
            'prenom.max' => 'Le prénom ne doit pas dépasser 20 caractères',
            'prenom.regex' => 'Le prénom ne doit pas contenir des nombres',
            'email.email' => 'Format de l\'email est incorrect',
            'email.unique' => 'L\'email est déjà utilisé',
        ]); 

        //cas erreur
        if ($credentials->fails()) {
            return response()->json($credentials->errors()->all(), 401);
        }
        //ok
        $img_url = "/images/users";
        $validated = $credentials->validated();
        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'sexe' => $validated['sexe'],
            'photo' => $img_url.'/user.png',
        ]);

        return response()->json([
            'success'=> "compte bien crée"
       ],200);
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
        //cas erreur
        if ($credentials->fails()) {
            return response()->json($credentials->errors()->all(), 401);
        }
        //ok
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
            'messages'=> "email ou mot de passe est incorrect"
        ],422);
      
    }

    public function getRole(Request $request)
    {   
         return response()->json([
            'is_admin' => auth()->user()->is_admin
         ]);
        
    }
}
