<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(User::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request,$id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator  = Validator::make($request->all(), [
            'nom' => ['required', 'max:20', 'string'],
            'prenom' => ['required','string'],
            'email' => ['required','string','email'],
            'telephone' => ['string'],
            'sexe' => ['string'],
            'photo'=>['string']
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages()->all(), 400);
        }

        $validated = $validator->validated();

        $user = User::find($id);

        
        if($user)
        {
            if($user->photo != $validated['photo']){
                $img_url = '/images/users/';
                $upload_path = public_path('images/users');
                //$generated_new_name = $user->idUser . '_' . $validated['photo'];
                $img = $img_url.$validated['photo'];
            }else
                $img = $user->photo;

            $user->nom =  $validated['nom'];
            $user->prenom = $validated['prenom'];
            $user->email = $validated['email'];
            $user->sexe = $validated['sexe'];
            $user->telephone = $validated['telephone'];
            $user->photo = $img;
            $user->save();  
            return response()->json($user);
             
        }

        return response()->json(["error"=>"erreur lors de l'enregistrement"], 400); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * update password
     */
    public function update_password(Request $request, $id)
    {
        $user = User::find($id);
        $actual_pd = $request->mp_actuel;
        if($user)
        {   
            //check if current password is ok
            if (Hash::check($actual_pd, $user->password)) {
                $user->password = Hash::make($request->mp_nouveau);
                $user->save();
                return response()->json([
                    ['success'=> "mot de passe modifié"]
            ],200);
                
            }else
            return response()->json(["error"=>"Le mot de passe actuel n'est pas correct"], 400);

            
        }
        return response()->json(["error"=>"user not found"], 400);
    }

}
