<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProgresStatus extends Mailable
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
    public function __construct($registrasi, $user, $pembayaran, $status)
    {
        //

       
        $this->registrasi = $registrasi;
<<<<<<< HEAD
        $this->pembayaran = $pembayaran;
=======
         $this->user = $user;
         $this->pembayaran = $pembayaran;
>>>>>>> e509d021d524c2de9eac58f9ef77affc1ae8fcd0
        $this->status = $status;
        //dd( $this);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $this->subject('Progres Status');
        return $this->view('mail.progresstatus');
       // error_log("tes");
    }

    
}
