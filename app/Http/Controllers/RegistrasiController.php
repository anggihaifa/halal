<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
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

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->status = $status;
            $e->updated_status_by = $updater;
            $e->save();
            
            
            //DB::commit();
            //Session::flash('success', ' '.$no_registrasi.' berhasil euyy!');

            // $dataUser = User::find($userId);
            // $dataRegistrasi = Registrasi::find($id);
            // Mail::to($dataUser->email)->send(new KonfirmasiPembayaran($dataUser,$dataRegistrasi));
            if($status == '4' ||$status == '5' ||$status == '7' ||$status == '8' ||$status == '10' ||$status == '11' ||$status == '12' ||$status == '13' ||$status == '16' ||$status == '17' ||$status == '20' ||$status == '22' ||$status == '23' ||$status == '24' ||$status == '25'){


                $u = $model2->find($id_user);
            
                    try{
                        Mail::to($u->email)->send(new ProgresStatus($u, $status));
                        //Session::flash('success', "data berhasil disimpan!");
                        Session::flash('success', 'data dengan no registrasi '.$no_registrasi.' berhasil di kirim emailnya!');

                        DB::commit();

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
                

            //Session::flash('success', 'data dengan no registrasi '.$no_registrasi.' berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

           
        }

        return redirect()->route('listregistrasipelangganaktif');

    }



    public function dataRegistrasiPelangganBayar(){
        $xdata = DB::table('registrasi')
                 ->join('jenis_registrasi','registrasi.id_jenis_registrasi','=','jenis_registrasi.id')
                 ->join('kelompok_produk','registrasi.id_kelompok_produk','=','kelompok_produk.id')
                 ->join('users','registrasi.id_user','=','users.id')
                 ->select('registrasi.*','jenis_registrasi.jenis_registrasi as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan')
                 ->where('registrasi.status_pembayaran','=',2)
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
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
        return view('registrasi.detail',compact('data'));
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
            $model->fill($data);
            $model->id_user = Auth::user()->id;
            $model->no_registrasi = $randomid;
            //$model->inv_registrasi = $fileName;
            $model->status = 1 ;
            $model->save();
            DB::commit();

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


    //Pembayaran registrasi
    public function pembayaranRegistrasi($id){
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
        return view('registrasi.pembayaran',compact('data','dataTransfer','dataTunai'));
    }

    public function konfirmasiPembayaran(Request $request, $id){
        $data = $request->except('_token','_method');

        $model = new Registrasi();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->tanggal_pembayaran = $data['tgl_pembayaran'];
            $e->status_pembayaran = 1;
            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = "REG".$data['id']."-".$data['no_registrasi'].".".$file->getClientOriginalExtension();
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
    public function konfirmasiPembayaranRegistrasi($id){
        //retrieve data
        $getUserId = Registrasi::where('id','=',$id)->get();

        foreach ($getUserId as $key) {
            $userId = $key->id_user;

            //create PDF File
            $getUser = User::find($userId);
            $getRegistrasi = Registrasi::find($id);
            $newData = ['userData'=>$getUser,'registrasiData'=>$getRegistrasi];
            $fileName = $key->no_registrasi.'_INV_PAYMENT.pdf';
            $pdf = PDF::loadView('pdf/pdf_pembayaran',$newData);

            //update data
            DB::table('registrasi')->where('id', $id)->update(['status_pembayaran' => 2,'inv_pembayaran'=>$fileName]);
            //DB::table('registrasi')->where('id', $id)->update(['inv_pembayaran'=>$fileName]);

            //for edit pdf ui
            //return PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf/pdf_pembayaran',$newData)->stream();

            //for download and save
            // Storage::put('public/pembayaran/'.$fileName, $pdf->output());
            // $pdf->download($fileName);

            //Send Email

            // $dataUser = User::find($userId);
            // $dataRegistrasi = Registrasi::find($id);
            // Mail::to($dataUser->email)->send(new KonfirmasiPembayaran($dataUser,$dataRegistrasi));

            return PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf/pdf_pembayaran',$newData)->stream();
        }


         Session::flash('success', "Pembayaran berhasil dikonfirmasi!");
         $redirect = redirect()->route('listpembayaranregistrasi');
         return $redirect;
    }
    public function download($path){
         return Storage::download($path);
    }


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

    // public function updateStatusHas($registrasi,$id,$name,$status){

    //     $approver = Auth::user()->name;
    //     DB::table('dokumen_has')->where('id_registrasi', $registrasi)->where('id', $id)->update([$name => $status,'check_by'=> $approver]);
    //     Session::flash('success', "Status berhasil diupdate");
    //     return redirect()->back();

    // }

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


    //etc
    public function pembayaranAkad(){
        return view('registrasi.pembayaranAkad');
    }
    public function penjadualanAudit(){
        return view('registrasi.penjadualanAudit');
    }
    public function dokumenTravel(){
        return view('registrasi.dokumenTravel');
    }
}
