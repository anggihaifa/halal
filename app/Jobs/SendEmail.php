<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ProgresStatus as ProgresStatus;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $registrasi;
    public $user;
    public $pembayaran;
    public $status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($registrasi, $user, $pembayaran, $status)
    {        
       
        $this->registrasi = $registrasi;
        $this->user = $user;
        $this->pembayaran = $pembayaran;
        $this->status = $status;
         //dd( $this);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($user->email)->send(new ProgresStatus($registrasi,$user,$pembayaran, $status));
    }
}
