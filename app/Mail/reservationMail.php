<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class reservationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $reserDetail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->reserDetail = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('goomoovies@gmail.com')
                    ->subject('Confirmation de votre réservation')
                    ->with(['reserDetail'=>$this->reserDetail])
                    ->view('emails.reservationEmail');
    }
}
