<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrasiJumlahProduksi extends Model
{
    protected $table = 'registrasi_jumlah_produksi';

    protected $fillable = [
        'id_registrasi',
        'jenis_hewan',
        'jumlah_produksi_perhari',
        'jumlah_produksi_perbulan'        
    ];
}
