<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_salle=Salle::all();
        return response()->json($list_salle);
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
        //validation 
        $validator  = Validator::make($request->all(), [
            'nom' => ['required', 'max:20', 'string'],
            'capacite' => ['required','integer'],
            
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages()->all(), 400);
        }

        $validated = $validator->validated();
        //
        $salle = new Salle();
        $salle->nom =  $request->nom;
        $salle->capacite = $request->capacite;
        $salle->save();   
        return response()->json(['salle'=>$salle],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salle  $salle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Salle::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salle  $salle
     * @return \Illuminate\Http\Response
     */
    public function edit(Salle $salle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salle  $salle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idSalle)
    {
        //need validation
        $validator  = Validator::make($request->all(), [
            'nom' => ['required', 'max:20', 'string'],
            'capacite' => ['required','integer'],
            
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages()->all(), 400);
        }

        $validated = $validator->validated();
        $salle = Salle::find($idSalle);
        if($salle)
        {
            $salle->nom =  $request->nom;
            $salle->capacite = $request->capacite;
            $salle->save();
            return response()->json(['salle'=>$salle],200);
        }
        return response()->json(["error"=>"erreur lors de l'enregistrement"], 400); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salle  $salle
     * @return \Illuminate\Http\Response
     */
    public function destroy($idSalle)
    {
        $salle=Salle::find($idSalle);
        if($salle)
        {
            $salle->delete();
            return response()->json($salle);
        }
        return "erreur";
    }
}
