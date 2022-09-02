<?php

namespace App\Services;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationService
{

      /**
     * Display the  Reservation for the user.
     */
    public function showUserReservation($idUser)
    {
        $list_reser = DB::table('reservations')
            ->Join('users', 'reservations.idUser', '=', 'users.idUser')
            ->Join('seances', 'seances.idSeance', '=', 'reservations.idSeance')
            ->Join('salles', 'salles.idSalle', '=', 'seances.idSalle')
            ->Join('films', 'films.idFilm', '=', 'seances.idFilm')
            ->select('reservations.idReservation', 'users.idUser','seances.idSeance',
            'films.idFilm','salles.idSalle','salles.nom as nom_salle',
            'films.titre', 'seances.date_seance','seances.horaire','reservations.nb_adult',
            'reservations.nb_enfant','reservations.prix_total',
            'reservations.date_reservation','reservations.est_annule')
            ->where('reservations.idUser', '=', $idUser)
            ->get();
        
        return response()->json($list_reser);
    }

    /**
 * Display the specified Reservation.
 */
    public function show($id)
    {
        return response()->json(Reservation::find($id));
    }

    /*show reservation details */
    public static function getReservationDetail($idRes)
    {
        $reser = DB::table('reservations')
        ->Join('users', 'reservations.idUser', '=', 'users.idUser')
        ->Join('seances', 'seances.idSeance', '=', 'reservations.idSeance')
        ->Join('salles', 'salles.idSalle', '=', 'seances.idSalle')
        ->Join('films', 'films.idFilm', '=', 'seances.idFilm')
        ->select('reservations.idReservation', 'users.idUser','users.nom','users.prenom','users.email'
        ,'seances.idSeance',
        'films.idFilm','salles.idSalle','salles.nom as nom_salle',
        'films.titre', 'seances.date_seance','seances.horaire','reservations.nb_adult',
        'reservations.nb_enfant','reservations.prix_total',
        'reservations.date_reservation')
        ->where('reservations.idReservation', '=', $idRes)
        ->get()->first();
    
        return $reser;
    }
}