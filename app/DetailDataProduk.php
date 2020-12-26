<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailDataProduk extends Model
{
    protected $table = 'detail_data_produk';

    protected $fillable = [
        'id_registrasi_data_produk',
        'merk'        
    ];
}
