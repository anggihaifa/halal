<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KebutuhanWaktuAudit extends Model
{
    protected $table = 'kebutuhan_waktu_audit';
    protected $fillable = ['ktgprod','total_waktu_kebutuhan_audit','w_dasar','h_keamanan_pangan','h_variasi_produk','h_jumlah_bahan','ft_equivalent','t_lokasi_dikunjungi','w_p_audit','
    w_pengujian','w_pelaporan_audit','w_verifikasi','w_tehnical_review','w_rapat_komite','faktor1','faktor2','faktor3','faktor4','faktor5','faktor6','faktor7','faktor8','faktor9','faktor10','faktor11','faktor12','faktor13','faktor14'];
}
