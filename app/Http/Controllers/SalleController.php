<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;

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
        //need validation 
        $salle = new Salle();
        $salle->nom =  $request->nom;
        $salle->capacite = $request->capacite;
        $salle->save();   
        return response()->json($salle);
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
        $salle = Salle::find($idSalle);
        if($salle)
        {
            $salle->nom =  $request->nom;
            $salle->capacite = $request->capacite;
            $salle->save();
            return response()->json($salle);
        }
        return "erreur";   
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
