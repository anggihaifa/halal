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
use App\Models\Akad;
use App\Models\System\User;
use App\Models\KebutuhanWaktuAudit;
use Illuminate\Support\Facades\Session;


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
                ->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')
                 ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('users','registrasi.id_user','=','users.id')
                 ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')  
                
                 ->where('penjadwalan.status_penjadwalan_audit1','=',1)
                 ->orWhere('penjadwalan.status_penjadwalan_audit2','=',1)
                 ->orWhere('penjadwalan.status_penjadwalan_tr','=',1)
                 ->orWhere('penjadwalan.status_penjadwalan_tinjauan','=',1)
                 ->select('registrasi_alamatkantor.alamat as alamat_kantor','registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.kode_wilayah as kode_wilayah','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');
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
                
              
                ->select('registrasi_alamatkantor.alamat as alamat_kantor','registrasi.id as id_regis','registrasi.no_registrasi as no_registrasi', 'registrasi.kode_wilayah as kode_wilayah', 'registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');


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
        //dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;

        $e = $model->find($data['idregis']);
        $j = $model2->find($e->id_penjadwalan);


        //dd($j);
       
            //dd($data['idregis1']);
        if($data['jenis']== 'audit1'){
            $j->status_penjadwalan_audit1 = 3;
        }else if($data['jenis']== 'audit2'){
            $j->status_penjadwalan_audit2 = 3;
        }else if($data['jenis']== 'tr'){
            $j->status_penjadwalan_tr = 3;
        }else if($data['jenis']== 'tinjauan'){
            $j->status_penjadwalan_tinjauan = 3;
        }

        $j->save();
    
        

        

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

    public function rejectPenjadwalanReviewer(Request $request)
    {

        $data = $request->except('_token','_method');
        //dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;

        $e = $model->find($data['idregis']);
        $j = $model2->find($e->id_penjadwalan);


        //dd($j);
       
            //dd($data['idregis1']);
        if($data['jenis']== 'audit1'){
            $j->status_penjadwalan_audit1 = 2;
        }else if($data['jenis']== 'audit2'){
            $j->status_penjadwalan_audit2 = 2;
        }else if($data['jenis']== 'tr'){
            $j->status_penjadwalan_tr = 2;
        }else if($data['jenis']== 'tinjauan'){
            $j->status_penjadwalan_tinjauan = 2;
        }

        $j->save();
    
        

        

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
        dd($data);
        


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
        }else{
            
            $k->status_kebutuhan_audit= '3';
            $e->status = '4';
        }

        $k->hasil_review = $data['hasil_review'];
        $k->catatan_review_kebutuhan_audit = $data['catatan_review_kebutuhan_audit'];

        $k->updated_by =  Auth::user()->id;;
        $k->save();
        $e->save();

        

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
                 ->where('registrasi.status_cancel','=',0)
                 ->orWhere('registrasi.status','=','3')
                 ->orWhere('registrasi.status','=','3_1')
                 ->orWhere('registrasi.status','=','3_2')
                 ->orWhere('registrasi.status','=','3_3')
                 ->select('registrasi.alamat_perusahaan as alamat_perusahaan','registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.kode_wilayah as kode_wilayah','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as ruang_lingkup','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','registrasi.no_registrasi_bpjph','registrasi.status_registrasi as status_registrasi','kebutuhan_waktu_audit.*');
        }else{

            $xdata = DB::table('registrasi')
                ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                ->join('users','registrasi.id_user','=','users.id')
                ->join('kebutuhan_waktu_audit','registrasi.id_kebutuhan_waktu_audit','=','kebutuhan_waktu_audit.id')     
                ->where('registrasi.kode_wilayah','=',$kodewilayah)
                ->where('registrasi.status_cancel','=',0)
                ->orWhere('registrasi.status','=','3')
                ->orWhere('registrasi.status','=','3_1')
                ->orWhere('registrasi.status','=','3_2')
                ->orWhere('registrasi.status','=','3_3')
                ->select('registrasi.alamat_perusahaan as alamat_perusahaan','registrasi.id as id_regis','registrasi.no_registrasi as no_registrasi', 'registrasi.kode_wilayah as kode_wilayah', 'registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as ruang_lingkup','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','kebutuhan_waktu_audit.*');


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


}
