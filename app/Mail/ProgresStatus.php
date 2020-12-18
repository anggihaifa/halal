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
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $status)
    {
        //
        $this->user = $user;
        $this->status=$status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.progresstatus');
       // error_log("tes");
    }

    
}
