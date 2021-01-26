<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'id_user',
        'nama_penulis',
        'judul_berita',
        'tanggal_publikasi',
        'isi_berita',
        'status_approve'
    ];
}
