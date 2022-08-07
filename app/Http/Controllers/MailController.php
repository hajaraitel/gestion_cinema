<?php

namespace App\Http\Controllers;
use App\Mail\reservationMail;
use Mail;


use Illuminate\Http\Request;

class MailController extends Controller
{
    public function sendMail()
    {
        Mail::to('testuser@test.com')->send(new reservationMail());

    }
}
