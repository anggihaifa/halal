<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrasiDataSDM extends Model
{
    protected $table = 'registrasi_data_sdm';

    protected $fillable = [
        'id_registrasi',
        'jenis_sdm',
        'nama_sdm',
        'ktp_sdm',
        'sertif_sdm',
        'no_tglsk_sdm',
        'no_kontrak_sdm'        
    ];
}
