<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrasiDPH extends Model
{
    protected $table = 'registrasi_dph';

    protected $fillable = [
        'id_registrasi',
        'nama_dph',
        'ktp_dph',
        'sertif_dph',
        'no_tglsk_dph',
        'no_kontrak_dph'
    ];
}
