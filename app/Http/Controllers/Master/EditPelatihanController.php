<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\System\User;
use App\Models\Pelatihan;
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
use App\Models\Berita;
use Validator,Redirect,File;

class EditPelatihanController extends Controller
{
    public function store(Request $request)
     {
         $data = $request->except('_token','_method');                  
         $model = new Pelatihan();
         try{
             DB::beginTransaction();
             $e = $model->find($data['id_pelatihan']);             
            if($request->has("gambar_cover")){
                $file = $request->file("gambar_cover");
                $file = $data["gambar_cover"];
                $profileImage = "Pelatihan_".date('YmdHis') . "." . $file->getClientOriginalExtension();                
                $file->storeAs("public/pelatihan/",$profileImage);

                $e->gambar_cover = $profileImage;
                $e->judul_pelatihan = $data['judul_pelatihan'];
                $e->isi_pelatihan = $data['isi_pelatihan'];
                // $e->fill($data);
                // dd("ada gambar"); 
            }else{                                
                // dd("gaada gambar"); 
                $e->judul_pelatihan = $data['judul_pelatihan'];
                $e->isi_pelatihan = $data['isi_pelatihan'];
            }             
             $e->save();
             DB::commit();
 
             Session::flash('success', 'data berhasil di update!');
         }catch (\Exception $e){
             DB::rollBack();
 
             Session::flash('error', $e->getMessage());
         }
 
         return redirect()->route('pelatihan.index');
     }
}
