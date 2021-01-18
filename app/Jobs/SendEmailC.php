<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\CancelOrder;
use App\Models\Registrasi;
use App\Models\Pembayaran;
use App\Models\System\User;
use Illuminate\Support\Facades\Mail;


class SendEmailC implements ShouldQueue
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
        $email = new CancelOrder($this->registrasi,$this->user,$this->pembayaran, $this->status);
        Mail::to($this->user['email'])->send($email);
    }
}
