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
use App\Models\Penjadwalan;
use App\Models\Akad;
use App\Models\Negara;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\System\User;
use App\Models\Master\JenisRegistrasi;
use App\Models\Master\KelompokProduk;
use App\Models\Master\DetailKelompokProduk;
use App\Models\UnggahData\Fasilitas;
use App\Models\UnggahData\Produk;
use App\Models\UnggahData\DokumenHas;
use App\Models\UnggahData\DokumenMaterial;
use App\Models\UnggahData\Material;
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
use App\Jobs\SendEmailP;
use App\Jobs\SendEmailK;
use App\Jobs\SendEmailC;
use Illuminate\Support\Facades\Mail;
use PDF;
use Response;
use DateTimeZone;
use DateTime; 
use Carbon\Carbon;
use App\Jobs\SendEmail;

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
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://apps.sucofindo.co.id/sciapi/index.php/invoice/listunitkerja',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $response = curl_exec($curl);   
        curl_close($curl);

        $response = json_decode($response);
        $cabang = $response->data;


        $kw = DB::table('registrasi')
                
                 ->where('registrasi.status_cancel','=',0)
                 ->select('registrasi.kode_wilayah')
                 ->orderBy('registrasi.updated_at','desc')
                 ->get();

        //dd($cabang);

        return view('registrasi.listRegistrasiAktif',compact('dataKelompok','dataJenis','cabang','kw'));
    }

    public function dataRegistrasiPelangganAktif(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start
        if($kodewilayah == '119'){
            $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('users','registrasi.id_user','=','users.id')
                 /*->leftJoin('pembayaran','registrasi.id','=', 'pembayaran.id_registrasi')*/
                 ->leftJoin('akad','registrasi.id', '=', 'akad.id_registrasi')
                 ->leftJoin('pembayaran','registrasi.id', '=', 'pembayaran.id_registrasi')
                 ->leftJoin('penjadwalan','registrasi.id', '=', 'penjadwalan.id_registrasi')
                 ->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')        
                
                
                 ->where('registrasi.status_cancel','=',0)
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan', 'pembayaran.status_tahap1 as status_tahap1','pembayaran.status_tahap2 as status_tahap2','pembayaran.status_tahap3 as status_tahap3','pembayaran.bb_tahap1 as bb_tahap1','pembayaran.bb_tahap2 as bb_tahap2','pembayaran.bb_tahap3 as bb_tahap3','pembayaran.nominal_tahap1 as nominal_tahap1', 'pembayaran.nominal_tahap2 as nominal_tahap2', 'pembayaran.nominal_tahap3 as nominal_tahap3', 'penjadwalan.status_audit1 as status_audit1', 'penjadwalan.status_audit2 as status_audit2', 'penjadwalan.status_rapat as status_rapat', 'penjadwalan.status_tinjauan as status_tinjauan', 'akad.berkas_akad as berkas_akad', 'akad.total_biaya_sertifikasi as total_biaya_sertifikasi', 'registrasi_alamatkantor.alamat as alamat_kantor');
        }else{

            $xdata = DB::table('registrasi')
                ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                ->join('users','registrasi.id_user','=','users.id')
                ->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')      
                ->leftJoin('pembayaran','registrasi.id', '=', 'pembayaran.id_registrasi')
                 ->leftJoin('penjadwalan','registrasi.id', '=', 'penjadwalan.id_registrasi')
                 ->leftJoin('akad','registrasi.id', '=', 'akad.id_registrasi')

                ->where('registrasi.kode_wilayah','=',$kodewilayah)
                ->where('registrasi.status_cancel','=',0)
                ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan', 'pembayaran.status_tahap1 as status_tahap1','pembayaran.status_tahap2 as status_tahap2','pembayaran.status_tahap3 as status_tahap3','pembayaran.bb_tahap1 as bb_tahap1','pembayaran.bb_tahap2 as bb_tahap2','pembayaran.bb_tahap3 as bb_tahap3', 'penjadwalan.status_audit1 as status_audit1', 'penjadwalan.status_audit2 as status_audit2', 'penjadwalan.status_rapat as status_rapat', 'penjadwalan.status_tinjauan as status_tinjauan', 'akad.berkas_akad as berkas_akad', 'akad.total_biaya_sertifikasi as total_biaya_sertifikasi', 'registrasi_alamatkantor.alamat as alamat_kantor');


        }

        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        if(isset($gdata['mulai'])){
            $xdata = $xdata->where('mulai_audit1','LIKE','%'.$gdata['mulai'].'%');
            $xdata = $xdata->where('mulai_audit2','LIKE','%'.$gdata['mulai'].'%');
        }

        $xdata = $xdata
                 ->orderBy('registrasi.updated_at','desc');
       
        return Datatables::of($xdata)->make();
    }

    public function dataRegistrasiPelanggan(Request $request){
        $gdata = $request->except('_token','_method');
        //start
        $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('users','registrasi.id_user','=','users.id')                                  
                 //
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan');

        
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
            
            
            date_default_timezone_set('Asia/Jakarta');

            $today= date('l');
            //dd($today);
            if($today == 'Friday'){
                $dl = date("Y-m-d", strtotime('+72 hours'))." 23:59:59";
            }else{
                $dl = date("Y-m-d", strtotime('+24 hours'))." 23:59:59";
            }
            
           
            if($status == '4' ||$status == '5' ||$status == '7' ||$status == '8' ||$status == '10' ||$status == '11' ||$status == '12' ||$status == '14'  ||$status == '15'    ||$status == '20' ||$status == '22' ||$status == '23' ||$status == '24' ||$status == '25' || $status == '2'||$status == '6' || $status == '9'||$status == 'g' || $status == '21'|| $status == '26'){
                
                     if( $status == '2'){
                        $e->dl_berkas = $dl;
                      
                       
                     }elseif( $status == '5'){
                        $e->status_berkas = '1';
                       

                     }elseif( $status == '6'){
                        $e->dl_akad = $dl;
                       

                       

                     }elseif( $status == '9'){
                        $p->dl_tahap1 = $dl;
                        

                     }elseif($status == 'g'){
                        if($p->nominal_tahap2 == 0){                            
                            $status=15;
                            $e->status = $status;
                            // $this->konfirmasiPembayaranTahap22($e->id,$e->no_registrasi,$e->id_user,15);                                                                

                        }else{

                            // dd($status);
                            $p->dl_tahap2 = $dl;
                        }
                           
                    }elseif( $status == '21'){
                       

                        $p->dl_tahap3 = $dl;
                        //$p->save();
                    }                    
                                                                     
                    
                        
                //dd($e);
                if(is_null($p)==0){
                    // dd($e->status);                    
                    $p->save();
                    $e->save();
                    $u->save();
                }else{                    
                    $e->save();
                    $u->save();
                }                

                // $p->save();
                // $e->save();
                // $u->save();
               
                //Session::flash('success', "data berhasil disimpan!");                                                       
                        
                //dd($e);
                
                if(is_null($p)== 0){

                     $e->save();
                     $u->save();
                     $p->save();

                }else{
                    $e->save();
                    $u->save();
                }
               
                //Session::flash('success', "data berhasil disimpan!");

                   
                try{
                    // dd($e->status);


                    if($e->status=='g' && $p->nominal_tahap2=='0'){
                            // dd($e->status);   
                    }else if($e->status == 15){                        
                        DB::commit();
                    }else{
                        DB::commit();
                    }
                                        
                    // dd($e);
                    // Mail::to($u->email)->send(new ProgresStatus($e,$u,$p, $status));
                    //dd($e->status);
                    //SendEmailP::dispatch($e,$u,$p, $status);
                    
                    SendEmailP::dispatch($e,$u,$p, $status);
                     
                    Session::flash('success', 'data dengan no registrasi '.$no_registrasi.' berhasil di kirim emailnya!');

                }catch(\Exception $u){

                    Session::flash('error', $u->getMessage());
                    DB::rollback();
                    //Session::flash('success', "data berhasil disimpan!");
                    //$statusreg = $e->getMessage();

                }   

                    
            }else{
                //dd($status);

                if(is_null($p)== 0){

                     $e->save();
                     $u->save();
                     $p->save();

                }else{
                    $e->save();
                    $u->save();
                }


                DB::commit();
                Session::flash('success', 'Data dengan nomor registrasi '.$no_registrasi.' berhasil diupdate');
            }
            
            
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

                ->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')
                 ->leftJoin('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->leftJoin('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                ->leftJoin('users','registrasi.id','=','users.registrasi_id')
               
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok', 'users.registrasi_id as registrasi_id','registrasi_alamatkantor.alamat as alamat_kantor')
                 ->where('id_user','=',Auth::user()->id)
                 ->where('registrasi.status_cancel','=',0)
                 ->orderBy('registrasi_id','desc')
                 
                 ->get();

        //alert(Datatables::of($xdata));

        return Datatables::of($xdata)->make();

    }
     public function detailRegistrasi($id){
            $data = DB::table('registrasi')
                ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                ->join('users','registrasi.id_user','=','users.id')
                ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                ->select('registrasi.*','registrasi.status as statusnya','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.*')
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
        $detailkelompokProduk = DetailKelompokProduk::all();

        $dataNegara = Negara::all();
        $dataProvinsi = Provinsi::all();
        $dataKebupaten = Kabupaten::all();
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
        return view('registrasi.create', compact('jenisRegistrasi','kelompokProduk','dataTransfer','dataTunai','dataNegara','dataProvinsi','dataKebupaten','detailkelompokProduk'));
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
            $length = 8;
            $token = "";
            $codeAlphabet= "0123456789";
            for($i=0;$i<$length;$i++){
                $token .= $codeAlphabet[$this->crypto_Rand_secure(0,strlen($codeAlphabet))];
            }
            $randomid =$token;
            $nosurat = $data['no_surat'];
            $expd = explode('-',$nosurat);            

            $no_order = date('YmdHis').".".Auth::user()->id . "." .$data['id_jenis_registrasi'];
            // dd($no_order);
            // dd($data);
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

            $kodewilayah = $expd[0];                      

            $model->kode_wilayah = $kodewilayah;
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
           // $model->tipe = $data['tipe'];
            $model->no_tipe = $data['no_tipe'];
            $model->no_tipe2 = $data['no_tipe2'];
            $model->sni = $data['sni'];
            $model->jenis_izin = $data['jenis_izin'];
            $model->jumlah_karyawan = $data['jumlah_karyawan'];
            $model->kapasitas_produksi = $data['kapasitas_produksi'];
            $model->jenis_produk = $data['jenis_produk'];
            $model->id_rincian_kelompok_produk = implode(',',$data['id_rincian_kelompok_produk']);

            $model->progress = 1;

            if($data['id_jenis_registrasi'] == 3){
                $model->jenis_usaha = $data['jenis_usaha'];
                $model->nama_jenis_usaha = $data['nama_jenis_usaha'];
                $model->nkv = $data['nkv'];
            }            

            $model->sertifikat_perusahaan = $data['sertifikat_perusahaan'];
            $model->nib = $data['nib'];
            $model->jenis_surat = $data['jenis_surat'];
            $model->nomor_surat = $data['nomor_surat'];
            $model->penerbit_sertifikat_perusahaan = $data['penerbit_sertifikat_perusahaan'];
            $model->no_sertifikat_perusahaan = $data['no_sertifikat_perusahaan'];

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
            $model_regisalamat->negara = $data['negara_kantor'];
            if($model_regisalamat->negara == 'Indonesia'){
                $kota = Kabupaten::find($data['kota_kantor_domestik']);
                $provinsi = Provinsi::find($data['provinsi_kantor_domestik']);
                $model_regisalamat->kota_domestik = $kota->nama_kabupaten;                
                $model_regisalamat->provinsi_domestik = $provinsi->nama_provinsi;                
            }else{
                $model_regisalamat->kota = $data['kota_pabrik'];
                $model_regisalamat->provinsi = $data['provinsi_pabrik'];
            }
            $model_regisalamat->telepon = $data['telepon_kantor'];
            $model_regisalamat->kodepos = $data['kodepos_kantor'];
            $model_regisalamat->email = $data['email_kantor'];
                    
            $model_regisalamat->save();
            DB::commit();

            $model_regispabrik = new RegistrasiAlamatPabrik();
            DB::beginTransaction();

            $model_regispabrik->id_registrasi = $idregis;
            $model_regispabrik->alamat = $data['alamat_pabrik'];            
            $model_regispabrik->negara = $data['negara_pabrik'];
            if($model_regispabrik->negara == 'Indonesia'){
                $kota2 = Kabupaten::find($data['kota_kantor_domestik']);
                $provinsi2 = Provinsi::find($data['provinsi_kantor_domestik']);
                $model_regispabrik->kota_domestik = $kota2->nama_kabupaten;
                $model_regispabrik->provinsi_domestik = $provinsi2->nama_provinsi;
            }else{
                $model_regispabrik->kota = $data['kota_pabrik'];
                $model_regispabrik->provinsi = $data['provinsi_pabrik'];
            }
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

    public function download($path){
         return Storage::download($path);
    }
    //Unggah Dokumen Sertifikasi
    //pelanggan
    public function unggahDokumenSertifikasi(){

        $id_registrasi  = Auth::user()->registrasi_id;
        $id_user = Auth::user()->id;

        $data   = new Registrasi;
        $data   = $data->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok')
                 ->where('registrasi.id','=',$id_registrasi)
                 ->orderBy('registrasi.id','desc')->get();

        $data   = $data[0];

        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);

        $checkHas =  DB::table('dokumen_has')
                     ->where('id_registrasi',$id_registrasi)
                     ->get();

       // dd($checkHas);
        if(isset($checkHas[0])){ $dataHas = json_decode($checkHas,true);}
        else{ $dataHas = null;}
        

        if(isset($checkKuisionerHas[0])){$dataKuisionerHas = json_decode($checkKuisionerHas,true);}
        else{$dataKuisionerHas = null;}


        return view('registrasi.unggahDokumenSertifikasi', compact('data','dataHas','dataRegistrasi'));
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
    public function storeDokumenSertifikasi(Request $request){

        $data_real = $request->except('_token','_method');
        $data = $request->except('_token','_method','has_selected');

        //dd($data);

        $model = new DokumenHas;
        $model2 = new Registrasi;

        $status = "HPAS";
        $id_user = Auth::user()->id;
        $id_registrasi  = Auth::user()->registrasi_id;

        $r = $model2->find($id_registrasi);

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
                        if($key == $data_real['has_selected']){
                            
                            $model->$key =  FileUploadServices::getFileNameHPAS($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);
                            FileUploadServices::getUploadFileHPAS($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);

                        }

                    }

                     //dd($key);
                    //print_r(count($data)) ;
                    
                    $model->status_has = 0;
                    $r->status_berkas = 1;
                    $r->save();

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
                    $redirect = redirect()->route('registrasi.unggahDokumenSertifikasi');
                    return $redirect;

                }catch (\Exception $e){
                    DB::rollBack();

                    //$this->debugs($e->getMessage());

                    Session::flash('error', $e->getMessage());
                    $redirectPass = redirect()->route('registrasi.unggahDokumenSertifikasi');
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

                    $no=1;
                    foreach ($data as $key => $value) {
                        $currentDateTime = Carbon::now();                                                

                        if($key == $data_real['has_selected']){

                            if($key == 'has_1'){
                                if($e->keterangan_has_1 != null){
                                    $e->tgl_penyerahan_1 = $currentDateTime;
                                }
                                
                            }else if($key == 'has_2'){
                                if($e->keterangan_has_2 != null){
                                    $e->tgl_penyerahan_2 = $currentDateTime;
                                }
                               
                            }else if($key == 'has_3'){
                                if($e->keterangan_has_3 != null){
                                    $e->tgl_penyerahan_3 = $currentDateTime;
                                }
                                
                            }else if($key == 'has_4'){
                                if($e->keterangan_has_4 != null){
                                    $e->tgl_penyerahan_4 = $currentDateTime;
                                }
                              
                            }else if($key == 'has_5'){
                                if($e->keterangan_has_5 != null){
                                    $e->tgl_penyerahan_5 = $currentDateTime;
                                }
                                
                            }else if($key == 'has_6'){
                                if($e->keterangan_has_6 != null){
                                    $e->tgl_penyerahan_6 = $currentDateTime;
                                }
                                
                            }else if($key == 'has_7'){
                                if($e->keterangan_has_7 != null){
                                     $e->tgl_penyerahan_7 = $currentDateTime;
                                }
                            }else if($key == 'has_8'){
                                if($e->keterangan_has_8 != null){
                                    $e->tgl_penyerahan_8 = $currentDateTime;
                                }
                               
                            }else if($key == 'has_9'){
                                if($e->keterangan_has_9 != null){
                                    $e->tgl_penyerahan_9 = $currentDateTime;
                                }
                               
                            }else if($key == 'has_10'){
                                if($e->keterangan_has_10 != null){
                                    $e->tgl_penyerahan_10 = $currentDateTime;
                                }
                               
                            }else if($key == 'has_11'){
                                if($e->keterangan_has_11 != null){
                                    $e->tgl_penyerahan_11 = $currentDateTime;
                                }
                                
                            }else if($key == 'has_12'){
                                if($e->keterangan_has_12 != null){
                                    $e->tgl_penyerahan_12 = $currentDateTime;
                                }
                                
                            }else if($key == 'has_13'){
                                if($e->keterangan_has_13 != null){
                                    $e->tgl_penyerahan_13 = $currentDateTime;
                                }
                               
                            }else if($key == 'has_14'){
                                if($e->keterangan_has_14 != null){
                                    $e->tgl_penyerahan_14 = $currentDateTime;
                                }
                               
                            }else if($key == 'has_15'){
                                if($e->keterangan_has_15 != null){
                                    $e->tgl_penyerahan_15 = $currentDateTime;
                                }
                               
                            }else if($key == 'has_16'){
                                if($e->keterangan_has_16 != null){
                                    $e->tgl_penyerahan_16 = $currentDateTime;
                                }
                              
                            }else if($key == 'has_17'){
                                if($e->keterangan_has_17 != null){
                                    $e->tgl_penyerahan_17 = $currentDateTime;
                                }
                               
                            }else if($key == 'has_18'){
                                if($e->keterangan_has_18 != null){
                                    $e->tgl_penyerahan_18 = $currentDateTime;
                                }
                              
                            }
                                                                  
                            $e->$key =  FileUploadServices::getFileNameHPAS($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);
                            FileUploadServices::getUploadFileHPAS($value,$id_user,$id_registrasi,$status,$key,$no_registrasi);                            
                        }
                        $no++;
                    }

                    $e->save();

                    $checkHasLengkap = "SELECT *
                       FROM dokumen_has
                       WHERE id_registrasi = ".$id_registrasi."
                       AND(
                        has_1 IS NULL
                        OR has_2 IS NULL
                        OR has_3 IS NULL
                        OR has_5 IS NULL
                        OR has_8 IS NULL
                        OR has_9 IS NULL
                        OR has_10 IS NULL
                        OR has_11 IS NULL
                        OR has_12 IS NULL
                        OR has_13 IS NULL
                        OR has_14 IS NULL
                        OR has_15 IS NULL
                        OR has_16 IS NULL)
                        OR has_17 IS NULL
                        OR has_18 IS NULL)
                        ";

                   // dd($checkHasLengkap);
                    $dataLengkap = DB::select($checkHasLengkap);

                    if(isset($dataLengkap[0])){
                         //dd($dataLengkap[0]);
                        $e->status_has = 0;
                    }else{
                        //dd("masuk");
                        $e->status_has = 1;
                        //masukan fungsi untuk pindah ke tahapan akad..
                        $this->updateStatusRegistrasi($r->id, $r->no_registrasi, $r->id_user, '2_1');
                        //update status table registrasi dan update tanggal updated at nya

                    }

                    $mytime = Carbon::now();
                    $now=  $mytime->toDateTimeString();

                    $r->updated_at= $now;
                    $r->status_berkas = 1;
                    //dd($r);
                    $r->save();
                    $e->save();

                    DB::commit();


                    Session::flash('success', "data berhasil diupdate!");
                    $redirect = redirect()->route('registrasi.unggahDokumenSertifikasi');
                    return $redirect;

            }catch (\Exception $e){
                    DB::rollBack();

                    //$this->debugs($e->getMessage());

                    Session::flash('error', $e->getMessage());
                    $redirectPass = redirect()->route('registrasi.unggahDokumenSertifikasi');
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

    public function deleteDokumenSertifikasi($id){

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

        return redirect()->route('registrasi.unggahDokumenSertifikasi');
    }


    //Admin
    public function verifikasiDokumenSertifikasi($id_registrasi){
        //get data registrasi
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);

        //check data dokumen has
        $checkHas =  DB::table('dokumen_has')
                     ->where('id_registrasi',$id_registrasi)
                     ->get();

       // dd($checkHas);
        if(isset($checkHas[0])){ $dataHas = json_decode($checkHas,true);}
        else{ $dataHas = null;}

        return view('pelanggan.dokumenSertifikasi.verifikasiDokumenSertifikasi', compact('dataRegistrasi','dataHas'));

    }

    public function updateStatusVerifikasiDokumen(Request $request, $id){
        
        $data = $request->except('_token','_method','status','has_selected');
        $currentDateTime = Carbon::now();
        $model = new DokumenHas();
        $model2 = new Registrasi();
        $model3 = new User();
        $model4 = new Penjadwalan();


       
        try{
            DB::beginTransaction();
            $e = $model->find($id);            
            $f = $model2->find($e->id_registrasi);
            $u = $model3->find($e->id_user);

            $id_user = $u->id;
            //dd($id_user);

            $e->fill($data);
            
            $e->check_by = Auth::user()->id;
            if($data['status_has_1']==null || $data['status_has_2']==null || $data['status_has_3']==null || $data['status_has_4']==null || $data['status_has_5']==null || $data['status_has_6']==null || $data['status_has_7']==null || $data['status_has_8']==null || $data['status_has_9']==null || $data['status_has_10']==null || $data['status_has_11']==null || $data['status_has_12']==null|| $data['status_has_13']==null || $data['status_has_14']==null|| $data['status_has_15']==null || $data['status_has_16']==null|| $data['status_has_17']==null || $data['status_has_18']==null){

                //dd($data);
                $e->status_berkas = 1;
                $e->updated_at =  $currentDateTime;
                $f->updated_at =  $currentDateTime;
                $f->status_berkas = 1;
                $e->save();
                $f->save();
                DB::commit();
                Session::flash('success', "Status berhasil diupdate");


            }else{

                
                if($data['status_has_1']=='2' || $data['status_has_2']=='2' || $data['status_has_3']=='2' || $data['status_has_4']=='2' || $data['status_has_5']=='2' || $data['status_has_6']=='2' || $data['status_has_7']=='2' || $data['status_has_8']=='2' || $data['status_has_9']=='2' || $data['status_has_10']=='2' || $data['status_has_11']=='2' || $data['status_has_12']=='2'|| $data['status_has_13']=='2' || $data['status_has_14']=='2'|| $data['status_has_15']=='2' || $data['status_has_16']=='2'|| $data['status_has_17']=='2' || $data['status_has_18']=='2'){
                   

                    $e->status_berkas = 2;
                    $f->status_berkas = 2;
                    $e->updated_at =  $currentDateTime;
                    $f->updated_at =  $currentDateTime;
                    $f->status = '2_2';
                    $e->save();
                    $f->save();
                    DB::commit();
                    //SendEmailP::dispatch($u,$f,$p,$f->status);
                    Session::flash('success', "Status berhasil diupdate");

                }else{
                    //dd($data);

                     //apabila tidak ada yang perlu revisi

                    $e->status_berkas = 3;
                    $f->status_berkas = 3;
                    $e->updated_at =  $currentDateTime;
                    $f->updated_at =  $currentDateTime;
                    
                    $f->status = '2_3';
                    $f->save();
                    $e->save();
                    //SendEmailP::dispatch($u,$f,$p,$f->status);
                    
                    $f->status = 3;
                    $f->save();
                    //SendEmailP::dispatch($u,$f,$p,$f->status);
                    DB::commit();

                    //$this->updateStatusRegistrasi($f->id, $f->no_registrasi, $f->id_user, 6);
                    
                    $model4->updated_by = Auth::user()->id;
                    $model4->status_audit1 = '0';
                    $model4->progres_penjadwalan = 'audit1';
                    $model4->id_registrasi = $e->id;
                    $model4->save();
                    
                }

               
            }
            
           
        }catch (\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }

        return redirect()->back();
    }


    //Audit Tahap1

    //pelanggan
    public function unggahDokumenAuditTahap1(){

        $id_registrasi  = Auth::user()->registrasi_id;
        $id_user = Auth::user()->id;

        $data   = new Registrasi;
        $data   = $data->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
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

        

        return view('audit.tahap1.unggahDokumenAuditTahap1', compact('data','dataHas'));
    }
    //auditor
    public function auditTahap1($id_registrasi){
        //dd("masuk");
        //get data registrasi
        $dataRegistrasi = $this->getDataRegistrasi($id_registrasi);

        $model2 = new Registrasi();
        $model3 = new KelompokProduk();
        
        $dataRegis = $model2->find($id_registrasi);        

        $dataRegis = json_decode($dataRegis,true);        

        $dataJenisProduk = $model3->find($dataRegis['jenis_produk']);

        // dd($dataJenisProduk);

        //check data dokumen has
        $checkHas =  DB::table('dokumen_has')
                     ->where('id_registrasi',$id_registrasi)
                     ->get();

        if(isset($checkHas[0])){ $dataHas = json_decode($checkHas,true);}
        else{ $dataHas = null;}

        

        return view('audit.tahap1.auditTahap1', compact('dataRegistrasi','dataHas','dataRegis'));

    }

    public function updateStatusAuditTahap1(Request $request, $id){
        
        $data = $request->except('_token','_method','status');
        
        $currentDateTime = Carbon::now();
        $model = new DokumenHas();
        $model2 = new Registrasi();
        $model3 = new User();
        $model4 = new Pembayaran();
        $id_user = Auth::user()->id;

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        try{
            DB::beginTransaction();
            $e = $model->find($id);            
            $f = $model2->find($e->id_registrasi);
            $u = $model3->find($f->id_user);
            $p = $model4->find($f->id_pembayaran);

            $e->fill($data);
            
            $e->check_by = Auth::user()->id;
            if($data['status_has_1']=='null' || $data['status_has_2']=='null' || $data['status_has_3']=='null' || $data['status_has_4']=='null' || $data['status_has_5']=='null' || $data['status_has_6']=='null' || $data['status_has_7']=='null' || $data['status_has_8']=='null' || $data['status_has_9']=='null' || $data['status_has_10']=='null' || $data['status_has_11']=='null' || $data['status_has_12']=='null'|| $data['status_has_13']=='null' || $data['status_has_14']=='null'|| $data['status_has_15']=='null' || $data['status_has_16']=='null'){
               
                $e->status_berkas = 2;
                $e->updated_at =  $currentDateTime;
                $f->updated_at =  $currentDateTime;
                $f->status_berkas = 2;
                $e->save();
                $f->save();
                DB::commit();
                Session::flash('success', "Status berhasil diupdate");

              
            }else{
                
                if($data['status_has_1']=='2' || $data['status_has_2']=='2' || $data['status_has_3']=='2' || $data['status_has_4']=='2' || $data['status_has_5']=='2' || $data['status_has_6']=='2' || $data['status_has_7']=='2' || $data['status_has_8']=='2' || $data['status_has_9']=='2' || $data['status_has_10']=='2' || $data['status_has_11']=='2' || $data['status_has_12']=='2'|| $data['status_has_13']=='2' || $data['status_has_14']=='2'|| $data['status_has_15']=='2' || $data['status_has_16']=='2'){

                    
                    $e->status_berkas = 2;
                    $f->status_berkas = 2;
                    $e->updated_at =  $currentDateTime;
                    $f->updated_at =  $currentDateTime;
                    $f->status = 4;
                    $e->save();
                    $f->save();
                    DB::commit();
                    SendEmailP::dispatch($u,$f,$p,$f->status);
                    Session::flash('success', "Status berhasil diupdate");

                }else{
                   

                     //apabila tidak ada yang perlu revisi

                    $e->status_berkas = 3;
                    $f->status_berkas = 3;
                    $e->updated_at =  $currentDateTime;
                    
                    $f->updated_at =  $currentDateTime;
                    
                    $f->status = 5;
                    
                    $e->save();
                    $f->save();
                    SendEmailP::dispatch($u,$f,$p,$f->status);
                    DB::commit();

                    $this->updateStatusRegistrasi($f->id, $f->no_registrasi, $f->id_user, 6);
                    
                    
                    
                }

                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
            
                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-04 Laporan Audit Tahap I.docx');

                    $templateProcessor->setValue('nama_organisasi', $data['nama_organisasi']);
                    $templateProcessor->setValue('nomor_registrasi', $data['nomor_registrasi_bpjph']);
                    $templateProcessor->setValue('ruang_lingkup', $data['ruang_lingkup']);
                    $templateProcessor->setValue('jenis_produk', $data['jenis_produk']);
                    $templateProcessor->setValue('status_registrasi', $data['status_sertifikasi']);

                    $templateProcessor->setValue('tgl_penyerahan1', $data['tgl_penyerahan_1']);
                    $templateProcessor->setValue('tgl_penyerahan2', $data['tgl_penyerahan_2']);
                    $templateProcessor->setValue('tgl_penyerahan3', $data['tgl_penyerahan_3']);
                    $templateProcessor->setValue('tgl_penyerahan4', $data['tgl_penyerahan_4']);
                    $templateProcessor->setValue('tgl_penyerahan5', $data['tgl_penyerahan_5']);                
                    $templateProcessor->setValue('tgl_penyerahan6', $data['tgl_penyerahan_6']);
                    $templateProcessor->setValue('tgl_penyerahan7', $data['tgl_penyerahan_7']);
                    $templateProcessor->setValue('tgl_penyerahan8', $data['tgl_penyerahan_8']);
                    $templateProcessor->setValue('tgl_penyerahan9', $data['tgl_penyerahan_9']);
                    $templateProcessor->setValue('tgl_penyerahan10', $data['tgl_penyerahan_10']);
                    $templateProcessor->setValue('tgl_penyerahan11', $data['tgl_penyerahan_11']);
                    $templateProcessor->setValue('tgl_penyerahan12', $data['tgl_penyerahan_12']);
                    $templateProcessor->setValue('tgl_penyerahan13', $data['tgl_penyerahan_13']);
                    $templateProcessor->setValue('tgl_penyerahan14', $data['tgl_penyerahan_14']);
                    $templateProcessor->setValue('tgl_penyerahan15', $data['tgl_penyerahan_15']);
                    $templateProcessor->setValue('tgl_penyerahan16', $data['tgl_penyerahan_16']);

                    $templateProcessor->setValue('temuan1', $data['keterangan_has_1']);
                    $templateProcessor->setValue('temuan2', $data['keterangan_has_2']);
                    $templateProcessor->setValue('temuan3', $data['keterangan_has_3']);
                    $templateProcessor->setValue('temuan4', $data['keterangan_has_4']);
                    $templateProcessor->setValue('temuan5', $data['keterangan_has_5']);
                    $templateProcessor->setValue('temuan6', $data['keterangan_has_6']);
                    $templateProcessor->setValue('temuan7', $data['keterangan_has_7']);
                    $templateProcessor->setValue('temuan8', $data['keterangan_has_8']);
                    $templateProcessor->setValue('temuan9', $data['keterangan_has_9']);
                    $templateProcessor->setValue('temuan10', $data['keterangan_has_10']);
                    $templateProcessor->setValue('temuan11', $data['keterangan_has_11']);
                    $templateProcessor->setValue('temuan12', $data['keterangan_has_12']);
                    $templateProcessor->setValue('temuan13', $data['keterangan_has_13']);
                    $templateProcessor->setValue('temuan14', $data['keterangan_has_14']);
                    $templateProcessor->setValue('temuan15', $data['keterangan_has_15']);
                    $templateProcessor->setValue('temuan16', $data['keterangan_has_16']);

                    $templateProcessor->setValue('review_perbaikan1', $data['review_perbaikan_1']);
                    $templateProcessor->setValue('review_perbaikan2', $data['review_perbaikan_2']);
                    $templateProcessor->setValue('review_perbaikan3', $data['review_perbaikan_3']);
                    $templateProcessor->setValue('review_perbaikan4', $data['review_perbaikan_4']);
                    $templateProcessor->setValue('review_perbaikan5', $data['review_perbaikan_5']);
                    $templateProcessor->setValue('review_perbaikan6', $data['review_perbaikan_6']);
                    $templateProcessor->setValue('review_perbaikan7', $data['review_perbaikan_7']);
                    $templateProcessor->setValue('review_perbaikan8', $data['review_perbaikan_8']);
                    $templateProcessor->setValue('review_perbaikan9', $data['review_perbaikan_9']);
                    $templateProcessor->setValue('review_perbaikan10', $data['review_perbaikan_10']);
                    $templateProcessor->setValue('review_perbaikan11', $data['review_perbaikan_11']);
                    $templateProcessor->setValue('review_perbaikan12', $data['review_perbaikan_12']);
                    $templateProcessor->setValue('review_perbaikan13', $data['review_perbaikan_13']);
                    $templateProcessor->setValue('review_perbaikan14', $data['review_perbaikan_14']);
                    $templateProcessor->setValue('review_perbaikan15', $data['review_perbaikan_15']);
                    $templateProcessor->setValue('review_perbaikan16', $data['review_perbaikan_16']);

                    if($data['status_memenuhi'] == 'memenuhi'){
                        $templateProcessor->setValue('pilihan1', '');
                        $templateProcessor->setValue('pilihan2', 'x');
                    }else{
                        $templateProcessor->setValue('pilihan1', 'x');
                        $templateProcessor->setValue('pilihan2', '');
                    }

                    $currentDateTime = Carbon::now();                

                    $newDateTime = Carbon::now()->addDays(5);
                    $templateProcessor->setValue('deadline', $newDateTime);
                    //$e->dl_berkas = $newDateTime;
                    $f->dl_berkas = $newDateTime;

                    $e->save();
                    $f->save();            
                    // dd($newDateTime);

                    $fileName = $e->id_registrasi.'_'.$e->id_penjadwalan.'_Laporan Audit 1_'.$e->nama_perusahaan.'.docx';
                    $templateProcessor->saveAs("storage/laporan/download/".$fileName);
                    
                    $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                                            
                    return response()->download('storage/laporan/download/'.$fileName);

            }
            
           
        }catch (\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }

        return redirect()->back();
    }
    
////////////////////////////END Unggah Data////////////////////////////
////////////////////////AKAD////////////////////////////////////////
    public function uploadAkadAdmin($id){
        //dd($id);
        $data = Registrasi::find($id);
        //get Data from FAQ Transfer        
        // dd($dataAkad);

        $getTransfer =   DB::table('faq')
                    ->where('status','transfer')
                    ->get();
        $dataTransfer = json_decode($getTransfer,true);
        //get Data from FAQ Tunai
        $getTunai =   DB::table('faq')
                    ->where('status','tunai')
                    ->get();
        $dataTunai = json_decode($getTunai,true);
        $dataAkad = DB::table('akad')->select('*')->where('id_registrasi',$id)->get();
        if($dataAkad != null){
            return view('registrasi.uploadKontrakAkad',compact('data','dataTransfer','dataTunai','dataAkad'));
        }else{
            return view('registrasi.uploadKontrakAkad',compact('data','dataTransfer','dataTunai'));
        }
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

    public function uploadReportAdmin($id){
        //dd($id);
        $data = Registrasi::find($id);
        
        return view('registrasi.uploadReportAdmin',compact('data'));
    }

    public function uploadBeritaAcaraAdmin($id){
        //dd($id);
        $data = Registrasi::find($id);        

        $dataAlamatKantor = DB::table('registrasi_alamatkantor')
                    ->where('id_registrasi',$id)
                    ->get();

        $dataPemilik = DB::table('registrasi_pemilik_perusahaan')
                    ->where('id_registrasi',$id)
                    ->get();

        $dataNamaProduk = DB::table('registrasi_data_produk')
                    ->join('detail_data_produk','registrasi_data_produk.id','=','detail_data_produk.id_registrasi_data_produk')
                    ->select('detail_data_produk.merk as merk')
                    ->where('registrasi_data_produk.id_registrasi','=',$id)
                    ->get();
        // dd($dataNamaProduk);

        $data = json_decode($data);        

        $dataKelProduk = DB::table('kelompok_produk')                    
                    ->where('id','=',$data->jenis_produk)
                    ->get();
        
        // dd($dataPemilik);

        $dataAlamatKantor = json_decode($dataAlamatKantor);        
        // dd($dataAlamatKantor);
        
        return view('registrasi.uploadBeritaAcaraAdmin',compact('data','dataAlamatKantor','dataNamaProduk','dataKelProduk','dataPemilik'));
    }

    public function kirimKeMUI($id){
        //dd($id);
        $data = Registrasi::find($id);
        
        return view('registrasi.kirimkemui',compact('data'));
    }



    public function konfirmasiAkadAdmin($id,$status){
       
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

            date_default_timezone_set('Asia/Jakarta');
            $date = date("Y-m-d h:i:sa");
            if($status == 2){
                $e->status = 8;
                $e->status_akad= $status;                
            }else{
                $e->status = 'q';
                $e->status_akad= $status;                
            }            
            
            $e->updated_status_by = $updater;
            $e->save();

            $e->total_biaya = ((int)str_replace(',', '', $e->total_biaya));

            if($p == null){
                if($e->total_biaya >10000000 && $e->total_biaya <= 50000000){
               // dd($e->total_biaya);

                    $model3->nominal_tahap1 = ((int)$e->total_biaya)/2;
                    $model3->nominal_tahap3 = ((int)$e->total_biaya)/2;
                    $model3->nominal_total =((int)$e->total_biaya);
                    $model3->id_registrasi = $e->id;
                    $model3->updated_by=$updater;
                    $model3->mata_uang = $e->mata_uang;
                    $model3->tanggal_tahap1 = $date;
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
                    $model3->tanggal_tahap1 = $date;
                    $model3->save();
                }else{
                     //dd($e->total_biaya);
                    $model3->nominal_tahap1 = ((int)$e->total_biaya);
                    $model3->nominal_total = ((int)$e->total_biaya);
                    $model3->id_registrasi = $e->id;
                    $model3->updated_by=$updater;
                    $model3->mata_uang = $e->mata_uang;
                    $model3->tanggal_tahap1 = $date;
                    $model3->save();

                }
                $e->id_pembayaran = $model3->id;
                $e->save();
                SendEmailP::dispatch($e,$u,$model3, $e->status);
            }else{
                if($e->total_biaya >10000000 && $e->total_biaya <= 50000000){
               // dd($e->total_biaya);

                    $p->nominal_tahap1 = ((int)$e->total_biaya)/2;
                    $p->nominal_tahap3 = ((int)$e->total_biaya)/2;
                    $p->nominal_total =((int)$e->total_biaya);
                    $p->id_registrasi = $e->id;
                    $p->updated_by=$updater;
                    $p->mata_uang = $e->mata_uang;
                    $p->tanggal_tahap1 = $date;
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
                    $p->tanggal_tahap1 = $date;
                    $p->save();
                }else{
                     //dd($e->total_biaya);
                    $p->nominal_tahap1 = ((int)$e->total_biaya);
                    $p->nominal_total = ((int)$e->total_biaya);
                    $p->id_registrasi = $e->id;
                    $p->updated_by=$updater;
                    $p->mata_uang = $e->mata_uang;
                    $p->tanggal_tahap1 = $date;
                     $p->save();
                }
                SendEmailP::dispatch($e,$u,$p, $e->status);
            }

            $this->updateStatusRegistrasi($e->id, $e->no_registrasi, $e->id_user, 9);
           
            DB::commit(); 
           
            if($status == 2){
                Session::flash('success', "Akad telahh terkonfirmasi dan dikirim emailnya");
            }else{
                Session::flash('success', "Menunggu Konfirmasi Dokumen Oleh Reviewer Kontrak");
            }            
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
        $model4 = new Akad();             
        // dd($id);        

        try{            
            DB::beginTransaction();
            // $cekAkad = new Akad::where('id_registrasi', $id)->first();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);                                   

            date_default_timezone_set('Asia/Jakarta');
            $date = date("Y-m-d h:i:sa");

            $e->tanggal_akad = $date;            
            $e->mata_uang = $data['mata_uang'];            
            $e->status_akad = 4;
            $e->status='m';
            
                // dd($model4);
            if($e->id_akad != null){
                $a = $model4->find($e->id_akad);
                // dd($a);

                // $a->id_registrasi = $id;
                $bp1 = str_replace('Rp', '', $data['biaya_pemeriksaan']);
                $bp2 = str_replace('.', '', $bp1);            
                $a->biaya_pemeriksaan = $bp2;

                $bpe1 = str_replace('Rp', '', $data['biaya_pengujian']);
                $bpe2 = str_replace('.', '', $bpe1);
                $a->biaya_pengujian = $bpe2;

                $bsf1 = str_replace('Rp', '', $data['biaya_sidang_fatwa']);
                $bsf2 = str_replace('.', '', $bsf1);
                $a->biaya_sidang_fatwa = $bsf2;

                $z = str_replace('Rp', '', $data['total_biaya']);
                $b = str_replace('.', '',$z);

                $a->total_biaya_sertifikasi = $b;
                $a->save();
                $e->total_biaya = $b;                
            }else{
                $model4->id_registrasi = $id;         
                $bp1 = str_replace('Rp', '', $data['biaya_pemeriksaan']);
                $bp2 = str_replace('.', '', $bp1);            
                $model4->biaya_pemeriksaan = $bp2;

                $bpe1 = str_replace('Rp', '', $data['biaya_pengujian']);
                $bpe2 = str_replace('.', '', $bpe1);
                $model4->biaya_pengujian = $bpe2;

                $bsf1 = str_replace('Rp', '', $data['biaya_sidang_fatwa']);
                $bsf2 = str_replace('.', '', $bsf1);
                $model4->biaya_sidang_fatwa = $bsf2;

                $z = str_replace('Rp', '', $data['total_biaya']);
                $b = str_replace('.', '',$z);

                $model4->total_biaya_sertifikasi = $b;
                $model4->save();
                $e->total_biaya = $b;
                $e->id_akad = $model4->id;
            }
                                                 
            // $e->status_akad = 1;
            // $e->status='c';

            // $data['total_biaya'] = str_replace(',', '', $data['total_biaya']);            
            // $b = str_replace('.', '', $a);
            // $total = (int)$b;
            // $a = $data['total_biaya'].split('.').join("");
			// $total = $a.split('Rp').join("");                            
            // $e->total_biaya = $data['total_biaya'];
            // dd($data['total_biaya']);
            // dd($e->total_biaya);            
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "AKAD-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/buktiakad/".$e->id_user."/", $filename);
                $e->file_akad = $filename;
                $model4->berkas_akad = $filename;
            }            
            $e->save();
            DB::commit();
             SendEmailP::dispatch($e,$u,$p, $e->status);
            Session::flash('success', "Upload Bukti Dokumen Kontrak Berhasil");

            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('listakadadmin');
            return $redirect;
    }

    public function accAuditAdmin(Request $request, $id){
        $data = $request->except('_token','_method');
        //dd($data);
        $model = new Registrasi();
        $model2 = new User();        

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);    
            
            $e->status_report = 2;
            $e->status_berita_acara = 2;
            $e->status = 17;       
            
            $e->save();
            DB::commit();
            //  SendEmailP::dispatch($e,$u,$p, $status);
            $this->updateStatusRegistrasi($e->id, $e->no_registrasi, $e->id_user, 18);
            Session::flash('success', "Konfirmasi File Report dan Berita Acara Audit Berhasil");
            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('registrasiHalal.index');            
            return $redirect;
    }

    public function accBeritaAcaraAdmin(Request $request, $id){
        $data = $request->except('_token','_method');
        //dd($data);

        $model = new Registrasi();
        $model2 = new User();        

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);            
            
            $e->status_berita_acara = 2;
            $e->status_report = 2;


            //$e->status = 17;
            
            $e->save();

            DB::commit();
            $this->updateStatusRegistrasi($e->id, $e->no_registrasi, $e->id_user, 18);
            //  SendEmailP::dispatch($e,$u,$p, $status);
            Session::flash('success', "Konfirmasi File Berita Acara Berhasil");
            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('registrasiHalal.index');            
            return $redirect;
    }    

    public function uploadFileReportAdmin(Request $request, $id){
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

            // $e->tanggal_akad = $data['tgl_akad'];
            // $e->status_akad = 1;
            // $e->mata_uang = $data['mata_uang'];
            // $e->status=31;
            $e->status_report=1;

            if($e->status_berita_acara==1){
                $e->status=16;
            }
            // $data['total_biaya'] = str_replace(',', '', $data['total_biaya']);
            // $e->total_biaya = $data['total_biaya'];
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "REPORT-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/buktireport/".$e->id_user."/", $filename);
                $e->file_report = $filename;
            }
            $e->save();
            DB::commit();
            // dd($data);
            if($e->status_berita_acara==1){
                SendEmailP::dispatch($e,$u,$p, $e->status);

            }
            // Session::flash('success', "Upload Dokumen Report Berhasil");            
            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('listberitaacara');
            return $redirect;
    }

    public function uploadFileBeritaAcaraAdmin(Request $request, $id){
        $data = $request->except('_token','_method');        

        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();      

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);  
            $p = $model3->find($e->id_pembayaran); 

            // $e->tanggal_akad = $data['tgl_akad'];
            // $e->status_akad = 1;
            // $e->mata_uang = $data['mata_uang'];
            $e->status_berita_acara=1;
            if($e->status_report==1){
                $e->status=16;
            }
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "BERITA_ACARA-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/beritaacara/".$e->id_user."/", $filename);
                $e->file_berita_acara = $filename;
            }
            $e->save();
            DB::commit();

            if($e->status_report==1){  

                SendEmailP::dispatch($e,$u,$p, $e->status);
                
            }            
            // dd($data);
            Session::flash('success', "Upload Dokumen Berita Acara Berhasil");

            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('listberitaacara');
            return $redirect;
    }

    public function uploadFileMUI(Request $request, $id){
        $data = $request->except('_token','_method');
        //dd($data);

        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user); 
            $p = $model2->find($e->id_pembayaran); 
            $e->status_mui=1;        
            $e->status=20;
            
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "HASIL_TINJAUAN_KOMITE-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/filemui/".Auth::user()->id."/", $filename);
                $e->file_mui = $filename;
            }
            $e->save();
            DB::commit();
            SendEmailP::dispatch($e,$u,$p, $e->status);
            Session::flash('success', "Upload Hasil Tinjauan Komite Ke MUI Berhasil");

            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('listberitaacara');
            return $redirect;
    }

    public function uploadFileAkadUser(Request $request, $id){
        $data = $request->except('_token','_method');        
        $model = new Registrasi();         
        $akad = Akad::where('id_registrasi', $id)->first();
        
        try{
            DB::beginTransaction();
            $e = $model->find($id);                                    

            if(isset($data['tidaksetuju'])){
                $e->status='s';
                $akad->catatan_user = $data['catatan_user'];
                $akad->save();
                $e->status_akad = 9;
            }else{
                $e->status='f';
                $e->status_akad = 2;
            }            
            // dd($akad);
            
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $CountA = $e->count_akad+1;
                if($e->status == 4){

                    if($e->file_akad == NULL){
                        $filename = "AKAD-".$e->count_akad."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                        $file->storeAs("public/buktiakad/".Auth::user()->id."/", $filename);
                        $e->file_akad = $filename;
                        $e->count_akad = $e->count_akad+1;

                    }else{
                         $filename = "AKAD-".$CountA."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                        $file->storeAs("public/buktiakad/".Auth::user()->id."/", $filename);
                        $e->file_akad = $filename;
                        $e->count_akad = $e->count_akad+1;
                    }
                }else{

                     $filename = "AKAD-".$e->count_akad."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                    $file->storeAs("public/buktiakad/".Auth::user()->id."/", $filename);
                    $e->file_akad = $filename;
                    //$e->count_akad = $e->count_akad+1;
                }
                
                
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

    public function listBeritaAcara(){
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('registrasi.listBeritaAcara',compact('dataKelompok','dataJenis'));
    }

    public function dataAkadAdmin(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start

        if($kodewilayah == '119'){
             $xdata = DB::table('registrasi')
                     ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                     ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                     ->join('users','registrasi.id_user','=','users.id')
                     
                     ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan')
                    ->where(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                       
                        $query->where('registrasi.status','=',5);
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                       
                        $query->where('registrasi.status','=',6);
                    }) 
                     ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                       
                        $query->where('registrasi.status','=',7);
                    }) 
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','c');
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','f');
                    })
                    ->orWhere(function($query) use ($kodewilayah){
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
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','s');
                    });
        }else{

            $xdata = DB::table('registrasi')
                     ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                     ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                     ->join('users','registrasi.id_user','=','users.id')
                     
                     ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan')
                    ->where(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                        $query->where('registrasi.status','=',5);
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                        $query->where('registrasi.status','=',6);
                    }) 
                     ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                        $query->where('registrasi.status','=',7);
                    }) 
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                        $query->where('registrasi.status','=','c');
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                        $query->where('registrasi.status','=','f');
                    })
                    ->orWhere(function($query) use ($kodewilayah){
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
                    })
                    ->orWhere(function($query) use ($kodewilayah){
                        $query->where('registrasi.status_cancel','=',0);
                        
                        $query->where('registrasi.status','=','s');
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
        if($dataP){
            return view('registrasi.pembayaran',compact('data','dataP','dataTransfer','dataTunai'));
        
        }else{
             Session::flash('error', 'Anda belum dapat memasuki tahapan ini. Silahkan selesaikan tahapan sebelumnya');
            $redirect = redirect()->route('registrasiHalal.index');
            return $redirect;
        }
         
            

           
       
           
        
    }

    //report
    public function reportAudit($id){        
            //dd($id);
            $data = Registrasi::find($id);
            //get Data from FAQ Transfer            
           

            if($data['status_report']==0  || $data['status_berita_acara']==0 ){
                Session::flash('error', 'Anda belum dapat memasuki tahapan ini. Silahkan selesaikan tahapan sebelumnya');
                $redirect = redirect()->route('registrasiHalal.index');
                return $redirect;
            
            }else{
                
                 return view('registrasi.reportAudit',compact('data'));
            }


    }

    public function reportBeritaAcara($id){        
        //dd($id);
        $data = Registrasi::find($id);
        //get Data from FAQ Transfer            
      
         if($data['status_report']==0  || $data['status_berita_acara']==0 ){
            Session::flash('warning', 'Anda belum dapat memasuki tahapan ini. Silahkan selesaikan tahapan sebelumnya');
            $redirect = redirect()->route('registrasiHalal.index');
            return $redirect;
            
        }else{
            
            return view('registrasi.reportBeritaAcara',compact('data'));

        }

    }    

    public function konfirmasiPembayaranUser(Request $request, $id){
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


            date_default_timezone_set('Asia/Jakarta');
            $today = Carbon::now()->toDateTimeString();
            $p->tanggal_tahap1 =  $today;
            $p->status_tahap1 = 1;

            
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $Count1 = $p->count_tahap1+1;
                //dd($Count1);
                if($e->status == 10 || $e->status == 12){

                    if($p->bb_tahap1 == NULL){
                         $filename = "BB1-".$p->count_tahap1."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                        $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
                        $p->bb_tahap1 = $filename;
                        $p->count_tahap1 = $p->count_tahap1 +1;
                    }else{
                        //dd($Count1);
                        $filename = "BB1-".$Count1."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                        $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
                        $p->bb_tahap1 = $filename;
                        $p->count_tahap1 = $p->count_tahap1 +1;
                    }
                }else{
                    //dd($e->status);
                    //dd($Count1);

                    $filename = "BB1-".$p->count_tahap1."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                    $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
                    $p->bb_tahap1 = $filename;
                    //$p->count_tahap1 = $p->count_tahap1 +1;

                }    
               
            }
            $e->status='d';
            $e->save();
            $u->save();
            $p->save();
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
        $model4 = new Penjadwalan();

         DB::beginTransaction();
        $e = $model->find($id);
        $u = $model2->find($e->id_user);
        $p = $model3->find($e->id_pembayaran);
        //$j = $model4->find($e->id_penjadwalan);
        

       

        $e->status = '13';
        $e->updated_status_by = $updater;
        $e->id_penjadwalan = $model4->id;
        
        $e->save();
        

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("Y-m-d H:i:s");

        


   
        $newData = ['userData'=>$u,'registrasiData'=>$e,'pembayaranData'=>$p];
        $fileName = $e->no_registrasi.'_BT_TAHAP1.pdf';
        $pdf = PDF::loadView('pdf/pdf_pembayaran',$newData);
            
        // save
         Storage::put('public/buktipembayaran/'.$e->id_user.'/'.$fileName, $pdf->output());
            
        
        if($p->nominal_total <10000000 ){
            $p->status_tahap1 = '2';
            $p->status_tahap2 = '2';
            $p->bb_tahap2 = $p->bb_tahap1;
            $p->status_tahap3 = '2';
            $p->bb_tahap3 = $p->bb_tahap1;

            $p->reminder12_tahap2 = 1;
            $p->reminder12_tahap3 = 1;

            $p->reminder6_tahap2 = 1;
            $p->reminder6_tahap3 = 1;

        }elseif($p->nominal_total >=10000000 && $p->nominal_total< 50000000 ){

            $p->status_tahap1 = '2';     
            $p->status_tahap2 = '2';
            $p->bb_tahap2 = $p->bb_tahap1;

            $p->reminder12_tahap2 = 1;
            $p->reminder6_tahap2 = 1;
        
        }else{
             $p->status_tahap1 = '2';
        }

        $p->bt_tahap1 = $fileName;
        $p->tanggal_tahap1 = $tanggal;
        //dd($p->tanggal_tahap1 );
        $p->updated_at = $tanggal;
        $p->save();

        SendEmailP::dispatch($e,$u,$p, $e->status);

        $this->updateStatusRegistrasi($e->id, $e->no_registrasi, $e->id_user, 14);
        DB::commit();  

        

         Session::flash('success', "Pembayaran berhasil dikonfirmasi dan email telah dikirim!");
         $redirect = redirect()->route('listpembayaranregistrasi');
         return $redirect;
    }



    public function dataPembayaranRegistrasi(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start
        if($kodewilayah == '119'){
             $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('pembayaran', 'registrasi.id','=','pembayaran.id_registrasi')
                 ->join('users','registrasi.id_user','=','users.id')
                 
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan', 'pembayaran.status_tahap1 as status_tahap1', 'pembayaran.nominal_tahap1 as nominal_tahap1', 'pembayaran.bb_tahap1 as bb_tahap1' )                 
                 ->where(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    
                    $query->where('registrasi.status','=',8);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=',9);
                }) 

                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    
                    $query->where('registrasi.status','=',10);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=',11);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                  
                    $query->where('registrasi.status','=',12);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=','d');
                });          

        }else{
            $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('pembayaran', 'registrasi.id','=','pembayaran.id_registrasi')
                 ->join('users','registrasi.id_user','=','users.id')
                 
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan', 'pembayaran.status_tahap1 as status_tahap1', 'pembayaran.nominal_tahap1 as nominal_tahap1', 'pembayaran.bb_tahap1 as bb_tahap1' )                 
                 ->where(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',8);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',9);
                }) 

                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',10);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',11);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',12);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=','d');
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
        
        if(isset($gdata['status_tahap1'])){
            $xdata = $xdata->where('status_tahap1','=',$gdata['status_tahap1']);
        }
        
        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }

    public function dataBeritaAcaraAdmin(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;        
        //start                                
        if($kodewilayah == '119'){
            $xdata = DB::table('registrasi')
                ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                ->join('users','registrasi.id_user','=','users.id')                
                ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan')
                ->where(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=',15);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=',16);
                });
        }else{
             $xdata = DB::table('registrasi')
                ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                ->join('users','registrasi.id_user','=','users.id')                
                ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan')
                ->where(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',15);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',16);
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
        if(isset($gdata['jenis_registrasi'])){
            $xdata = $xdata->where('jenis_registrasi','=',$gdata['jenis_registrasi']);
        }
        if(isset($gdata['status_registrasi'])){
            $xdata = $xdata->where('status_registrasi','=',$gdata['status_registrasi']);
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
        //dd($ket);
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
            
            if($status =='11'){
                $p->status_tahap1 = '2';
                $p->updated_by = $updater;
                $p->save();
            }else{
                $p->status_tahap1 = '0';
                $p->updated_by = $updater;
                $p->save();
            }
            
           
        
                try{
                    SendEmailP::dispatch($e,$u,$p, $status);
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


     //////////////Start Pembayaran Tahap2 ///////////////////////////   


    //Pembayaran registrasi
    public function pembayaranTahap2($id){
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
       

        if($dataP){
           return view('registrasi.pembayaranTahap2',compact('data','dataP','dataTransfer','dataTunai'));
        
        }else{
             Session::flash('error', 'Anda belum dapat memasuki tahapan ini. Silahkan selesaikan tahapan sebelumnya');
            $redirect = redirect()->route('registrasiHalal.index');
            return $redirect;
        }
    }

    public function konfirmasiPembayaranUserTahap2(Request $request, $id){
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

            date_default_timezone_set('Asia/Jakarta');
            $today = Carbon::now()->toDateTimeString();
            $p->tanggal_tahap2 = $today;
            $p->status_tahap2 = 1;

            
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $Count2 = $p->count_tahap2+1;

                if($e->status == 'h' || $e->status == 'j'){

                    if($p->bb_tahap2 == NULL){
                         $filename = "BB2-".$p->count_tahap2."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                        $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
                        $p->bb_tahap2 = $filename;
                        $p->count_tahap2 = $p->count_tahap2+1;
                    }else{
                        $filename = "BB2-".$Count2."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                        $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
                        $p->bb_tahap2 = $filename;
                        $p->count_tahap2 = $p->count_tahap2+1;
                    }
                }else{

                    $filename = "BB2-".$p->count_tahap2."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                    $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
                    $p->bb_tahap2 = $filename;
                    //$p->count_tahap2 = $p->count_tahap2+1;
                }    

              
            }
            $e->status='k';
            $e->save();
            $u->save();
            $p->save();
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
    public function listPembayaranTahap2(){
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('registrasi.listPembayaranTahap2',compact('dataKelompok','dataJenis'));
    }

    public function konfirmasiPembayaranTahap22($id,$noregis,$iduser,$status){
        // Mail::to($u->email)->send(new KonfirmasiPembayaran($e,$u,$p,$status));            
        $this->updateStatusRegistrasi($id,$noregis,$iduser,$status);         
    }

    
    public function konfirmasiPembayaranTahap2($id){
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
        
        $e->status = 'l';

        $e->updated_status_by = $updater;

       // dd(model3);
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("Y-m-d H:i:s");


        foreach ($getUserId as $key) {
            $userId = $key->id_user;

            //create PDF File
            $getUser = User::find($userId);
            $getRegistrasi= Registrasi::find($id);
            $getPembayaran= Pembayaran::find($getRegistrasi->id_pembayaran);
            $newData = ['userData'=>$getUser,'registrasiData'=>$getRegistrasi,'pembayaranData'=>$getPembayaran];
            
            $fileName = $key->no_registrasi.'_BT_TAHAP2.pdf';
            $pdf = PDF::loadView('pdf/pdf_pembayaran',$newData);
                
            // save
            Storage::put('public/buktipembayaran/'.$e->id_user.'/'.$fileName, $pdf->output());
                
            $p->status_tahap2 = '2';
            

            $p->bt_tahap2 = $fileName;
            $p->tanggal_tahap2 = $tanggal;
            //dd($p->tanggal_tahap1 );
            $p->updated_at = $tanggal;

            $e->save();
            $p->save();

            DB::commit();  
            SendEmailP::dispatch($e,$u,$p, $e->status);
            //dd("masuk");

            $this->updateStatusRegistrasi($e->id, $e->no_registrasi, $e->id_user, 15);

        }

         Session::flash('success', "Pelunasan berhasil dikonfirmasi!");
         $redirect = redirect()->route('listpembayarantahap2');
         return $redirect;
    }



    public function dataPembayaranTahap2(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start
        if($kodewilayah == '119'){
            $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('pembayaran', 'registrasi.id','=','pembayaran.id_registrasi')
                 ->join('users','registrasi.id_user','=','users.id')
                 
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan', 'pembayaran.status_tahap2 as status_tahap2', 'pembayaran.nominal_tahap2 as nominal_tahap2', 'pembayaran.bb_tahap2 as bb_tahap2' )
                ->where(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    
                    $query->where('registrasi.status','=',14);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=','g');
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    
                    $query->where('registrasi.status','=','h');
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    
                    $query->where('registrasi.status','=','i');
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=','j');
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    
                    $query->where('registrasi.status','=','k');
                }) ;
        }else{
            $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('pembayaran', 'registrasi.id','=','pembayaran.id_registrasi')
                 ->join('users','registrasi.id_user','=','users.id')
                 
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan', 'pembayaran.status_tahap2 as status_tahap2', 'pembayaran.nominal_tahap2 as nominal_tahap2', 'pembayaran.bb_tahap2 as bb_tahap2' )
                ->where(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',14);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=','g');
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=','h');
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=','i');
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=','j');
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=','k');
                }) ;
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
       
        if(isset($gdata['status_tahap2'])){
            $xdata = $xdata->where('status_tahap2','=',$gdata['status_tahap2']);
        }
    

        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }



    public function updateStatusPembayaranTahap2($id,$no_registrasi,$id_user,$status){
        
        $updater = Auth::user()->name;

         $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();
        //dd($model3);
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);
            $e->status = $status;
            $e->updated_status_by = $updater;
            $e->save();
            
            if($status == 'i'){
                $p->status_tahap2 = '2';
                $p->updated_by = $updater;
                $p->save();
            }else{
                $p->status_tahap2 = '0';
                $p->updated_by = $updater;
                $p->save();
            }
             
        
                try{
                    SendEmailP::dispatch($e,$u,$p, $status);
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

        $redirect = redirect()->route('listpembayarantahap2');
         return $redirect;

    }


/////////////////////END of Pembayaran tahap 2////////////////////////////////


 //////////////Start Pelunasan ///////////////////////////   


    //Pembayaran registrasi
    public function pelunasan($id){
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
       

        if($dataP){
           return view('registrasi.pelunasan',compact('data','dataP','dataTransfer','dataTunai'));
        
        }else{
             Session::flash('error', 'Anda belum dapat memasuki tahapan ini. Silahkan selesaikan tahapan sebelumnya');
            $redirect = redirect()->route('registrasiHalal.index');
            return $redirect;
        }
    }

    public function konfirmasiPelunasanUser(Request $request, $id){
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

            date_default_timezone_set('Asia/Jakarta');
            $today = Carbon::now()->toDateTimeString();
            $p->tanggal_tahap3 = $today;
            $p->status_tahap3 = 1;

            
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $Count3 = $p->count_tahap3+1;

                if($e->status == '22' || $e->status == '24'){

                    if($p->bb_tahap3 == NULL){
                         $filename = "BB3-".$p->count_tahap3."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                        $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
                        $p->bb_tahap3 = $filename;
                        $p->count_tahap3 = $p->count_tahap3+1;
                    }else{
                        $filename = "BB3-".$Count3."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                        $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
                        $p->bb_tahap3 = $filename;
                        $p->count_tahap3 = $p->count_tahap3+1;
                    }
                }else{

                    $filename = "BB3-".$p->count_tahap3."-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                    $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
                    $p->bb_tahap3 = $filename;
                   // $p->count_tahap3 = $p->count_tahap3+1;
                }    
               
            }
            $e->status='e';
            $e->save();
            $u->save();
            $p->save();
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
    public function listPelunasan(){
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        return view('registrasi.listPelunasan',compact('dataKelompok','dataJenis'));
    }

    
    public function konfirmasiPelunasanInvoiceAdmin(Request $request, $id){
        //retrieve data
        $data = $request->except('_token','_method');
        $getUserId = Registrasi::where('id','=',$id)->get();

        $updater = Auth::user()->name;

        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();

         DB::beginTransaction();
        $e = $model->find($id);
        $u = $model2->find($e->id_user);
        $p = $model3->find($e->id_pembayaran);
        $e->status = 25;
        $e->updated_status_by = $updater;
        $e->save();

       // dd(model3);
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("Y-m-d H:i:s");


        foreach ($getUserId as $key) {
            $userId = $key->id_user;

            //create PDF File
            $getUser = User::find($userId);
            $getRegistrasi= Registrasi::find($id);
            $getPembayaran= Pembayaran::find($getRegistrasi->id_pembayaran);
            $newData = ['userData'=>$getUser,'registrasiData'=>$getRegistrasi,'pembayaranData'=>$getPembayaran];
            
            $fileName = $key->no_registrasi.'_BT_TAHAP3.pdf';
            $pdf = PDF::loadView('pdf/pdf_pembayaran',$newData);
                
            // save
            Storage::put('public/buktipembayaran/'.$e->id_user.'/'.$fileName, $pdf->output());
                
            //$p->status_tahap3 = '3';
            

            $p->bt_tahap3 = $fileName;
            $p->tanggal_tahap3 = $tanggal;
            //dd($p->tanggal_tahap1 );
            $p->updated_at = $tanggal;
            $p->status_tahap3 = 2;
            $p->save();

            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "INV-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/INV/" , $filename);
                $e->inv_pembayaran = $filename;
                $e->save();
            }

            DB::commit(); 
            SendEmailP::dispatch($e,$u,$p, $e->status);

            $this->updateStatusRegistrasi($e->id, $e->no_registrasi, $e->id_user, 26);
             

        }

         Session::flash('success', "Pembayaran Pelunasan berhasil dikonfirmasi!");
         $redirect = redirect()->route('listpelunasan');
         return $redirect;
    }



    public function dataPelunasan(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start
        if($kodewilayah == '119'){
            $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('pembayaran', 'registrasi.id','=','pembayaran.id_registrasi')
                 ->join('users','registrasi.id_user','=','users.id')
                 
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan', 'pembayaran.status_tahap3 as status_tahap3', 'pembayaran.nominal_tahap3 as nominal_tahap3', 'pembayaran.bb_tahap3 as bb_tahap3' )
                 ->where(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=',20);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=',21);
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                   $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=',22);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=',23);
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                 
                    $query->where('registrasi.status','=',24);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                   
                    $query->where('registrasi.status','=','e');
                });
        }else{
            $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('pembayaran', 'registrasi.id','=','pembayaran.id_registrasi')
                 ->join('users','registrasi.id_user','=','users.id')
                 
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan', 'pembayaran.status_tahap3 as status_tahap3', 'pembayaran.nominal_tahap3 as nominal_tahap3', 'pembayaran.bb_tahap3 as bb_tahap3' )
                 ->where(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',20);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',21);
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                   $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',22);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',23);
                }) 
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=',24);
                })
                ->orWhere(function($query) use ($kodewilayah){
                    $query->where('registrasi.status_cancel','=',0);
                    $query->where('registrasi.kode_wilayah','=',$kodewilayah);
                    $query->where('registrasi.status','=','e');
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
        
       
        if(isset($gdata['status_tahap3'])){
            $xdata = $xdata->where('status_tahap3','=',$gdata['status_tahap3']);
        }
        

        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }



    public function updateStatusPelunasan($id,$no_registrasi,$id_user,$status){
        
        $updater = Auth::user()->name;

         $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();
        //dd($model3);
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);
            $e->status = $status;
            $e->updated_status_by = $updater;
            $e->save();
            
            if($status == 23){
                $p->status_tahap3 = '2';
                $p->updated_by = $updater;
                $p->save();
            }else{
                $p->status_tahap3 = '0';
                $p->updated_by = $updater;
                $p->save();
            }
             
        
                try{
                    SendEmailP::dispatch($e,$u,$p, $status);
                    //Session::flash('success', "data berhasil disimpan!");
                    Session::flash('success', 'data dengan no registrasi '.$no_registrasi.' berhasil diupdate dan dikirim emailnya!');

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

        $redirect = redirect()->route('listpelunasan');
         return $redirect;

    }


    public function uploadInvoice($id){
        //dd($id);
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
        return view('registrasi.uploadInvoice',compact('data','dataP','dataTransfer','dataTunai'));
    }

   

    public function uploadFileInvoice(Request $request, $id){
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

            date_default_timezone_set('Asia/Jakarta');
            $date = date("Y-m-d h:i:sa");

            //$e->tanggal_akad = $date;
            $p->status_tahap3 = 3;
            // $p->status_tahap3 = 2;
            $p->save();
            //$e->mata_uang = $data['mata_uang'];
            // $e->status=25;
            ///$data['total_biaya'] = str_replace(',', '', $data['total_biaya']);
           // $e->total_biaya = $data['total_biaya'];
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "INV-".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/INV/", $filename);
                $e->inv_pembayaran = $filename;
            }
            $e->save();
            DB::commit();
             SendEmailP::dispatch($e,$u,$p, $e->status);
            Session::flash('success', "Upload Invoice Berhasil");

            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
            $redirect = redirect()->route('listpelunasan');
            return $redirect;
    }




///////lebih kurang////



    public function lebih($id,$tahap){
        //dd($id);
        $data = Registrasi::find($id);
        $dataP = Pembayaran::find($data->id_pembayaran);
        //get Data from FAQ Transfer
       

        return view('registrasi.lebih',compact('data','dataP','tahap'));
    }
      public function kurang($id,$tahap){
        //dd($id);
        $data = Registrasi::find($id);
        $dataP = Pembayaran::find($data->id_pembayaran);
        //get Data from FAQ Transfer
       
        return view('registrasi.kurang',compact('data','dataP','tahap'));
    }

   

     public function updateStatusLebih(Request $request, $id){
        //retrieve data
        $data = $request->except('_token','_method');
        $updater = Auth::user()->name;

        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();
        $model4 = new Penjadwalan();

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("Y-m-d H:i:s");

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);

            $e->status = $data['status'];

            $e->updated_status_by = $updater;

        
            
            if($data['status'] =='11'){
                $p->status_tahap1 = '2';                
                $lebih1 = str_replace('.', '', $data['lebih_tahap1']);
                $lebihTotal = str_replace('Rp', '', $lebih1);

                $p->lebih_tahap1 = (int)$lebihTotal;                
                $p->updated_by = $updater;

                $model4->updated_by = $updater;
                $model4->status_audit1 = '0';
                $model4->progres_penjadwalan = 'audit1';
                $model4->id_registrasi = $e->id;
                $model4->save();

                        //create PDF File
                       
                $newData = ['userData'=>$u,'registrasiData'=>$e,'pembayaranData'=>$p];
                $fileName = $e->no_registrasi.'_BT_TAHAP1.pdf';
                $pdf = PDF::loadView('pdf/pdf_pembayaran',$newData);
                    
                // save
                 Storage::put('public/buktipembayaran/'.$e->id_user.'/'.$fileName, $pdf->output());
                    
                
                if($p->nominal_total <10000000 ){
                    $p->status_tahap1 = '2';
                    $p->status_tahap2 = '2';
                    $p->bb_tahap2 = $p->bb_tahap1;
                    $p->status_tahap3 = '2';
                    $p->bb_tahap3 = $p->bb_tahap1;

                    $p->reminder12_tahap2 = 1;
                    $p->reminder12_tahap3 = 1;

                    $p->reminder6_tahap2 = 1;
                    $p->reminder6_tahap3 = 1;

                }elseif($p->nominal_total >=10000000 && $p->nominal_total< 50000000 ){

                    $p->status_tahap1 = '2';     
                    $p->status_tahap2 = '2';
                    $p->bb_tahap2 = $p->bb_tahap1;

                    $p->reminder12_tahap2 = 1;
                    $p->reminder6_tahap2 = 1;
                
                }else{
                     $p->status_tahap1 = '2';
                }

                $p->bt_tahap1 = $fileName;
                $p->tanggal_tahap1 = $tanggal;
                //dd($p->tanggal_tahap1 );
                $p->updated_at = $tanggal;
                $p->save();
                        
                


            }elseif($data['status'] =='i'){
                $p->status_tahap2 = '2';
                $lebih2 = str_replace('.', '', $data['lebih_tahap2']);
                $lebihTotal2 = str_replace('Rp', '', $lebih2);

                $p->lebih_tahap2 = (int)$lebihTotal2;
                // $p->lebih_tahap2 = $data['lebih_tahap2'];
                $p->updated_by = $updater;

                $newData = ['userData'=>$u,'registrasiData'=>$e,'pembayaranData'=>$p];
                $fileName = $e->no_registrasi.'_BT_TAHAP2.pdf';
                $pdf = PDF::loadView('pdf/pdf_pembayaran',$newData);
                    
                // save
                 Storage::put('public/buktipembayaran/'.$e->id_user.'/'.$fileName, $pdf->output());
                    

                $p->bt_tahap2 = $fileName;
                $p->tanggal_tahap2 = $tanggal;
                //dd($p->tanggal_tahap1 );
                $p->updated_at = $tanggal;
                $p->save();

                
            }elseif($data['status'] =='23'){
                $p->status_tahap3 = '2';
                $lebih3 = str_replace('.', '', $data['lebih_tahap3']);
                $lebihTotal3 = str_replace('Rp', '', $lebih3);

                $p->lebih_tahap3 = (int)$lebihTotal3;
                // $p->lebih_tahap3 = $data['lebih_tahap3'];
                $p->updated_by = $updater;

                 $p->updated_by = $updater;

                $newData = ['userData'=>$u,'registrasiData'=>$e,'pembayaranData'=>$p];
                $fileName = $e->no_registrasi.'_BT_TAHAP3.pdf';
                $pdf = PDF::loadView('pdf/pdf_pembayaran',$newData);
                    
                // save
                 Storage::put('public/buktipembayaran/'.$e->id_user.'/'.$fileName, $pdf->output());
                    

                $p->bt_tahap3 = $fileName;
                $p->tanggal_tahap3 = $tanggal;
                //dd($p->tanggal_tahap1 );
                $p->updated_at = $tanggal;
                $p->save();
                
                
            }
            
           $e->save();
           $p->save();
        
            try{

                DB::commit();

               SendEmailP::dispatch($e,$u,$p, $data['status']);
                //Session::flash('success', "data berhasil disimpan!");
                Session::flash('success', 'data dengan no registrasi '.$e->no_registrasi.' berhasil di kirim emailnya!');

                

                if($data['status'] =='11'){
                
                    $this->updateStatusRegistrasi($e->id, $e->no_registrasi, $e->id_user, 14);

                }elseif($data['status'] =='i'){

                    $this->updateStatusRegistrasi($e->id, $e->no_registrasi, $e->id_user, 15);
                    
                }


            }catch(\Exception $u){

                Session::flash('error', $u->getMessage());
                //Session::flash('success', "data berhasil disimpan!");
                //$statusreg = $e->getMessage();

            }
            
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

           
        }


            if($data['status'] =='11'){
            
                 $redirect = redirect()->route('listpembayaranregistrasi');

            }elseif($data['status'] =='i'){

                $redirect = redirect()->route('listpembayarantahap2');
                
            }elseif($data['status'] =='23'){
               
               $redirect = redirect()->route('listpelunasan');
                
            }

            return $redirect;
    }


    public function updateStatusKurang(Request $request, $id){
        //retrieve data
        $data = $request->except('_token','_method');
        $updater = Auth::user()->name;

        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();


        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $u = $model2->find($e->id_user);
            $p = $model3->find($e->id_pembayaran);

            $e->status = $data['status'];

            $e->updated_status_by = $updater;

        
            
            if($data['status'] =='10'){
                $p->status_tahap1 = '0';
                $kurang1 = str_replace('.', '', $data['kurang_tahap1']);
                $kurangTotal = str_replace('Rp', '', $kurang1);

                $p->kurang_tahap1 = (int)$kurangTotal;                
                // $p->kurang_tahap1 = $data['kurang_tahap1'];
                $p->updated_by = $updater;



            }elseif($data['status'] =='h'){
                $p->status_tahap2 = '0';
                $kurang2 = str_replace('.', '', $data['kurang_tahap2']);
                $kurangTotal2 = str_replace('Rp', '', $kurang2);

                $p->kurang_tahap2 = (int)$kurangTotal2;
                // $p->kurang_tahap2 = $data['kurang_tahap2'];
                $p->updated_by = $updater;

                
            }elseif($data['status'] =='22'){
                $p->status_tahap3 = '0';
                $kurang3 = str_replace('.', '', $data['kurang_tahap3']);
                $kurangTotal3 = str_replace('Rp', '', $kurang3);

                $p->kurang_tahap3 = (int)$kurangTotal3;
                // $p->kurang_tahap3 = $data['kurang_tahap3'];
                $p->updated_by = $updater;
                
                
            }
            
            $e->save();
            $p->save();
        
          
            DB::commit();

            SendEmailP::dispatch($e,$u,$p, $data['status']);
            //Session::flash('success', "data berhasil disimpan!");
            Session::flash('success', 'data dengan no registrasi '.$e->no_registrasi.' berhasil di kirim emailnya!');


           
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

           
        }


            if($data['status'] =='10'){
            
                 $redirect = redirect()->route('listpembayaranregistrasi');

            }elseif($data['status'] =='h'){

                $redirect = redirect()->route('listpembayarantahap2');
                
            }elseif($data['status'] =='22'){
               
               $redirect = redirect()->route('listpelunasan');
                
            }

            return $redirect;
    }
/////////////////////END of Pembayaran tahap 3////////////////////////////////

    public function updateCabang(Request $request){

        $gdata = $request->except('_token','_method');
        //dd($gdata);
        $user = Auth::user()->id;

        $model = new Registrasi();

        try{
            DB::beginTransaction();
            $e = $model->find($gdata['id']);

            $e->kode_wilayah = $gdata['kode_wilayah'];
            $e->updated_status_by = $user;
            $e->save();

            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        $redirect = redirect()->route('listregistrasipelangganaktif');
        return $redirect;
    }

    

}