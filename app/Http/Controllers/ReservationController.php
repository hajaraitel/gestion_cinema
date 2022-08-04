<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_reservation= DB::table('reservations')
        ->Join('users','reservations.idUser','=',"users.idUser")
        ->Join('seances','reservations.idSeance','=',"seances.idSeance")
        ->select('reservations.*','users.nom','users.prenom','users.email','seances.date_seance',)
        ->get();
        return response()->json($list_reservation);
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
        //
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

    public function countReservation()
    {
        $reservations = Reservation::all();

        $allReservations = [
            'reservations' => $reservations,
            'reservations_count' => $reservations->count()
        ];

        return $allReservations;
    }
    public function sumReservation()
    {
        $reservations = Reservation::all();

        $allReservations = [
            'reservations' => $reservations,
            'reservations_sum' => $reservations->sum('prix_total')
        ];

        return $allReservations;
    }
}
