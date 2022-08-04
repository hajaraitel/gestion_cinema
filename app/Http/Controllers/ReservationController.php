<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservationController extends Controller
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
        $credentials = Validator::make($request->all(),[
            'idSeance' => ['required'],
            'idUser' => ['required'],
            'nb_adult' => ['required', 'int'],
            'nb_enfant' => ['required', 'int'],
            'prix_total' => ['required','numeric'],
        ],[
            'nb_adult.required'=>'Nombre d\'adulte est obligatoire',
            'nb_enfant.required'=>'Nombre d\'enfant est obligatoire',
            'prix_total.required'=>'Le prix total est obligatoire',
        ]); 

        //cas erreur
        if ($credentials->fails()) {
            return response()->json([$credentials->messages()], 401);
        }
        //ok
        $validated = $credentials->validated();
        //$date = Carbon::now();// will get you the current date, time 
        //dd($date->format("YYYY-MM-D")); //this will dump the date time in the desired format
        $date =Carbon::now()->toDateString();
        $res = new Reservation();
        
        $res->idSeance = $validated['idSeance'];
        $res->idUser = $validated['idUser'];
        $res->nb_adult = $validated['nb_adult'];
        $res->nb_enfant = $validated['nb_enfant'];
        $res->prix_total = $validated['prix_total'];
        $res->date_reservation = $date;
        
        $res->save();
        return response()->json([
            ['success'=> "la séance à été réserver"]
       ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $res = Reservation::find($id);

        
        if($res)
        {
            $res->est_annule =  true;
            $res->save();  
            return response()->json($res);
             
        }

        return response()->json(["error"=>"erreur lors de l'annulation"], 400); 
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
}
