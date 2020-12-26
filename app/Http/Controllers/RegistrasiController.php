<?php

namespace App\Http\Controllers;

use App\RegistrasiAlamatKantor;
use App\RegistrasiAlamatPabrik;
use App\RegistrasiPemilikPerusahaan;
use App\RegistrasiDPH;
use App\RegistrasiDataProduk;
use App\DetailDataProduk;
use App\DetailDSM;
use App\RegistrasiDSM;
use App\RegistrasiDataSDM;
use App\RegistrasiLokasiLain;
use App\RegistrasiKU;
use App\RegistrasiJasa;
use App\RegistrasiJumlahProduksi;
use App\DetailKU;

use App\Models\Registrasi;
use App\Models\Pembayaran;
use App\Models\System\User;
use App\Models\Master\JenisRegistrasi;
use App\Models\Master\KelompokProduk;
use App\Models\UnggahData\Fasilitas;
use App\Models\UnggahData\Produk;
use App\Models\UnggahData\DokumenHas;
use App\Models\UnggahData\DokumenMaterial;
use App\Models\UnggahData\material;
use App\Models\UnggahData\DokumenMatriksProduk;
use App\Models\UnggahData\KuisionerHas;
use App\Models\UnggahData\unggahDataSertifikasi;
use App\Models\UnggahData\KantorPusat;
use App\Models\UnggahData\MenuRestoran;
use App\Models\UnggahData\Jagal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Services\FileUploadServices;
use App\Mail\KonfirmasiPembayaran;
use App\Mail\ProgresStatus;
use Illuminate\Support\Facades\Mail;
use PDF;
use Response;

class RegistrasiController extends Controller
{
    //registrasi halal
    public function index(){

        if(Auth::user()->registrasi_id !== null){
            $data = Registrasi::find(Auth::user()->registrasi_id);
            return view('registrasi.index',compact('data'));
        }else{
            return view('registrasi.index');
        }
    }

    public function viewEmail(){
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('mail.verifikasimanual',compact('user'));
    }

    public function listRegistrasiPelanggan(){
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('registrasi.listRegistrasi',compact('dataKelompok','dataJenis'));
    }
    public function listRegistrasiPelangganAktif(){
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('registrasi.listRegistrasiAktif',compact('dataKelompok','dataJenis'));
    }
    public function dataRegistrasiPelangganAktif(Request $request){
        $gdata = $request->except('_token','_method');
        //start
        $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                 //->join('users','registrasi.id_user','=','users.id')
                 ->join('users','registrasi.id','=','users.registrasi_id')
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

    public function dataRegistrasiPelanggan(Request $request){
        $gdata = $request->except('_token','_method');
        //start
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


       
   


    public function updateStatusRegistrasi($id,$no_registrasi,$id_user,$status){
        
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
            
            
           
            if($status == '4' ||$status == '5' ||$status == '7' ||$status == '8' ||$status == '10' ||$status == '11' ||$status == '12'  ||$status == '16' ||$status == '17' ||$status == '20' ||$status == '22' ||$status == '23' ||$status == '24' ||$status == '25'){
                //dd($e);

            
                    try{
                        
                        //Session::flash('success', "data berhasil disimpan!");
                        Session::flash('success', 'data dengan no registrasi '.$no_registrasi.' berhasil di kirim emailnya!');

                        DB::commit();

                        Mail::to($u->email)->send(new ProgresStatus($u,$e,$p, $status));

                    }catch(\Exception $u){

                        Session::flash('error', $u->getMessage());
                        //Session::flash('success', "data berhasil disimpan!");
                        //$statusreg = $e->getMessage();

                    }
            }else{
                DB::commit();
                Session::flash('success', 'Data dengan nomor registrasi '.$no_registrasi.' berhasil diupdate');
            }
            
            
            //}
                

            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

           
        }

        return redirect()->route('listregistrasipelangganaktif');

    }



   

    //Registrasi Halal
    public function registrasiDatatable(){
        /*$xdata = DB::table('registrasi')
                 ->orderBy('id','desc');*/
        //for detail data
        $xdata = DB::table('registrasi')
                 ->leftJoin('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->leftJoin('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok')
                 ->where('id_user','=',Auth::user()->id)
                 ->orderBy('registrasi.id','desc')
                 ->get();

        //alert(Datatables::of($xdata));

        return Datatables::of($xdata)->make();

    }
     public function detailRegistrasi($id){
            $data = DB::table('registrasi')
                ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                ->join('users','registrasi.id_user','=','users.id')
                ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.*')
                ->where('registrasi.id','=',$id)
                ->get();
            $data = json_decode($data,true);

            foreach ($data as $key => $value) {
                $id_reg = $value['id_jenis_registrasi'];
            }

            $dataKantor = DB::table('registrasi_alamatkantor')
                ->join('registrasi','registrasi_alamatkantor.id_registrasi','=','registrasi.id')                                
                ->select('registrasi_alamatkantor.*')
                ->where('registrasi_alamatkantor.id_registrasi','=',$id)
                ->get();
            
            $dataPabrik = DB::table('registrasi_alamatpabrik')
                ->join('registrasi','registrasi_alamatpabrik.id_registrasi','=','registrasi.id')                                
                ->select('registrasi_alamatpabrik.*')
                ->where('registrasi_alamatpabrik.id_registrasi','=',$id)
                ->get();

            $dataPemilikPerusahaan = DB::table('registrasi_pemilik_perusahaan')
                ->join('registrasi','registrasi_pemilik_perusahaan.id_registrasi','=','registrasi.id')                                
                ->select('registrasi_pemilik_perusahaan.*')
                ->where('registrasi_pemilik_perusahaan.id_registrasi','=',$id)
                ->get();

            $dataDSM = DB::table('registrasi_data_sistem_manajemen')
                ->join('registrasi','registrasi_data_sistem_manajemen.id_registrasi','=','registrasi.id')
                ->select('registrasi_data_sistem_manajemen.*')
                ->where('registrasi_data_sistem_manajemen.id_registrasi','=',$id)
                ->get();

            $dataDSM = json_decode($dataDSM,true);
            
            foreach ($dataDSM as $key => $value) {
                $id_dsm = $value['id'];
                alert($id_dsm);
            }

            $detailDSM = DB::table('detail_data_sistem_manajemen')
                ->join('registrasi_data_sistem_manajemen','detail_data_sistem_manajemen.id_data_sistem_manajemen','=','registrasi_data_sistem_manajemen.id')
                ->select('detail_data_sistem_manajemen.*')
                ->where('detail_data_sistem_manajemen.id_data_sistem_manajemen','=',$id_dsm)
                ->get();

            $dataLokasiLain = DB::table('registrasi_data_lokasilainnya')
                ->join('registrasi','registrasi_data_lokasilainnya.id_registrasi','=','registrasi.id')
                ->select('registrasi_data_lokasilainnya.*')
                ->where('registrasi_data_lokasilainnya.id_registrasi','=',$id)
                ->get();

            $dataKantor = json_decode($dataKantor,true);
            $dataPabrik = json_decode($dataPabrik,true);
            $dataPemilikPerusahaan = json_decode($dataPemilikPerusahaan,true);
            $detailDSM = json_decode($detailDSM,true);
            $dataLokasiLain = json_decode($dataLokasiLain,true);

            if($id_reg == 1 || $id_reg == 5){
                $dataPenyeliaHalal = DB::table('registrasi_dph')
                    ->join('registrasi','registrasi_dph.id_registrasi','=','registrasi.id')
                    ->select('registrasi_dph.*')
                    ->where('registrasi_dph.id_registrasi','=',$id)
                    ->get();

                $dataPenyeliaHalal = json_decode($dataPenyeliaHalal,true);        

                $dataProduk = DB::table('registrasi_data_produk')
                    ->join('registrasi','registrasi_data_produk.id_registrasi','=','registrasi.id')
                    ->select('registrasi_data_produk.*')
                    ->where('registrasi_data_produk.id_registrasi','=',$id)
                    ->get();

                $dataProduk = json_decode($dataProduk,true);    
                
                foreach ($dataProduk as $key => $value) {
                    $id_dp = $value['id'];
                }

                $detailDataProduk = DB::table('detail_data_produk')
                    ->join('registrasi_data_produk','detail_data_produk.id_registrasi_data_produk','=','registrasi_data_produk.id')
                    ->select('detail_data_produk.*')
                    ->where('detail_data_produk.id_registrasi_data_produk','=',$id_dp)
                    ->get();

                $detailDataProduk = json_decode($detailDataProduk,true);

                return view('registrasi.detail',compact('data','dataKantor','dataPabrik','dataPemilikPerusahaan','dataDSM','detailDSM','dataLokasiLain','dataPenyeliaHalal','dataProduk','detailDataProduk'));
                
            }else if($id_reg == 2){

                $dataPenyeliaHalal = DB::table('registrasi_dph')
                    ->join('registrasi','registrasi_dph.id_registrasi','=','registrasi.id')
                    ->select('registrasi_dph.*')
                    ->where('registrasi_dph.id_registrasi','=',$id)
                    ->get();

                $dataPenyeliaHalal = json_decode($dataPenyeliaHalal,true);                

                $dataKelompokUsaha = DB::table('registrasi_kelompok_usaha')
                    ->join('registrasi','registrasi_kelompok_usaha.id_registrasi','=','registrasi.id')
                    ->select('registrasi_kelompok_usaha.*')
                    ->where('registrasi_kelompok_usaha.id_registrasi','=',$id)
                    ->get();

                $dataKelompokUsaha = json_decode($dataKelompokUsaha,true);

                foreach ($dataKelompokUsaha as $key => $value) {
                    $id_kelompok_usaha = $value['id'];
                }

                $detailRegisKelompok = DB::table('detail_registrasi_kelompok_usaha')
                    ->join('registrasi_kelompok_usaha','detail_registrasi_kelompok_usaha.id_registrasi_kelompok_usaha','=','registrasi_kelompok_usaha.id')
                    ->select('detail_registrasi_kelompok_usaha.*')
                    ->where('detail_registrasi_kelompok_usaha.id_registrasi_kelompok_usaha','=',$id_kelompok_usaha)
                    ->get();

                $detailRegisKelompok = json_decode($detailRegisKelompok,true);

                return view('registrasi.detail',compact('data','dataKantor','dataPabrik','dataPemilikPerusahaan','dataDSM','detailDSM','dataLokasiLain','dataPenyeliaHalal','dataKelompokUsaha','detailRegisKelompok'));

            }else if($id_reg == 3){
                $dataSDM = DB::table('registrasi_data_sdm')
                ->join('registrasi','registrasi_data_sdm.id_registrasi','=','registrasi.id')
                ->select('registrasi_data_sdm.*')
                ->where('registrasi_data_sdm.id_registrasi','=',$id)
                ->get();

                $dataSDM = json_decode($dataSDM,true);

                $dataJmlProduksi = DB::table('registrasi_jumlah_produksi')
                ->join('registrasi','registrasi_jumlah_produksi.id_registrasi','=','registrasi.id')
                ->select('registrasi_jumlah_produksi.*')
                ->where('registrasi_jumlah_produksi.id_registrasi','=',$id)
                ->get();            
                
                $dataJmlProduksi = json_decode($dataJmlProduksi,true);

                return view('registrasi.detail',compact('data','dataKantor','dataPabrik','dataPemilikPerusahaan','dataSDM','dataJmlProduksi','dataDSM','detailDSM','dataLokasiLain'));             
            }else if($id_reg == 4){
                $dataPenyeliaHalal = DB::table('registrasi_dph')
                    ->join('registrasi','registrasi_dph.id_registrasi','=','registrasi.id')
                    ->select('registrasi_dph.*')
                    ->where('registrasi_dph.id_registrasi','=',$id)
                    ->get();

                $dataPenyeliaHalal = json_decode($dataPenyeliaHalal,true);

                $dataJasa = DB::table('registrasi_jasa')
                    ->join('registrasi','registrasi_jasa.id_registrasi','=','registrasi.id')
                    ->select('registrasi_jasa.*')
                    ->where('registrasi_jasa.id_registrasi','=',$id)
                    ->get();

                $dataJasa = json_decode($dataJasa,true);

                return view('registrasi.detail',compact('data','dataKantor','dataPabrik','dataPemilikPerusahaan','dataDSM','detailDSM','dataLokasiLain','dataPenyeliaHalal','dataJasa'));
            }                                                                                                        
        
        // return view('registrasi.detail',compact('data','dataKantor','dataPabrik','dataPemilikPerusahaan','dataSDM','dataJmlProduksi','dataDSM','detailDSM','dataLokasiLain','dataPenyeliaHalal','dataProduk','detailDataProduk'));
    }
    public function create(){
        $jenisRegistrasi = JenisRegistrasi::all();
        $kelompokProduk = KelompokProduk::all();
        //get Data from FAQ Transfer
        $getTransfer =   DB::table('faq')
                    ->where('status','transfer')
                    ->get();
        $dataTransfer = json_decode($getTransfer,true);
        //get Data from FAQ Tunai
        $getTunai =   DB::table('faq')
                    ->where('status','tunai')
                    ->get();
        $dataTunai = json_decode($getTunai,true);
        return view('registrasi.create', compact('jenisRegistrasi','kelompokProduk','dataTransfer','dataTunai'));
    }

    //function random generate
    public function crypto_Rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

   public function store(Request $request){
        $data = $request->except('_token','_method');

        $model = new Registrasi();

        try{

            //get random token from function random generate
            $length = 8;
            $token = "";
            $codeAlphabet= "0123456789";
            for($i=0;$i<$length;$i++){
                $token .= $codeAlphabet[$this->crypto_Rand_secure(0,strlen($codeAlphabet))];
            }
            $randomid =$token;

            // //Create PDF
            // $nama = Auth::user()->name;
            // $perusahaan = Auth::user()->perusahaan;
            // $kota = Auth::user()->kota;
            // $newdata = ['nama'=>$nama,'perusahaan'=>$perusahaan,'no_registrasi'=>$randomid,'kota'=>$kota,'data'=>$data];
            // $pdf = PDF::loadView('pdf/pdf_download',$newdata);
            // $fileName = 'REG_'.$randomid.'_INV.pdf';

            //input data
            DB::beginTransaction();
            // $model->fill($data);
            // $model->id_user = Auth::user()->id;
            // $model->no_registrasi = $randomid;
            //$model->inv_registrasi = $fileName;

            $model->id_user = Auth::user()->id;            
            $model->nama_perusahaan = $data['nama_perusahaan'];
            $model->no_surat = $data['no_surat'];            
            $model->no_registrasi = $randomid;
            $model->tgl_registrasi = $data['tgl_registrasi'];
            $model->id_jenis_registrasi = $data['id_jenis_registrasi'];
            $model->status_registrasi = $data['status_registrasi'];
            $model->status_halal = $data['status_halal'];
            $model->sh_berlaku = $data['sh_berlaku'];
            $model->no_sertifikat = $data['no_sertifikat'];
            $model->tgl_sjph = $data['tgl_sjph'];
            $model->jenis_produk = $data['jenis_produk'];
            $model->jenis_badan_usaha = $data['jenis_badan_usaha'];
            $model->nama_jenis_badan_usaha = $data['nama_jenis_badan_usaha'];
            $model->kepemilikan = $data['kepemilikan'];
            $model->nama_kepemilikan = $data['nama_kepemilikan'];
            $model->skala_usaha = $data['skala_usaha'];
            $model->tipe = $data['tipe'];
            $model->no_tipe = $data['no_tipe'];
            $model->jenis_izin = $data['jenis_izin'];
            $model->jumlah_karyawan = $data['jumlah_karyawan'];
            $model->kapasitas_produksi = $data['kapasitas_produksi'];
            $model->id_kelompok_produk = $data['id_kelompok_produk'];

            if($data['id_jenis_registrasi'] == 3){
                $model->jenis_usaha = $data['jenis_usaha'];
                $model->nama_jenis_usaha = $data['nama_jenis_usaha'];
                $model->nkv = $data['nkv'];
            }            

            $model->sertifikat_perusahaan = $data['sertifikat_perusahaan'];
            $model->nib = $data['nib'];
            $model->jenis_surat = $data['jenis_surat'];
            $model->nomor_surat = $data['nomor_surat'];

            $model->status = 1 ;
            $model->save();
            DB::commit();                        
            
            $model_regisalamat = new RegistrasiAlamatKantor();
             
            DB::beginTransaction();

            $id_registrasi = DB::table('registrasi')            
            ->select('id')
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
                        
            foreach($id_registrasi as $id){
                foreach($id as $id_asli){
                    $idregis = $id_asli;
                }                
            }
            
            $model_regisalamat->id_registrasi = $idregis;
            $model_regisalamat->alamat = $data['alamat_kantor'];
            $model_regisalamat->kota = $data['kota_kantor'];
            $model_regisalamat->provinsi = $data['provinsi_kantor'];
            $model_regisalamat->negara = $data['negara_kantor'];
            $model_regisalamat->telepon = $data['telepon_kantor'];
            $model_regisalamat->kodepos = $data['kodepos_kantor'];
            $model_regisalamat->email = $data['email_kantor'];
                    
            $model_regisalamat->save();
            DB::commit();

            $model_regispabrik = new RegistrasiAlamatPabrik();
            DB::beginTransaction();

            $model_regispabrik->id_registrasi = $idregis;
            $model_regispabrik->alamat = $data['alamat_pabrik'];
            $model_regispabrik->kota = $data['kota_pabrik'];
            $model_regispabrik->provinsi = $data['provinsi_pabrik'];
            $model_regispabrik->negara = $data['negara_pabrik'];
            $model_regispabrik->telepon = $data['telepon_pabrik'];
            $model_regispabrik->kodepos = $data['kodepos_pabrik'];
            $model_regispabrik->email = $data['email_pabrik'];
            $model_regispabrik->status_pabrik = $data['status_pabrik'];
            $model_regispabrik->nama_status_pabrik = $data['nama_status_pabrik'];
            $model_regispabrik->jenis_fasilitas_produksi = $data['jenis_fasilitas_produksi'];

            $model_regispabrik->save();
            DB::commit();

            $model_regispemilik = new RegistrasiPemilikPerusahaan();
            DB::beginTransaction();

            $model_regispemilik->id_registrasi = $idregis;
            $model_regispemilik->nama_pemilik = $data['nama_pemilik'];
            $model_regispemilik->nama_pj = $data['nama_pj'];
            $model_regispemilik->jabatan_pemilik = $data['jabatan_pemilik'];
            $model_regispemilik->jabatan_pj = $data['jabatan_pj'];
            $model_regispemilik->telepon_pemilik = $data['telepon_pemilik'];
            $model_regispemilik->telepon_pj = $data['telepon_pj'];
            $model_regispemilik->fax_pemilik = $data['fax_pemilik'];
            $model_regispemilik->fax_pj = $data['fax_pj'];
            $model_regispemilik->email_pemilik = $data['email_pemilik'];
            $model_regispemilik->email_pj = $data['email_pj'];

            $model_regispemilik->save();
            DB::commit();

            if($data['id_jenis_registrasi'] == 1 || $data['id_jenis_registrasi'] == 5){
                $model_regisdataproduk = new RegistrasiDataProduk();
                DB::beginTransaction();

                $model_regisdataproduk->id_registrasi = $idregis;
                $model_regisdataproduk->klasifikasi_jenis_produk = $data['klasifikasi_jenis_produk'];
                $model_regisdataproduk->area_pemasaran = $data['area_pemasaran'];
                $model_regisdataproduk->izin_edar = $data['izin_edar'];
                $model_regisdataproduk->produk_lain = $data['produk_lain'];

                $model_regisdataproduk->save();
                DB::commit();

                $id_registrasi_produk = DB::table('registrasi_data_produk')            
                ->select('id')
                ->orderBy('id','desc')
                ->limit(1)
                ->get();
                            
                foreach($id_registrasi_produk as $id){
                    foreach($id as $id_asli){
                        $idregis_produk = $id_asli;
                    }                
                }

                // dd($data);
                if(count($data['merk']) > 0){
                    foreach($data['merk'] as $item => $value){
                        $data2 = array(
                            'id_registrasi_data_produk' => $idregis_produk,
                            'merk' => $data['merk'][$item]                        
                        );                    
                        DetailDataProduk::create($data2);
                    }
                }
            }else if($data['id_jenis_registrasi'] == 2){
                $model_regiskelompokusaha = new RegistrasiKU();
                DB::beginTransaction();

                $model_regiskelompokusaha->id_registrasi = $idregis;
                $model_regiskelompokusaha->kelompok_usaha = $data['kelompok_usaha'];
                $model_regiskelompokusaha->kategori_usaha = $data['kategori_usaha'];
                $model_regiskelompokusaha->jumlah_cabang_usaha = $data['jumlah_cabang_usaha'];
                $model_regiskelompokusaha->alamat_cabang_usaha = $data['alamat_cabang_usaha'];
                $model_regiskelompokusaha->area_pemasaran_usaha = $data['area_pemasaran_usaha'];
                $model_regiskelompokusaha->izin_edar_usaha = $data['izin_edar_usaha'];
                $model_regiskelompokusaha->izin_edar_usaha = $data['produk_lain_usaha'];

                $model_regiskelompokusaha->save();
                DB::commit();

                $id_registrasi_kelompok_usaha = DB::table('registrasi_kelompok_usaha')            
                ->select('id')
                ->orderBy('id','desc')
                ->limit(1)
                ->get();
                            
                foreach($id_registrasi_kelompok_usaha as $id){
                    foreach($id as $id_asli){
                        $idregis_kelompokusaha = $id_asli;
                    }                
                }

                // dd($data);
                if(count($data['sertifikat_lainnya']) > 0){
                    foreach($data['sertifikat_lainnya'] as $item => $value){
                        $data2 = array(
                            'id_registrasi_kelompok_usaha' => $idregis_kelompokusaha,
                            'sertifikat_lainnya' => $data['sertifikat_lainnya'][$item]
                        );                    
                        DetailKU::create($data2);
                    }
                }
            }else if($data['id_jenis_registrasi'] == 4){
                $model_regisjasa = new RegistrasiJasa();
                DB::beginTransaction();

                $model_regisjasa->id_registrasi = $idregis;
                $model_regisjasa->klasifikasi_jenis_jasa = $data['klasifikasi_jenis_jasa'];                
                $model_regisjasa->area_pemasaran_jasa = $data['area_pemasaran_jasa'];                
                $model_regisjasa->produk_lain_jasa = $data['produk_lain_jasa'];

                $model_regisjasa->save();
                DB::commit();
            }else if($data['id_jenis_registrasi'] == 3){
                // dd($data);
                if(count($data['jenis_sdm']) > 0){
                    foreach($data['jenis_sdm'] as $item => $value){
                        $data2 = array(
                            'id_registrasi' => $idregis,
                            'jenis_sdm' => $data['jenis_sdm'][$item],
                            'nama_sdm' => $data['nama_sdm'][$item],
                            'ktp_sdm' => $data['ktp_sdm'][$item],
                            'sertif_sdm' => $data['sertif_sdm'][$item],
                            'no_tglsk_sdm' => $data['no_tglsk_sdm'][$item],
                            'no_kontrak_sdm' => $data['no_kontrak_sdm'][$item]
                        );                    
                        RegistrasiDataSDM::create($data2);
                    }
                }

                if(count($data['jenis_hewan']) > 0){
                    foreach($data['jenis_hewan'] as $item => $value){
                        $data3 = array(
                            'id_registrasi' => $idregis,
                            'jenis_hewan' => $data['jenis_hewan'][$item],
                            'jumlah_produksi_perhari' => $data['jumlah_produksi_perhari'][$item],
                            'jumlah_produksi_perbulan' => $data['jumlah_produksi_perbulan'][$item]
                        );                    
                        RegistrasiJumlahProduksi::create($data3);
                    }
                }
            }

            // dd($data);
            if(count($data['nama_dph']) > 0){
                foreach($data['nama_dph'] as $item => $value){
                    $data2 = array(
                        'id_registrasi' => $idregis,
                        'nama_dph' => $data['nama_dph'][$item],
                        'ktp_dph' => $data['ktp_dph'][$item],
                        'sertif_dph' => $data['sertif_dph'][$item],
                        'no_tglsk_dph' => $data['no_tglsk_dph'][$item],
                        'no_kontrak_dph' => $data['no_kontrak_dph'][$item],
                    );                    
                    RegistrasiDPH::create($data2);
                }
            } 
            
            $model_regisdsm = new RegistrasiDSM();
            DB::beginTransaction();

            $model_regisdsm->id_registrasi = $idregis;
            $model_regisdsm->outsourcing = $data['outsourcing'];            
            $model_regisdsm->konsultan = $data['konsultan'];
            $model_regisdsm->jumlah_karyawan_organisasi = $data['jumlah_karyawan_organisasi'];
            $model_regisdsm->shift_1 = $data['shift_1'];
            $model_regisdsm->shift_2 = $data['shift_2'];
            $model_regisdsm->shift_3 = $data['shift_3'];
            $model_regisdsm->save();
            DB::commit();

            $id_registrasi_dsm = DB::table('registrasi_data_sistem_manajemen')
            ->select('id')
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
                        
            foreach($id_registrasi_dsm as $id){
                foreach($id as $id_asli){
                    $idregis_dsm = $id_asli;
                }                
            }

            // dd($data);
            if(count($data['sistem_manajemen']) > 0){
                foreach($data['sistem_manajemen'] as $item => $value){
                    $data2 = array(
                        'id_data_sistem_manajemen' => $idregis_dsm,
                        'sistem_manajemen' => $data['sistem_manajemen'][$item],
                        'sertifikasi_manajemen' => $data['sertifikasi_manajemen'][$item]
                    );                    
                    DetailDSM::create($data2);
                }
            } 
             
            // $model_regislokasilain = new RegistrasiLokasiLain();
            // DB::beginTransaction();

            if(count($data['nama_lokasi_lainnya']) > 0){
                foreach($data['nama_lokasi_lainnya'] as $item => $value){
                    $data2 = array(
                        'id_registrasi' => $idregis,
                        'nama_lokasi_lainnya' => $data['nama_lokasi_lainnya'][$item],
                        'alamat_lainnya' => $data['alamat_lainnya'][$item],
                        'kota_lainnya' => $data['kota_lainnya'][$item],
                        'telepon_lainnya' => $data['telepon_lainnya'][$item],
                        'kodepos_lainnya' => $data['kodepos_lainnya'][$item],
                        'fax_lainnya' => $data['fax_lainnya'][$item],
                        'narahubung_lainnya' => $data['narahubung_lainnya'][$item]
                    );                    
                    RegistrasiLokasiLain::create($data2);
                }
            }            
            
            // dd($data);
            // $model_regislokasilain->save();
            // DB::commit();

            // //for edit pdf ui
            // return PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf/pdf_download',$newdata)->stream();

            // //Save PDF File
            // $path = public_path('public/registrasi/'.$fileName);
            // Storage::put('public/registrasi/'.$fileName, $pdf->output());
            // //$pdf->download($fileName);


            //Session::flash('success', "data berhasil disimpan!, Silahkan unduh file invoice di list registrasi");

            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('registrasiHalal.index');

            return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('registrasiHalal.create');
            return $redirectPass;
        }
    }
    public function activeRegistrasi($id){

            try{
                //$this->debugs($data);
                $model = new User();
                DB::beginTransaction();
                $e = $model->find(Auth::user()->id);
                $e->registrasi_id = $id;
                $e->save();
                DB::commit();

                Session::flash('success', "Registrasi Telah Diaktifkan");
                $redirect = redirect()->route('registrasiHalal.index');
                return $redirect;

            }catch (\Exception $e){
                DB::rollBack();

                //$this->debugs($e->getMessage());

                Session::flash('error', $e->getMessage());
                $redirectPass = redirect()->route('registrasiHalal.index');
                return $redirectPass;
            }
    }
/////////////////////END of Registrasi////////////////////////////








    
    public function download($path){
         return Storage::download($path);
    }


////////////////////////////START Unggah Data////////////////////////////////


    //unggah data sertifikasi
    public function unggahDataSertifikasi(){

        $id_registrasi  = Auth::user()->registrasi_id;
        $id_user = Auth::user()->id;

        $data   = new Registrasi;
        $data   = $data->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok')
                 ->where('registrasi.id','=',$id_registrasi)
                 ->orderBy('registrasi.id','desc')->get();

        $data   = $data[0];

        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);

        //check data dokumen has
        $checkHas =  DB::table('dokumen_has')
                     ->where('id_user','=',$id_user)
                     ->where('id_registrasi',$id_registrasi)
                     ->get();

        if(isset($checkHas[0])){ $dataHas = json_decode($checkHas,true);}
        else{ $dataHas = null;}

        //check data dokumen material
        $checkMaterial = DB::table('dokumen_material')
                         ->where('id_user','=',$id_user)
                         ->where('id_registrasi',$id_registrasi)
                         ->get();

        if(isset($checkMaterial[0])){$dataMaterial = json_decode($checkMaterial,true);}
        else{$dataMaterial = null;}

        //check data dokumen matriks produk
        $checkMatriks = DB::table('dokumen_matriks_produk')
                         ->where('id_user','=',$id_user)
                         ->where('id_registrasi',$id_registrasi)
                         ->get();

        if(isset($checkMatriks[0])){$dataMatriksProduk = json_decode($checkMatriks,true);}
        else{$dataMatriksProduk = null;}

        //check data kuisioner has
        $checkKuisionerHas = DB::table('kuisioner_has')
                         ->where('id_user','=',$id_user)
                         ->where('id_registrasi',$id_registrasi)
                         ->get();

        if(isset($checkKuisionerHas[0])){$dataKuisionerHas = json_decode($checkKuisionerHas,true);}
        else{$dataKuisionerHas = null;}


        return view('registrasi.unggahData', compact('data','dataHas','dataMaterial','dataMatriksProduk','dataKuisionerHas','dataRegistrasi'));
    }
    public function listUnggahDataSertifikasi(){
        return view('pelanggan.unggahDataSertifikasi.index');
    }
    public function getDataRegistrasi($id){
        $detailRegistrasi =  DB::table('registrasi')
                            ->select('registrasi.id','registrasi.no_registrasi','registrasi.id_jenis_registrasi','users.perusahaan','users.name')
                            ->join('users','users.id','=','registrasi.id_user')
                            ->where('registrasi.id',$id)
                            ->get();
        $dataRegistrasi = json_decode($detailRegistrasi,true);

        return $dataRegistrasi;
    }

    public function detailUnggahDataSertifikasi($id_registrasi){
        //get data registrasi
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);

        //check data dokumen has
        $checkHas =  DB::table('dokumen_has')
                     ->where('id_registrasi',$id_registrasi)
                     ->get();

        if(isset($checkHas[0])){ $dataHas = json_decode($checkHas,true);}
        else{ $dataHas = null;}

        //check data dokumen matriks produk
        $checkMatriks = DB::table('dokumen_matriks_produk')
                         ->where('id_registrasi',$id_registrasi)
                         ->get();

        if(isset($checkMatriks[0])){$dataMatriksProduk = json_decode($checkMatriks,true);}
        else{$dataMatriksProduk = null;}

        //check data kuisioner has
        $checkKuisionerHas = DB::table('kuisioner_has')
                         ->where('id_registrasi',$id_registrasi)
                         ->get();

        if(isset($checkKuisionerHas[0])){$dataKuisionerHas = json_decode($checkKuisionerHas,true);}
        else{$dataKuisionerHas = null;}

        return view('pelanggan.unggahDataSertifikasi.detailData', compact('dataRegistrasi','dataHas','dataMatriksProduk','dataKuisionerHas'));

    }

    public function dataFasilitas($id_registrasi){
        $xdata = DB::table('fasilitas')
                 ->where('id_registrasi','=',$id_registrasi)
                 ->orderBy('id','desc');

        return Datatables::of($xdata)->make();
    }

    public function dataProduk($id_registrasi){

        $xdata = DB::table('produk')
                 ->join('fasilitas','produk.id_fasilitas','=','fasilitas.id')
                 ->join('kelompok_produk','produk.id_kelompok_produk','=','kelompok_produk.id')
                 ->select('produk.*','fasilitas.fasilitas as fasilitas','kelompok_produk.kelompok_produk as kelompok')
                 ->where('produk.id_registrasi','=',$id_registrasi)
                 ->orderBy('produk.id','desc');

        return Datatables::of($xdata)->make();
    }

    public function dataMenuRestoran($id_registrasi){
        $xdata = DB::table('menu_restoran')
                 ->where('id_registrasi','=',$id_registrasi)
                 ->orderBy('id','desc');

        return Datatables::of($xdata)->make();
    }

    public function dataKantorPusat($id_registrasi){
        $xdata = DB::table('kantor_pusat')
                 ->where('id_registrasi','=',$id_registrasi)
                 ->orderBy('id','desc');

        return Datatables::of($xdata)->make();
    }

    public function dataJagal($id_registrasi){
        $xdata = DB::table('jagal')
                 ->where('id_registrasi','=',$id_registrasi)
                 ->orderBy('id','desc');

        return Datatables::of($xdata)->make();
    }

    public function dataMaterial($id_registrasi){
        $xdata = DB::table('material')
                 ->where('id_registrasi','=',$id_registrasi)
                 ->orderBy('id','desc');

        return Datatables::of($xdata)->make();
    }


    //for detail
    public function fasilitasDetail($id_registrasi,$id){
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailFasilitas = DB::table('fasilitas')
                            ->where('id',$id)
                            ->get();
        $dataFasilitas = json_decode($detailFasilitas,true);

        return view('registrasi.detailFasilitas',compact('dataRegistrasi','dataFasilitas'));
    }
    public function kantorPusatDetail($id_registrasi,$id){
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailKantorPusat = DB::table('kantor_pusat')
                            ->where('id',$id)
                            ->get();
        $dataKantorPusat = json_decode($detailKantorPusat,true);
        return view('registrasi.detailKantorPusat',compact('dataKantorPusat','dataRegistrasi'));
    }
    public function materialDetail($id_registrasi,$id){
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailMaterial = DB::table('material')
                            ->where('id',$id)
                            ->get();
        $dataMaterial = json_decode($detailMaterial,true);
        return view('registrasi.detailMaterial',compact('dataMaterial','dataRegistrasi'));
    }
    public function jagalDetail($id_registrasi,$id){
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailJagal = DB::table('jagal')
                            ->select('jagal.*','fasilitas.*')
                            ->join('fasilitas','fasilitas.id','=','jagal.id_fasilitas')
                            ->where('jagal.id',$id)
                            ->where('fasilitas.id_registrasi',$id_registrasi)
                            ->get();
        $dataJagal = json_decode($detailJagal,true);
        return view('registrasi.detailJagal',compact('dataJagal','dataRegistrasi'));
    }


    //tab fasilitas
    public function listFasilitas(){
        $xdata = DB::table('fasilitas')
                 ->where('id_user','=',Auth::user()->id)
                 ->where('id_registrasi','=',Auth::user()->registrasi_id)
                 ->orderBy('id','desc');

        return Datatables::of($xdata)->make();
    }
    public function createFasilitas(){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        return view('registrasi.createFasilitas',compact('dataRegistrasi'));
    }
    public function storeFasilitas(Request $request){
        $data = $request->except('_token','_method');

        $model = new Fasilitas();

        try{
            //$this->debugs($data);
            DB::beginTransaction();
            $model->fill($data);
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = Auth::user()->registrasi_id;
            $model->save();
            DB::commit();

            Session::flash('success', "data berhasil disimpan!");
            $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
            return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('tambahfasilitas');
            return $redirectPass;
        }
    }
    public function detailFasilitas($id){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailFasilitas = DB::table('fasilitas')
                            ->where('id',$id)
                            ->get();
        $dataFasilitas = json_decode($detailFasilitas,true);

        return view('registrasi.detailFasilitas',compact('dataRegistrasi','dataFasilitas'));
    }
    public function editFasilitas($id){
        $data = Fasilitas::find($id);

        return view('registrasi.editFasilitas',compact('data'));
    }
     public function updateFasilitas(Request $request, $id){
        $data = $request->except('_token','_method');

        $model = new Fasilitas();

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->save();
            DB::commit();

            Session::flash('success', 'data berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('registrasi.unggahDataSertifikasi');
    }


    //tab produk
    public function listProduk(){
        $xdata = DB::table('produk')
                 ->join('fasilitas','produk.id_fasilitas','=','fasilitas.id')
                 ->join('kelompok_produk','produk.id_kelompok_produk','=','kelompok_produk.id')
                 ->select('produk.*','fasilitas.fasilitas as fasilitas','kelompok_produk.kelompok_produk as kelompok')
                 ->where('produk.id_user','=',Auth::user()->id)
                 ->where('produk.id_registrasi','=',Auth::user()->registrasi_id)
                 ->orderBy('produk.id','desc');

        return Datatables::of($xdata)->make();
    }
    public function createProduk(){
        $kelompokProduk = KelompokProduk::all();
        $id_registrasi  = Auth::user()->registrasi_id;
        $detailFasilitas = DB::table('fasilitas')
                            ->where('id_registrasi',$id_registrasi)
                            ->get();
        $fasilitas = json_decode($detailFasilitas,true);
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        return view('registrasi.createProduk',compact('fasilitas','kelompokProduk','dataRegistrasi'));
    }
    public function storeProduk(Request $request){
        $data = $request->except('_token','_method');

        $model = new Produk();

        try{
            //$this->debugs($data);
            DB::beginTransaction();
            $model->fill($data);
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = Auth::user()->registrasi_id;
            $model->save();
            DB::commit();

            Session::flash('success', "data berhasil disimpan!");
            $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
            return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('tambahproduk');
            return $redirectPass;
        }
    }
    public function editProduk($id){
        $data = Produk::find($id);
        $fasilitas = Fasilitas::all();
        $kelompokProduk = KelompokProduk::all();

        return view('registrasi.editProduk',compact('data','fasilitas','kelompokProduk'));
    }
    public function updateProduk(Request $request, $id)
    {
        $data = $request->except('_token','_method');

        $model = new Produk();

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->save();
            DB::commit();

            Session::flash('success', 'data berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('registrasi.unggahDataSertifikasi');
    }


    //tab dokumen has

    public function storeDokumenHas(Request $request){
        $data = $request->except('_token','_method');

        $model = new DokumenHas;

        $status = "HAS";
        $id_user = Auth::user()->id;
        $id_registrasi  = Auth::user()->registrasi_id;

        $getRegistrasi = DB::table('registrasi')->where('id','=',Auth::user()->registrasi_id)->get();

        foreach ($getRegistrasi as $key => $value) {
            $no_registrasi = $value->no_registrasi;
        }


        if($data["status"] == "0"){
                try{
                    DB::beginTransaction();

                    unset($data["status"]);
                    $model->id_user = $id_user;
                    $model->id_registrasi = $id_registrasi;

                    foreach ($data as $key => $value) {
                        if($key){

                            $model->$key =  FileUploadServices::getFileName($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);
                            FileUploadServices::getUploadFile($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);

                        }

                    }
                    //print_r(count($data)) ;
                    if(count($data)==10){
                        $model->status_has = 1;
                    }else{
                        $model->status_has = 0;
                    }

                    $model->save();
                    DB::commit();

                    //update unggah data sertifikasi
                    $checkDataHas = DB::table('dokumen_has')
                         ->where('id_user','=',$id_user)
                         ->where('id_registrasi',$id_registrasi)
                         ->get();

                    $id_has = $checkDataHas[0]->id;

                    DB::table('unggah_data_sertifikasi')->where('id_registrasi', $id_registrasi)->update(['id_has' => $id_has]);

                    Session::flash('success', "data berhasil disimpan!");
                    $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
                    return $redirect;

                }catch (\Exception $e){
                    DB::rollBack();

                    //$this->debugs($e->getMessage());

                    Session::flash('error', $e->getMessage());
                    $redirectPass = redirect()->route('registrasi.unggahDataSertifikasi');
                    return $redirectPass;
                }

        }elseif($data["status"] == "1"){
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            try{
                    DB::beginTransaction();

                    $id = $data["id"];
                    $e = $model->find($id);

                    unset($data["id"]);
                    unset($data["status"]);

                    foreach ($data as $key => $value) {
                        if($key){

                            $e->$key =  FileUploadServices::getFileName($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);
                            FileUploadServices::getUploadFile($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);
                        }

                    }

                    $e->save();

                    $checkHasLengkap = "SELECT *
                       FROM dokumen_has
                       WHERE id_registrasi = ".$id_registrasi."
                       AND(
                        has_1 IS NULL
                        OR has_2 IS NULL
                        OR has_3 IS NULL
                        OR has_4 IS NULL
                        OR has_5 IS NULL
                        OR has_6 IS NULL
                        OR has_7 IS NULL
                        OR has_8 IS NULL
                        OR has_9 IS NULL
                        OR has_10 IS NULL
                        OR has_11 IS NULL
                        OR has_12 IS NULL)
                        ";

                    $dataLengkap = DB::select($checkHasLengkap);

                    if(isset($dataLengkap[0])){
                        $e->status_has = 0;
                    }else{
                        $e->status_has = 1;
                    }
                    $e->save();

                    DB::commit();


                    Session::flash('success', "data berhasil diupdate!");
                    $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
                    return $redirect;

            }catch (\Exception $e){
                    DB::rollBack();

                    //$this->debugs($e->getMessage());

                    Session::flash('error', $e->getMessage());
                    $redirectPass = redirect()->route('registrasi.unggahDataSertifikasi');
                    return $redirectPass;
            }
            $checkDataHas = DB::table('dokumen_has')
                         ->where('id_user','=',$id_user)
                         ->where('id_registrasi',$id_registrasi)
                         ->get();
            $id_has = $checkDataHas[0]->id;

            DB::table('unggah_data_sertifikasi')
                    ->where('id_registrasi', $id_registrasi)
                    ->update(['id_has' => $id_has]);
        }
    }

   

    public function updateStatusHas(Request $request, $id){
        $data = $request->except('_token','_method','status');

        $model = new DokumenHas();
        $id_user = Auth::user()->id;

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->check_by = Auth::user()->id;
            $e->save();
            DB::commit();
            Session::flash('success', "Status berhasil diupdate");
        }catch (\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteDokumenHas($id){

        $model = new DokumenHas();
        $status = "HAS";
        $id_user = Auth::user()->id;
        $id_registrasi  = Auth::user()->registrasi_id;
        try{
            DB::beginTransaction();
            $model = $model->find($id);
            $model->delete();
            DB::commit();

            FileUploadServices::deleteUploadFile($id_user,$id_registrasi,$status);
            DB::table('unggah_data_sertifikasi')->where('id_registrasi', $id_registrasi)->update(['id_has' => null]);

            Session::flash('success', 'data berhasil di dihapus!');

        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('registrasi.unggahDataSertifikasi');
    }


    //tab dokumen material
    public function listMaterial(){
        $xdata = DB::table('material')
                 ->where('id_user','=',Auth::user()->id)
                 ->where('id_registrasi','=',Auth::user()->registrasi_id)
                 ->orderBy('id','desc');

        return Datatables::of($xdata)->make();
    }
    public function createMaterial(){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        return view('registrasi.createMaterial',compact('dataRegistrasi'));
    }
    public function storeMaterial(Request $request){
        $data = $request->except('_token','_method');

        $model = new Material();
        $status = "MATERIAL";
        $id_user = Auth::user()->id;
        $id_registrasi  = Auth::user()->registrasi_id;

        $getRegistrasi = DB::table('registrasi')->where('id','=',Auth::user()->registrasi_id)->get();

        foreach ($getRegistrasi as $key => $value) {
            $no_registrasi = $value->no_registrasi;
        }

        try{

            DB::beginTransaction();
            $model->fill($data);
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = Auth::user()->registrasi_id;
            $model->save();
            if(isset($data['file_material'])){
                $value = $data["file_material"];
            $key   = $model->id;
            $model->file_material = FileUploadServices::getFileName($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);
            FileUploadServices::getUploadFile($value,$id_user,$id_registrasi,$status,$key, $no_registrasi);
            $model->save();
            }
            DB::commit();

            Session::flash('success', "data berhasil disimpan!");
            $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
            return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('tambahmaterial');
            return $redirectPass;
        }
    }
    public function editMaterial($id){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $data = Material::find($id);

        return view('registrasi.editMaterial',compact('data','dataRegistrasi'));
    }
    public function updateMaterial(Request $request, $id){
        $data = $request->except('_token','_method');

        $model = new Material();
        $status = "MATERIAL";
        $id_user = Auth::user()->id;
        $id_registrasi  = Auth::user()->registrasi_id;

        $getRegistrasi = DB::table('registrasi')->where('id','=',Auth::user()->registrasi_id)->get();

        foreach ($getRegistrasi as $key => $value) {
            $no_registrasi = $value->no_registrasi;
        }

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            if(isset($data['file_material'])){
                $value = $data["file_material"];
                $key   = $id;
                $e->file_material = FileUploadServices::getFileName($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);
                FileUploadServices::getUploadFile($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);
            }
            $e->save();
            DB::commit();

            Session::flash('success', 'data berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('registrasi.unggahDataSertifikasi');
    }
    public function detailMaterial($id){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailMaterial = DB::table('material')
                            ->where('id',$id)
                            ->get();
        $dataMaterial = json_decode($detailMaterial,true);
        return view('registrasi.detailMaterial',compact('dataMaterial','dataRegistrasi'));
    }


    //tab dokumen matriks produk
    public function storeMatriksProduk(Request $request){
        $data = $request->except('_token','_method');

        $model = new DokumenMatriksProduk;

        $status = "MATRIKSPRODUK";
        $id_user = Auth::user()->id;
        $id_registrasi = Auth::user()->registrasi_id;

        $getRegistrasi = DB::table('registrasi')->where('id','=',Auth::user()->registrasi_id)->get();

        foreach ($getRegistrasi as $key => $value) {
            $no_registrasi = $value->no_registrasi;
        }

        if($data["status"] == "0"){
            try{
                DB::beginTransaction();

                unset($data["status"]);
                $model->id_user = $id_user;
                $model->id_registrasi = $id_registrasi;

                foreach($data as $key => $value){
                    if($key){

                        $model->$key = FileUploadServices::getFileName($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);
                        FileUploadServices::getUploadFile($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);

                    }
                }

                $model->status_matriks_produk = 1;

                $model->save();
                DB::commit();


                //update unggah data sertifikasi
                    $checkDataMatriks = DB::table('dokumen_matriks_produk')
                         ->where('id_user','=',$id_user)
                         ->where('id_registrasi',$id_registrasi)
                         ->get();

                    $id_matriks = $checkDataMatriks[0]->id;

                    DB::table('unggah_data_sertifikasi')->where('id_registrasi', $id_registrasi)->update(['id_matriks' => $id_matriks]);

                Session::flash('success', "data berhasil disimpan!");
                $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
                return $redirect;
            }catch(\Exception $e){
                DB::rollBack();

                Session::flash('error', $e->getMessage());
                $redirectPass = redirect()->route('registrasi.unggahDataSertifikasi');
                return $redirectPass;
            }
        }elseif($data["status"] == "1"){
            try{
                DB::beginTransaction();

                $id = $data['id'];
                $e = $model->find($id);

                unset($data["id"]);
                unset($data["status"]);

                foreach ($data as $key => $value) {
                   if($key){

                        $e->$key =  FileUploadServices::getFileName($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);
                        FileUploadServices::getUploadFile($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);

                   }
                }
                $e->save();
                DB::commit();

                Session::flash('success', "data berhasil diupdate!");
                $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
                return $redirect;

            }catch (\Exception $e){
                DB::rollBack();
                Session::flash('error', $e->getMessage());
                $redirectPass = redirect()->route('registrasi.unggahDataSertifikasi');
                return $redirectPass;
            }
        }
    }
    public function deleteMatriksProduk($id){
        $model = new DokumenMatriksProduk();
        $status = "MATRIKSPRODUK";
        $id_user = Auth::user()->id;
        $id_registrasi  = Auth::user()->registrasi_id;
        try{
            DB::beginTransaction();
            $model = $model->find($id);
            $model->delete();
            DB::commit();

            FileUploadServices::deleteUploadFile($id_user,$id_registrasi,$status);

            Session::flash('success', 'data berhasil di dihapus!');

        }catch (\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('registrasi.unggahDataSertifikasi');
    }


    //tab kuisioner has
    public function storeKuisionerHas(Request $request){
        $data = $request->except('_token','_method');

        $model = new KuisionerHas();
        $id_user = Auth::user()->id;
        $id_registrasi = Auth::user()->registrasi_id;

        if($data["status"] == "0"){
            try{
                DB::beginTransaction();
                unset($data["status"]);
                $model->fill($data);
                $model->id_user = $id_user;
                $model->id_registrasi = $id_registrasi;
                $model->status_kuis = 1;
                $model->save();
                DB::commit();


                //update unggah data sertifikasi
                    $checkDataKuis = DB::table('kuisioner_has')
                         ->where('id_user','=',$id_user)
                         ->where('id_registrasi',$id_registrasi)
                         ->get();

                    $id_kuis = $checkDataKuis[0]->id;

                    DB::table('unggah_data_sertifikasi')->where('id_registrasi', $id_registrasi)->update(['id_kuis' => $id_kuis]);


                Session::flash('success', "data berhasil disimpan!");
                $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
                return $redirect;

            }catch (\Exception $e){
                DB::rollBack();
                Session::flash('error', $e->getMessage());
                $redirectPass = redirect()->route('registrasi.unggahDataSertifikasi');
                return $redirectPass;
            }
        }elseif($data["status"] == "1"){
            try{
                DB::beginTransaction();

                $id = $data['id'];
                $e = $model->find($id);

                unset($data["id"]);
                unset($data["status"]);

                $e->fill($data);
                $e->save();
                DB::commit();

                Session::flash('success', "data berhasil disimpan!");
                $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
                return $redirect;

            }catch (\Exception $e){
                DB::rollBack();
                Session::flash('error', $e->getMessage());
                $redirectPass = redirect()->route('registrasi.unggahDataSertifikasi');
                return $redirectPass;
            }
        }
    }
    public function deleteKuisionerHas($id){
        $model = new KuisionerHas();
        $status = "MATRIKSPRODUK";
        $id_user = Auth::user()->id;
        $id_registrasi  = Auth::user()->registrasi_id;
        try{
            DB::beginTransaction();
            $model = $model->find($id);
            $model->delete();
            DB::commit();

            DB::table('unggah_data_sertifikasi')->where('id_registrasi', $id_registrasi)->update(['id_kuis' => null]);

            Session::flash('success', 'data berhasil di dihapus!');

        }catch (\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('registrasi.unggahDataSertifikasi');
    }


    //tab kantor pusat
    public function listKantorPusat(){
        $xdata = DB::table('kantor_pusat')
                 ->where('id_user','=',Auth::user()->id)
                 ->where('id_registrasi','=',Auth::user()->registrasi_id)
                 ->orderBy('id','desc');

        return Datatables::of($xdata)->make();
    }
    public function createKantorPusat(){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        return view('registrasi.createKantorPusat',compact('dataRegistrasi'));
    }
    public function storeKantorPusat(Request $request){
        $data = $request->except('_token','_method');

        $model = new KantorPusat();

        try{
            //$this->debugs($data);
            DB::beginTransaction();
            $model->fill($data);
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = Auth::user()->registrasi_id;
            $model->save();
            DB::commit();

            Session::flash('success', "data berhasil disimpan!");
            $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
            return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('tambahkantorpusat');
            return $redirectPass;
        }
    }
    public function detailKantorPusat($id){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailKantorPusat = DB::table('kantor_pusat')
                            ->where('id',$id)
                            ->get();
        $dataKantorPusat = json_decode($detailKantorPusat,true);
        return view('registrasi.detailKantorPusat',compact('dataKantorPusat','dataRegistrasi'));
    }
    public function editKantorPusat($id){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $data = KantorPusat::find($id);

        return view('registrasi.editKantorPusat',compact('data','dataRegistrasi'));
    }
    public function updateKantorPusat(Request $request, $id){
        $data = $request->except('_token','_method');

        $model = new KantorPusat();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->save();
            DB::commit();

            Session::flash('success', 'data berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('registrasi.unggahDataSertifikasi');
    }

    //tab menu restoran
    public function listMenuRestoran(){
        $xdata = DB::table('menu_restoran')
                 ->where('id_user','=',Auth::user()->id)
                 ->where('id_registrasi','=',Auth::user()->registrasi_id)
                 ->orderBy('id','desc');

        return Datatables::of($xdata)->make();
    }
    public function createMenuRestoran(){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        return view('registrasi.createMenuRestoran',compact('dataRegistrasi'));
    }
    public function storeMenuRestoran(Request $request){
        $data = $request->except('_token','_method');

        $model = new MenuRestoran();

        try{
            //$this->debugs($data);
            DB::beginTransaction();
            $model->fill($data);
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = Auth::user()->registrasi_id;
            $model->save();
            DB::commit();

            Session::flash('success', "data berhasil disimpan!");
            $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
            return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('tambahmenurestoran');
            return $redirectPass;
        }
    }
    public function detailMenuRestoran($id){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailMenuRestoran = DB::table('menu_restoran')
                            ->where('id',$id)
                            ->get();
        $dataMenuRestoran = json_decode($detailMenuRestoran,true);
        return view('registrasi.detailMenuRestoran',compact('dataMenuRestoran','dataRegistrasi'));
    }
    public function editMenuRestoran($id){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $data = MenuRestoran::find($id);

        return view('registrasi.editMenuRestoran',compact('data','dataRegistrasi'));
    }
    public function updateMenuRestoran(Request $request, $id){
        $data = $request->except('_token','_method');

        $model = new MenuRestoran();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->save();
            DB::commit();

            Session::flash('success', 'data berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('registrasi.unggahDataSertifikasi');
    }

    //tab menu restoran
    public function listJagal(){
        $xdata = DB::table('jagal')
                 ->where('id_user','=',Auth::user()->id)
                 ->where('id_registrasi','=',Auth::user()->registrasi_id)
                 ->orderBy('id','desc');

        return Datatables::of($xdata)->make();
    }
    public function createJagal(){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailFasilitas = DB::table('fasilitas')
                            ->where('id_registrasi',$id_registrasi)
                            ->get();
        $fasilitas = json_decode($detailFasilitas,true);
        return view('registrasi.createJagal',compact('dataRegistrasi','fasilitas'));
    }
    public function storeJagal(Request $request){
        $data = $request->except('_token','_method');

        $model = new Jagal();

        try{
            //$this->debugs($data);
            DB::beginTransaction();
            $model->fill($data);
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = Auth::user()->registrasi_id;
            $model->save();
            DB::commit();

            Session::flash('success', "data berhasil disimpan!");
            $redirect = redirect()->route('registrasi.unggahDataSertifikasi');
            return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('tambahjagal');
            return $redirectPass;
        }
    }
    public function detailJagal($id){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailJagal = DB::table('jagal')
                            ->select('jagal.*','fasilitas.*')
                            ->join('fasilitas','fasilitas.id','=','jagal.id_fasilitas')
                            ->where('jagal.id',$id)
                            ->where('fasilitas.id_registrasi',$id_registrasi)
                            ->get();
        $dataJagal = json_decode($detailJagal,true);
        return view('registrasi.detailJagal',compact('dataJagal','dataRegistrasi'));
    }
    public function editJagal($id){
        $id_registrasi  = Auth::user()->registrasi_id;
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);
        $detailFasilitas = DB::table('fasilitas')
                            ->where('id_registrasi',$id_registrasi)
                            ->get();
        $fasilitas = json_decode($detailFasilitas,true);

        $data = Jagal::find($id);

        return view('registrasi.editJagal',compact('data','dataRegistrasi','fasilitas'));
    }
    public function updateJagal(Request $request, $id){
        $data = $request->except('_token','_method');

        $model = new Jagal();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->save();
            DB::commit();

            Session::flash('success', 'data berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('registrasi.unggahDataSertifikasi');
    }
////////////////////////////END Unggah Data////////////////////////////

    public function penjadualanAudit(){
        return view('registrasi.penjadualanAudit');
    }
    public function dokumenTravel(){
        return view('registrasi.dokumenTravel');
    }


    ////////////////////////AKAD////////////////////////////////////////
    public function uploadAkadAdmin($id){
        //dd($id);
        $data = Registrasi::find($id);
        //get Data from FAQ Transfer
        $getTransfer =   DB::table('faq')
                    ->where('status','transfer')
                    ->get();
        $dataTransfer = json_decode($getTransfer,true);
        //get Data from FAQ Tunai
        $getTunai =   DB::table('faq')
                    ->where('status','tunai')
                    ->get();
        $dataTunai = json_decode($getTunai,true);
        return view('registrasi.uploadKontrakAkad',compact('data','dataTransfer','dataTunai'));
    }
    public function uploadAkadUser($id){
        //dd($id);
        $data = Registrasi::find($id);
        //get Data from FAQ Transfer
        $getTransfer =   DB::table('faq')
                    ->where('status','transfer')
                    ->get();
        $dataTransfer = json_decode($getTransfer,true);
        //get Data from FAQ Tunai
        $getTunai =   DB::table('faq')
                    ->where('status','tunai')
                    ->get();
        $dataTunai = json_decode($getTunai,true);
        return view('registrasi.kontrakAkad',compact('data','dataTransfer','dataTunai'));
    }



    public function konfirmasiAkadAdmin($id){
       
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

            
            $e->status = '8';
            $e->status_akad= 3;
            $e->updated_status_by = $updater;
            $e->save();
           

             $e->total_biaya = ((int)str_replace(',', '', $e->total_biaya));
           if($p == null){
                if($e->total_biaya >10000000 && $e->total_biaya <= 50000000){
               // dd($e->total_biaya);

                    $model3->nominal_tahap1 = ((int)$e->total_biaya)/2;
                    $model3->nominal_tahap2 = ((int)$e->total_biaya)/2;
                    $model3->nominal_total =((int)$e->total_biaya);
                    $model3->id_registrasi = $e->id;
                    $model3->updated_by=$updater;
                    $model3->mata_uang = $e->mata_uang;
                    $model3->save();
                    }
                elseif($e->total_biaya > 50000000){
                   // dd($e->total_biaya);
                    $model3->nominal_tahap1 = ((int)$e->total_biaya)*30/100;
                    $model3->nominal_tahap2 = ((int)$e->total_biaya)*30/100;
                    $model3->nominal_tahap3 =  ((int)$e->total_biaya)*40/100;
                    $model3->nominal_total =  ((int)$e->total_biaya);
                    $model3->id_registrasi = $e->id;
                    $model3->updated_by=$updater;
                    $model3->mata_uang = $e->mata_uang;
                    $model3->save();
                }else{
                     //dd($e->total_biaya);
                    $model3->nominal_tahap1 = ((int)$e->total_biaya);
                    $model3->nominal_total = ((int)$e->total_biaya);
                    $model3->id_registrasi = $e->id;
                    $model3->updated_by=$updater;
                    $model3->mata_uang = $e->mata_uang;
                     $model3->save();

                }
                $e->id_pembayaran = $model3->id;
                $e->save();
                 Mail::to($u->email)->send(new KonfirmasiPembayaran($u,$e,$model3, $e->status));
           }else{
                if($e->total_biaya >10000000 && $e->total_biaya <= 50000000){
               // dd($e->total_biaya);

                    $p->nominal_tahap1 = ((int)$e->total_biaya)/2;
                    $p->nominal_tahap2 = ((int)$e->total_biaya)/2;
                    $p->nominal_total =((int)$e->total_biaya);
                    $p->id_registrasi = $e->id;
                    $p->updated_by=$updater;
                    $p->mata_uang = $e->mata_uang;
                    $p->save();
                    }
                elseif($e->total_biaya > 50000000){
                   // dd($e->total_biaya);
                    $p->nominal_tahap1 = ((int)$e->total_biaya)*30/100;
                    $p->nominal_tahap2 = ((int)$e->total_biaya)*30/100;
                    $p->nominal_tahap3 =  ((int)$e->total_biaya)*40/100;
                    $p->nominal_total =  ((int)$e->total_biaya);
                    $p->id_registrasi = $e->id;
                    $p->updated_by=$updater;
                    $p->mata_uang = $e->mata_uang;
                    $p->save();
                }else{
                     //dd($e->total_biaya);
                    $p->nominal_tahap1 = ((int)$e->total_biaya);
                    $p->nominal_total = ((int)$e->total_biaya);
                    $p->id_registrasi = $e->id;
                    $p->updated_by=$updater;
                    $p->mata_uang = $e->mata_uang;
                     $p->save();
                }
                 Mail::to($u->email)->send(new KonfirmasiPembayaran($u,$e,$p, $e->status));


           }

            
            
           
            DB::commit(); 
           

            Session::flash('success', "Konfirmasi Dokumen Kontrak Berhasil");
            // dd($e->total_biaya);


        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }



            $redirect = redirect()->route('listakadadmin');
            return $redirect;
    }
   


    public function uploadFileAkadAdmin(Request $request, $id){
        $data = $request->except('_token','_method');
        //dd($data);

        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);

            $e->tanggal_akad = $data['tgl_akad'];
            $e->status_akad = 1;
            $e->mata_uang = $data['mata_uang'];
            $e->status=31;
            $data['total_biaya'] = str_replace(',', '', $data['total_biaya']);
            $e->total_biaya = $data['total_biaya'];
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "AKAD-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/buktiakad/".Auth::user()->id."/", $filename);
                $e->file_akad = $filename;
            }
            $e->save();
            DB::commit();
            Mail::to($u->email)->send(new ProgresStatus($u,$e,$p,$e->status));
            Session::flash('success', "Upload Bukti Dokumen Kontrak Berhasil");

            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('listakadadmin');
            return $redirect;
    }

    public function uploadFileAkadUser(Request $request, $id){
        $data = $request->except('_token','_method');
        //dd($data);
        $model = new Registrasi();
        
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            
            $e->status_akad = 2;
            $e->status=34;
           
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "AKAD-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/buktiakad/".Auth::user()->id."/", $filename);
                $e->file_akad = $filename;
            }
            $e->save();
            DB::commit();

            Session::flash('success', "Upload Bukti Dokumen Kontrak Berhasil");

            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('registrasiHalal.index');
            return $redirect;
    }

     public function listAkadAdmin(){
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('registrasi.listKontrakAkad',compact('dataKelompok','dataJenis'));
    }

    public function dataAkadAdmin(Request $request){
        $gdata = $request->except('_token','_method');
        //start
        $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                 //->join('users','registrasi.id_user','=','users.id')
                 ->join('users','registrasi.id','=','users.registrasi_id')
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan')
                 ->where('registrasi.status_akad','0')
                 
                     ->orWhere('registrasi.status_akad','1')
                       ->orWhere('registrasi.status_akad','2');
                        //->orWhere('registrasi.status_akad','0');
                             
                          

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
        
        if(isset($gdata['status_akad'])){
            $xdata = $xdata->where('status_akad','=',$gdata['status_akad']);
        }
        if(isset($gdata['status'])){
            $xdata = $xdata->where('registrasi.status','=',$gdata['status']);
        }

        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }

     public function updateStatusAkad($id,$no_registrasi,$id_user,$status){
        
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
            
            if($status =='8'){
                $e->status_pembayaran = '1';
                $e->save();
            }
            
            
        
                try{
                    Mail::to($u->email)->send(new ProgresStatus($u,$e,$p, $status));
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



 ///////////////////////////ENDofAKAD////////////////////////////


 //////////////Start Pembayaran///////////////////////////   


    //Pembayaran registrasi
    public function pembayaranRegistrasi($id){
        $data = Registrasi::find($id);
        $dataP = Pembayaran::find($data->id_pembayaran);
        //get Data from FAQ Transfer
        $getTransfer =   DB::table('faq')
                    ->where('status','transfer')
                    ->get();
        $dataTransfer = json_decode($getTransfer,true);
        //get Data from FAQ Tunai
        $getTunai =   DB::table('faq')
                    ->where('status','tunai')
                    ->get();
        $dataTunai = json_decode($getTunai,true);
        return view('registrasi.pembayaran',compact('data','dataP','dataTransfer','dataTunai'));
    }

    public function konfirmasiPembayaranUser(Request $request, $id){
        $data = $request->except('_token','_method');
        //dd($data);
        $model = new Registrasi();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->tanggal_pembayaran = $data['tgl_pembayaran'];
            $e->status_pembayaran = 1;
            $e->status=32;
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "BB".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
                $e->bukti_pembayaran = $filename;
            }
            $e->save();
            DB::commit();

            Session::flash('success', "Upload Bukti Pembayaran Berhasil");

            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('registrasiHalal.index');
            return $redirect;
    }

   

    //list pembayaran registrasi
    public function listPembayaranRegistrasi(){
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('registrasi.listPembayaran',compact('dataKelompok','dataJenis'));
    }

    public function unduhBuktiBayar($id){
        
         $pdfName=DB::table('registrasi')->select('inv_pembayaran')->where('id', $id)->get();
         
         foreach($pdfName as $name)
        {
            foreach($name as $file_name)
            {
            
                $name2 = $file_name;
            }
           
        }

        $file= public_path(). '/storage/pembayaran/'.$name2;
        $headers = array('Content-Type: application/pdf',);
        return Response::download($file, 'Bukti Pembayaran.pdf', $headers);
        //return download("40305628_INV_PAYMENT.pdf");
    }
    public function konfirmasiPembayaranRegistrasi($id){
        //retrieve data
        $getUserId = Registrasi::where('id','=',$id)->get();

        $updater = Auth::user()->name;

        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();

         DB::beginTransaction();
        $e = $model->find($id);
        $u = $model2->find($e->id_user);
        $p = $model3->find($e->id_pembayaran);
        $e->status = '13';
        $e->updated_status_by = $updater;
        $e->save();

        date_default_timezone_set('Indonesia/Jakarta');


        foreach ($getUserId as $key) {
            $userId = $key->id_user;

            //create PDF File
            $getUser = User::find($userId);
            $getRegistrasi= Registrasi::find($id);
            $newData = ['userData'=>$getUser,'registrasiData'=>$getRegistrasi];
            $fileName = $key->no_registrasi.'_BB_TAHAP1.pdf';
            $pdf = PDF::loadView('pdf/pdf_pembayaran',$newData);
                
            // save
             Storage::put('public/pembayaran/'.$fileName, $pdf->output());
                
            $p->status_tahap1 = '2';
            $p->bb_tahap1 = $fileName;
            $p->tanggal_tahap1 = date_default_timezone_get();
             $p->updated_at = date_default_timezone_get();
            $p->save();

            Mail::to($u->email)->send(new KonfirmasiPembayaran($e,$u,$p,$status));
            DB::commit();  
;
        }

         Session::flash('success', "Pembayaran berhasil dikonfirmasi!");
         $redirect = redirect()->route('listpembayaranregistrasi');
         return $redirect;
    }



    public function dataPembayaranRegistrasi(Request $request){
        $gdata = $request->except('_token','_method');
        //start
        $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                 ->join('pembayaran', 'registrasi.id','=','pembayaran.id_registrasi')
                 //->join('users','registrasi.id_user','=','users.id')
                 ->join('users','registrasi.id','=','users.registrasi_id')
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan', 'pembayaran.status_tahap1 as status_tahap1', 'pembayaran.nominal_tahap1 as nominal_tahap1' )
                 ->where('pembayaran.status_tahap1','0')
                         ->orWhere('pembayaran.status_tahap1','1')
                           ->orWhere('registrasi.status','11');
                           

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



    public function updateStatusPembayaran($id,$no_registrasi,$id_user,$status){
        
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
            
            if($status =='12'){
                $p->status_tahap1 = '0';
                $p->updated_by = $updater;
                $p->save();
            }elseif($status =='11' || $status =='10'){
                $p->status_tahap1 = '0';
                $p->updated_by = $updater;
                $p->save();
            }
            
           
        
                try{
                    Mail::to($u->email)->send(new ProgresStatus($u,$e,$p, $status));
                    //Session::flash('success', "data berhasil disimpan!");
                    Session::flash('success', 'data dengan no registrasi '.$no_registrasi.' berhasil di kirim emailnya!');

                    DB::commit();

                }catch(\Exception $u){

                    Session::flash('error', $u->getMessage());
                    //Session::flash('success', "data berhasil disimpan!");
                    //$statusreg = $e->getMessage();

                }
            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

           
        }

        $redirect = redirect()->route('listpembayaranregistrasi');
         return $redirect;

    }


/////////////////////END of Pembayaran////////////////////////////////


/////////////////////Start Pelunasan///////////////////////////////   

     public function konfirmasiPelunasan(Request $request, $id){
        $data = $request->except('_token','_method');

        $model = new Registrasi();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->tanggal_pelunasan = $data['tgl_pelunasan'];
            $e->status_pelunasan = 1;
            $e->status=33;
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "LUNAS".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/buktipelunasan/".Auth::user()->id."/", $filename);
                $e->bukti_pelunasan = $filename;
            }
            $e->save();
            DB::commit();

            Session::flash('success', "Upload Bukti Pelunasan Berhasil");

            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('registrasiHalal.index');
            return $redirect;
    } 


    public function pelunasanRegistrasi($id){
        $data = Registrasi::find($id);
        //get Data from FAQ Transfer
        $getTransfer =   DB::table('faq')
                    ->where('status','transfer')
                    ->get();
        $dataTransfer = json_decode($getTransfer,true);
        //get Data from FAQ Tunai
        $getTunai =   DB::table('faq')
                    ->where('status','tunai')
                    ->get();
        $dataTunai = json_decode($getTunai,true);
        return view('registrasi.pelunasan',compact('data','dataTransfer','dataTunai'));


    }
  
    public function listPelunasanRegistrasi(){
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('registrasi.listPelunasan',compact('dataKelompok','dataJenis'));
    }

    public function konfirmasiPelunasanRegistrasi($id){
        //retrieve data
        $getUserId = Registrasi::where('id','=',$id)->get();




        foreach ($getUserId as $key) {
            $userId = $key->id_user;

            //create PDF File
            $getUser = User::find($userId);
            $getRegistrasi = Registrasi::find($id);
            $newData = ['userData'=>$getUser,'registrasiData'=>$getRegistrasi];
            $fileName = $key->no_registrasi.'_INV_LUNAS.pdf';
            $pdf = PDF::loadView('pdf/pdf_pembayaran',$newData);

            //update data
            DB::table('registrasi')->where('id', $id)->update(['status_pelunasan' => 2,'inv_pelunasan'=>$fileName]);
            
             Storage::put('public/pelunasan/'.$fileName, $pdf->output());
            

              $updater = Auth::user()->name;

                $model = new Registrasi();
                $model2 = new User();

                
                DB::beginTransaction();
                $e = $model->find($id);
                $e->status = '25';
                $e->updated_status_by = $updater;
                $e->save();

                $dataUser = User::find($userId);
                $dataRegistrasi = Registrasi::find($id);
                Mail::to($dataUser->email)->send(new KonfirmasiPembayaran($dataUser,$dataRegistrasi));
                DB::commit();  


           
        }

         Session::flash('success', "Pelunasan berhasil dikonfirmasi!");
         $redirect = redirect()->route('listpelunasanregistrasi');
         return $redirect;
    }

   

    public function updateStatusPelunasan($id,$no_registrasi,$id_user,$status){
        
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
            
            if($status =='24'){
                $e->status_pelunasan = '0';
                $e->save();
            }
            
            
        
                try{
                    Mail::to($u->email)->send(new ProgresStatus($u,$e,$p, $status));
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

        $redirect = redirect()->route('listpembayaranregistrasi');
         return $redirect;

    }

    

    public function dataPelunasanRegistrasi(Request $request){
        $gdata = $request->except('_token','_method');
        //start
        $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                 //->join('users','registrasi.id_user','=','users.id')
                 ->join('users','registrasi.id','=','users.registrasi_id')
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan')
                 /*->where('registrasi.status','13')
                 ->orWhere('registrasi.status','17')
                  ->orWhere('registrasi.status','18')
                    ->orWhere('registrasi.status','19')*/
                    ->where('registrasi.status','20')
                     ->orWhere('registrasi.status','21')
                      ->orWhere('registrasi.status','22')
                       ->orWhere('registrasi.status','23')
                        ->orWhere('registrasi.status','24')
                         ->orWhere('registrasi.status','33')
                            ->where('registrasi.biaya_registrasi','>=',10000000);
                 

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



/////////////////////////////END Pelunasan///////////////////////////////////////
    
  

}


