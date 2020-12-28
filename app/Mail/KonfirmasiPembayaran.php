<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KonfirmasiPembayaran extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $registrasi;
    public $pembayaran;
    public $status;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registrasi,$user, $pembayaran, $status)
    {
        //

       
        $this->registrasi = $registrasi;
        $this->user = $user;
        $this->pembayaran = $pembayaran;
        $this->status = $status;
       // dd( $this);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Progres Status');
        //dd($this);

        return $this->view('mail.konfirmasipembayaran');
    }
}
