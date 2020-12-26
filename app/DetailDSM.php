<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailDSM extends Model
{
    protected $table = 'detail_data_sistem_manajemen';

    protected $fillable = [
        'id_data_sistem_manajemen',
        'sistem_manajemen',
        'sertifikasi_manajemen'
    ];
}
