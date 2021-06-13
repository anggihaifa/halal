<?php

namespace App\Http\Controllers;

/*use vendor\pear\http_request2\HTTP\Request2;*/
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
use App\Models\KebutuhanWaktuAudit;
use App\Models\System\User;
use App\Models\Master\JenisRegistrasi;
use App\Models\Master\KelompokProduk;
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
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Services\FileUploadServices;
use App\Mail\KonfirmasiPembayaran;
use App\Mail\ProgresStatus;
use App\Jobs\SendEmailP;
use App\Jobs\SendEmailAuditor;
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
  

    public function dataAuditor1(Request $request)
    {        
        $data = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;

        Log::info($data['mulai']);
        if($data['mulai']){
                $dataAuditor1_TidakLuangRaw =  DB::table('penjadwalan')
                                    ->where('mulai_audit1','=', $data['mulai'])
                                    ->select('pelaksana1_audit1')
                                    ->get();

                $dataAuditor2_TidakLuang =  DB::table('penjadwalan')
                                        
                                        ->where(function($query) use ($data){
                                            $query->where('mulai_audit2', $data['mulai']);
                                            
                                          
                                        })
                                        
                                        /*->get();*/
                                       ->select('pelaksana1_audit2','pelaksana2_audit2')
                                        ->get();

            $dataAuditor1_TidakLuang = array();
                                       
           $dataAuditor1_TidakLuangRaw= json_decode($dataAuditor1_TidakLuangRaw, true);
           //Log::info($dataAuditor1_TidakLuangRaw);
           for( $i=0;$i<count($dataAuditor1_TidakLuangRaw);$i++) {
            //Log::info($dataAuditor1_TidakLuangRaw[$i]['pelaksana1_audit1']);
            $count[$dataAuditor1_TidakLuangRaw[$i]['pelaksana1_audit1']] =0;
                if($i != 0){
                    for( $j=$i-1;$j<count($dataAuditor1_TidakLuangRaw)-1;$j++) {

                        
    
    
                        if($dataAuditor1_TidakLuangRaw[$j]['pelaksana1_audit1'] == $dataAuditor1_TidakLuangRaw[$i]['pelaksana1_audit1'] ){
                            $count[$dataAuditor1_TidakLuangRaw[$i]['pelaksana1_audit1']]++;
                        }
                    }
                   
                    if( $count[$dataAuditor1_TidakLuangRaw[$i]['pelaksana1_audit1']] >= 2){
                        //$dataAuditor1_TidakLuang = $dataAuditor1_TidakLuangRaw[$i]
                        $dataAuditor1_TidakLuang[]= array('pelaksana1_audit1'=>$dataAuditor1_TidakLuangRaw[$i]['pelaksana1_audit1']);
                    }
                }      
           }

           $dataAuditor2_TidakLuang= json_decode($dataAuditor2_TidakLuang, true);
          
            
           
            // $str =  explode("_",$data['selected_pelaksana1']);
            // $data['selected_pelaksana1'] = $str[0];

            if($kodewilayah == 119){
               
                 
                
                if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL ){

                        $dataAuditor1 = DB::table('users')
                        ->where('usergroup_id','10')
                        ->orWhere('usergroup_id','11')
                        ->orWhere('usergroup_id','11')
                        ->pluck('id', 'name');   
                            
                }else{

                        
                    if($dataAuditor1_TidakLuang){    
                        if($dataAuditor2_TidakLuang){
                            foreach ( $dataAuditor1_TidakLuang as $key) {
                                foreach ( $dataAuditor2_TidakLuang as $key2) {


                                    $aud =  explode("_",$key['pelaksana1_audit1']);
                                    $key['pelaksana1_audit1'] =$aud[0];
                                    
                                    $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                    $key2['pelaksana1_audit2'] =$aud3[0];
                                    $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                    $key2['pelaksana2_audit2'] =$aud4[0];
                                    
                                    

                                    $dataAuditor1 = DB::table('users')
                                    ->where(function($query) use ($key,$key2){
                                            $query->where('usergroup_id','10')  ; 
                                            
                                            $query->where('id','!=',$key['pelaksana1_audit1']);                     
                                            $query->where('id','!=',$key2['pelaksana1_audit2']);
                                            $query->where('id','!=',$key2['pelaksana2_audit2']);
                                            

                                    })
                                    ->orWhere(function($query) use ($key,$key2){
                                        $query->where('usergroup_id','11')  ; 
                               
                                        $query->where('id','!=',$key['pelaksana1_audit1']);                     
                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                        

                                    })
                                    ->orWhere(function($query) use ($key,$key2){
                                        $query->where('usergroup_id','12')  ; 
                               
                                        $query->where('id','!=',$key['pelaksana1_audit1']);                     
                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                        

                                    })
                                
                                    
                                    ->pluck('id', 'name');   
                                    
                                }
                            }

                            
                        }else{
                            foreach ( $dataAuditor1_TidakLuang as $key) {

                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                $key['pelaksana1_audit1'] =$aud[0];
                             
                                
                                

                                $dataAuditor1 = DB::table('users')
                                ->where(function($query) use ($key){
                                        $query->where('usergroup_id','10')  ;  
                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                                            
                                })
                                ->orWhere(function($query) use ($key){
                                    $query->where('usergroup_id','11')  ;  
                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                                        
                                })
                                ->orWhere(function($query) use ($key){
                                        $query->where('usergroup_id','12')  ;  
                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                                            
                                }) 
                                ->pluck('id', 'name');   
                            }
                            
                        }      
                    }else{

                        foreach ( $dataAuditor2_TidakLuang as $key2) {

                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                            $key2['pelaksana1_audit2'] =$aud3[0];
                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                            $key2['pelaksana2_audit2'] =$aud4[0];
                            
                            
                            

                            $dataAuditor1 = DB::table('users')
                            ->where(function($query) use ($key2){
                                    $query->where('usergroup_id','10')  ;  
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                            ->orWhere(function($query) use ($key2){
                                    $query->where('usergroup_id','10')  ;  
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                            ->orWhere(function($query) use ($key2){
                                    $query->where('usergroup_id','10')  ;  
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                        
                            
                            ->pluck('id', 'name');   
                        }
                    }
                }          

               
            }else{

                //data kodewilayah selain pusat
                if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL ){

                        $dataAuditor1 = DB::table('users')
                        ->where(function($query) use ($kodewilayah){
                            $query->where('usergroup_id','10');
                            $query->where('kode_wilayah',$kodewilayah);
                        })
                        ->orWhere(function($query) use ($kodewilayah){
                            $query->where('usergroup_id','11');
                            $query->where('kode_wilayah',$kodewilayah);
                        })
                        ->orWhere(function($query) use ($kodewilayah){
                            $query->where('usergroup_id','12');
                            $query->where('kode_wilayah',$kodewilayah);
                        })
                            


                        ->pluck('id', 'name');   
                            
                }else{

                        
                    if($dataAuditor1_TidakLuang){    
                        if($dataAuditor2_TidakLuang){
                            foreach ( $dataAuditor1_TidakLuang as $key) {
                                foreach ( $dataAuditor2_TidakLuang as $key2) {


                                    $aud =  explode("_",$key['pelaksana1_audit1']);
                                    $key['pelaksana1_audit1'] =$aud[0];
                                    
                                    $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                    $key2['pelaksana1_audit2'] =$aud3[0];
                                    $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                    $key2['pelaksana2_audit2'] =$aud4[0];
                                    
                                    

                                    $dataAuditor1 = DB::table('users')
                                    ->where(function($query) use ($key,$key2,$kodewilayah){
                                            $query->where('usergroup_id','10')  ; 
                                            $query->where('kode_wilayah',$kodewilayah);
                                            $query->where('id','!=',$key['pelaksana1_audit1']);                     
                                            $query->where('id','!=',$key2['pelaksana1_audit2']);
                                            $query->where('id','!=',$key2['pelaksana2_audit2']);
                                            

                                    })
                                    ->orWhere(function($query) use ($key,$key2,$kodewilayah){
                                        $query->where('usergroup_id','11')  ; 
                                        $query->where('kode_wilayah',$kodewilayah);
                                        $query->where('id','!=',$key['pelaksana1_audit1']);                     
                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                        

                                    })
                                    ->orWhere(function($query) use ($key,$key2,$kodewilayah){
                                        $query->where('usergroup_id','12')  ; 
                                        $query->where('kode_wilayah',$kodewilayah);
                                        $query->where('id','!=',$key['pelaksana1_audit1']);                     
                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                        

                                    })
                                
                                    
                                    ->pluck('id', 'name');   
                                    
                                }
                            }

                            
                        }else{
                            foreach ( $dataAuditor1_TidakLuang as $key) {

                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                $key['pelaksana1_audit1'] =$aud[0];
                             
                                
                                

                                $dataAuditor1 = DB::table('users')
                                ->where(function($query) use ($key,$kodewilayah){
                                        $query->where('usergroup_id','10')  ; 
                                        $query->where('kode_wilayah',$kodewilayah); 
                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                                            
                                })
                                ->orWhere(function($query) use ($key,$kodewilayah){
                                    $query->where('usergroup_id','11')  ; 
                                    $query->where('kode_wilayah',$kodewilayah); 
                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                                        
                                })
                                ->orWhere(function($query) use ($key,$kodewilayah){
                                        $query->where('usergroup_id','12')  ; 
                                        $query->where('kode_wilayah',$kodewilayah); 
                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                                            
                                }) 
                                ->pluck('id', 'name');   
                            }
                            
                        }      
                    }else{

                        foreach ( $dataAuditor2_TidakLuang as $key2) {

                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                            $key2['pelaksana1_audit2'] =$aud3[0];
                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                            $key2['pelaksana2_audit2'] =$aud4[0];
                            
                            
                            

                            $dataAuditor1 = DB::table('users')
                            ->where(function($query) use ($key2,$kodewilayah){
                                    $query->where('usergroup_id','10')  ; 
                                    $query->where('kode_wilayah',$kodewilayah); 
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                            ->orWhere(function($query) use ($key2,$kodewilayah){
                                    $query->where('usergroup_id','10')  ;  
                                    $query->where('kode_wilayah',$kodewilayah);
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                            ->orWhere(function($query) use ($key2,$kodewilayah){
                                    $query->where('usergroup_id','10')  ;  
                                    $query->where('kode_wilayah',$kodewilayah);
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                        
                            
                            ->pluck('id', 'name');   
                        }
                    }
                }       
               

            }
            
            //Log::info('ini data auditor: '.$dataAuditor1);
            return response()->json($dataAuditor1);
        }
    }



    public function jenisAkomodasi(Request $request)
    {
        $dataJenisAkomodasi =  DB::table('jenis_akomodasi')
                           
                             ->pluck('id', 'jenis_akomodasi');   

        return response()->json( $dataJenisAkomodasi);
    }

    public function opsiAkomodasi(Request $request)
    {
        
        $data = $request->except('_token','_method');

        if($data['jenis'] == 1){
            $dataOpsiAkomodasi = DB::table('detail_transportasi_darat')    
                                ->pluck('id', 'transportasi_darat as opsi_akomodasi');   

        }elseif($data['jenis'] == 2){
            $dataOpsiAkomodasi = DB::table('detail_transportasi_laut')    
                                ->pluck('id', 'transportasi_laut as opsi_akomodasi');  

        }elseif($data['jenis'] == 3){
             $dataOpsiAkomodasi = DB::table('detail_transportasi_udara')    
                                ->pluck('id', 'transportasi_udara as opsi_akomodasi');   

        }elseif($data['jenis'] == 4){
            $dataOpsiAkomodasi= DB::table('detail_penginapan')    
                                ->pluck('id', 'penginapan as opsi_akomodasi');   
        }
       

        return response()->json( $dataOpsiAkomodasi);
    }


    public function dataAuditor2(Request $request)
    {

        $data = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;

        if($data['mulai'] && $data['selesai']){
                $dataAuditor1_TidakLuang =  DB::table('penjadwalan')
                                        ->where(function($query) use ($data){
                                            $query->where('mulai_audit1','<=', $data['mulai']);
                                            $query->where('selesai_audit1','>=', $data['mulai']);
                                            
                                           
                                        })
                                        ->orWhere(function($query) use ($data){
                                            $query->where('mulai_audit1','>=', $data['mulai']);
                                            $query->where('mulai_audit1','<=', $data['selesai']);
                                           
                                           
                                           
                                        })
                                       
                                        /*->get();*/
                                       ->select('pelaksana1_audit1','pelaksana2_audit1')
                                        ->get();

                $dataAuditor2_TidakLuang =  DB::table('penjadwalan')
                                        
                                        ->where(function($query) use ($data){
                                            $query->where('mulai_audit2','<=', $data['mulai']);
                                            $query->where('selesai_audit2','>=', $data['mulai']);
                                            $query->where('id_registrasi','!=', $data['id_regis']);
                                           
                                        })
                                        ->orWhere(function($query) use ($data){
                                            $query->where('mulai_audit2','>=', $data['mulai']);
                                            $query->where('mulai_audit2','<=', $data['selesai']);
                                            $query->where('id_registrasi','!=', $data['id_regis']);
                                          
                                        })
                                        
                                        /*->get();*/
                                       ->select('pelaksana1_audit2','pelaksana2_audit2')
                                        ->get();

                $dataAuditor3_TidakLuang =  DB::table('penjadwalan')
                                        
                                        ->where(function($query) use ($data){
                                            $query->where('mulai_tr','<=', $data['mulai']);
                                            $query->where('selesai_tr','>=', $data['mulai']);
                                            //$query->where('id_registrasi','!=', $data['id_regis']);
                                           
                                        })
                                        ->orWhere(function($query) use ($data){
                                            $query->where('mulai_tr','>=', $data['mulai']);
                                            $query->where('mulai_tr','<=', $data['selesai']);
                                            //$query->where('id_registrasi','!=', $data['id_regis']);
                                          
                                        })
                                        
                                        /*->get();*/
                                       ->select('pelaksana1_tr','pelaksana2_tr','pelaksana3_tr')
                                        ->get();
                                       
                                     
                                        
            
           
          
            $dataAuditor1_TidakLuang= json_decode($dataAuditor1_TidakLuang, true);
            $dataAuditor2_TidakLuang= json_decode($dataAuditor2_TidakLuang, true);
            $dataAuditor3_TidakLuang= json_decode($dataAuditor3_TidakLuang, true);
            
           
            $str =  explode("_",$data['selected_pelaksana1']);
            $data['selected_pelaksana1'] = $str[0];

            if($kodewilayah == 00){

                if($data['selected_pelaksana1'] == ''){
                 
                
                    if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL && $dataAuditor3_TidakLuang  == NULL){

                           $dataAuditor2 = DB::table('users')
                            ->where('usergroup_id','10')  
                            ->pluck('id', 'name');   
                             
                    }else{

                         
                        if($dataAuditor1_TidakLuang){    
                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ( $dataAuditor3_TidakLuang as $key3) {

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key2,$key3){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                        $query->where('id','!=',$key3['pelaksana1_tr']);
                                                        $query->where('id','!=',$key3['pelaksana2_tr']);
                                                        $query->where('id','!=',$key3['pelaksana3_tr']);

                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                           
                                          

                                            $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$key2){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }
                                }  
                            }else{

                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                         foreach ( $dataAuditor3_TidakLuang as $key3) {

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                            $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                            $key3['pelaksana1_tr'] =$aud5[0];
                                            $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                            $key3['pelaksana2_tr'] =$aud6[0];
                                            $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                            $key3['pelaksana3_tr'] =$aud7[0];
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$key3){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {

                                        $aud =  explode("_",$key['pelaksana1_audit1']);
                                        $key['pelaksana1_audit1'] =$aud[0];
                                        $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                        $key['pelaksana2_audit1'] =$aud2[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key['pelaksana1_audit1']);
                                                $query->where('id','!=',$key['pelaksana2_audit1']);
                                               
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }

                                }
                            }      
                        }else{

                             if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {

                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                            $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                            $key3['pelaksana1_tr'] =$aud5[0];
                                            $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                            $key3['pelaksana2_tr'] =$aud6[0];
                                            $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                            $key3['pelaksana3_tr'] =$aud7[0];
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key2,$key3){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');  
                                        } 
                                    }


                                }else{

                                    foreach ( $dataAuditor2_TidakLuang as $key2) {

                                        $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                        $key2['pelaksana1_audit2'] =$aud3[0];
                                        $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                        $key2['pelaksana2_audit2'] =$aud4[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key2){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                $query->where('id','!=',$key2['pelaksana2_audit2']);
                                               
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }
                                }
                             }else{

                                 foreach ( $dataAuditor3_TidakLuang as $key3) {

                                        $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                        $key3['pelaksana1_tr'] =$aud5[0];
                                        $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                        $key3['pelaksana2_tr'] =$aud6[0];
                                        $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                        $key3['pelaksana3_tr'] =$aud7[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key3){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key3['pelaksana1_tr']);
                                                $query->where('id','!=',$key3['pelaksana2_tr']);
                                                $query->where('id','!=',$key3['pelaksana3_tr']);
                                               
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }

                             }

                        }
                        
                    } 

                }else{
                    // Log::info('masuk ');

                   if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL && $dataAuditor3_TidakLuang  == NULL){

                           $dataAuditor2 = DB::table('users')
                            ->where('usergroup_id','10')  
                            ->where('id','!=',$data['selected_pelaksana1'])
                            ->pluck('id', 'name');   
                             
                    }else{

                         
                        if($dataAuditor1_TidakLuang){    
                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ( $dataAuditor3_TidakLuang as $key3) {

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key2,$key3, $data){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                        $query->where('id','!=',$key3['pelaksana1_tr']);
                                                        $query->where('id','!=',$key3['pelaksana2_tr']);
                                                        $query->where('id','!=',$key3['pelaksana3_tr']);
                                                        $query->where('id','!=',$data['selected_pelaksana1']);

                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                           
                                          

                                            $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$key2,$data){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }
                                }  
                            }else{

                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                         foreach ( $dataAuditor3_TidakLuang as $key3) {

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                            $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                            $key3['pelaksana1_tr'] =$aud5[0];
                                            $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                            $key3['pelaksana2_tr'] =$aud6[0];
                                            $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                            $key3['pelaksana3_tr'] =$aud7[0];
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$key3,$data){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {

                                        $aud =  explode("_",$key['pelaksana1_audit1']);
                                        $key['pelaksana1_audit1'] =$aud[0];
                                        $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                        $key['pelaksana2_audit1'] =$aud2[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key,$key2,$key3,$data){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key['pelaksana1_audit1']);
                                                $query->where('id','!=',$key['pelaksana2_audit1']);
                                                $query->where('id','!=',$data['selected_pelaksana1']);
                                               
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }

                                }
                            }      
                        }else{

                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {

                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                            $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                            $key3['pelaksana1_tr'] =$aud5[0];
                                            $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                            $key3['pelaksana2_tr'] =$aud6[0];
                                            $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                            $key3['pelaksana3_tr'] =$aud7[0];
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key2,$key3,$data){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');  
                                        } 
                                    }


                                }else{

                                    foreach ( $dataAuditor2_TidakLuang as $key2) {

                                        $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                        $key2['pelaksana1_audit2'] =$aud3[0];
                                        $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                        $key2['pelaksana2_audit2'] =$aud4[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key2,$data){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                $query->where('id','!=',$data['selected_pelaksana1']);
                                               
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }
                                }
                            }else{

                                 foreach ( $dataAuditor3_TidakLuang as $key3) {
                                    
                                        $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                        $key3['pelaksana1_tr'] =$aud5[0];
                                        $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                        $key3['pelaksana2_tr'] =$aud6[0];
                                        $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                        $key3['pelaksana3_tr'] =$aud7[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key3,$data){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key3['pelaksana1_tr']);
                                                $query->where('id','!=',$key3['pelaksana2_tr']);
                                                $query->where('id','!=',$key3['pelaksana3_tr']);
                                                $query->where('id','!=',$data['selected_pelaksana1']);
                                               
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }

                            }

                        }
                        
                    }
                }

            }else{

                //kodewilayah selain 00 pusat

                if($data['selected_pelaksana1'] == ''){
                 
                
                    if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL && $dataAuditor3_TidakLuang  == NULL){

                           $dataAuditor2 = DB::table('users')
                            ->where('usergroup_id','10')  
                            ->where('kode_wilayah',$kodewilayah)  
                            ->pluck('id', 'name');   
                             
                    }else{

                         
                        if($dataAuditor1_TidakLuang){    
                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ( $dataAuditor3_TidakLuang as $key3) {

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key2,$key3,$kodewilayah){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                        $query->where('id','!=',$key3['pelaksana1_tr']);
                                                        $query->where('id','!=',$key3['pelaksana2_tr']);
                                                        $query->where('id','!=',$key3['pelaksana3_tr']);
                                                        $query->where('kode_wilayah',$kodewilayah);

                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                           
                                          

                                            $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$key2,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('kode_wilayah',$kodewilayah);
                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }
                                }  
                            }else{

                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                         foreach ( $dataAuditor3_TidakLuang as $key3) {

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                            $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                            $key3['pelaksana1_tr'] =$aud5[0];
                                            $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                            $key3['pelaksana2_tr'] =$aud6[0];
                                            $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                            $key3['pelaksana3_tr'] =$aud7[0];
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$key3,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('kode_wilayah',$kodewilayah);

                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {

                                        $aud =  explode("_",$key['pelaksana1_audit1']);
                                        $key['pelaksana1_audit1'] =$aud[0];
                                        $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                        $key['pelaksana2_audit1'] =$aud2[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key,$kodewilayah){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key['pelaksana1_audit1']);
                                                $query->where('id','!=',$key['pelaksana2_audit1']);
                                                $query->where('kode_wilayah',$kodewilayah);
                                                    
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }

                                }
                            }      
                        }else{

                             if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {

                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                            $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                            $key3['pelaksana1_tr'] =$aud5[0];
                                            $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                            $key3['pelaksana2_tr'] =$aud6[0];
                                            $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                            $key3['pelaksana3_tr'] =$aud7[0];
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key2,$key3,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('kode_wilayah',$kodewilayah);
                                                    
                                                })
                                     
                                         
                                            ->pluck('id', 'name');  
                                        } 
                                    }


                                }else{

                                    foreach ( $dataAuditor2_TidakLuang as $key2) {

                                        $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                        $key2['pelaksana1_audit2'] =$aud3[0];
                                        $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                        $key2['pelaksana2_audit2'] =$aud4[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key2,$kodewilayah){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                $query->where('kode_wilayah',$kodewilayah);
                                                    
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }
                                }
                             }else{

                                 foreach ( $dataAuditor3_TidakLuang as $key3) {

                                        $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                        $key3['pelaksana1_tr'] =$aud5[0];
                                        $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                        $key3['pelaksana2_tr'] =$aud6[0];
                                        $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                        $key3['pelaksana3_tr'] =$aud7[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key3,$kodewilayah){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key3['pelaksana1_tr']);
                                                $query->where('id','!=',$key3['pelaksana2_tr']);
                                                $query->where('id','!=',$key3['pelaksana3_tr']);
                                                $query->where('kode_wilayah',$kodewilayah);
                                                    
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }

                             }

                        }
                        
                    } 

                }else{
                    // Log::info('masuk ');

                   if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL && $dataAuditor3_TidakLuang  == NULL){

                           $dataAuditor2 = DB::table('users')
                            ->where('usergroup_id','10') 
                            ->where('kode_wilayah',$kodewilayah)  
                            ->where('id','!=',$data['selected_pelaksana1'])
                            ->pluck('id', 'name');   
                             
                    }else{

                         
                        if($dataAuditor1_TidakLuang){    
                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ( $dataAuditor3_TidakLuang as $key3) {

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key2,$key3, $data,$kodewilayah){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                        $query->where('id','!=',$key3['pelaksana1_tr']);
                                                        $query->where('id','!=',$key3['pelaksana2_tr']);
                                                        $query->where('id','!=',$key3['pelaksana3_tr']);
                                                        $query->where('id','!=',$data['selected_pelaksana1']);
                                                        $query->where('kode_wilayah',$kodewilayah);
                                                    

                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                           
                                          

                                            $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$key2,$data,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                                    $query->where('kode_wilayah',$kodewilayah);
                                                    
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }
                                }  
                            }else{

                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                         foreach ( $dataAuditor3_TidakLuang as $key3) {

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                            $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                            $key3['pelaksana1_tr'] =$aud5[0];
                                            $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                            $key3['pelaksana2_tr'] =$aud6[0];
                                            $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                            $key3['pelaksana3_tr'] =$aud7[0];
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$key3,$data,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                                    $query->where('kode_wilayah',$kodewilayah);
                                                    
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {

                                        $aud =  explode("_",$key['pelaksana1_audit1']);
                                        $key['pelaksana1_audit1'] =$aud[0];
                                        $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                        $key['pelaksana2_audit1'] =$aud2[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key,$key2,$key3,$data,$kodewilayah){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key['pelaksana1_audit1']);
                                                $query->where('id','!=',$key['pelaksana2_audit1']);
                                                $query->where('id','!=',$data['selected_pelaksana1']);
                                                $query->where('kode_wilayah',$kodewilayah);
                                                    
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }

                                }
                            }      
                        }else{

                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {

                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                            $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                            $key3['pelaksana1_tr'] =$aud5[0];
                                            $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                            $key3['pelaksana2_tr'] =$aud6[0];
                                            $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                            $key3['pelaksana3_tr'] =$aud7[0];
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key2,$key3,$data,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                                    $query->where('kode_wilayah',$kodewilayah);
                                                    
                                                })
                                     
                                         
                                            ->pluck('id', 'name');  
                                        } 
                                    }


                                }else{

                                    foreach ( $dataAuditor2_TidakLuang as $key2) {

                                        $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                        $key2['pelaksana1_audit2'] =$aud3[0];
                                        $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                        $key2['pelaksana2_audit2'] =$aud4[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key2,$data,$kodewilayah){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                $query->where('id','!=',$data['selected_pelaksana1']);
                                                $query->where('kode_wilayah',$kodewilayah);
                                                    
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }
                                }

                            }else{

                                foreach ( $dataAuditor3_TidakLuang as $key3) {
                                    
                                    $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                    $key3['pelaksana1_tr'] =$aud5[0];
                                    $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                    $key3['pelaksana2_tr'] =$aud6[0];
                                    $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                    $key3['pelaksana3_tr'] =$aud7[0];
                                   
                                   
                                  

                                   $dataAuditor2 = DB::table('users')
                                    ->where(function($query) use ($key3,$data,$kodewilayah){
                                            $query->where('usergroup_id','10')  ;  
                                            $query->where('id','!=',$key3['pelaksana1_tr']);
                                            $query->where('id','!=',$key3['pelaksana2_tr']);
                                            $query->where('id','!=',$key3['pelaksana3_tr']);
                                            $query->where('id','!=',$data['selected_pelaksana1']);
                                            $query->where('kode_wilayah',$kodewilayah);
                                                    
                                           
                                        })
                             
                                 
                                    ->pluck('id', 'name');   
                                }

                            }
                        }      
                    }
                }
            }

            
            
            //Log::info('ini data auditor: '.$dataAuditor1);
            return response()->json($dataAuditor2);
        }
    }


    public function dataDDTehnicalReview(Request $request)
    {

        $data = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
      
        if($data['mulai'] && $data['selesai']){
            $dataAuditor1_TidakLuang =  DB::table('penjadwalan')
                                        ->where(function($query) use ($data){
                                            $query->where('mulai_audit1','<=', $data['mulai']);
                                            $query->where('selesai_audit1','>=', $data['mulai']);
                                            
                                           
                                        })
                                        ->orWhere(function($query) use ($data){
                                            $query->where('mulai_audit1','>=', $data['mulai']);
                                            $query->where('mulai_audit1','<=', $data['selesai']);
                                           
                                           
                                           
                                        })
                                       
                                        /*->get();*/
                                       ->select('pelaksana1_audit1','pelaksana2_audit1')
                                        ->get();

            $dataAuditor2_TidakLuang =  DB::table('penjadwalan')
                                    
                                    ->where(function($query) use ($data){
                                        $query->where('mulai_audit2','<=', $data['mulai']);
                                        $query->where('selesai_audit2','>=', $data['mulai']);
                                        //$query->where('id_registrasi','!=', $data['id_regis']);
                                       
                                    })
                                    ->orWhere(function($query) use ($data){
                                        $query->where('mulai_audit2','>=', $data['mulai']);
                                        $query->where('mulai_audit2','<=', $data['selesai']);
                                        
                                      
                                    })
                                    
                                    /*->get();*/
                                   ->select('pelaksana1_audit2','pelaksana2_audit2')
                                    ->get();

            $dataAuditor3_TidakLuang =  DB::table('penjadwalan')
                                    
                                    ->where(function($query) use ($data){
                                        $query->where('mulai_tr','<=', $data['mulai']);
                                        $query->where('selesai_tr','>=', $data['mulai']);
                                        $query->where('id_registrasi','!=', $data['id_regis']);
                                       
                                    })
                                    ->orWhere(function($query) use ($data){
                                        $query->where('mulai_tr','>=', $data['mulai']);
                                        $query->where('mulai_tr','<=', $data['selesai']);
                                        $query->where('id_registrasi','!=', $data['id_regis']);
                                      
                                    })
                                    
                                    /*->get();*/
                                   ->select('pelaksana1_tr','pelaksana2_tr','pelaksana3_tr')
                                    ->get();
            

            $dataAuditor_sudahTerpilih =  DB::table('penjadwalan')
                                        ->where('id_registrasi', $data['id_regis'])
                                        ->select('pelaksana1_audit1','pelaksana2_audit1','pelaksana1_audit2','pelaksana2_audit2') 
                                        ->get();
                                           
                                           
            $dataAuditor1_TidakLuang= json_decode($dataAuditor1_TidakLuang, true);
            $dataAuditor2_TidakLuang= json_decode($dataAuditor2_TidakLuang, true);
            $dataAuditor3_TidakLuang= json_decode($dataAuditor3_TidakLuang, true);
            $dataAuditor_sudahTerpilih= json_decode($dataAuditor_sudahTerpilih, true);

            $str =  explode("_",$data['selected_pelaksana1']);
            $data['selected_pelaksana1'] = $str[0];
            $str2 =  explode("_",$data['selected_pelaksana2']);
            $data['selected_pelaksana2'] = $str2[0];

            if($kodewilayah == 0){
                if($data['selected_pelaksana1'] == ''){

                
                
                    if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL && $dataAuditor3_TidakLuang  == NULL){

                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                $key4['pelaksana1_audit1'] = $str3[0];
                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                $key4['pelaksana2_audit1'] = $str4[0];

                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                $key4['pelaksana1_audit2'] = $str5[0];
                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                $key4['pelaksana2_audit2'] = $str6[0];
                                $dataAuditor2 = DB::table('users')
                                ->where('usergroup_id','10')  
                                ->where('id','!=',$key4['pelaksana1_audit1'])
                                ->where('id','!=',$key4['pelaksana2_audit1'])
                                ->where('id','!=',$key4['pelaksana1_audit2'])
                                ->where('id','!=',$key4['pelaksana2_audit2'])
                                                           
                                ->pluck('id', 'name');   
                            }
                             
                    }else{     
                        if($dataAuditor1_TidakLuang){    
                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ( $dataAuditor3_TidakLuang as $key3) {
                                                foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                    $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                    $key4['pelaksana1_audit1'] = $str3[0];
                                                    $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                    $key4['pelaksana2_audit1'] = $str4[0];

                                                    $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                    $key4['pelaksana1_audit2'] = $str5[0];
                                                    $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                    $key4['pelaksana2_audit2'] = $str6[0];

                                                    $aud =  explode("_",$key['pelaksana1_audit1']);
                                                    $key['pelaksana1_audit1'] =$aud[0];
                                                    $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                    $key['pelaksana2_audit1'] =$aud2[0];
                                                    $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                    $key2['pelaksana1_audit2'] =$aud3[0];
                                                    $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                    $key2['pelaksana2_audit2'] =$aud4[0];
                                                    $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                    $key3['pelaksana1_tr'] =$aud5[0];
                                                    $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                    $key3['pelaksana2_tr'] =$aud6[0];
                                                    $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                    $key3['pelaksana3_tr'] =$aud7[0];
                                                  

                                                    $dataAuditor2 = DB::table('users')
                                                    ->where(function($query) use ($key,$key2,$key3, $key4){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                        $query->where('id','!=',$key3['pelaksana1_tr']);
                                                        $query->where('id','!=',$key3['pelaksana2_tr']);
                                                        $query->where('id','!=',$key3['pelaksana3_tr']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);

                                                    })
                                             
                                                 
                                                    ->pluck('id', 'name');   
                                                }     
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];


                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                           
                                          

                                                $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key2, $key4){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                       
                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }
                                }  
                            }else{

                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                               
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key3, $key4){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                   
                                                   
                                                })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                           
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key, $key4){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key['pelaksana1_audit1']);
                                                $query->where('id','!=',$key['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                   

                                               
                                               
                                            })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }
                                }
                            }

                        }else{

                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                               
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key2,$key3, $key4){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                   
                                                })
                                         
                                             
                                                ->pluck('id', 'name');  
                                            }
                                        } 
                                    }


                                }else{

                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                           
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key2, $key4){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                $query->where('id','!=',$key2['pelaksana2_audit2']);

                                                $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                   
                                               
                                               
                                            })
                                     
                                         
                                            ->pluck('id', 'name'); 
                                        }  
                                    }
                                }
                            }else{

                                foreach ( $dataAuditor3_TidakLuang as $key3) {
                                    foreach ($dataAuditor_sudahTerpilih as $key4) {
                                        $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                        $key4['pelaksana1_audit1'] = $str3[0];
                                        $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                        $key4['pelaksana2_audit1'] = $str4[0];

                                        $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                        $key4['pelaksana1_audit2'] = $str5[0];
                                        $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                        $key4['pelaksana2_audit2'] = $str6[0];

                                        $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                        $key3['pelaksana1_tr'] =$aud5[0];
                                        $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                        $key3['pelaksana2_tr'] =$aud6[0];
                                        $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                        $key3['pelaksana3_tr'] =$aud7[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key3, $key4){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key3['pelaksana1_tr']);
                                                $query->where('id','!=',$key3['pelaksana2_tr']);
                                                $query->where('id','!=',$key3['pelaksana3_tr']);
                                                $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                   
                                               
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }
                                }
                            }
                        }
                    }      

                }else if($data['selected_pelaksana1'] != '' && $data['selected_pelaksana2']==''){

                    if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL && $dataAuditor3_TidakLuang  == NULL){

                           foreach ($dataAuditor_sudahTerpilih as $key4) {
                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                $key4['pelaksana1_audit1'] = $str3[0];
                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                $key4['pelaksana2_audit1'] = $str4[0];

                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                $key4['pelaksana1_audit2'] = $str5[0];
                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                $key4['pelaksana2_audit2'] = $str6[0];

                                $dataAuditor2 = DB::table('users')
                                ->where('usergroup_id','10')  
                                ->where('id','!=',$data['selected_pelaksana1'])
                                ->where('id','!=',$key4['pelaksana1_audit1'])
                                ->where('id','!=',$key4['pelaksana2_audit1'])
                                ->where('id','!=',$key4['pelaksana1_audit2'])
                                ->where('id','!=',$key4['pelaksana2_audit2'])
                                                           
                                ->pluck('id', 'name');   
                            }
                             
                    }else{

                         
                        if($dataAuditor1_TidakLuang){    
                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ( $dataAuditor3_TidakLuang as $key3) {
                                                foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                    $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                    $key4['pelaksana1_audit1'] = $str3[0];
                                                    $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                    $key4['pelaksana2_audit1'] = $str4[0];

                                                    $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                    $key4['pelaksana1_audit2'] = $str5[0];
                                                    $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                    $key4['pelaksana2_audit2'] = $str6[0];

                                                    $aud =  explode("_",$key['pelaksana1_audit1']);
                                                    $key['pelaksana1_audit1'] =$aud[0];
                                                    $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                    $key['pelaksana2_audit1'] =$aud2[0];
                                                    $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                    $key2['pelaksana1_audit2'] =$aud3[0];
                                                    $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                    $key2['pelaksana2_audit2'] =$aud4[0];
                                                    $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                    $key3['pelaksana1_tr'] =$aud5[0];
                                                    $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                    $key3['pelaksana2_tr'] =$aud6[0];
                                                    $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                    $key3['pelaksana3_tr'] =$aud7[0];
                                                  

                                                   $dataAuditor2 = DB::table('users')
                                                    ->where(function($query) use ($key,$key2,$key3, $data,$key4){
                                                            $query->where('usergroup_id','10')  ;  
                                                            $query->where('id','!=',$key['pelaksana1_audit1']);
                                                            $query->where('id','!=',$key['pelaksana2_audit1']);
                                                            $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                            $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                            $query->where('id','!=',$key3['pelaksana1_tr']);
                                                            $query->where('id','!=',$key3['pelaksana2_tr']);
                                                            $query->where('id','!=',$key3['pelaksana3_tr']);
                                                            $query->where('id','!=',$data['selected_pelaksana1']);


                                                            $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                            $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                            $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                            $query->where('id','!=',$key4['pelaksana2_audit2']);

                                                        })
                                             
                                                 
                                                    ->pluck('id', 'name');   
                                                }
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                               
                                              

                                                $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key2,$data,$key4){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                        $query->where('id','!=',$data['selected_pelaksana1']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                       
                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }
                                }  
                            }else{

                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                         foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                           
                                          

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key3,$data,$key4){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key3['pelaksana1_tr']);
                                                        $query->where('id','!=',$key3['pelaksana2_tr']);
                                                        $query->where('id','!=',$key3['pelaksana3_tr']);
                                                        $query->where('id','!=',$data['selected_pelaksana1']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                       
                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                           
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$data,$key4){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);

                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                   
                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }

                                }
                            }      
                        }else{

                             if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                               
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key2,$key3,$data,$key4){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);

                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                   
                                                })
                                     
                                             
                                                ->pluck('id', 'name');  
                                            }
                                        } 
                                    }


                                }else{

                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                       
                                       
                                      

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key2,$data,$key4){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                   
                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }
                                }
                             }else{

                                foreach ( $dataAuditor3_TidakLuang as $key3) {
                                    foreach ($dataAuditor_sudahTerpilih as $key4) {
                                        $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                        $key4['pelaksana1_audit1'] = $str3[0];
                                        $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                        $key4['pelaksana2_audit1'] = $str4[0];

                                        $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                        $key4['pelaksana1_audit2'] = $str5[0];
                                        $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                        $key4['pelaksana2_audit2'] = $str6[0];
                                    
                                        $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                        $key3['pelaksana1_tr'] =$aud5[0];
                                        $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                        $key3['pelaksana2_tr'] =$aud6[0];
                                        $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                        $key3['pelaksana3_tr'] =$aud7[0];
                                       
                                       
                                      

                                        $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key3,$data,$key4){
                                            $query->where('usergroup_id','10')  ;  
                                            $query->where('id','!=',$key3['pelaksana1_tr']);
                                            $query->where('id','!=',$key3['pelaksana2_tr']);
                                            $query->where('id','!=',$key3['pelaksana3_tr']);
                                            $query->where('id','!=',$data['selected_pelaksana1']);
                                            $query->where('id','!=',$key4['pelaksana1_audit1']);
                                            $query->where('id','!=',$key4['pelaksana2_audit1']);
                                            $query->where('id','!=',$key4['pelaksana1_audit2']);
                                            $query->where('id','!=',$key4['pelaksana2_audit2']);
                                           
                                        })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }
                                }

                             }

                        }
                        
                    }


                    
                }else if($data['selected_pelaksana1'] != '' && $data['selected_pelaksana2'] !=''){

                    if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL && $dataAuditor3_TidakLuang  == NULL){

                        foreach ($dataAuditor_sudahTerpilih as $key4) {

                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                            $key4['pelaksana1_audit1'] = $str3[0];
                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                            $key4['pelaksana2_audit1'] = $str4[0];

                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                            $key4['pelaksana1_audit2'] = $str5[0];
                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                            $key4['pelaksana2_audit2'] = $str6[0];

                           $dataAuditor2 = DB::table('users')
                            ->where('usergroup_id','10')  
                            ->where('id','!=',$key4['pelaksana1_audit1'])
                            ->where('id','!=',$key4['pelaksana2_audit1'])
                            ->where('id','!=',$key4['pelaksana1_audit2'])
                            ->where('id','!=',$key4['pelaksana2_audit2'])
                            ->where('id','!=',$data['selected_pelaksana1'])
                            ->where('id','!=',$data['selected_pelaksana2'])
                            ->pluck('id', 'name');  
                        } 
                             
                    }else{

                         
                        if($dataAuditor1_TidakLuang){    
                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ( $dataAuditor3_TidakLuang as $key3) {
                                                foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                    $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                    $key4['pelaksana1_audit1'] = $str3[0];
                                                    $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                    $key4['pelaksana2_audit1'] = $str4[0];

                                                    $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                    $key4['pelaksana1_audit2'] = $str5[0];
                                                    $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                    $key4['pelaksana2_audit2'] = $str6[0];

                                                    $aud =  explode("_",$key['pelaksana1_audit1']);
                                                    $key['pelaksana1_audit1'] =$aud[0];
                                                    $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                    $key['pelaksana2_audit1'] =$aud2[0];
                                                    $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                    $key2['pelaksana1_audit2'] =$aud3[0];
                                                    $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                    $key2['pelaksana2_audit2'] =$aud4[0];
                                                    $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                    $key3['pelaksana1_tr'] =$aud5[0];
                                                    $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                    $key3['pelaksana2_tr'] =$aud6[0];
                                                    $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                    $key3['pelaksana3_tr'] =$aud7[0];
                                                  

                                                   $dataAuditor2 = DB::table('users')
                                                    ->where(function($query) use ($key,$key2,$key3, $data,$key4){
                                                            $query->where('usergroup_id','10')  ;  
                                                            $query->where('id','!=',$key['pelaksana1_audit1']);
                                                            $query->where('id','!=',$key['pelaksana2_audit1']);
                                                            $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                            $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                            $query->where('id','!=',$key3['pelaksana1_tr']);
                                                            $query->where('id','!=',$key3['pelaksana2_tr']);
                                                            $query->where('id','!=',$key3['pelaksana3_tr']);
                                                            $query->where('id','!=',$data['selected_pelaksana1']);
                                                            $query->where('id','!=',$data['selected_pelaksana2']);

                                                            $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                            $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                            $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                            $query->where('id','!=',$key4['pelaksana2_audit2']);

                                                        })
                                             
                                                 
                                                    ->pluck('id', 'name');   
                                                }
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                               
                                              

                                                $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key2,$data,$key4){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                        $query->where('id','!=',$data['selected_pelaksana1']);
                                                        $query->where('id','!=',$data['selected_pelaksana2']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                       
                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }
                                }  
                            }else{

                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                         foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                               
                                              

                                                $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key3,$data,$key4){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key3['pelaksana1_tr']);
                                                        $query->where('id','!=',$key3['pelaksana2_tr']);
                                                        $query->where('id','!=',$key3['pelaksana3_tr']);
                                                        $query->where('id','!=',$data['selected_pelaksana1']);
                                                        $query->where('id','!=',$data['selected_pelaksana2']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                       
                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                           
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$data,$key4){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key['pelaksana1_audit1']);
                                                $query->where('id','!=',$key['pelaksana2_audit1']);
                                                $query->where('id','!=',$data['selected_pelaksana1']);
                                                $query->where('id','!=',$data['selected_pelaksana2']);

                                                $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                $query->where('id','!=',$key4['pelaksana2_audit2']);
                                               
                                               
                                            })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }

                                }
                            }      
                        }else{

                             if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                               
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key2,$key3,$data,$key4){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                                    $query->where('id','!=',$data['selected_pelaksana2']);


                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                               
                                                   
                                                })
                                         
                                             
                                                ->pluck('id', 'name');  
                                            }
                                        } 
                                    }


                                }else{

                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                       
                                       
                                      

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key2,$data,$key4){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                $query->where('id','!=',$data['selected_pelaksana1']);
                                                $query->where('id','!=',$data['selected_pelaksana2']);


                                                $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                $query->where('id','!=',$key4['pelaksana2_audit2']);
                                               
                                               
                                               
                                            })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }
                                }
                             }else{

                                 foreach ( $dataAuditor3_TidakLuang as $key3) {
                                    foreach ($dataAuditor_sudahTerpilih as $key4) {
                                        $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                        $key4['pelaksana1_audit1'] = $str3[0];
                                        $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                        $key4['pelaksana2_audit1'] = $str4[0];

                                        $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                        $key4['pelaksana1_audit2'] = $str5[0];
                                        $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                        $key4['pelaksana2_audit2'] = $str6[0];
                                    
                                        $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                        $key3['pelaksana1_tr'] =$aud5[0];
                                        $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                        $key3['pelaksana2_tr'] =$aud6[0];
                                        $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                        $key3['pelaksana3_tr'] =$aud7[0];
                                       
                                       
                                      

                                        $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key3,$data,$key4){
                                            $query->where('usergroup_id','10')  ;  
                                            $query->where('id','!=',$key3['pelaksana1_tr']);
                                            $query->where('id','!=',$key3['pelaksana2_tr']);
                                            $query->where('id','!=',$key3['pelaksana3_tr']);
                                            $query->where('id','!=',$data['selected_pelaksana1']);
                                            $query->where('id','!=',$data['selected_pelaksana2']);


                                            $query->where('id','!=',$key4['pelaksana1_audit1']);
                                            $query->where('id','!=',$key4['pelaksana2_audit1']);
                                            $query->where('id','!=',$key4['pelaksana1_audit2']);
                                            $query->where('id','!=',$key4['pelaksana2_audit2']);
                                           
                                           
                                           
                                        })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }
                                }
                            }
                        }      
                    }
                }

            }else{
                //kodewilayah selain 00 pusat

                if($data['selected_pelaksana1'] == ''){

                
                
                    if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL && $dataAuditor3_TidakLuang  == NULL){

                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                $key4['pelaksana1_audit1'] = $str3[0];
                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                $key4['pelaksana2_audit1'] = $str4[0];

                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                $key4['pelaksana1_audit2'] = $str5[0];
                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                $key4['pelaksana2_audit2'] = $str6[0];
                                $dataAuditor2 = DB::table('users')
                                ->where('usergroup_id','10') 
                                ->where('kode_wilayah',$kodewilayah)  
                                ->where('id','!=',$key4['pelaksana1_audit1'])
                                ->where('id','!=',$key4['pelaksana2_audit1'])
                                ->where('id','!=',$key4['pelaksana1_audit2'])
                                ->where('id','!=',$key4['pelaksana2_audit2'])
                                                           
                                ->pluck('id', 'name');   
                            }
                             
                    }else{     
                        if($dataAuditor1_TidakLuang){    
                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ( $dataAuditor3_TidakLuang as $key3) {
                                                foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                    $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                    $key4['pelaksana1_audit1'] = $str3[0];
                                                    $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                    $key4['pelaksana2_audit1'] = $str4[0];

                                                    $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                    $key4['pelaksana1_audit2'] = $str5[0];
                                                    $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                    $key4['pelaksana2_audit2'] = $str6[0];

                                                    $aud =  explode("_",$key['pelaksana1_audit1']);
                                                    $key['pelaksana1_audit1'] =$aud[0];
                                                    $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                    $key['pelaksana2_audit1'] =$aud2[0];
                                                    $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                    $key2['pelaksana1_audit2'] =$aud3[0];
                                                    $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                    $key2['pelaksana2_audit2'] =$aud4[0];
                                                    $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                    $key3['pelaksana1_tr'] =$aud5[0];
                                                    $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                    $key3['pelaksana2_tr'] =$aud6[0];
                                                    $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                    $key3['pelaksana3_tr'] =$aud7[0];
                                                  

                                                    $dataAuditor2 = DB::table('users')
                                                    ->where(function($query) use ($key,$key2,$key3, $key4,$kodewilayah){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                        $query->where('id','!=',$key3['pelaksana1_tr']);
                                                        $query->where('id','!=',$key3['pelaksana2_tr']);
                                                        $query->where('id','!=',$key3['pelaksana3_tr']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                        $query->where('kode_wilayah',$kodewilayah);

                                                    })
                                             
                                                 
                                                    ->pluck('id', 'name');   
                                                }     
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];


                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                           
                                          

                                                $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key2, $key4,$kodewilayah){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                        $query->where('kode_wilayah',$kodewilayah);

                                                       
                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }
                                }  
                            }else{

                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                               
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key3, $key4,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                    $query->where('kode_wilayah',$kodewilayah);

                                                   
                                                })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                           
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key, $key4,$kodewilayah){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key['pelaksana1_audit1']);
                                                $query->where('id','!=',$key['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                $query->where('kode_wilayah',$kodewilayah);
  

                                               
                                               
                                            })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }
                                }
                            }

                        }else{

                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                               
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key2,$key3, $key4,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                    $query->where('kode_wilayah',$kodewilayah);

                                                })
                                         
                                             
                                                ->pluck('id', 'name');  
                                            }
                                        } 
                                    }


                                }else{

                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                           
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key2, $key4,$kodewilayah){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                $query->where('id','!=',$key2['pelaksana2_audit2']);

                                                $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                $query->where('kode_wilayah',$kodewilayah);

                                               
                                               
                                            })
                                     
                                         
                                            ->pluck('id', 'name'); 
                                        }  
                                    }
                                }
                            }else{

                                foreach ( $dataAuditor3_TidakLuang as $key3) {
                                    foreach ($dataAuditor_sudahTerpilih as $key4) {
                                        $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                        $key4['pelaksana1_audit1'] = $str3[0];
                                        $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                        $key4['pelaksana2_audit1'] = $str4[0];

                                        $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                        $key4['pelaksana1_audit2'] = $str5[0];
                                        $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                        $key4['pelaksana2_audit2'] = $str6[0];

                                        $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                        $key3['pelaksana1_tr'] =$aud5[0];
                                        $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                        $key3['pelaksana2_tr'] =$aud6[0];
                                        $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                        $key3['pelaksana3_tr'] =$aud7[0];
                                       
                                       
                                      

                                       $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key3, $key4,$kodewilayah){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key3['pelaksana1_tr']);
                                                $query->where('id','!=',$key3['pelaksana2_tr']);
                                                $query->where('id','!=',$key3['pelaksana3_tr']);
                                                $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                $query->where('kode_wilayah',$kodewilayah);
   
                                               
                                               
                                            })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }
                                }
                            }
                        }
                    }      

                }else if($data['selected_pelaksana1'] != '' && $data['selected_pelaksana2']==''){

                    if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL && $dataAuditor3_TidakLuang  == NULL){

                           foreach ($dataAuditor_sudahTerpilih as $key4) {
                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                $key4['pelaksana1_audit1'] = $str3[0];
                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                $key4['pelaksana2_audit1'] = $str4[0];

                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                $key4['pelaksana1_audit2'] = $str5[0];
                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                $key4['pelaksana2_audit2'] = $str6[0];

                                $dataAuditor2 = DB::table('users')
                                ->where('usergroup_id','10')  
                                ->where('kode_wilayah',$kodewilayah) 
                                ->where('id','!=',$data['selected_pelaksana1'])
                                ->where('id','!=',$key4['pelaksana1_audit1'])
                                ->where('id','!=',$key4['pelaksana2_audit1'])
                                ->where('id','!=',$key4['pelaksana1_audit2'])
                                ->where('id','!=',$key4['pelaksana2_audit2'])
                                                           
                                ->pluck('id', 'name');   
                            }
                             
                    }else{

                         
                        if($dataAuditor1_TidakLuang){    
                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ( $dataAuditor3_TidakLuang as $key3) {
                                                foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                    $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                    $key4['pelaksana1_audit1'] = $str3[0];
                                                    $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                    $key4['pelaksana2_audit1'] = $str4[0];

                                                    $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                    $key4['pelaksana1_audit2'] = $str5[0];
                                                    $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                    $key4['pelaksana2_audit2'] = $str6[0];

                                                    $aud =  explode("_",$key['pelaksana1_audit1']);
                                                    $key['pelaksana1_audit1'] =$aud[0];
                                                    $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                    $key['pelaksana2_audit1'] =$aud2[0];
                                                    $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                    $key2['pelaksana1_audit2'] =$aud3[0];
                                                    $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                    $key2['pelaksana2_audit2'] =$aud4[0];
                                                    $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                    $key3['pelaksana1_tr'] =$aud5[0];
                                                    $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                    $key3['pelaksana2_tr'] =$aud6[0];
                                                    $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                    $key3['pelaksana3_tr'] =$aud7[0];
                                                  

                                                   $dataAuditor2 = DB::table('users')
                                                    ->where(function($query) use ($key,$key2,$key3, $data,$key4,$kodewilayah){
                                                            $query->where('usergroup_id','10')  ;  
                                                            $query->where('id','!=',$key['pelaksana1_audit1']);
                                                            $query->where('id','!=',$key['pelaksana2_audit1']);
                                                            $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                            $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                            $query->where('id','!=',$key3['pelaksana1_tr']);
                                                            $query->where('id','!=',$key3['pelaksana2_tr']);
                                                            $query->where('id','!=',$key3['pelaksana3_tr']);
                                                            $query->where('id','!=',$data['selected_pelaksana1']);


                                                            $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                            $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                            $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                            $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                            $query->where('kode_wilayah',$kodewilayah);


                                                        })
                                             
                                                 
                                                    ->pluck('id', 'name');   
                                                }
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                               
                                              

                                                $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key2,$data,$key4,$kodewilayah){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                        $query->where('id','!=',$data['selected_pelaksana1']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                        $query->where('kode_wilayah',$kodewilayah);

                                                       
                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }
                                }  
                            }else{

                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                         foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                           
                                          

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key3,$data,$key4,$kodewilayah){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key3['pelaksana1_tr']);
                                                        $query->where('id','!=',$key3['pelaksana2_tr']);
                                                        $query->where('id','!=',$key3['pelaksana3_tr']);
                                                        $query->where('id','!=',$data['selected_pelaksana1']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                        $query->where('kode_wilayah',$kodewilayah);

                                                       
                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                           
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$data,$key4,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key['pelaksana2_audit1']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);

                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                    $query->where('kode_wilayah',$kodewilayah);

                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }

                                }
                            }      
                        }else{

                             if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                               
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key2,$key3,$data,$key4,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);

                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                    $query->where('kode_wilayah',$kodewilayah);

                                                })
                                     
                                             
                                                ->pluck('id', 'name');  
                                            }
                                        } 
                                    }


                                }else{

                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                       
                                       
                                      

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key2,$data,$key4,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                    $query->where('kode_wilayah',$kodewilayah);

                                                   
                                                })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }
                                }
                             }else{

                                foreach ( $dataAuditor3_TidakLuang as $key3) {
                                    foreach ($dataAuditor_sudahTerpilih as $key4) {
                                        $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                        $key4['pelaksana1_audit1'] = $str3[0];
                                        $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                        $key4['pelaksana2_audit1'] = $str4[0];

                                        $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                        $key4['pelaksana1_audit2'] = $str5[0];
                                        $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                        $key4['pelaksana2_audit2'] = $str6[0];
                                    
                                        $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                        $key3['pelaksana1_tr'] =$aud5[0];
                                        $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                        $key3['pelaksana2_tr'] =$aud6[0];
                                        $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                        $key3['pelaksana3_tr'] =$aud7[0];
                                       
                                       
                                      

                                        $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key3,$data,$key4,$kodewilayah){
                                            $query->where('usergroup_id','10')  ;  
                                            $query->where('id','!=',$key3['pelaksana1_tr']);
                                            $query->where('id','!=',$key3['pelaksana2_tr']);
                                            $query->where('id','!=',$key3['pelaksana3_tr']);
                                            $query->where('id','!=',$data['selected_pelaksana1']);
                                            $query->where('id','!=',$key4['pelaksana1_audit1']);
                                            $query->where('id','!=',$key4['pelaksana2_audit1']);
                                            $query->where('id','!=',$key4['pelaksana1_audit2']);
                                            $query->where('id','!=',$key4['pelaksana2_audit2']);
                                            $query->where('kode_wilayah',$kodewilayah);

                                        })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }
                                }

                             }

                        }
                        
                    }


                    
                }else if($data['selected_pelaksana1'] != '' && $data['selected_pelaksana2'] !=''){

                    if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL && $dataAuditor3_TidakLuang  == NULL){

                        foreach ($dataAuditor_sudahTerpilih as $key4) {

                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                            $key4['pelaksana1_audit1'] = $str3[0];
                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                            $key4['pelaksana2_audit1'] = $str4[0];

                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                            $key4['pelaksana1_audit2'] = $str5[0];
                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                            $key4['pelaksana2_audit2'] = $str6[0];

                           $dataAuditor2 = DB::table('users')
                            ->where('usergroup_id','10')  
                            ->where('id','!=',$key4['pelaksana1_audit1'])
                            ->where('id','!=',$key4['pelaksana2_audit1'])
                            ->where('id','!=',$key4['pelaksana1_audit2'])
                            ->where('id','!=',$key4['pelaksana2_audit2'])
                            ->where('id','!=',$data['selected_pelaksana1'])
                            ->where('id','!=',$data['selected_pelaksana2'])
                            ->pluck('id', 'name');  
                        } 
                             
                    }else{

                         
                        if($dataAuditor1_TidakLuang){    
                            if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ( $dataAuditor3_TidakLuang as $key3) {
                                                foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                    $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                    $key4['pelaksana1_audit1'] = $str3[0];
                                                    $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                    $key4['pelaksana2_audit1'] = $str4[0];

                                                    $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                    $key4['pelaksana1_audit2'] = $str5[0];
                                                    $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                    $key4['pelaksana2_audit2'] = $str6[0];

                                                    $aud =  explode("_",$key['pelaksana1_audit1']);
                                                    $key['pelaksana1_audit1'] =$aud[0];
                                                    $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                    $key['pelaksana2_audit1'] =$aud2[0];
                                                    $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                    $key2['pelaksana1_audit2'] =$aud3[0];
                                                    $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                    $key2['pelaksana2_audit2'] =$aud4[0];
                                                    $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                    $key3['pelaksana1_tr'] =$aud5[0];
                                                    $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                    $key3['pelaksana2_tr'] =$aud6[0];
                                                    $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                    $key3['pelaksana3_tr'] =$aud7[0];
                                                  

                                                   $dataAuditor2 = DB::table('users')
                                                    ->where(function($query) use ($key,$key2,$key3, $data,$key4,$kodewilayah){
                                                            $query->where('usergroup_id','10')  ;  
                                                            $query->where('id','!=',$key['pelaksana1_audit1']);
                                                            $query->where('id','!=',$key['pelaksana2_audit1']);
                                                            $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                            $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                            $query->where('id','!=',$key3['pelaksana1_tr']);
                                                            $query->where('id','!=',$key3['pelaksana2_tr']);
                                                            $query->where('id','!=',$key3['pelaksana3_tr']);
                                                            $query->where('id','!=',$data['selected_pelaksana1']);
                                                            $query->where('id','!=',$data['selected_pelaksana2']);

                                                            $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                            $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                            $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                            $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                            $query->where('kode_wilayah',$kodewilayah);


                                                        })
                                             
                                                 
                                                    ->pluck('id', 'name');   
                                                }
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ( $dataAuditor2_TidakLuang as $key2) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                               
                                              

                                                $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key2,$data,$key4,$kodewilayah){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                        $query->where('id','!=',$data['selected_pelaksana1']);
                                                        $query->where('id','!=',$data['selected_pelaksana2']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                        $query->where('kode_wilayah',$kodewilayah);

                                                       
                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }
                                }  
                            }else{

                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                         foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud =  explode("_",$key['pelaksana1_audit1']);
                                                $key['pelaksana1_audit1'] =$aud[0];
                                                $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                                $key['pelaksana2_audit1'] =$aud2[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                               
                                              

                                                $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key,$key3,$data,$key4,$kodewilayah){
                                                        $query->where('usergroup_id','10')  ;  
                                                        $query->where('id','!=',$key['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key3['pelaksana1_tr']);
                                                        $query->where('id','!=',$key3['pelaksana2_tr']);
                                                        $query->where('id','!=',$key3['pelaksana3_tr']);
                                                        $query->where('id','!=',$data['selected_pelaksana1']);
                                                        $query->where('id','!=',$data['selected_pelaksana2']);

                                                        $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                        $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                        $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                        $query->where('kode_wilayah',$kodewilayah);

                                                       
                                                    })
                                         
                                             
                                                ->pluck('id', 'name');   
                                            }
                                        }
                                    }

                                }else{

                                    foreach ( $dataAuditor1_TidakLuang as $key) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud =  explode("_",$key['pelaksana1_audit1']);
                                            $key['pelaksana1_audit1'] =$aud[0];
                                            $aud2 =  explode("_",$key['pelaksana2_audit1']);
                                            $key['pelaksana2_audit1'] =$aud2[0];
                                           
                                           
                                          

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key,$data,$key4,$kodewilayah){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key['pelaksana1_audit1']);
                                                $query->where('id','!=',$key['pelaksana2_audit1']);
                                                $query->where('id','!=',$data['selected_pelaksana1']);
                                                $query->where('id','!=',$data['selected_pelaksana2']);

                                                $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                $query->where('kode_wilayah',$kodewilayah);

                                               
                                            })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }

                                }
                            }      
                        }else{

                             if($dataAuditor2_TidakLuang){
                                if($dataAuditor3_TidakLuang){
                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ( $dataAuditor3_TidakLuang as $key3) {
                                            foreach ($dataAuditor_sudahTerpilih as $key4) {
                                                $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                                $key4['pelaksana1_audit1'] = $str3[0];
                                                $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                                $key4['pelaksana2_audit1'] = $str4[0];

                                                $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                                $key4['pelaksana1_audit2'] = $str5[0];
                                                $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                                $key4['pelaksana2_audit2'] = $str6[0];

                                                $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                                $key2['pelaksana1_audit2'] =$aud3[0];
                                                $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                                $key2['pelaksana2_audit2'] =$aud4[0];
                                                $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                                $key3['pelaksana1_tr'] =$aud5[0];
                                                $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                                $key3['pelaksana2_tr'] =$aud6[0];
                                                $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                                $key3['pelaksana3_tr'] =$aud7[0];
                                               
                                              

                                               $dataAuditor2 = DB::table('users')
                                                ->where(function($query) use ($key2,$key3,$data,$key4,$kodewilayah){
                                                    $query->where('usergroup_id','10')  ;  
                                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                    $query->where('id','!=',$key3['pelaksana1_tr']);
                                                    $query->where('id','!=',$key3['pelaksana2_tr']);
                                                    $query->where('id','!=',$key3['pelaksana3_tr']);
                                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                                    $query->where('id','!=',$data['selected_pelaksana2']);


                                                    $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                    $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                    $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                    $query->where('kode_wilayah',$kodewilayah);

                                                   
                                                })
                                         
                                             
                                                ->pluck('id', 'name');  
                                            }
                                        } 
                                    }


                                }else{

                                    foreach ( $dataAuditor2_TidakLuang as $key2) {
                                        foreach ($dataAuditor_sudahTerpilih as $key4) {
                                            $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                            $key4['pelaksana1_audit1'] = $str3[0];
                                            $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                            $key4['pelaksana2_audit1'] = $str4[0];

                                            $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                            $key4['pelaksana1_audit2'] = $str5[0];
                                            $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                            $key4['pelaksana2_audit2'] = $str6[0];

                                            $aud3 =  explode("_",$key2['pelaksana1_audit2']);
                                            $key2['pelaksana1_audit2'] =$aud3[0];
                                            $aud4 =  explode("_",$key2['pelaksana2_audit2']);
                                            $key2['pelaksana2_audit2'] =$aud4[0];
                                       
                                       
                                      

                                           $dataAuditor2 = DB::table('users')
                                            ->where(function($query) use ($key2,$data,$key4,$kodewilayah){
                                                $query->where('usergroup_id','10')  ;  
                                                $query->where('id','!=',$key2['pelaksana1_audit2']);
                                                $query->where('id','!=',$key2['pelaksana2_audit2']);
                                                $query->where('id','!=',$data['selected_pelaksana1']);
                                                $query->where('id','!=',$data['selected_pelaksana2']);


                                                $query->where('id','!=',$key4['pelaksana1_audit1']);
                                                $query->where('id','!=',$key4['pelaksana2_audit1']);
                                                $query->where('id','!=',$key4['pelaksana1_audit2']);
                                                $query->where('id','!=',$key4['pelaksana2_audit2']);
                                                $query->where('kode_wilayah',$kodewilayah);

                                               
                                               
                                            })
                                     
                                         
                                            ->pluck('id', 'name');   
                                        }
                                    }
                                }
                             }else{

                                 foreach ( $dataAuditor3_TidakLuang as $key3) {
                                    foreach ($dataAuditor_sudahTerpilih as $key4) {
                                        $str3 =  explode("_", $key4['pelaksana1_audit1']);
                                        $key4['pelaksana1_audit1'] = $str3[0];
                                        $str4 =  explode("_",$key4['pelaksana2_audit1']);
                                        $key4['pelaksana2_audit1'] = $str4[0];

                                        $str5 =  explode("_",$key4['pelaksana1_audit2']);
                                        $key4['pelaksana1_audit2'] = $str5[0];
                                        $str6 =  explode("_",$key4['pelaksana2_audit2']);
                                        $key4['pelaksana2_audit2'] = $str6[0];
                                    
                                        $aud5 =  explode("_",$key3['pelaksana1_tr']);
                                        $key3['pelaksana1_tr'] =$aud5[0];
                                        $aud6 =  explode("_",$key3['pelaksana2_tr']);
                                        $key3['pelaksana2_tr'] =$aud6[0];
                                        $aud7 =  explode("_",$key3['pelaksana3_tr']);
                                        $key3['pelaksana3_tr'] =$aud7[0];
                                       
                                       
                                      

                                        $dataAuditor2 = DB::table('users')
                                        ->where(function($query) use ($key3,$data,$key4,$kodewilayah){
                                            $query->where('usergroup_id','10')  ;  
                                            $query->where('id','!=',$key3['pelaksana1_tr']);
                                            $query->where('id','!=',$key3['pelaksana2_tr']);
                                            $query->where('id','!=',$key3['pelaksana3_tr']);
                                            $query->where('id','!=',$data['selected_pelaksana1']);
                                            $query->where('id','!=',$data['selected_pelaksana2']);


                                            $query->where('id','!=',$key4['pelaksana1_audit1']);
                                            $query->where('id','!=',$key4['pelaksana2_audit1']);
                                            $query->where('id','!=',$key4['pelaksana1_audit2']);
                                            $query->where('id','!=',$key4['pelaksana2_audit2']);
                                            $query->where('kode_wilayah',$kodewilayah);

                                           
                                           
                                        })
                                 
                                     
                                        ->pluck('id', 'name');   
                                    }
                                }
                            }
                        }      
                    }
                }

            }

            

            return response()->json($dataAuditor2);
        }
    }



    public function dataKomite(Request $request)
    {


         $data = $request->except('_token','_method');

        if($data['mulai'] && $data['selesai']){
            $data = $request->except('_token','_method');
            $kodewilayah = Auth::user()->kode_wilayah;
          
            $dataKomite_TidakLuang =  DB::table('penjadwalan')
                                        ->where(function($query) use ($data){
                                            $query->where('mulai_tinjauan','<=', $data['mulai']);
                                            $query->where('selesai_tinjauan','>=', $data['mulai']);
                                            $query->where('id_registrasi','!=', $data['id_regis']);
                                           
                                        })
                                        ->orWhere(function($query) use ($data){
                                            $query->where('mulai_tinjauan','>=', $data['mulai']);
                                            $query->where('mulai_tinjauan','<=', $data['selesai']);
                                            $query->where('id_registrasi','!=', $data['id_regis']);
                                        })
                                           
                                      
                                        ->get();
            
           Log::info('ini data: '.$dataKomite_TidakLuang);
           $dataKomite_TidakLuang= json_decode($dataKomite_TidakLuang, true);
            
           

            $str =  explode("_",$data['selected_pelaksana1']);
            $data['selected_pelaksana1'] = $str[0];
            $str2 =  explode("_",$data['selected_pelaksana2']);
            $data['selected_pelaksana2'] = $str2[0];

            if($kodewilayah == 00){
                if($data['selected_pelaksana1'] == ''){

                
                    if($dataKomite_TidakLuang == NULL){
                        
                           $dataKomite = DB::table('users')
                            ->where('usergroup_id','9')  
                            ->pluck('id', 'name');   
                             
                    }else{

                        foreach ( $dataKomite_TidakLuang as $key) {

                            $aud =  explode("_",$key['pelaksana1_tinjauan']);
                            $key['pelaksana1_tinjauan'] =$aud[0];
                            $aud2 =  explode("_",$key['pelaksana2_tinjauan']);
                            $key['pelaksana2_tinjauan'] =$aud2[0];
                            $aud3 =  explode("_",$key['pelaksana3_tinjauan']);
                            $key['pelaksana3_tinjauan'] =$aud3[0];
                            
                           $dataKomite = DB::table('users')
                            ->where(function($query) use ($key){
                                    $query->where('usergroup_id','9')  ;  
                                    $query->where('id','!=',$key['pelaksana1_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana2_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana3_tinjauan']);
                                    

                                })
                     
                         
                            ->pluck('id', 'name');   
                        }      
                    }

                  

               }else if($data['selected_pelaksana1'] != '' && $data['selected_pelaksana2']==''){

                    if($dataKomite_TidakLuang == NULL){
                        
                           $dataKomite = DB::table('users')
                            ->where('usergroup_id','9') 
                            ->where('id','!=',$data['selected_pelaksana1']) 
                            ->pluck('id', 'name');   
                             
                    }else{
                       
                        foreach ( $dataKomite_TidakLuang as $key) {

                            $aud =  explode("_",$key['pelaksana1_tinjauan']);
                            $key['pelaksana1_tinjauan'] =$aud[0];
                            $aud2 =  explode("_",$key['pelaksana2_tinjauan']);
                            $key['pelaksana2_tinjauan'] =$aud2[0];
                            $aud3 =  explode("_",$key['pelaksana3_tinjauan']);
                            $key['pelaksana3_tinjauan'] =$aud3[0];

                           $dataKomite = DB::table('users')
                            ->where(function($query) use ($key,$data){
                                    $query->where('usergroup_id','9');    
                                    $query->where('id','!=',$key['pelaksana1_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana2_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana3_tinjauan']);
                                    $query->where('id','!=',$data['selected_pelaksana1']);

                                })
                           
                            ->pluck('id', 'name');   
                        }
                    }  
               }else if($data['selected_pelaksana1'] != '' && $data['selected_pelaksana2'] !=''){

                    if($dataKomite_TidakLuang == NULL){
                        
                          $dataKomite = DB::table('users')
                            ->where('usergroup_id','9') 
                            ->where('id','!=',$data['selected_pelaksana1']) 
                            ->where('id','!=',$data['selected_pelaksana2'])
                            ->pluck('id', 'name');   
                             
                    }else{
                       
                        foreach ( $dataKomite_TidakLuang as $key) {

                            $aud =  explode("_",$key['pelaksana1_tinjauan']);
                            $key['pelaksana1_tinjauan'] =$aud[0];
                            $aud2 =  explode("_",$key['pelaksana2_tinjauan']);
                            $key['pelaksana2_tinjauan'] =$aud2[0];
                            $aud3 =  explode("_",$key['pelaksana3_tinjauan']);
                            $key['pelaksana3_tinjauan'] =$aud3[0];

                           $dataKomite = DB::table('users')
                            ->where(function($query) use ($key,$data){
                                    $query->where('usergroup_id','9');    
                                    $query->where('id','!=',$key['pelaksana1_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana2_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana3_tinjauan']);
                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                    $query->where('id','!=',$data['selected_pelaksana2']);

                                })
                           
                            ->pluck('id', 'name');   
                        }
                    }  
                }

            }else{

                //selain kodewilayah pusat 00 
                if($data['selected_pelaksana1'] == ''){

                
                    if($dataKomite_TidakLuang == NULL){
                        
                           $dataKomite = DB::table('users')
                            ->where('usergroup_id','9') 
                            ->where('kode_wilayah',$kodewilayah)  
                            ->pluck('id', 'name');   
                             
                    }else{

                        foreach ( $dataKomite_TidakLuang as $key) {

                            $aud =  explode("_",$key['pelaksana1_tinjauan']);
                            $key['pelaksana1_tinjauan'] =$aud[0];
                            $aud2 =  explode("_",$key['pelaksana2_tinjauan']);
                            $key['pelaksana2_tinjauan'] =$aud2[0];
                            $aud3 =  explode("_",$key['pelaksana3_tinjauan']);
                            $key['pelaksana3_tinjauan'] =$aud3[0];
                            
                           $dataKomite = DB::table('users')
                            ->where(function($query) use ($key,$kodewilayah){
                                    $query->where('usergroup_id','9')  ;  
                                    $query->where('id','!=',$key['pelaksana1_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana2_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana3_tinjauan']);
                                    $query->where('kode_wilayah',$kodewilayah);
                                    

                                })
                     
                         
                            ->pluck('id', 'name');   
                        }      
                    }

                  

               }else if($data['selected_pelaksana1'] != '' && $data['selected_pelaksana2']==''){

                    if($dataKomite_TidakLuang == NULL){
                        
                           $dataKomite = DB::table('users')
                            ->where('usergroup_id','9') 
                            ->where('id','!=',$data['selected_pelaksana1']) 
                            ->pluck('id', 'name');   
                             
                    }else{
                       
                        foreach ( $dataKomite_TidakLuang as $key) {

                            $aud =  explode("_",$key['pelaksana1_tinjauan']);
                            $key['pelaksana1_tinjauan'] =$aud[0];
                            $aud2 =  explode("_",$key['pelaksana2_tinjauan']);
                            $key['pelaksana2_tinjauan'] =$aud2[0];
                            $aud3 =  explode("_",$key['pelaksana3_tinjauan']);
                            $key['pelaksana3_tinjauan'] =$aud3[0];

                           $dataKomite = DB::table('users')
                            ->where(function($query) use ($key,$data,$kodewilayah){
                                    $query->where('usergroup_id','9');    
                                    $query->where('id','!=',$key['pelaksana1_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana2_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana3_tinjauan']);
                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                    $query->where('kode_wilayah',$kodewilayah);

                                })
                           
                            ->pluck('id', 'name');   
                        }
                    }  
               }else if($data['selected_pelaksana1'] != '' && $data['selected_pelaksana2'] !=''){

                    if($dataKomite_TidakLuang == NULL){
                        
                          $dataKomite = DB::table('users')
                            ->where('usergroup_id','9') 
                            ->where('id','!=',$data['selected_pelaksana1']) 
                            ->where('id','!=',$data['selected_pelaksana2'])
                            ->pluck('id', 'name');   
                             
                    }else{
                       
                        foreach ( $dataKomite_TidakLuang as $key) {

                            $aud =  explode("_",$key['pelaksana1_tinjauan']);
                            $key['pelaksana1_tinjauan'] =$aud[0];
                            $aud2 =  explode("_",$key['pelaksana2_tinjauan']);
                            $key['pelaksana2_tinjauan'] =$aud2[0];
                            $aud3 =  explode("_",$key['pelaksana3_tinjauan']);
                            $key['pelaksana3_tinjauan'] =$aud3[0];

                           $dataKomite = DB::table('users')
                            ->where(function($query) use ($key,$data,$kodewilayah){
                                    $query->where('usergroup_id','9');    
                                    $query->where('id','!=',$key['pelaksana1_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana2_tinjauan']);
                                    $query->where('id','!=',$key['pelaksana3_tinjauan']);
                                    $query->where('id','!=',$data['selected_pelaksana1']);
                                    $query->where('id','!=',$data['selected_pelaksana2']);
                                    $query->where('kode_wilayah',$kodewilayah);
                                })
                           
                            ->pluck('id', 'name');   
                        }
                    }  
                }

            }
          
            

             return response()->json($dataKomite);
        }
        
    
       
    }


    public function audit1(Request $request)
    {

        $data = $request->except('_token','_method');
        //dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;

        $e = $model->find($data['idregis1']);
        $j = $model2->find($e->id_penjadwalan);
        //dd($j);
        if($j){
            //dd($data['idregis1']);
            $j->mulai_audit1 = $data['mulai_audit1'];
            $j->status_penjadwalan_audit1 = 1;
            $j->pelaksana1_audit1 = $data['pelaksana1_audit1'];


            $j->save();
        }else{
           //dd($data['mulai_audit1']);
            $model2->mulai_audit1 = $data['mulai_audit1'];
            $model2->status_penjadwalan_audit1 = 1;

            $model2->pelaksana1_audit1 = $data['pelaksana1_audit1'];
            $model2->id_registrasi = $data['idregis1'];
               
            $model2->save();
            $e->id_penjadwalan = $model2->id;
            $e->save();  
           
            
            //dd($model2);
        }
        

        

        try{
            DB::Commit();

            // if($data['pelaksana1_audit1']){
            //     $str =  explode("_",$data['pelaksana1_audit1']);
            //     $u = $model3->find($str[0]);
               
            //     SendEmailAuditor::dispatch($u,$e,$j,'audit1');

            // }if($data['pelaksana2_audit1']){

            //     $str2 =  explode("_",$data['pelaksana2_audit1']);
            //     $u2 = $model3->find($str2[0]);
                
            //     SendEmailAuditor::dispatch($u2,$e,$j,'audit1');
            // }
            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('listregistrasipelangganaktif');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('istregistrasipelangganaktif');
            return $redirectPass;
        }
  
    }

    public function audit2(Request $request)
    {

        $data = $request->except('_token','_method');
                   
        $full_opsi = join("#",$data['opsi_a']);
       



        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;

        $e = $model->find($data['idregis2']);
        $j = $model2->find($e->id_penjadwalan);
        //dd($j);

        if($j){
            //dd($data['idregis1']);
            $j->mulai_audit2 = $data['mulai_audit2'];
            $j->status_penjadwalan_audit2 = 1;
            $j->pelaksana1_audit1 = $data['pelaksana1_audit2'];
            $j->pelaksana2_audit2 = $data['pelaksana2_audit2'];


            $j->save();
        }else{
           //dd($data['mulai_audit1']);
            $model2->mulai_audit2 = $data['mulai_audit2'];
            $model2->status_penjadwalan_audit2 = 1;

            $model2->pelaksana1_audit2 = $data['pelaksana1_audit2'];
            $model2->pelaksana2_audit2 = $data['pelaksana2_audit2'];
            $model2->id_registrasi = $data['idregis2'];
               
            $model2->save();
            $e->id_penjadwalan = $model2->id;
            $e->save();  
           
            
            //dd($model2);
        }

        try{
            DB::Commit();

            // if($data['pelaksana1_audit2']){
            //     $str =  explode("_",$data['pelaksana1_audit2']);
            //     $u = $model3->find($str[0]);
               
            //     SendEmailAuditor::dispatch($u,$e,$j,'audit2');

            // }if($data['pelaksana2_audit2']){

            //     $str2 =  explode("_",$data['pelaksana2_audit2']);
            //     $u2 = $model3->find($str2[0]);
                
            //     SendEmailAuditor::dispatch($u2,$e,$j,'audit2');
            // }

            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('listregistrasipelangganaktif');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('listregistrasipelangganaktif');
            return $redirectPass;
        }
  
    }

    public function tehnicalReview(Request $request)
    {

        $data = $request->except('_token','_method');
        //dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;

        $e = $model->find($data['idregis3']);
        $j = $model2->find($e->id_penjadwalan);
        //dd($j);

        if($j){
            //dd($data['idregis1']);
            //$j->mulai_tr = $data['mulai_tr'];
            $j->status_penjadwalan_tr = 1;
            $j->pelaksana1_tr1 = $data['pelaksana1_tr'];
            $j->pelaksana2_tr = $data['pelaksana2_tr'];


            $j->save();
        }else{
           //dd($data['mulai_audit1']);
            //$model2->mulai_tr = $data['mulai_tr'];
            $model2->status_penjadwalan_tr = 1;

            $model2->pelaksana1_tr = $data['pelaksana1_tr'];
            $model2->pelaksana2_tr = $data['pelaksana2_tr'];
            $model2->id_registrasi = $data['idregis3'];
               
            $model2->save();
            $e->id_penjadwalan = $model2->id;
            $e->save();  
           
            
            //dd($model2);
        }

        try{
            DB::Commit();

            // if($data['pelaksana1_tr']){
            //     $str =  explode("_",$data['pelaksana1_tr']);
            //     $u = $model3->find($str[0]);
                
            //     //dd($u);
            //     SendEmailAuditor::dispatch($u,$e,$j,'tehnical_review');

            // }if($data['pelaksana2_tr']){

            //     $str2 =  explode("_",$data['pelaksana2_tr']);
            //     $u2 = $model3->find($str2[0]);
                
            //     SendEmailAuditor::dispatch($u2,$e,$j,'tehnical_review');
            // }if($data['pelaksana3_tr']){

            //     $str3 =  explode("_",$data['pelaksana3_tr']);
            //     $u3 = $model3->find($str3[0]);
                
            //     SendEmailAuditor::dispatch($u3,$e,$j,'tehnical_review');
            // }

            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('listregistrasipelangganaktif');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('listregistrasipelangganaktif');
            return $redirectPass;
        }
  
    }

     public function tinjauan(Request $request)
    {

        $data = $request->except('_token','_method');
        //dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;

        $e = $model->find($data['idregis4']);
        $j = $model2->find($e->id_penjadwalan);
        //dd($j);

        if($j){
            //dd($data['idregis1']);
            //$j->mulai_tinjauan = $data['mulai_tinjauan'];
            $j->status_penjadwalan_tinjauan = 1;
            $j->pelaksana1_tinjauan = $data['pelaksana1_tinjauan'];
            $j->pelaksana2_tinjauan = $data['pelaksana2_tinjauanr'];


            $j->save();
        }else{
           //dd($data['mulai_audit1']);
            //$model2->mulai_tinjauan = $data['mulai_tinjauan'];
            $model2->status_penjadwalan_tinjauan = 1;

            $model2->pelaksana1_tinjauan = $data['pelaksana1_tinjauan'];
            $model2->pelaksana2_tinjauan = $data['pelaksana2_tinjauan'];
            $model2->id_registrasi = $data['idregis4'];
               
            $model2->save();
            $e->id_penjadwalan = $model2->id;
            $e->save();  
           
            
            //dd($model2);
        }

        try{
            DB::Commit();

            // if($data['pelaksana1_tinjauan']){
            //     $str =  explode("_",$data['pelaksana1_tinjauan']);
            //     $u = $model3->find($str[0]);
               
            //     SendEmailAuditor::dispatch($u,$e,$j,'tinjauan');

            // }if($data['pelaksana2_tinjauan']){

            //     $str2 =  explode("_",$data['pelaksana2_tinjauan']);
            //     $u2 = $model3->find($str2[0]);
                
            //     SendEmailAuditor::dispatch($u2,$e,$j,'tinjauan');
            // }if($data['pelaksana3_tinjauan']){

            //     $str3 =  explode("_",$data['pelaksana3_tinjauan']);
            //     $u3 = $model3->find($str3[0]);
                
            //     SendEmailAuditor::dispatch($u3,$e,$j,'tinjauan');
            // }

            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('listregistrasipelangganaktif');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('listregistrasipelangganaktif');
            return $redirectPass;
        }
  
    }

    public function detail(Request $request){
        $data = $request->except('_token','_method');

        $detailNama = DB::table('users')
                    ->where('id',$data['id']) 
                    ->pluck('name');   
        //Log::info('masuk :'.$detailNama);

        
                
        return $detailNama;
    }

    public function storeKebutuhanWaktuAudit(Request $request)
    {

        $data = $request->except('_token','_method');
        $data_K = $request->except('_token','_method','idregis1','status_registrasi');
        dd($data);
        


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;
        $model4 = new KebutuhanWaktuAudit;

        $e = $model->find($data['idregis1']);
        $k = $model4->find($e->id_kebutuhan_waktu_audit);
        //dd($j);

        $k->fill($data_K);
        //dd($k);
        $k->hasil_review = "";
        $k->catatan_review_kebutuhan_audit = "";
        $k->updated_by =  Auth::user()->id;
        $k->status_kebutuhan_audit= '1';
        $k->save();

        

        try{
            DB::Commit();

            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('listkebutuhanwaktuaudit');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('listkebutuhanwaktuaudit');
            return $redirectPass;
        }
  
    }

    public function storeReviewKebutuhanWaktuAudit(Request $request)
    {

        $data = $request->except('_token','_method');
        //$data_K = $request->except('_token','_method','idregis1','status_registrasi');
        //dd($data);
        


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;
        $model4 = new KebutuhanWaktuAudit;

        $e = $model->find($data['idregis1']);
        $k = $model4->find($e->id_kebutuhan_waktu_audit);
        //dd($j);

        //$k->fill($data_K);
        //dd($k);
        if($data['hasil_review']== 'perbaikan'){
            $k->status_kebutuhan_audit= '2';
            $e->status = '3_2';
        }else{
            
            $k->status_kebutuhan_audit= '3';
            $e->status = '4';
        }

        $k->hasil_review = $data['hasil_review'];
        $k->catatan_review_kebutuhan_audit = $data['catatan_review_kebutuhan_audit'];

        $k->updated_by =  Auth::user()->id;;
        $k->save();
        $e->save();

        

        try{
            DB::Commit();

            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('reviewkebutuhanwaktuaudit');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('reviewkebutuhanwaktuaudit');
            return $redirectPass;
        }
  
    }
    public function perbaikanKebutuhanWaktuAudit(Request $request){
        $data = $request->except('_token','_method');
        //$data_K = $request->except('_token','_method','idregis1','status_registrasi');
        dd($request);
        


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model3 = new User;
        $model4 = new KebutuhanWaktuAudit;

        $e = $model->find($data['idregis1']);
        $k = $model4->find($e->id_kebutuhan_waktu_audit);
        //dd($j);

        //$k->fill($data_K);
        //dd($k);
        $k->updated_by =  Auth::user()->id;;
        $k->status_kebutuhan_audit= '2';
        $k->save();

        

        try{
            DB::Commit();

            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('reviewkebutuhanwaktuaudit');


         return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('reviewkebutuhanwaktuaudit');
            return $redirectPass;
        }
    }

    public function listPenjadwalanAdmin(){

        
       
    
        return view('penjadwalan.listPenjadwalanAdmin');
    }

    public function listKebutuhanWaktuAudit(){

        return view('penjadwalan.listKebutuhanWaktuAudit');
    }
    public function reviewKebutuhanWaktuAudit(){

        return view('penjadwalan.reviewKebutuhanWaktuAudit');
    }

    public function listAudit1(){
        
        return view('penjadwalan.listAudit1');
    }

    public function listAudit2(){
        
        return view('penjadwalan.listAudit2');
    }

    public function listTehnicalReview(){
        
        return view('penjadwalan.listTehnicalReview');
    }

    public function listTinjauan(){
        
        return view('penjadwalan.listTinjauan');
    }

    public function dataKebutuhanWaktuAudit(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start
        if($kodewilayah == '119'){
            $xdata = DB::table('registrasi')
               
                 ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('users','registrasi.id_user','=','users.id')
                 ->join('kebutuhan_waktu_audit','registrasi.id_kebutuhan_waktu_audit','=','kebutuhan_waktu_audit.id')                 
                 ->where('registrasi.status_cancel','=',0)
                 ->orWhere('registrasi.status','=','3')
                 ->orWhere('registrasi.status','=','3_1')
                 ->orWhere('registrasi.status','=','3_2')
                 ->orWhere('registrasi.status','=','3_3')
                 ->select('registrasi.alamat_perusahaan as alamat_perusahaan','registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.kode_wilayah as kode_wilayah','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as ruang_lingkup','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','registrasi.no_registrasi_bpjph','registrasi.status_registrasi as status_registrasi','kebutuhan_waktu_audit.*');
        }else{

            $xdata = DB::table('registrasi')
                ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                ->join('users','registrasi.id_user','=','users.id')
                ->join('kebutuhan_waktu_audit','registrasi.id_kebutuhan_waktu_audit','=','kebutuhan_waktu_audit.id')     
                ->where('registrasi.kode_wilayah','=',$kodewilayah)
                ->where('registrasi.status_cancel','=',0)
                ->orWhere('registrasi.status','=','3')
                ->orWhere('registrasi.status','=','3_1')
                ->orWhere('registrasi.status','=','3_2')
                ->orWhere('registrasi.status','=','3_3')
                ->select('registrasi.alamat_perusahaan as alamat_perusahaan','registrasi.id as id_regis','registrasi.no_registrasi as no_registrasi', 'registrasi.kode_wilayah as kode_wilayah', 'registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as ruang_lingkup','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','kebutuhan_waktu_audit.*');


        }

       


        //filter condition
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        

        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }


    public function dataPenjadwalanAdmin(Request $request){
        $gdata = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        //start
        if($kodewilayah == '119'){
            $xdata = DB::table('registrasi')
                ->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')
                 ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                 ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                 ->join('users','registrasi.id_user','=','users.id')
                 ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')  
                
                 ->where('registrasi.status_cancel','=',0)
                 ->select('registrasi_alamatkantor.alamat as alamat_kantor','registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.kode_wilayah as kode_wilayah','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');
        }else{

            $xdata = DB::table('registrasi')
                ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
                ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
                ->join('users','registrasi.id_user','=','users.id')
                ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')  
                ->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')
                ->where('registrasi.kode_wilayah','=',$kodewilayah)
                ->where('registrasi.status_cancel','=',0)
                ->select('registrasi_alamatkantor.alamat as alamat_kantor','registrasi.id as id_regis','registrasi.no_registrasi as no_registrasi', 'registrasi.kode_wilayah as kode_wilayah', 'registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');


        }

       


        //filter condition
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        if(isset($gdata['mulai_audit1'])){
            $xdata = $xdata->where('mulai_audit1','LIKE','%'.$gdata['mulai_audit1'].'%');
        }
        

        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }

    public function dataAudit1(Request $request){
        $gdata = $request->except('_token','_method');
        $id_user = Auth::user()->id;
        //start
       
        $xdata = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')
             ->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%');
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);  
                $query->where('penjadwalan.pelaksana2_audit1','LIKE','%'.$id_user.'%');
  
            })               
            ->select('registrasi_alamatkantor.alamat as alamat_kantor','registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');
       

        //filter condition
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        if(isset($gdata['mulai_audit1'])){
            $xdata = $xdata->where('mulai_audit1','LIKE','%'.$gdata['mulai_audit1'].'%');
        }
        
        //end
        $xdata = $xdata
                 ->orderBy('registrasi.id','desc');

        return Datatables::of($xdata)->make();
    }

    public function dataAudit2(Request $request){
        $gdata = $request->except('_token','_method');
        $id_user = Auth::user()->id;
        //start
       
        $xdata = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')             
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana1_audit2','LIKE','%'.$id_user.'%');
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana2_audit2','LIKE','%'.$id_user.'%');
  
            })               
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');
       

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
        if(isset($gdata['ruang_lingkup'])){
            $xdata = $xdata->where('ruang_lingkup','=',$gdata['ruang_lingkup']);
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

    public function dataTehnicalReview(Request $request){
        $gdata = $request->except('_token','_method');
        $id_user = Auth::user()->id;
        //start
       
        $xdata = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')             
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana1_tr','LIKE','%'.$id_user.'%');
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana2_tr','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana3_tr','LIKE','%'.$id_user.'%');
  
            })               
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');
       

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
        if(isset($gdata['ruang_lingkup'])){
            $xdata = $xdata->where('ruang_lingkup','=',$gdata['ruang_lingkup']);
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
    public function dataTinjauan(Request $request){
        $gdata = $request->except('_token','_method');
        $id_user = Auth::user()->id;
        //start
       
        $xdata = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')             
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana1_tinjauan','LIKE','%'.$id_user.'%');
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana2_tinjauan','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana3_tinjauan','LIKE','%'.$id_user.'%');
  
            })               
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');
       

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
        if(isset($gdata['ruang_lingkup'])){
            $xdata = $xdata->where('ruang_lingkup','=',$gdata['ruang_lingkup']);
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


    public function dokumenView($id_regis, $hpas){

       $data = DB::table('dokumen_has')
                ->where('id_registrasi', $id_regis)
                ->select($hpas,'id_user','id_registrasi')
                ->get();
       
        foreach ($data as $key ) {
           $datkey = $key;
        }
        
        $headers = $datkey->$hpas;
      
      
        return view('penjadwalan.viewer', compact('datkey','hpas'));
    }

    public function view($id_user,$id_regis, $hpas){

        $loc = public_path('storage/uploadDokumen/'.$id_user.'/'.$id_regis.'/HPAS/'.$hpas);
        //dd($loc);
      
        return response()->file($loc);

    }    

    public function laporanAudit($id){
        $dataRegistrasi = DB::table('registrasi')
                ->join('registrasi_alamatkantor','registrasi.id','=','registrasi_alamatkantor.id_registrasi')
                ->join('registrasi_pemilik_perusahaan','registrasi.id','=','registrasi_pemilik_perusahaan.id_registrasi')
                ->select('registrasi.*','registrasi_alamatkantor.alamat as alamat', 'registrasi_pemilik_perusahaan.nama_pemilik as nama_pemilik')
                ->where('registrasi.id',$id)
                ->get();        
        // $dataRegistrasi = Registrasi::find($id);
        $dataRegistrasi_ = json_decode($dataRegistrasi, true);

        foreach ($dataRegistrasi_ as $key => $value) {
            $id_penjadwalan = $value['id_penjadwalan'];
        }
        
        $dataPenjadwalan = DB::table('penjadwalan')
                ->where('id',$id_penjadwalan)
                ->get();               
        // $dataPenjadwalan = Penjadwalan::find($id_penjadwalan);
        $dataPenjadwalan_ = json_decode($dataPenjadwalan, true);
                
        return view('penjadwalan.laporanAudit',compact('dataRegistrasi','dataPenjadwalan'));
    }

    public function auditPlan($id){        
        $dataRegistrasi = DB::table('registrasi')                
                ->select('registrasi.*')
                ->where('registrasi.id',$id)
                ->get();
        // $dataRegistrasi = Registrasi::find($id);
        $dataRegistrasi_ = json_decode($dataRegistrasi, true);

        foreach ($dataRegistrasi_ as $key => $value) {
            $id_penjadwalan = $value['id_penjadwalan'];
        }
        
        $dataPenjadwalan = DB::table('penjadwalan')
                ->where('id',$id_penjadwalan)
                ->get();               
        // $dataPenjadwalan = Penjadwalan::find($id_penjadwalan);
        $dataPenjadwalan_ = json_decode($dataPenjadwalan, true);

        $laporan2 = DB::table('laporan_audit2')
                ->where('id_registrasi',$id)
                ->get();   
        $laporan2 = json_decode($laporan2, true);        
        
        return view('penjadwalan.auditPlan',compact('dataRegistrasi','dataPenjadwalan','laporan2'));
    }

    // public function auditPlan($id){
    //     $dataRegistrasi = DB::table('registrasi')
    //             ->join('registrasi_alamatkantor','registrasi.id','=','registrasi_alamatkantor.id_registrasi')                
    //             ->select('registrasi.*','registrasi_alamatkantor.alamat as alamat')
    //             ->where('registrasi.id',$id)
    //             ->get();        
    //     // $dataRegistrasi = Registrasi::find($id);
    //     $dataRegistrasi_ = json_decode($dataRegistrasi, true);

    //     foreach ($dataRegistrasi_ as $key => $value) {
    //         $id_penjadwalan = $value['id_penjadwalan'];
    //     }
        
    //     $dataPenjadwalan = DB::table('penjadwalan')
    //             ->where('id',$id_penjadwalan)
    //             ->get();               
    //     // $dataPenjadwalan = Penjadwalan::find($id_penjadwalan);
    //     $dataPenjadwalan_ = json_decode($dataPenjadwalan, true);
                
    //     return view('penjadwalan.auditPlan',compact('dataRegistrasi','dataPenjadwalan'));
    // }

    public function listLog(){
        $id_user = Auth::user()->id;
        return view('penjadwalan.listLog', compact('id_user'));
    }

    public function dataLog(Request $request){
        $gdata = $request->except('_token','_method');
        $id_user = Auth::user()->id;
        //start
       
        $dataAudit1 = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id') 
                      
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%');
                //$query->where('penjadwalan.status_penjadwalan_audit1','=', 4);
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana2_audit1','LIKE','%'.$id_user.'%');
                //$query->where('penjadwalan.status_penjadwalan_audit1','=', 4);
  
            })               
            ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenisR','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.id as id_user','penjadwalan.mulai_audit1 as mulai','penjadwalan.selesai_audit1 as selesai','penjadwalan.pelaksana1_audit1 as pelaksana1','penjadwalan.pelaksana2_audit1 as pelaksana2', 'penjadwalan.skema as skema', 'penjadwalan.ktg_audit2 as ktg');

        

        $dataAudit2 = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id') 
                      
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana1_audit2','LIKE','%'.$id_user.'%');
                //$query->where('penjadwalan.status_penjadwalan_audit2','=', 4);
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('penjadwalan.pelaksana2_audit2','LIKE','%'.$id_user.'%');
                //$query->where('penjadwalan.status_penjadwalan_audit2','=', 4);
  
            })               
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenisR','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.id as id_user','penjadwalan.mulai_audit2 as mulai','penjadwalan.selesai_audit2 as selesai','penjadwalan.pelaksana1_audit2 as pelaksana1','penjadwalan.pelaksana2_audit2 as pelaksana2', 'penjadwalan.skema as skema', 'penjadwalan.ktg_audit2 as ktg' );
       


        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        if(isset($gdata['mulai'])){
            $xdata = $xdata->where('mulai_audit1','LIKE','%'.$gdata['mulai'].'%');
            $xdata = $xdata->where('mulai_audit2','LIKE','%'.$gdata['mulai'].'%');
        }

        
        $xdata = $dataAudit1
                ->union($dataAudit2)
                ->get();

        //Log::info($dataAudit1);


       // Log::info($xdata);


       

        return Datatables::of($xdata)->make();
    }

    public function uploadKsb($id){
        // dd("disini");
        $id_regis = $id;
        $id_user = Auth::user()->id;
        $data = Registrasi::find($id);

        $laporan2 = DB::table('laporan_audit2')
                ->where('id_registrasi',$id_regis)
                ->get();   
        $laporan2 = json_decode($laporan2, true);     

        if($laporan2 == null){
            return view('penjadwalan.uploadKsb', compact('data','id_user','id_regis'));
        }else{
            // dd($laporan2);
            return view('penjadwalan.uploadKsb', compact('data','id_user','id_regis','laporan2'));
        }        
    }
    

}


    