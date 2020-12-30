<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function dataRegistrasiPelanggan(Request $request){
        $gdata = $request->except('_token','_method');
        
        $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                 ->join('users','registrasi.id_user','=','users.id')
                 //->join('users','registrasi.id','=','users.registrasi_id')
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan');

        //filter condition
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        if(isset($gdata['name'])){
            $xdata = $xdata->where('name','LIKE','%'.$gdata['name'].'%');
        }
        if(isset($gdata['perusahaan'])){
            $xdata = $xdata->where('perusahaan','LIKE','%'.$gdata['perusahaan'].'%');
        }
        if(isset($gdata['kelompok_produk'])){
            $xdata = $xdata->where('kelompok_produk','=',$gdata['kelompok_produk']);
        }
        if(isset($gdata['tgl_registrasi'])){
            $xdata = $xdata->where('tgl_registrasi','=',$gdata['tgl_registrasi']);
        }
        if(isset($gdata['jenis_registrasi'])){
            $xdata = $xdata->where('jenis_registrasi','=',$gdata['jenis_registrasi']);
        }
        if(isset($gdata['status_registrasi'])){
            $xdata = $xdata->where('status_registrasi','=',$gdata['status_registrasi']);
        }
        if(isset($gdata['metode_pembayaran'])){
            $xdata = $xdata->where('metode_pembayaran','=',$gdata['metode_pembayaran']);
        }
        if(isset($gdata['status_pembayaran'])){
            $xdata = $xdata->where('status_pembayaran','=',$gdata['status_pembayaran']);
        }
        if(isset($gdata['status'])){
            $xdata = $xdata->where('registrasi.status','=',$gdata['status']);
        }

        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }
}
