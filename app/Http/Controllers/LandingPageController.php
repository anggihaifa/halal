<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\System\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Berita;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index(){
        // $berita = Berita::all();
        $berita = Db::table('berita')
                    ->where('status_approve','=',1)
                    ->get();

        $pelatihan = Db::table('pelatihan')
                    ->where('status_approve','=',1)
                    ->get();
                    
        $produk = Db::table('registrasi')                    
                    ->get();
        
        $cek = Db::table('registrasi')
                    ->where('nama_perusahaan','like',"%9999999999%")
                    ->get();
                    // dd($produk);


        return view('landingPage', compact('berita','produk','cek','pelatihan'));

        // return redirect()->route('home.index');
    }

    public function cariProduk(Request $request){
        $data = $request->except('_token','_method');
        // dd($produk);
        
        if($data['katakunci']!=null){
            $produk = Db::table('registrasi')
                    ->where('nama_perusahaan','like',"%".$data['katakunci']."%")
                    ->orWhere('no_registrasi','like',"%".$data['katakunci']."%")
                    ->orWhere('no_sertifikat','like',"%".$data['katakunci']."%")
                    ->get();

            $berita = Db::table('berita')                    
                    ->where('status_approve','=',1)
                    ->get();

            $pelatihan = Db::table('pelatihan')
                    ->where('status_approve','=',1)
                    ->get();
            // Session::flash('success', 'Data berhasil ditemukan!');
            return view('landingpage',compact('produk','berita','pelatihan'));
        }else{
            $produk = Db::table('registrasi')                    
                    ->get();
        
            $cek = Db::table('registrasi')
                    ->where('nama_perusahaan','like',"%9999999999%")
                    ->get();
                    
            $berita = Db::table('berita')                    
                    ->where('status_approve','=',1)
                    ->get();
            
            Session::flash('error', 'Data yang akan dicari tidak boleh kosong!');
            return view('landingPage', compact('berita','produk','cek'));            
        }
        
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
