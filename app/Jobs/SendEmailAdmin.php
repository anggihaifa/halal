<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ProgresStatus;
use App\Models\Registrasi;
use App\Models\Pembayaran;
use App\Models\System\User;
use Illuminate\Support\Facades\Mail;

class SendEmailAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 1200;
    public $user;
    public $registrasi;
    public $pembayaran;
    public $status;
    /**
     * Create a new job instance.
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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        foreach($this->user as $key){
            $email = new ProgresStatus($this->registrasi,$key,$this->pembayaran, $this->status);
            Mail::to($key['email'])->send($email);
        }
       
    }
}
