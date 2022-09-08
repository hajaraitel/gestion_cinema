<?php

namespace App\Services;
use App\Mail\reservationMail;
use Mail;

class MailService
{
    public function sendReservationMail($resDetail)
    {
        
        Mail::to($resDetail->email)->send(new reservationMail($resDetail));

    }
}