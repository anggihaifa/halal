<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    protected $table = 'pelatihan';

    protected $fillable = [
        'id_user',
        'nama_penulis',
        'judul_pelatihan',        
        'gambar_cover',
        'isi_pelatihan',
        'status_approve'
    ];
}
