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
use App\Mail\CancelOrder;
use App\Mail\ProgresStatus;
use App\Mail\ReminderMail;
use Carbon\Carbon;

class CancelOrderController extends Controller
{
    public function dataCancelOrder(Request $request){ 
        $model = new Registrasi();       
        $model2 = new User();
        $model3 = new Pembayaran();

        try{                        
            DB::beginTransaction(); 
            $p = Pembayaran::all();

            foreach ($p as $key => $value) {     
                $e = $model->find($value->id_registrasi);
                $u = $model2->find($e->id_user);

                $tgl2 = $value->dl_tahap1;
                $idregistrasi = $value->id_registrasi;                
                
                $time2 = Carbon::parse($tgl2)->timestamp;
                $timenow = Carbon::now()->timestamp;                
                
                //cancel pembayaran
                if($timenow > $time2){                    

                    $model = new Registrasi();                                        

                    try {       
                                       
                        $status = $model->find($idregistrasi);
                        
                        $status->status_cancel = 1;
                        
                        $status->save();                                     
                        DB::commit();

                        Mail::to("$u->email")->send(new CancelOrder($e,$u,$status,'pembayaran'));
                                                
                    } catch (\Exception $e) {
                        // \Log::error("Error".$e);
                        DB::rollBack();
                        Session::flash('error', $e->getMessage());
                    }                    
                    
                }                                
            }    
            
            //cancel aberkas
            $e = Registrasi::all();

            foreach ($e as $key => $value2) {                 
                $u = $model2->find($value2->id_user);
                $p = $model3->find($value2->id);

                $tgl_berkas = $value2->dl_berkas;
                
                $time2 = Carbon::parse($value2->dl_berkas)->timestamp;
                $timenow2 = Carbon::now()->timestamp;
                                
                // dd(Carbon::parse($value2->dl_berkas));
                
                //cancel pembayaran                
                if($timenow2 > $time2){   
                    // dd($value2->dl_berkas);                                               
                    // dd(Carbon::parse($value2->dl_berkas));
                    try {                                                                                         
                        // dd("disini");
                        $value2->status_cancel = 1;
                        
                        $value2->save();                                     
                        DB::commit();                        
                        Mail::to("$u->email")->send(new CancelOrder($value2,$u,$p,'berkas'));
                                                
                    } catch (\Exception $e) {
                        // \Log::error("Error".$e);
                        DB::rollBack();
                        Session::flash('error', $e->getMessage());
                    }                    
                    
                }                                
            }  
        }catch (\Exception $e){            
            DB::rollBack();
            Session::flash('error', $e->getMessage());            
        }  

    }
}
