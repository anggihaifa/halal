<?php

namespace App\Models;
use App\Models\Master\JenisRegistrasi;
use App\Models\Master\KelompokProduk;
use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    // protected $table = 'registrasi_v2';
    protected $table = 'registrasi';

    protected $fillable = [
        'status_cancel'
    ];


    protected $guarded = [
        'id'
    ];


    public function jenis_registrasi(){
        return $this->hasOne(
            JenisRegistrasi::class,
            'id',
            'id_jenis_registrasi',
        );
    }

    public function kelompok_produk(){
        return $this->hasOne(
            KelompokProduk::class,
            'id',
            'id_kelompok_produk',
        );
    }
}
