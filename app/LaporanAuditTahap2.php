<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanAuditTahap2 extends Model
{
    protected $table = 'laporan_audit_tahap2';

    protected $fillable = [
        'id_user',
        'id_registrasi',
        'nomor_id',
        'skema_audit',
        'jenis_audit',
        'no_audit',
        'nama_perusahaan',
        'alamat',
        'tanggal_audit',
        'tujuan_audit',
        'lingkup_audit',
        'jenis_produk',
        'lokasi_audit1',
        'lokasi_audit2',
        'tim_audit1',
        'tim_audit2'
    ];
}
