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
use App\Models\Akad;
use App\Models\System\User;
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
}
