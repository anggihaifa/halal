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

class ReviewerController extends Controller
{
    public function listAkadReviewer()
    {
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('reviewer.listKontrakAkadReviewer',compact('dataKelompok','dataJenis'));
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
                     
                     ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan')
                    ->where(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                       
                        $query->where('registrasi.status','=','m');
                    })                     
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','n');
                    });
        }else{

            $xdata = DB::table('registrasi')
                     ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                     ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                     ->join('users','registrasi.id_user','=','users.id')
                     
                     ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan')
                     ->where(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                       
                        $query->where('registrasi.status','=','m');
                    })                     
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','n');
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

    }

    public function listPelunasanReviewer()
    {

    }
    public function updateStatusAkad($id,$no_registrasi,$id_user,$status,$catatan){
        
        $updater = Auth::user()->name;

        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);
            $e->status = $status;
            $e->updated_status_by = $updater;
            $e->save();
            
            if($status =='7'){
                $e->status_akad = '1';
                $e->save();
            }
            
            
        
                try{
                    SendEmailP::dispatch($e,$u,$p, $status);
                    //Session::flash('success', "data berhasil disimpan!");
                    Session::flash('success', 'data dengan no registrasi '.$no_registrasi.' berhasil di kirim emailnya!');

                    DB::commit();

                }catch(\Exception $u){

                    Session::flash('error', $u->getMessage());
                   

                }
            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

           
        }

        $redirect = redirect()->route('listakadadmin');
         return $redirect;

    }
}
