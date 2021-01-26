<?php

namespace App\Http\Controllers\Master;

use App\Models\System\User;

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
use App\Models\Berita;
use Validator,Redirect,File;

class EditBeritaController extends Controller
{
    public function store(Request $request2)
     {
         $data = $request2->except('_token','_method');         
 
         $model = new Berita();
         try{
             DB::beginTransaction();
             $e = $model->find($data['id_berita']);
            //  dd("disinioi");
             $e->fill($data);
             $e->save();
             DB::commit();
 
             Session::flash('success', 'data berhasil di update!');
         }catch (\Exception $e){
             DB::rollBack();
 
             Session::flash('error', $e->getMessage());
         }
 
         return redirect()->route('berita.index');
     }
}
