<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $registrasi;
    public $user;
    public $pembayaran;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registrasi, $user, $pembayaran, $status)
    {
        $this->registrasi = $registrasi;
        $this->user = $user;
        $this->pembayaran = $pembayaran;
        $this->status = $status;

    }    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.cancelorder');
    }
}
