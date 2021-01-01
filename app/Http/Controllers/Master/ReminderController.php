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

class ReminderController extends Controller
{      
    public function dataReminderPembayaran(Request $request){                
        $model = new Registrasi();
        $model2 = new User();
        $model3 = new Pembayaran();

        //reminder

        try{            
            DB::beginTransaction();
            $p = Pembayaran::all();
            //dd($p);
            foreach ($p as $key => $value) {

                $e = $model->find($value->id_registrasi);
                $u = $model2->find($e->id_user);

                if(is_null($value->dl_tahap1)==0){


                    $tgl_1 = $value->tanggal_tahap1;
                    $tgl2_1 = $value->dl_tahap1;

                    //dd($tgl2_1);
                    $time1 = Carbon::parse($tgl_1)->timestamp;
                    $time2 = Carbon::parse($tgl2_1)->timestamp;
                    $timenow = Carbon::now()->timestamp;

                    
                    if($time2 - $timenow <= 43200){
                        //dd($p);
                        
                        if($value->reminder12_tahap1 == 0){
                            
                            $value->reminder12_tahap1 = 1;
                            $value->save();
                           //dd($p);
                             DB::commit();
                             Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r1_12'));
                        
                        }
                        else{
                            \Log::info("udh dikirim sebelumnya");
                        }
                    }if($time2 - $timenow <=21600){
                        
                        if($value->reminder6_tahap1 == 0){
               
                             $value->reminder6_tahap1 = 1;
                             $value->save();
                              DB::commit();
                             Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r1_6'));
                        \Log::info("sukses");
                        }
                        else{
                            \Log::info("udh dikirim sebelumnya");
                        }
                                    

                }if(is_null($value->dl_tahap2)==0){

                    $tgl_2 = $value->tanggal_tahap2;
                    $tgl2_2 = $value->dl_tahap2; 

                    $time1_2 = Carbon::parse($tgl_2)->timestamp;
                    $time2_2 = Carbon::parse($tgl2_2)->timestamp;
                    $timenow_2 = Carbon::now()->timestamp;

                    if($time2_2 - $timenow_2 <= 43200){
                        if($value->reminder12_tahap2 == 0){

                            $value->reminder12_tahap2 = 1;
                            $value->save();
                             DB::commit();
                             Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r2_12'));
                        \Log::info("sukses");
                        }
                        else{
                            \Log::info("udh dikirim sebelumnya");
                        }
                    }if($time2_2 - $timenow_2 <=21600){
                        if($value->reminder6_tahap2 == 0){

                            $value->reminder6_tahap2 = 1;
                            $value->save();
                             DB::commit();
                             Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r2_6'));
                        \Log::info("sukses");
                        }
                        else{
                            \Log::info("udh dikirim sebelumnya");
                        }
                    }      

                }if(is_null($value->dl_tahap3)==0){

                    $tgl_3 = $value->tanggal_tahap3;
                    $tgl2_3 = $value->dl_tahap3; 

                    $time1_3 = Carbon::parse($tgl_3)->timestamp;
                    $time2_3 = Carbon::parse($tgl2_3)->timestamp;
                    $timenow_3 = Carbon::now()->timestamp;


                    if($time2_3 - $timenow_3 <= 43200){
                        if($value->reminder12_tahap3 == 0){

                            $value->reminder12_tahap3 = 1;
                            $value->save();
                             DB::commit();
                             Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r3_12'));
                        \Log::info("sukses");
                        }
                        else{
                            \Log::info("udh dikirim sebelumnya");
                        }
                    }if($time2_3 - $timenow_3 <=21600){
                        if($value->reminder6_tahap3 == 0){

                            $value->reminder6_tahap3 = 1;
                            $value->save();
                             DB::commit();
                             Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r3_6'));
                        \Log::info("sukses");
                        }
                        else{
                            \Log::info("udh dikirim sebelumnya");
                        }
                    }     

                } else{
                    dd($p);
                }        
            }
                        
            
        }catch (\Exception $e){
                     
            \Log::info("failed");
        }  


        //cancel                

        try{                        
            DB::beginTransaction(); 
            $p = Pembayaran::all();

            foreach ($p as $key => $value) {                          
                $tgl2 = $value->dl_tahap1;
                $idregistrasi = $value->id_registrasi;                
                
                $time2 = Carbon::parse($tgl2)->timestamp;
                $timenow = Carbon::now()->timestamp;
                                
                if($timenow > $time2){
                    Mail::to("hamdanmiftahul@gmail.com")->send(new CancelOrder());

                    $model = new Registrasi();                                     

                    try {                                              
                        $status = $model->find($idregistrasi);                                                
                        $status->status_cancel = 3;                        
                        $status->save();                                     
                        DB::commit();
                                                
                    } catch (\Exception $e) {                        
                        DB::rollBack();
                        Session::flash('error', $e->getMessage());
                    }                    
                    
                }else{                    

                }                
            }                                    
        }catch (\Exception $e){            
            DB::rollBack();
            Session::flash('error', $e->getMessage());            
        }  

    }
    
}
