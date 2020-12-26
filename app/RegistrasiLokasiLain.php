<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrasiLokasiLain extends Model
{
    protected $table = 'registrasi_data_lokasilainnya';

    protected $fillable = [
        'id_registrasi',
        'nama_lokasi_lainnya',
        'alamat_lainnya',
        'kota_lainnya',
        'telepon_lainnya',
        'kodepos_lainnya',
        'fax_lainnya',
        'narahubung_lainnya'
    ];
}
