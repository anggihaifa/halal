<?php

namespace App\Http\Controllers\Master;

use App\Models\Registrasi;
use App\Models\Pembayaran;
use App\Models\System\User;
use Illuminate\Support\Facades\Mail;
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
use App\Mail\ReminderMail;
use Carbon\Carbon;

class ReminderController extends Controller
{
    public function dataReminderPembayaran(Request $request){                
        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();

        try{            
            DB::beginTransaction();
            $p = Pembayaran::all();

            foreach ($p as $key => $value) {
                $tgl = $value->tanggal_tahap1;
                $tgl2 = $value->dl_tahap1;                   

                \Log::info(Carbon::parse($tgl2)." dan ".Carbon::now());

                $time1 = Carbon::parse($tgl)->timestamp;
                $time2 = Carbon::parse($tgl2)->timestamp;
                $timenow = Carbon::now()->timestamp;
                \Log::info($time2-$timenow);
                
                if($time2 - $timenow <= 43200){
                    Mail::to("hamdanmiftahul@gmail.com")->send(new ReminderMail());
                    \Log::info("sukseslnying");
                }else{
                    \Log::info("gagalnying");
                }                
            }            

            // $e = $model->find($id);
            // $u = $model2->find($e->id_user);
            // $p = $model3->find($e->id_pembayaran);                                                
            
            
            // date_default_timezone_set('Asia/Jakarta');
            // $dl = date("Y-m-d H:i:s", strtotime('+24 hours'));               
            
            
            // \Log::info("success");
            // Mail::to($u->email)->send(new ReminderMail($e,$u,$p, $status));
            
        }catch (\Exception $e){
            // \Log::error($e);
            // DB::rollBack();
            // Session::flash('error', $e->getMessage());           
            \Log::info("failed");
        }        
    }    
}
