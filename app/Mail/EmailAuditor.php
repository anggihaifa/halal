<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailAuditor extends Mailable
{
    use Queueable, SerializesModels;

   
    public $user;
    public $registrasi;
    public $penjadwalan;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$registrasi, $penjadwalan, $status)
    {        
        
        $this->user = $user;
        $this->registrasi = $registrasi;
        $this->penjadwalan = $penjadwalan;
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
        //dd( $this);
        if($this->status == 'audit1'){
            $this->subject('Jadwal Audit Tahap 1 Untuk Pendaftaran Dengan No registrasi ');

        }elseif($this->status == 'audit2'){
            $this->subject('Jadwal Audit Tahap 2 Untuk Pendaftaran Dengan No registrasi ');

        }elseif($this->status == 'rapat'){
            $this->subject('Jadwal Rapat Audit Untuk Pendaftaran Dengan No registrasi ');

        }elseif($this->status == 'tinjauan'){
            $this->subject('Jadwal Tinajaun Komite Untuk Pendaftaran Dengan No registrasi ');

        }else{

            $this->subject('Emai Auditor');

        }

        return $this->view('mail.emailauditor');

        //alert("disini");
    }

    
}
