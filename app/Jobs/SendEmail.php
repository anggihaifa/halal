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

    protected $registrasi;
    protected $user;
    protected $pembayaran;
    protected $status;
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
        //echo("berhasil");
        //dd($this->pembayaran);
         //dd( $this);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //echo("berhasil");
        //dd($this->pembayaran);
        Mail::to($this->user['email'])->send(new ProgresStatus($this->registrasi,$this->user,$this->pembayaran, $this->status));
    }
}
