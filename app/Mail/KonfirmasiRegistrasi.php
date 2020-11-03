<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KonfirmasiRegistrasi extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $registrasi;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$registrasi)
    {
        //
        $this->user = $user;
        $this->registrasi = $registrasi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.konfirmasiregistrasi');
    }
}
