<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ProgresStatus;
use App\Mail\EmailAuditor;
use App\Models\Registrasi;
use App\Models\Pembayaran;
use App\Models\System\User;
use Illuminate\Support\Facades\Mail;

class SendEmailAuditor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 1200;
    public $user;
    public $registrasi;
    public $penjadwalan;
    public $status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$registrasi,$penjadwalan, $status)
    {
        //
        
        $this->user = $user;
        $this->registrasi = $registrasi;
        $this->penjadwalan = $penjadwalan;
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
        $email = new EmailAuditor($this->user,$this->registrasi,$this->penjadwalan, $this->status);
        Mail::to($this->user['email'])->send($email);
    }
}
