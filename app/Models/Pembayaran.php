<?php

namespace App\Models;
use App\Models\Registrasi;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';


    protected $guarded = [
        'id'
    ];

    


   /* public function registrasi(){
        return $this->hasOne(
            Registrasi::class,
            'id_pembayaran',
            'id_registrasi',
        );
    }*/

    
}
