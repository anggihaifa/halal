<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use App\Services\FileUploadServices;
use Illuminate\Support\Facades\Auth;
use App\Models\System\User;

class PelangganController extends Controller
{
    public function user(){        
        // dd("disini");
        $getPelanggan =   DB::table('registrasi')
                    ->join('registrasi_alamatkantor','registrasi.id','=','registrasi_alamatkantor.id_registrasi')
                    ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')
                    ->join('registrasi_pemilik_perusahaan','registrasi.id','=','registrasi_pemilik_perusahaan.id_registrasi')
                    ->where('registrasi.status','28')
                    // ->select('registrasi.*','resgitrasi_alamatkantor.*','penjadlwan.*')
                    ->get();
        $dataPelanggan = json_decode($getPelanggan,true);
        // dd($dataPelanggan);

        return view('master.pelanggankami.create',compact('dataPelanggan'));        
	}
}
