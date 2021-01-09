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
use App\Jobs\SendEmailC;

class CancelOrderController extends Controller
{
    public function dataCancelOrder(Request $request){ 
        $model = new Registrasi();       
        $model2 = new User();
        $model3 = new Pembayaran();


        try{                      
        ////////Email Cancel Order///////  
                      
            DB::beginTransaction(); 
            //$p = Pembayaran::all();

            /*foreach ($p as $key => $value) {     
                $e = $model->find($value->id_registrasi);
                $u = $model2->find($e->id_user);

                $tgl2 = $value->dl_tahap1;

                $idregistrasi = $value->id_registrasi;    

                date_default_timezone_set('Asia/Jakarta');            

                
                $time2 = Carbon::parse($tgl2)->timestamp;
                $timenow = Carbon::now()->timestamp;                
                
                //cancel pembayaran
                if($timenow > $time2){                    

                    $model = new Registrasi();                                        


                    try { 

                                       
                        $status = $model->find($idregistrasi);
                        if($status->status_cancel==0 && $value->status_tahap1 == 0){

                            $status->status_cancel = 1;
                        
                            $status->save();                                     
                            DB::commit();

                            Mail::to("$u->email")->send(new CancelOrder($e,$u,$status,'pembayaran'));
                        }  
                        
                                                
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
                $p = $model3->find($value2->id_pembayaran);

                $tgl_berkas = $value2->dl_berkas;
                date_default_timezone_set('Asia/Jakarta');
      
                
                $time2 = Carbon::parse($value2->dl_berkas)->timestamp;
                $timenow2 = Carbon::now()->timestamp;
                                
                // dd(Carbon::parse($value2->dl_berkas));
                

                //cancel pembayaran  
                           
                if($timenow2 > $time2){   
                    // dd($value2->dl_berkas);                                               
                    // dd(Carbon::parse($value2->dl_berkas));
                     //dd($timenow2);   
                    try {                                                                                         
                         
                        if($value2->status_cancel==0 && $value2->status_berkas == 0){

                            $value2->status_cancel = 1;
                        
                            $value2->save();                                     
                            DB::commit();  
                            //dd($timenow2);                       
                            Mail::to("$u->email")->send(new CancelOrder($value2,$u,$p,'berkas'));
                        } 
                                                
                    } catch (\Exception $e) {
                        // \Log::error("Error".$e);
                        DB::rollBack();
                        Session::flash('error', $e->getMessage());
                    }                    
                    
                }                                
            }  


             $e = Registrasi::all();

            foreach ($e as $key => $value3) {                 
                $u = $model2->find($value3->id_user);
                $p = $model3->find($value3->id_pembayaran);

                $tgl_berkas = $value3->dl_akad;
                date_default_timezone_set('Asia/Jakarta');
                
                $time3 = Carbon::parse($value3->dl_akad)->timestamp;
                $timenow3 = Carbon::now()->timestamp;
                                
                // dd(Carbon::parse($value2->dl_berkas));
                
                //cancel pembayaran  
                           
                if($timenow3 > $time3){   
                    // dd($value2->dl_berkas);                                               
                    // dd(Carbon::parse($value2->dl_berkas));
                     //dd($timenow2);   
                    try {                                                                                         
                         
                        if($value3->status_cancel==0 ){
                            if($value3->status_akad == 0 || $value3->status_akad == 1){

                                $value3->status_cancel = 1;
                        
                                $value3->save();                                     
                                DB::commit();  
                                //dd($timenow2);                       
                                Mail::to("$u->email")->send(new CancelOrder($value2,$u,$p,'akad'));

                            }

                           
                        } 
                       

                                                
                    } catch (\Exception $e) {
                        // \Log::error("Error".$e);
                        DB::rollBack();
                        Session::flash('error', $e->getMessage());
                    }                    
                    
                }                                
            }  */


            /////Email Reminder///////

            $p = Pembayaran::all();
            //dd($p);
            foreach ($p as $key => $value) {

                $e = $model->find($value->id_registrasi);
                $u = $model2->find($e->id_user);

                if(is_null($value->dl_tahap1)==0){

                    date_default_timezone_set('Asia/Jakarta');    
                    $tgl_1 = $value->tanggal_tahap1;
                    $tgl2_1 = $value->dl_tahap1;

                    //dd($tgl2_1);
                    $time1 = Carbon::parse($tgl_1)->timestamp;
                    $time2 = Carbon::parse($tgl2_1)->timestamp;
                    $timenow = Carbon::now()->timestamp;

                    
                    if($time2 - $timenow <= 43200){
                        //dd($p);
                        
                        if($value->reminder12_tahap1 == 0 && $value->status_tahap1 == 0){
                            
                            $value->reminder12_tahap1 = 1;
                            $value->save();
                           //dd($p);
                             DB::commit();
                             //Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r1_12'));

                             SendEmailC::dispatch($e,$u,$value,'r1_12');
                        
                        }
                       
                    }if($time2 - $timenow <=21600){
                        
                        if($value->reminder6_tahap1 == 0 && $value->status_tahap1 == 0){
               
                             $value->reminder6_tahap1 = 1;
                             $value->save();
                              DB::commit();
                             //Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r1_6'));
                             SendEmailC::dispatch($e,$u,$value,'r1_6');
                        \Log::info("sukses");
                        }
                    }
                }if(is_null($value->dl_tahap2)==0){

                    $tgl_2 = $value->tanggal_tahap2;
                    $tgl2_2 = $value->dl_tahap2; 

                    date_default_timezone_set('Asia/Jakarta');    

                    $time1_2 = Carbon::parse($tgl_2)->timestamp;
                    $time2_2 = Carbon::parse($tgl2_2)->timestamp;
                    $timenow_2 = Carbon::now()->timestamp;

                    if($time2_2 - $timenow_2 <= 43200){
                        if($value->reminder12_tahap2 == 0 && $value->status_tahap2 == 0){

                            $value->reminder12_tahap2 = 1;
                            $value->save();
                             DB::commit();
                             //Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r2_12'));
                             SendEmailC::dispatch($e,$u,$value,'r2_12');
                        
                        }
                        
                    }if($time2_2 - $timenow_2 <=21600){
                        if($value->reminder6_tahap2 == 0 && $value->status_tahap2 == 0){

                            $value->reminder6_tahap2 = 1;
                            $value->save();
                             DB::commit();
                             //Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r2_6'));
                             SendEmailC::dispatch($e,$u,$value,'r2_6');
                       
                        }
                      
                    }      

                }if(is_null($value->dl_tahap3)==0){

                    $tgl_3 = $value->tanggal_tahap3;
                    $tgl2_3 = $value->dl_tahap3; 

                    date_default_timezone_set('Asia/Jakarta');    

                    $time1_3 = Carbon::parse($tgl_3)->timestamp;
                    $time2_3 = Carbon::parse($tgl2_3)->timestamp;
                    $timenow_3 = Carbon::now()->timestamp;


                    if($time2_3 - $timenow_3 <= 43200){
                        if($value->reminder12_tahap3 == 0 && $value->status_tahap3 == 0){

                            $value->reminder12_tahap3 = 1;
                            $value->save();
                             DB::commit();
                             //Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r3_12'));
                             SendEmailC::dispatch($e,$u,$value,'r3_12');
                        
                        }
                        
                    }if($time2_3 - $timenow_3 <=21600){
                        if($value->reminder6_tahap3 == 0 && $value->status_tahap3 == 0){

                            $value->reminder6_tahap3 = 1;
                            $value->save();
                             DB::commit();
                            // Mail::to("$u->email")->send(new ReminderMail($e,$u,$value,'r3_6'));
                             SendEmailC::dispatch($e,$u,$value,'r3_6');
                       
                        }
                        
                    }     

                }    
            }      

        }catch (\Exception $e){            
            DB::rollBack();
            Session::flash('error', $e->getMessage());            
        }  

    }
}
