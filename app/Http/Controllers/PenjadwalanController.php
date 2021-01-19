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
use App\Models\Negara;
use App\Models\Provinsi;
use App\Models\Kabupaten;
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

class PenjadwalanController extends Controller
{
    //registrasi halal
   
    public function listPenjadwalanAdmin(){
        $dataKelompok = KelompokProduk::all();
        $dataJenis = JenisRegistrasi::all();
        $dataAuditor =DB::table('user')
                ->where('usergroup','8');

        $dataKomite =DB::table('user')
                ->where('usergroup','9');        
        
        return view('penjadwalan.listPenjadwalanAdmin',compact('dataKelompok','dataJenis','dataAuditor','dataKomite'));
    }
    public function dataPenjadwalanAdmin(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start
        if($kodewilayah == '00'){
            $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                 ->join('users','registrasi.id_user','=','users.id')
                 ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')             
                 ->where('registrasi.status_cancel','=',0)
                 ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');
        }else{

            $xdata = DB::table('registrasi')
                ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                ->join('users','registrasi.id_user','=','users.id')
                ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')  
                 
                ->where('registrasi.kode_wilayah','=',$kodewilayah)
                ->where('registrasi.status_cancel','=',0)
                ->select('registrasi.id as id_regis','registrasi.no_registrasi as no_registrasi', 'registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');


        }
       


        //filter condition
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
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

    

}