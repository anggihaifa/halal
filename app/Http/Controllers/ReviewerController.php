<?php

namespace App\Http\Controllers;
use App\Models\Master\JenisRegistrasi;
use App\Models\Master\KelompokProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Registrasi;
use App\Models\Pembayaran;
use App\Models\Penjadwalan;
use App\LogKegiatan;
use App\Models\Akad;
use App\Models\System\User;
use App\Models\KebutuhanWaktuAudit;
use App\Models\LaporanAudit1;
use App\Jobs\SendEmailAuditor;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class ReviewerController extends Controller
{
    public function listAkadReviewer()
    {
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('reviewer.listKontrakAkadReviewer',compact('dataKelompok','dataJenis'));
    }

    public function listAkadApprover()
    {
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('reviewer.listKontrakAkadApprover',compact('dataKelompok','dataJenis'));
    }

    public function dataAkadReviewer(Request $request)
    {
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start

        if($kodewilayah == '00'){
             $xdata = DB::table('registrasi')
                     ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                     ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                     ->join('users','registrasi.id_user','=','users.id')
                     
                     ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','akad.catatan_reviewer as catatan')
                    ->where(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                       
                        $query->where('registrasi.status','=','m');
                    })                     
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','n');
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','o');
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','p');
                    });
        }else{

            $xdata = DB::table('registrasi')
                     ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                     ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                     ->join('users','registrasi.id_user','=','users.id')
                     ->join('akad','registrasi.id','=','akad.id_registrasi')
                     
                     ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','akad.catatan_reviewer as catatan')
                     ->where(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                       
                        $query->where('registrasi.status','=','m');
                    })                                                             
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','o');
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','q');
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','p');
                    });
        }
                          

        //filter condition
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        if(isset($gdata['name'])){
            $xdata = $xdata->where('name','LIKE','%'.$gdata['name'].'%');
        }
        if(isset($gdata['perusahaan'])){
            $xdata = $xdata->where('nama_perusahaan','LIKE','%'.$gdata['perusahaan'].'%');
        }
        if(isset($gdata['kelompok_produk'])){
            $xdata = $xdata->where('kelompok_produk','=',$gdata['kelompok_produk']);
        }
        if(isset($gdata['tgl_registrasi'])){
            $xdata = $xdata->where('tgl_registrasi','=',$gdata['tgl_registrasi']);
        }
       
        if(isset($gdata['status_akad'])){
            $xdata = $xdata->where('status_akad','=',$gdata['status_akad']);
        }
        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }

    public function dataAkadApprover(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start

        if($kodewilayah == '00'){
             $xdata = DB::table('registrasi')
                     ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                     ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                     ->join('users','registrasi.id_user','=','users.id')
                     
                     ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','akad.catatan_reviewer as catatan')
                    ->where(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                       
                        $query->where('registrasi.status','=','n');
                    })                                         
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','p');
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','r');
                    });
        }else{

            $xdata = DB::table('registrasi')
                     ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                     ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                     ->join('users','registrasi.id_user','=','users.id')
                     ->join('akad','registrasi.id','=','akad.id_registrasi')
                     
                     ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','akad.catatan_reviewer as catatan')
                     ->where(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                       
                        $query->where('registrasi.status','=','n');
                    })                                         
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','p');
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','r');
                    });
        }
                          

        //filter condition
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        if(isset($gdata['name'])){
            $xdata = $xdata->where('name','LIKE','%'.$gdata['name'].'%');
        }
        if(isset($gdata['perusahaan'])){
            $xdata = $xdata->where('nama_perusahaan','LIKE','%'.$gdata['perusahaan'].'%');
        }
        if(isset($gdata['kelompok_produk'])){
            $xdata = $xdata->where('kelompok_produk','=',$gdata['kelompok_produk']);
        }
        if(isset($gdata['tgl_registrasi'])){
            $xdata = $xdata->where('tgl_registrasi','=',$gdata['tgl_registrasi']);
        }
       
        if(isset($gdata['status_akad'])){
            $xdata = $xdata->where('status_akad','=',$gdata['status_akad']);
        }
        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }

    public function listPenjadwalanReviewer()
    {
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('reviewer.listPenjadwalanReviewer',compact('dataKelompok','dataJenis'));
    }

    public function dataPenjadwalanReviewer(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start
        if($kodewilayah == '119'){
            $xdata = DB::table('registrasi')
                 //->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')
                  ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                  ->join('users','registrasi.id_user','=','users.id')
                 ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')  
                
                 ->where('penjadwalan.status_penjadwalan_audit1','=',1)
                 ->orWhere('penjadwalan.status_penjadwalan_audit2','=',1)
                 ->orWhere('penjadwalan.status_penjadwalan_tr','=',1)
                 ->orWhere('penjadwalan.status_penjadwalan_tinjauan','=',1)
                 ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.kode_wilayah as kode_wilayah','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');
                //->select('registrasi.*');
        }else{

            $xdata = DB::table('registrasi')
                ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                ->join('users','registrasi.id_user','=','users.id')
                ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')  
                ->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')
               
                ->where(function($query) use ($kodewilayah){
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);  
                    $query->where('penjadwalan.status_penjadwalan_audit1','=',1);
                    
                    
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);  
                    $query->where('penjadwalan.status_penjadwalan_audit2','=',1);  
                        
                        
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);  
                    $query->where('penjadwalan.status_penjadwalan_tr','=',1); 
                        
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);  
                    $query->where('penjadwalan.status_penjadwalan_tinjauan','=',1); 
                        
                })
                
              
                ->select('registrasi.id as id_regis','registrasi.no_registrasi as no_registrasi', 'registrasi.kode_wilayah as kode_wilayah', 'registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');


        }

        //filter condition
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('registrasi.no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        if(isset($gdata['nama_perusahaan'])){
            $xdata = $xdata->where('registrasi.nama_perusahaan','LIKE','%'.$gdata['nama_perusahaan'].'%');
        }
        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

       // Log::Info(json_encode($xdata,true));

        return Datatables::of($xdata)->make();
    }

    public function listPelunasanReviewer()
    {
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('reviewer.listPelunasanReviewer',compact('dataKelompok','dataJenis'));
    }    
    public function konfirmasiAkadReviewer($id,$id_akad)
    {
        $model1 = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();
        //dd($model3);
        try{
            $updater = Auth::user()->name;

            DB::beginTransaction();
            $e = $model1->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);

            // date_default_timezone_set('Asia/Jakarta');
            // $date = date("Y-m-d h:i:sa");
            $e->status = 'n';
            $e->status_akad= 6;
            $e->updated_status_by = $updater;
            $e->save();                        
            
            // $this->updateStatusRegistrasi($e->id, $e->no_registrasi, $e->id_user, 9);
           
            DB::commit(); 
           

            Session::flash('success', "Konfirmasi Dokumen Kontrak Berhasil");
            // dd($e->total_biaya);


        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }



            $redirect = redirect()->route('listakadreviewer');
            return $redirect;
    }
    public function konfirmasiAkadReviewer2($id,$id_akad)
    {
        $model1 = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();
        //dd($model3);
        try{
            $updater = Auth::user()->name;

            DB::beginTransaction();
            $e = $model1->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);

            // date_default_timezone_set('Asia/Jakarta');
            // $date = date("Y-m-d h:i:sa");
            $e->status = 'f';
            $e->status_akad= 8;
            $e->status_akad= 1;
            $e->updated_status_by = $updater;
            $e->save();                        
            
            // $this->updateStatusRegistrasi($e->id, $e->no_registrasi, $e->id_user, 9);
           
            DB::commit(); 
           

            Session::flash('success', "Konfirmasi Dokumen Kontrak Berhasil");
            // dd($e->total_biaya);


        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }



            $redirect = redirect()->route('listakadapprover');
            return $redirect;
    }
    public function updateStatusAkad($id,$id_user,$status,$id_akad,$catatan){
        
        $updater = Auth::user()->name;

        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();
        $model4 = new Akad();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);
            $e->status = $status;
            $e->updated_status_by = $updater;
            $e->save();

            $a = $model4->find($id_akad);            

            $a->catatan_reviewer = $catatan;
            $a->save();
            
            if($status =='o'){
                $e->status_akad = 5;
                $e->save();
            }
            
            
        
                try{
                    // SendEmailP::dispatch($e,$u,$p, $status);
                    //Session::flash('success', "data berhasil disimpan!");
                    Session::flash('success', 'Data berhasil diubah!');

                    DB::commit();

                }catch(\Exception $u){

                    Session::flash('error', $u->getMessage());
                   

                }
            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

           
        }

        $redirect = redirect()->route('listakadreviewer');
         return $redirect;

    }
    public function updateStatusAkad2($id,$id_user,$status,$id_akad,$catatan){
        
        $updater = Auth::user()->name;

        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();
        $model4 = new Akad();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);
            $e->status = $status;
            $e->updated_status_by = $updater;
            $e->save();

            $a = $model4->find($id_akad);            

            $a->catatan_reviewer = $catatan;
            $a->save();
            
            if($status =='p'){
                $e->status_akad = 7;
                $e->save();
            }
            
                try{
                    // SendEmailP::dispatch($e,$u,$p, $status);
                    //Session::flash('success', "data berhasil disimpan!");
                    Session::flash('success', 'Data berhasil diubah!');

                    DB::commit();

                }catch(\Exception $u){

                    Session::flash('error', $u->getMessage());
                   

                }
            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

           
        }

        $redirect = redirect()->route('listakadapprover');
         return $redirect;

    }

    public function approvePenjadwalanReviewer(Request $request)
    {

        $data = $request->except('_token','_method');
       

        // dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;
        $model4 = new LaporanAudit1;

        $e = $model->find($data['id']);
        $j = $model2->find($e->id_penjadwalan);
        $l = $model4->find($e->id_laporan_audit1);


        //dd($j);

        $checkHas =  DB::table('dokumen_has')
        ->where('id_registrasi',$e->id)
        ->get();

        $dataHas = json_decode($checkHas,true);

        if($l){ 
            
        }else{
            $model = new LaporanAudit1();
            DB::beginTransaction();
            // dd("masuk");
            $model4->id_registrasi = $e->id;
            $model4->id_dokumen_has = $dataHas[0]['id'];
            $model4->save();
            $e->id_laporan_audit1 = $model->id;
            $e->save();            
        }
       
            //dd($data['idregis1']);
        if($data['jenis']== 'audit1'){            
            $j->status_penjadwalan_audit1 = 3;
            $e->status = 8;
            $j->catatan_penjadwalan_audit1 = $data['catatan_penjadwalan'];

            if($data['pelaksana1']){
                $str =  explode("_",$data['pelaksana1']);
                $u = $model3->find($str[0]);
               
                SendEmailAuditor::dispatch($u,$e,$j,'audit1');

            }            
            $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 7, "Menyetujui penjadwalan audit tahap 1", Auth::user()->usergroup_id);
            //dd("masuk");
        }else if($data['jenis']== 'audit2'){
            $j->status_penjadwalan_audit2 = 3;
            $e->status = 10;
            $j->catatan_penjadwalan_audit2 = $data['catatan_penjadwalan'];


            if($data['pelaksana1']){
                $str =  explode("_",$data['pelaksana1']);
                $u = $model3->find($str[0]);
               
                SendEmailAuditor::dispatch($u,$e,$j,'audit2');

            }if($data['pelaksana2']){

                $str2 =  explode("_",$data['pelaksana2']);
                $u2 = $model3->find($str2[0]);
                
                SendEmailAuditor::dispatch($u2,$e,$j,'audit2');
            }

            $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 9, "Menyetujui penjadwalan audit tahap 2", Auth::user()->usergroup_id);
        }else if($data['jenis']== 'tr'){
            $e->status = '12';
            $j->status_penjadwalan_tr = 3;
            $j->catatan_penjadwalan_tr = $data['catatan_penjadwalan'];


            if($data['pelaksana1']){
                $str =  explode("_",$data['pelaksana1']);
                $u = $model3->find($str[0]);
               
                SendEmailAuditor::dispatch($u,$e,$j,'tr');

            }if($data['pelaksana2']){

                $str2 =  explode("_",$data['pelaksana2']);
                $u2 = $model3->find($str2[0]);
                
                SendEmailAuditor::dispatch($u2,$e,$j,'tr');
            }

            $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 11, "Menyetujui penjadwalan technical review", Auth::user()->usergroup_id);
        }else if($data['jenis']== 'tinjauan'){
            $e->status = '14';
            $j->status_penjadwalan_tinjauan = 3;
            $j->catatan_penjadwalan_tinjauan = $data['catatan_penjadwalan'];


            if($data['pelaksana1']){
                $str =  explode("_",$data['pelaksana1']);
                $u = $model3->find($str[0]);
               
                SendEmailAuditor::dispatch($u,$e,$j,'tinjauan');

            }if($data['pelaksana2']){

                $str2 =  explode("_",$data['pelaksana2']);
                $u2 = $model3->find($str2[0]);
                
                SendEmailAuditor::dispatch($u2,$e,$j,'tinjauan');
            }

            $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 13, "Menyetujui penjadwalan komite sertifikasi", Auth::user()->usergroup_id);
        }
                
        $e->save();
        $j->save();
        DB::Commit();
        

        

        try{
            DB::Commit();

           
            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('listpenjadwalanreviewer');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('listpenjadwalanreviewer');
            return $redirectPass;
        }
  
    }

    public function rejectPenjadwalanReviewer(Request $request)
    {

        $data = $request->except('_token','_method');
        //dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;

        $e = $model->find($data['id']);
        $j = $model2->find($e->id_penjadwalan);


        //dd($j);
       
            //dd($data['idregis1']);
        if($data['jenis']== 'audit1'){
            $j->status_penjadwalan_audit1 = 2;
            $e->status = '7_2';
            $j->catatan_penjadwalan_audit1 = $data['catatan_penjadwalan'];
            //dd($j->catatan_penjadwalan_audit1);
            $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 7, "Menolak penjadwalan audit tahap 1", Auth::user()->usergroup_id);

        }else if($data['jenis']== 'audit2'){
            $j->status_penjadwalan_audit2 = 2;
            $e->status = '9_2';
            $j->catatan_penjadwalan_audit2 = $data['catatan_penjadwalan'];

            $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 9, "Menolak penjadwalan audit tahap 2", Auth::user()->usergroup_id);

        }else if($data['jenis']== 'tr'){
            $j->status_penjadwalan_tr = 2;
            $e->status = '11_2';
            $j->catatan_penjadwalan_tr = $data['catatan_penjadwalan'];

            $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 11, "Menolak penjadwalan technical review", Auth::user()->usergroup_id);

        }else if($data['jenis']== 'tinjauan'){
            $j->status_penjadwalan_tinjauan = 2;
            $e->status = '13_2';
            $j->catatan_penjadwalan_tinjauan= $data['catatan_penjadwalan'];

            $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 13, "Menolak penjadwalan komite sertifikasi", Auth::user()->usergroup_id);

        }
        //$j->catatan_penjadwalan = $data['catatan_penjadwalan'];

        $j->save();
        $e->save();
    
        

        

        try{
            DB::Commit();

            // if($data['pelaksana1_audit1']){
            //     $str =  explode("_",$data['pelaksana1_audit1']);
            //     $u = $model3->find($str[0]);
               
            //     SendEmailAuditor::dispatch($u,$e,$j,'audit1');

            // }if($data['pelaksana2_audit1']){

            //     $str2 =  explode("_",$data['pelaksana2_audit1']);
            //     $u2 = $model3->find($str2[0]);
                
            //     SendEmailAuditor::dispatch($u2,$e,$j,'audit1');
            // }
            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('listpenjadwalanreviewer');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('listpenjadwalanreviewer');
            return $redirectPass;
        }
  
    }


    public function storeKebutuhanWaktuAudit(Request $request)
    {

        $data = $request->except('_token','_method');
        $data_K = $request->except('_token','_method','idregis1','status_registrasi');
        //dd($data);
        


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;
        $model4 = new KebutuhanWaktuAudit;

        $e = $model->find($data['idregis1']);
        $k = $model4->find($e->id_kebutuhan_waktu_audit);
        //dd($j);

        $k->fill($data_K);
        //dd($k);
        $k->hasil_review = "";
        $k->catatan_review_kebutuhan_audit = "";
        $k->updated_by =  Auth::user()->id;
        $k->status_kebutuhan_audit= '1';
        $k->save();

        

        try{
            DB::Commit();

            $this->LogKegiatan($data['idregis1'], Auth::user()->id, Auth::user()->name, 3, "Menentukan Waktu Audit.", Auth::user()->usergroup_id);

            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('listkebutuhanwaktuaudit');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('listkebutuhanwaktuaudit');
            return $redirectPass;
        }
  
    }

    public function storeReviewKebutuhanWaktuAudit(Request $request)
    {

        $data = $request->except('_token','_method');
        //$data_K = $request->except('_token','_method','idregis1','status_registrasi');
        //dd($data);
        


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;
        $model4 = new KebutuhanWaktuAudit;

        $e = $model->find($data['idregis1']);
        $k = $model4->find($e->id_kebutuhan_waktu_audit);
        //dd($j);

        //$k->fill($data_K);
        //dd($k);
        if($data['hasil_review']== 'perbaikan'){
            $k->status_kebutuhan_audit= '2';
            $e->status = '3_2';

            $this->LogKegiatan($data['idregis1'], Auth::user()->id, Auth::user()->name, 3, "Review kebutuhan waktu audit terdapat perbaikan.", Auth::user()->usergroup_id);
        }else{
            
            $k->status_kebutuhan_audit= '3';
            $e->status = 4;
           
            $this->LogKegiatan($data['idregis1'], Auth::user()->id, Auth::user()->name, 3, "Review kebutuhan waktu audit selesai (sesuai).", Auth::user()->usergroup_id);
        }

        $k->hasil_review = $data['hasil_review'];
        $k->catatan_review_kebutuhan_audit = $data['catatan_review_kebutuhan_audit'];

        $k->updated_by =  Auth::user()->id;;
        $k->save();
        $e->save();
        //dd( $e->status);

        

        try{
            DB::Commit();

            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('reviewkebutuhanwaktuaudit');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('reviewkebutuhanwaktuaudit');
            return $redirectPass;
        }
  
    }
    public function perbaikanKebutuhanWaktuAudit(Request $request){
        $data = $request->except('_token','_method');
        //$data_K = $request->except('_token','_method','idregis1','status_registrasi');
        //dd($request);
        


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;
        $model4 = new KebutuhanWaktuAudit;

        $e = $model->find($data['idregis1']);
        $k = $model4->find($e->id_kebutuhan_waktu_audit);
        //dd($j);

        //$k->fill($data_K);
        //dd($k);
        $k->updated_by =  Auth::user()->id;;
        $k->status_kebutuhan_audit= '2';
        $k->save();

        

        try{
            DB::Commit();

            $this->LogKegiatan($data['idregis1'], Auth::user()->id, Auth::user()->name, 3, "Upload perbaikan kebutuhan waktu audit.", Auth::user()->usergroup_id);

            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('reviewkebutuhanwaktuaudit');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('reviewkebutuhanwaktuaudit');
            return $redirectPass;
        }
    }

    public function listKebutuhanWaktuAudit(){

        return view('penjadwalan.listKebutuhanWaktuAudit');
    }
    public function reviewKebutuhanWaktuAudit(){

        return view('penjadwalan.reviewKebutuhanWaktuAudit');
    }

    public function dataKebutuhanWaktuAudit(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start
        if($kodewilayah == '119'){
            $xdata = DB::table('registrasi')
               
                 ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('users','registrasi.id_user','=','users.id')
                 ->join('kebutuhan_waktu_audit','registrasi.id_kebutuhan_waktu_audit','=','kebutuhan_waktu_audit.id')   
                 
                 ->select('registrasi.alamat_perusahaan as alamat_perusahaan','registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.kode_wilayah as kode_wilayah','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as ruang_lingkup','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','registrasi.no_registrasi_bpjph','registrasi.status_registrasi as status_registrasi','kebutuhan_waktu_audit.*')
               
                ->where(function($query) use ($kodewilayah){
                    $query ->where('registrasi.status_cancel','=',0);
                     $query ->where('registrasi.status','=','3');
                })
                ->orWhere(function($query) use ($kodewilayah ){
                    $query ->where('registrasi.status_cancel','=',0);
                    
                    $query ->where('registrasi.status','=','3_1');
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query ->where('registrasi.status_cancel','=',0);
                    
                    $query ->where('registrasi.status','=','3_2');
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query ->where('registrasi.status_cancel','=',0);
                    
                    $query ->where('registrasi.status','=','3_3');
                });
                
                
        }else{

            $xdata = DB::table('registrasi')
                ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                ->join('users','registrasi.id_user','=','users.id')
                ->join('kebutuhan_waktu_audit','registrasi.id_kebutuhan_waktu_audit','=','kebutuhan_waktu_audit.id')     

                ->select('registrasi.alamat_perusahaan as alamat_perusahaan','registrasi.id as id_regis','registrasi.no_registrasi as no_registrasi', 'registrasi.kode_wilayah as kode_wilayah', 'registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as ruang_lingkup','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','kebutuhan_waktu_audit.*')

                ->where(function($query) use ($kodewilayah){
                    $query ->where('registrasi.status_cancel','=',0);
                    $query ->where('registrasi.kode_wilayah','=',$kodewilayah);
                    
                    $query ->where('registrasi.status','=','3');
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query ->where('registrasi.status_cancel','=',0);
                    $query ->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query ->where('registrasi.status','=','3_1');
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query ->where('registrasi.status_cancel','=',0);
                    $query ->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query ->where('registrasi.status','=','3_2');
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query ->where('registrasi.status_cancel','=',0);
                    $query ->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query ->where('registrasi.status','=','3_3');
                });
                


        }

       


        //filter condition
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        

        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }

    public function LogKegiatan($id_registrasi, $id_user, $nama, $id_kegiatan, $judul_kegiatan, $usergroup_id){
        $model3 = new LogKegiatan();
        DB::beginTransaction();
            $model3->id_registrasi = $id_registrasi;
            $model3->id_user = $id_user;
            $model3->nama_user = $nama;
            $model3->id_kegiatan = $id_kegiatan;
            $model3->usergroup_id = $usergroup_id;
            $model3->judul_kegiatan = $judul_kegiatan;            
            $model3->save();
        DB::commit();
    }


}
