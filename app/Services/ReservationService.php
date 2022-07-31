<?php

namespace App\Services;
use App\Models\Reservation;

class ReservationService
{

      /**
     * Display the  Reservation for the user.
     */
    public function showUserReservation($idUser)
    {
        
    }

    /**
 * Display the specified Reservation.
 */
    public function show($id)
    {
        return response()->json(Reservation::find($id));
    }
}