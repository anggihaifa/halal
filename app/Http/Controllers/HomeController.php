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
                                 ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                                 //->join('users','registrasi.id_user','=','users.id')
                                 //->join('users','registrasi.id','=','users.registrasi_id')
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
                            ->select('users.registrasi_id','registrasi.*','ruang_lingkup.ruang_lingkup')
                            ->join('registrasi','registrasi.id','=','users.registrasi_id')
                            ->join('ruang_lingkup','ruang_lingkup.id','=','registrasi.id_ruang_lingkup')
                            ->where('users.id',Auth::user()->id)
                            ->get();    
        $statistikregistrasi = DB::table('registrasi')                            
                            ->select(DB::raw('count(MONTH(created_at)) as jumlah'),DB::raw('MONTH(created_at) as bulan'),DB::raw('YEAR(created_at) as tahun'))
                            ->groupBy(DB::raw('MONTH(created_at)'))
                            ->orderBy(DB::raw('YEAR(created_at)'),'ASC')
                            ->get();
        $statistikpelanggan = DB::table('users')
                            ->select(DB::raw('count(MONTH(created_at)) as jumlah'),DB::raw('MONTH(created_at) as bulan'),DB::raw('YEAR(created_at) as tahun'))
                            ->where('usergroup_id','=','2')
                            ->groupBy(DB::raw('MONTH(created_at)'))
                            ->orderBy(DB::raw('YEAR(created_at)'),'ASC')
                            ->get();
        // dd($statistikregistrasi);

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

        $id_user = Auth::user()->id;
        $cekAudit = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%');
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana2_audit1','LIKE','%'.$id_user.'%');
  
            })               
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*')
             ->get();

        $dataAudit = count($cekAudit);
        // dd($dataAudit);

        // echo "<pre>";
        // print_r(count($checkRegistrasi));
        // print_r(count($checkUserActive));
        // echo "</pre>"; 

        if(Auth::user()->usergroup_id == 1 || Auth::user()->usergroup_id == 3 || Auth::user()->usergroup_id == 4 || Auth::user()->usergroup_id == 5 || Auth::user()->usergroup_id == 6 || Auth::user()->usergroup_id == 7 || Auth::user()->usergroup_id == 8 || Auth::user()->usergroup_id == 9 || Auth::user()->usergroup_id == 13 || Auth::user()->usergroup_id == 14){
            return view('home',compact('dataRegistrasi','dataUser','dataRegistrasiAktif','dataPelanggan','statistikregistrasi','statistikpelanggan'));
        }else if(Auth::user()->usergroup_id == 10 || Auth::user()->usergroup_id == 11 || Auth::user()->usergroup_id == 12){
            return view('homeAuditor',compact('dataRegistrasi','dataUser','dataRegistrasiAktif','dataPelanggan','statistikregistrasi','statistikpelanggan','dataAudit'));
        }else if(Auth::user()->usergroup_id == 2){
            return view('homeUser',compact('dataDetailUser','totalRegistrasiUser','dataCurrent'));
        }
        //return view('home');
    }        

    public function home(){
        //return view('home');

        return redirect()->route('home.index');
    }    

}
