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
                                 ->join('users','registrasi.id','=','users.registrasi_id')
                                 ->where('registrasi.kode_wilayah','=',$kodewilayah)
                                //  ->where('registrasi.status_cancel','=',0)
                                 ->get();
        // dd($checkRegistrasiActive);

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
                            ->where(DB::raw('YEAR(created_at)'), DB::raw('YEAR(now())'))
                            ->groupBy(DB::raw('MONTH(created_at)'))
                            ->orderBy(DB::raw('YEAR(created_at)'),'ASC')
                            ->get();
        $statistikpelanggan = DB::table('users')
                            ->select(DB::raw('count(MONTH(created_at)) as jumlah'),DB::raw('MONTH(created_at) as bulan'),DB::raw('YEAR(created_at) as tahun'))
                            ->where('usergroup_id','=','2')
                            ->where(DB::raw('YEAR(created_at)'), DB::raw('YEAR(now())'))
                            ->groupBy(DB::raw('MONTH(created_at)'))
                            ->orderBy(DB::raw('YEAR(created_at)'),'ASC')
                            ->get();
        // dd($statistikpelanggan);

        $logKegiatan = DB::table('users')
                            ->select('users.registrasi_id','log_kegiatan.*','users.name as nama',)
                            ->join('log_kegiatan','log_kegiatan.id_registrasi','=','users.registrasi_id')
                            ->where('users.id',Auth::user()->id)
                            ->where('log_kegiatan.usergroup_id','=','2')
                            ->get(); 
        // dd($logKegiatan);
        
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
        $nama_user = Auth::user()->name;
        
        $usertahap1 = $id_user.'_'.$nama_user.'_tahap1';
        $usertahap2 = $id_user.'_'.$nama_user.'_tahap2';
        // dd($usertahap2);
        $cekAudit = DB::table('registrasi')             
            ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')
            ->where(function($query) use ($usertahap1){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$usertahap1.'%');
                // $query->where('penjadwalan.status_penjadwalan_audit1','=',3);
                $query->where('registrasi.status','=',8);
            })    
            ->orWhere(function($query) use ($usertahap1){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$usertahap1.'%');
                // $query->where('penjadwalan.status_penjadwalan_audit1','=',3);
                $query->where('registrasi.status','=','8_1');
            })
            ->orWhere(function($query) use ($usertahap1){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$usertahap1.'%');
                // $query->where('penjadwalan.status_penjadwalan_audit1','=',3);
                $query->where('registrasi.status','=','8_2');
            })
            ->orWhere(function($query) use ($usertahap1){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$usertahap1.'%');
                // $query->where('penjadwalan.status_penjadwalan_audit1','=',3);
                $query->where('registrasi.status','=','8_3');
            })
            ->orWhere(function($query) use ($usertahap1){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana2_audit1','LIKE','%'.$usertahap1.'%');
                // $query->where('penjadwalan.status_penjadwalan_audit1','=',3);
                $query->where('registrasi.status','=',8);
            })
            ->orWhere(function($query) use ($usertahap1){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana2_audit1','LIKE','%'.$usertahap1.'%');
                // $query->where('penjadwalan.status_penjadwalan_audit1','=',3);
                $query->where('registrasi.status','=','8_1');
            })
            ->orWhere(function($query) use ($usertahap1){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana2_audit1','LIKE','%'.$usertahap1.'%');
                // $query->where('penjadwalan.status_penjadwalan_audit1','=',3);
                $query->where('registrasi.status','=','8_2');
            })
            ->orWhere(function($query) use ($usertahap1){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana2_audit1','LIKE','%'.$usertahap1.'%');
                // $query->where('penjadwalan.status_penjadwalan_audit1','=',3);
                $query->where('registrasi.status','=','8_3');
            })
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','penjadwalan.*')
             ->get();
        
        $cekAudit2 = DB::table('registrasi')
            ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')
            ->where(function($query) use ($usertahap2){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('penjadwalan.pelaksana1_audit2','LIKE','%'.$usertahap2.'%');
                $query->where('penjadwalan.status_penjadwalan_audit2','=',3);
                $query->where('registrasi.status','!=',17);

            })        
            ->orWhere(function($query) use ($usertahap2){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('penjadwalan.pelaksana1_audit2','LIKE','%'.$usertahap2.'%');
                $query->where('penjadwalan.status_penjadwalan_audit2','=',3);
                $query->where('registrasi.status','!=',17);
            })
            ->orWhere(function($query) use ($usertahap2){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('penjadwalan.pelaksana1_audit2','LIKE','%'.$usertahap2.'%');
                $query->where('penjadwalan.status_penjadwalan_audit2','=',3);
                $query->where('registrasi.status','!=',17);
            })        
            ->orWhere(function($query) use ($usertahap2){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('penjadwalan.pelaksana2_audit2','LIKE','%'.$usertahap2.'%');
                $query->where('penjadwalan.status_penjadwalan_audit2','=',3);
                $query->where('registrasi.status','!=',17);
            })
            ->orWhere(function($query) use ($usertahap2){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('penjadwalan.pelaksana2_audit2','LIKE','%'.$usertahap2.'%');
                $query->where('penjadwalan.status_penjadwalan_audit2','=',3);
                $query->where('registrasi.status','!=',17);
            })        
            ->orWhere(function($query) use ($usertahap2){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('penjadwalan.pelaksana2_audit2','LIKE','%'.$usertahap2.'%');
                $query->where('penjadwalan.status_penjadwalan_audit2','=',3);
                $query->where('registrasi.status','!=',17);
            })        
            ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','penjadwalan.*')
             ->get();

        $dataAudit_1 = count($cekAudit);
        $dataAudit_2 = count($cekAudit2);
        // dd($cekAudit);

        $verifikasi = DB::table('registrasi')
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=',2);
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','2_0');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','2_1');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','2_2');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','2_3');
            })
             ->select('registrasi.*')
             ->get();
        $dataVerifikasi = count($verifikasi);

        $audit1 = DB::table('registrasi')
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=',8);
                // $query->where('registrasi.id_user','=',$id_user);
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','8_1');
                // $query->where('registrasi.id_user','=',$id_user);
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','8_2');
                // $query->where('registrasi.id_user','=',$id_user);
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','8_3');
                // $query->where('registrasi.id_user','=',$id_user);
            })            
             ->select('registrasi.*')
             ->get();
        $dataAudit1 = count($audit1);
        // dd($dataAudit1);

        $audit2 = DB::table('registrasi')
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=',10);
                // $query->where('registrasi.id_user','=',$id_user);
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','10_1');
                // $query->where('registrasi.id_user','=',$id_user);
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','10_2');
                // $query->where('registrasi.id_user','=',$id_user);
            })            
             ->select('registrasi.*')
             ->get();
        $dataAudit2 = count($audit2);

        $sidangfatwa = DB::table('registrasi')
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=',16);
  
            })                
             ->select('registrasi.*')
             ->get();
        $dataSidangFatwa = count($sidangfatwa);        

        $ketetapanhalal = DB::table('registrasi')
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=',17);
  
            })                
             ->select('registrasi.*')
             ->get();
        $dataKetetapanHalal = count($ketetapanhalal);

        $penjadwalan1 = DB::table('registrasi')
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=',7);  
            })             
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','7_0');
            })   
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','7_1');
            })   
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','7_2');
            })   
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','7_3');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=',9);
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','9_0');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','9_1');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','9_2');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','9_3');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=',11);
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','11_0');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','11_1');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','11_2');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','11_3');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=',13);
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','13_0');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','13_1');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','13_2');
            })
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('registrasi.status','=','13_3');
            })
             ->select('registrasi.*')
             ->get();
        $dataPenjadwalan1 = count($penjadwalan1);

        if(Auth::user()->usergroup_id == 1 || Auth::user()->usergroup_id == 3 || Auth::user()->usergroup_id == 4 || Auth::user()->usergroup_id == 5 || Auth::user()->usergroup_id == 6 || Auth::user()->usergroup_id == 7 || Auth::user()->usergroup_id == 8 ||  Auth::user()->usergroup_id == 13 || Auth::user()->usergroup_id == 14){
            return view('home',compact('dataRegistrasi','dataUser','dataRegistrasiAktif','dataPelanggan','statistikregistrasi','statistikpelanggan'));
        }else if(Auth::user()->usergroup_id == 10 || Auth::user()->usergroup_id == 11 || Auth::user()->usergroup_id == 12){
            return view('homeAuditor',compact('dataRegistrasi','dataUser','dataRegistrasiAktif','dataPelanggan','statistikregistrasi','statistikpelanggan','dataAudit_1','dataAudit_2'));
        }else if(Auth::user()->usergroup_id == 9){            
            return view('homeApprover',compact('dataVerifikasi','dataAudit1','dataAudit2','dataSidangFatwa','dataKetetapanHalal','statistikregistrasi','statistikpelanggan','dataPenjadwalan1'));
        }else if(Auth::user()->usergroup_id == 2){
            return view('homeUser',compact('dataDetailUser','totalRegistrasiUser','dataCurrent','logKegiatan'));
        }
        //return view('home');
    }        

    public function home(){
        //return view('home');

        return redirect()->route('home.index');
    }    

}
