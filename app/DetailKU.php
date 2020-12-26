<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailKU extends Model
{
    protected $table = 'detail_registrasi_kelompok_usaha';

    protected $fillable = [
        'id_registrasi_kelompok_usaha',
        'sertifikat_lainnya'        
    ];
}
