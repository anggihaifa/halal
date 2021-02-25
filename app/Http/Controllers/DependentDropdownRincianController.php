<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\KelompokProduk;
use App\Models\Master\DetailKelompokProduk;

class DependentDropdownRincianController extends Controller
{
    public function index()
    {
        $kelompok_produk = KelompokProduk::pluck('id', 'kelompok_produk');

        return view('registrasi.create', [
            'kel_produk' => $kelompok_produk,
        ]);
    }

    public function store(Request $request)
    {
        $detail_kelompok_produk = DetailKelompokProduk::where('id_kelompok_produk', $request->get('id'))
            // ->pluck('id','rincian_kelompok_produk');
            ->pluck('kode_klasifikasi','rincian_kelompok_produk');
    
        return response()->json($detail_kelompok_produk);
    }
}
