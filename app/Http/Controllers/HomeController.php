<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\System\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kodewilayah = Auth::user()->kode_wilayah;

        $checkRegistrasi =  DB::table('registrasi')->get();
        $checkUserActive =  DB::table('users')
                            ->where('status',1)
                            ->where('usergroup_id',2)
                            ->get();
        $checkUser =  DB::table('users')
                            ->where('usergroup_id',2)
                            ->get();                    
        $checkRegistrasiActive =  DB::table('registrasi')
                                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                                 ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                                 //->join('users','registrasi.id_user','=','users.id')
                                 ->join('users','registrasi.id','=','users.registrasi_id')
                                 ->where('registrasi.kode_wilayah','=',$kodewilayah)
                                 ->where('registrasi.status_cancel','=',0)
                                 ->get();

        $getDetailDataUser =  DB::table('users')
                            ->where('id',Auth::user()->id)
                            ->get();


        $getTotalRegistrasiUser = DB::table('registrasi')
                                    ->where('id_user',Auth::user()->id)
                                    ->where('status_cancel',0)
                                    ->get();
        $currentRegistrasi = DB::table('users')
                            ->select('users.registrasi_id','registrasi.*','jenis_registrasi.jenis_registrasi')
                            ->join('registrasi','registrasi.id','=','users.registrasi_id')
                            ->join('jenis_registrasi','jenis_registrasi.id','=','registrasi.id_jenis_registrasi')
                            ->where('users.id',Auth::user()->id)
                            ->get();                                                                                  

        $dataRegistrasi = count($checkRegistrasi);
        $dataUser    = count($checkUserActive);
        $dataPelanggan = count($checkUser);
        $dataRegistrasiAktif = count($checkRegistrasiActive);
        $totalRegistrasiUser = count($getTotalRegistrasiUser);
        //$statusRegistrasiUser = count($getTotalRegistrasiUser);
        $dataDetailUser = json_decode($getDetailDataUser,true);
        if(isset($currentRegistrasi)){
            $dataCurrent = json_decode($currentRegistrasi,true);    
        }else{
            $dataCurrent = null;    
        }


        // echo "<pre>";
        // print_r(count($checkRegistrasi));
        // print_r(count($checkUserActive));
        // echo "</pre>"; 

        if(Auth::user()->usergroup_id == 1 || Auth::user()->usergroup_id == 3 ){
            return view('home',compact('dataRegistrasi','dataUser','dataRegistrasiAktif','dataPelanggan'));
        }else{
            // echo "<pre>";
            // print_r($dataCurrent);
            // echo "</pre>";
            return view('homeUser',compact('dataDetailUser','totalRegistrasiUser','dataCurrent'));
        }
        //return view('home');
    }

    public function home(){
        //return view('home');

        return redirect()->route('home.index');
    }

}
