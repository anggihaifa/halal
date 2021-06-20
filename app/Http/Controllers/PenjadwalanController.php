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
use App\Models\LaporanTehnicalReview;
use App\Models\LaporanTinjauan;
use App\Models\LaporanPersiapanSidang;

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

        //Log::info($data['mulai']);
        if($data['mulai']){
                $dataAuditor1_TidakLuangRaw =  DB::table('penjadwalan')
                                    ->where('mulai_audit1','=', $data['mulai'])
                                    ->select('pelaksana1_audit1')
                                    ->get();

                $dataAuditor2_TidakLuang =  DB::table('penjadwalan')
                                            ->where('mulai_audit2','=', $data['mulai'])
                                            ->select('pelaksana1_audit2','pelaksana2_audit2')
                                            ->get();

            $dataAuditor1_TidakLuang = array();
            //                               
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
                        //Log::info("masuk tambah ke array");  
                        $dataAuditor1_TidakLuang[]= array('pelaksana1_audit1'=>$dataAuditor1_TidakLuangRaw[$i]['pelaksana1_audit1']);
                    }
                }      
           }

           $dataAuditor2_TidakLuang= json_decode($dataAuditor2_TidakLuang, true);
          
           //Log::info($dataAuditor1_TidakLuang);  
           
            // $str =  explode("_",$data['selected_pelaksana1']);
            // $data['selected_pelaksana1'] = $str[0];

            if($kodewilayah == 119){
               
                 
                
                if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL ){

                        $dataAuditor1 = DB::table('users')
                        ->where('usergroup_id','10')
                        ->orWhere('usergroup_id','11')
                        ->orWhere('usergroup_id','12')
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
                                    $query->where('usergroup_id','11')  ;  
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                            ->orWhere(function($query) use ($key2){
                                    $query->where('usergroup_id','12')  ;  
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
                                    $query->where('usergroup_id','11')  ;  
                                    $query->where('kode_wilayah',$kodewilayah);
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                            ->orWhere(function($query) use ($key2,$kodewilayah){
                                    $query->where('usergroup_id','12')  ;  
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

        Log::info($data['mulai']);
        if($data['mulai']){
            $dataAuditor1_TidakLuang =  DB::table('penjadwalan')
                                        ->where('mulai_audit1','=', $data['mulai']) 
                                        ->select('pelaksana1_audit1')
                                        ->get();

            $dataAuditor2_TidakLuangRaw =  DB::table('penjadwalan')
                                        ->where('mulai_audit2','=', $data['mulai'])
                                        ->where('id_registrasi','!=', $data['id_regis'])
                                        ->select('id','pelaksana1_audit2','pelaksana2_audit2')
                                        ->get();   
          
            $dataAuditor1_TidakLuang= json_decode($dataAuditor1_TidakLuang, true);
    
            //Log::info($dataAuditor2_TidakLuangRaw);    
            $dataAuditor2_TidakLuangRaw= json_decode($dataAuditor2_TidakLuangRaw, true);
            //Log::info($dataAuditor2_TidakLuangRaw);        
            

            $dataAuditor2_TidakLuang = array();
            
            for( $i=0;$i<count($dataAuditor2_TidakLuangRaw);$i++) {
            //
            $count1 =0;
            $count2 =0;
                if($i != 0){
                    for( $j=$i-1;$j<count($dataAuditor2_TidakLuangRaw)-1;$j++) {

                        
    
    
                        if($dataAuditor2_TidakLuangRaw[$j]['pelaksana1_audit2'] == $dataAuditor2_TidakLuangRaw[$i]['pelaksana1_audit2'] ){
                            $count1++;
                        }
                        if($dataAuditor2_TidakLuangRaw[$j]['pelaksana2_audit2'] == $dataAuditor2_TidakLuangRaw[$i]['pelaksana2_audit2'] ){
                            $count2++;
                        }
                    }
                    
                    if( $count1 >= 1 && $count2 <1){
                        //$dataAuditor2_TidakLuang = $dataAuditor2_TidakLuangRaw[$i]
                        $dataAuditor2_TidakLuang[]= array('pelaksana1_audit2'=>$dataAuditor2_TidakLuangRaw[$i]['pelaksana1_audit2'], 'pelaksana2_audit2'=>NULL);
                        
                    }elseif($count1 >= 1 && $count2 >= 1){
                        $dataAuditor2_TidakLuang[]= array('pelaksana1_audit2'=>$dataAuditor2_TidakLuangRaw[$i]['pelaksana1_audit2'], 'pelaksana2_audit2'=>$dataAuditor2_TidakLuangRaw[$i]['pelaksana2_audit2']);
                    }elseif( $count2 >= 1 && $count1 <1){
                       
                        $dataAuditor2_TidakLuang[]= array('pelaksana1_audit2'=>NULL,'pelaksana2_audit2'=>$dataAuditor2_TidakLuangRaw[$i]['pelaksana2_audit2']);
                    }
                }      
            }
           // Log::info(count($dataAuditor2_TidakLuangRaw));
            //Log::info($count1);
            //Log::info($count2);
            //Log::info($dataAuditor2_TidakLuang);

            if($kodewilayah == '119'){
                    
                if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL ){

                    $dataAuditor1 = DB::table('users')
                    ->where('usergroup_id','10')
                    ->orWhere('usergroup_id','11')
                    ->orWhere('usergroup_id','12')
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
                                    
                                    Log::info("masuk sini");

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
                            
                            Log::info("masuk sini yang cuma data kedua");
                            

                            $dataAuditor1 = DB::table('users')
                            ->where(function($query) use ($key2){
                                    $query->where('usergroup_id','10')  ;  
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                            ->orWhere(function($query) use ($key2){
                                    $query->where('usergroup_id','11')  ;  
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                            ->orWhere(function($query) use ($key2){
                                    $query->where('usergroup_id','12')  ;  
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
                                    $query->where('usergroup_id','11')  ;  
                                    $query->where('kode_wilayah',$kodewilayah);
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                            ->orWhere(function($query) use ($key2,$kodewilayah){
                                    $query->where('usergroup_id','12')  ;  
                                    $query->where('kode_wilayah',$kodewilayah);
                                    $query->where('id','!=',$key2['pelaksana1_audit2']);
                                    $query->where('id','!=',$key2['pelaksana2_audit2']);
                                    
                                    
                            })
                        
                            
                            ->pluck('id', 'name');   
                        }
                    }
                }   
            }    
        }    
        //Log::info('ini data auditor: '.$dataAuditor1);
        return response()->json($dataAuditor1);
    }


    public function dataDDTehnicalReview(Request $request)
    {

        $data = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
      
       

        if($kodewilayah == '119'){

            $dataAuditor1 = DB::table('users')
            
            ->where('usergroup_id','11')
            ->orWhere('usergroup_id','12')
            ->pluck('id', 'name');   

        }else{

            $dataAuditor1 = DB::table('users')

          
            ->where(function($query) use ($kodewilayah){
                $query->where('usergroup_id','11');
                $query->where('kode_wilayah',$kodewilayah);
            })
            ->orWhere(function($query) use ($kodewilayah){
                $query->where('usergroup_id','12');
                $query->where('kode_wilayah',$kodewilayah);
            })

            ->pluck('id', 'name');   
            
        }

            

        return response()->json($dataAuditor1);
      
    }



    public function dataKomite(Request $request)
    {
            $data = $request->except('_token','_method');
            $kodewilayah = Auth::user()->kode_wilayah;
          
            

            if($kodewilayah == '119'){

                $dataAuditor1 = DB::table('users')
                
                ->orWhere('usergroup_id','13')
                
                ->pluck('id', 'name');   
    
            }else{
    
                $dataAuditor1 = DB::table('users')
    
                ->where(function($query) use ($kodewilayah){
                    $query->where('usergroup_id','13');
                    $query->where('kode_wilayah',$kodewilayah);
                })
                
    
                ->pluck('id', 'name');   
                
            }
            return response()->json($dataAuditor1);

      
        
    
       
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
            $e->status = '7_1';
            $j->pelaksana1_audit1 = $data['pelaksana1_audit1'];
            $j->skema = $data['skema_audit'];

            $e->save();
            $j->save();
        }else{
           //dd($data['mulai_audit1']);
            $model2->mulai_audit1 = $data['mulai_audit1'];
            $model2->status_penjadwalan_audit1 = 1;
            $e->status = '7_1';
            $model2->pelaksana1_audit1 = $data['pelaksana1_audit1'];
            $model2->id_registrasi = $data['idregis1'];
            $model2->skema = $data['skema_audit'];
               
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
            $redirectPass = redirect()->route('listregistrasipelangganaktif');
            return $redirectPass;
        }
  
    }

    public function audit2(Request $request)
    {

        $data = $request->except('_token','_method');
                   
        //$full_opsi = join("#",$data['opsi_a']);
       



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
            $j->pelaksana1_audit2 = $data['pelaksana1_audit2'];
            $j->pelaksana2_audit2 = $data['pelaksana2_audit2'];
            $e->status= '9_1';
            $e->save();  

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
            $e->status= '9_1';
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
            $j->pelaksana1_tr = $data['pelaksana1_tr'];
            $j->pelaksana2_tr = $data['pelaksana2_tr'];
            $e->status = '11_1';

            $e->save();
            $j->save();
        }else{
           //dd($data['mulai_audit1']);
            //$model2->mulai_tr = $data['mulai_tr'];
            $model2->status_penjadwalan_tr = 1;

            $model2->pelaksana1_tr = $data['pelaksana1_tr'];
            $model2->pelaksana2_tr = $data['pelaksana2_tr'];
            $model2->id_registrasi = $data['idregis3'];
               
            $model2->save();
            $e->status = '11_1';
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
            $j->pelaksana2_tinjauan = $data['pelaksana2_tinjauan'];

            $e->status = '13_1';
            $j->save();
            $e->save();
        }else{
           //dd($data['mulai_audit1']);
            //$model2->mulai_tinjauan = $data['mulai_tinjauan'];
            $model2->status_penjadwalan_tinjauan = 1;

            $model2->pelaksana1_tinjauan = $data['pelaksana1_tinjauan'];
            $model2->pelaksana2_tinjauan = $data['pelaksana2_tinjauan'];
            $model2->id_registrasi = $data['idregis4'];
               
            $model2->save();
            $e->status = '13_1';
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

   
    public function listPenjadwalanAdmin(){

        
       
    
        return view('penjadwalan.listPenjadwalanAdmin');
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

    public function listPersiapanSidang(){
        
        return view('penjadwalan.listpersiapansidang');
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
             //->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);  
                $query->where('registrasi.status','=',8);  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);  
                $query->where('registrasi.status','=','8_1');  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);  
                $query->where('registrasi.status','=','8_2');  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);  
                $query->where('registrasi.status','=','8_3');  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%');
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);  
                $query->where('registrasi.status','=','8_0');  
                $query->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%');
  
            })    
                     
            ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.kode_wilayah','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*');
       

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
             ->leftJoin('laporan_audit2','registrasi.id', '=', 'laporan_audit2.id_registrasi')
            ->leftJoin('laporan_audit1','registrasi.id', '=', 'laporan_audit1.id_registrasi')
            ->leftJoin('laporan_tehnical_review','registrasi.id', '=', 'laporan_tehnical_review.id_registrasi')
            ->leftJoin('laporan_tinjauan','registrasi.id', '=', 'laporan_tinjauan.id_registrasi')
            ->leftJoin('laporan_persiapan_sidang','registrasi.id', '=', 'laporan_persiapan_sidang.id_registrasi')
            //  ->join('laporan_audit1','registrasi.id_laporan_audit1','=','laporan_audit1.id')
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('penjadwalan.status_penjadwalan_audit2','=',3);
                $query->where('penjadwalan.pelaksana1_audit2','LIKE','%'.$id_user.'%');
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;
                $query->where('penjadwalan.status_penjadwalan_audit2','=',3);  
                $query->where('penjadwalan.pelaksana2_audit2','LIKE','%'.$id_user.'%');
  
            })       
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0);
                $query->where('penjadwalan.status_penjadwalan_audit2','=',3);
                $query->where('penjadwalan.pelaksana2_audit2','LIKE','%'.$id_user.'%');
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;
                $query->where('penjadwalan.status_penjadwalan_audit2','=',3);  
                $query->where('penjadwalan.pelaksana1_audit2','LIKE','%'.$id_user.'%');
  
            })               
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*','laporan_audit1.file_laporan_audit1','laporan_audit2.file_laporan_audit_tahap_2','laporan_tehnical_review.file_laporan_tr','laporan_tinjauan.file_laporan_tinjauan','laporan_tehnical_review.catatan_tr','laporan_tinjauan.catatan_tinjauan','laporan_persiapan_sidang.catatan_persiapan_sidang');
            //  ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*','laporan_audit1.file_laporan_audit1');
       

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
             ->leftjoin('laporan_audit1','registrasi.id_laporan_audit1','=','laporan_audit1.id')
             ->leftjoin('laporan_audit2','registrasi.id_laporan_audit2','=','laporan_audit2.id')
             ->leftjoin('laporan_tehnical_review','registrasi.id_tehnical_review','=','laporan_tehnical_review.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')             
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=',12)  ;  
                $query->where('penjadwalan.pelaksana1_tr','LIKE','%'.$id_user.'%');
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_12_0')  ;
                $query->where('penjadwalan.pelaksana2_tr','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_12_1')  ;
                $query->where('penjadwalan.pelaksana2_tr','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_12_2')  ;
                $query->where('penjadwalan.pelaksana2_tr','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_12_3')  ;
                $query->where('penjadwalan.pelaksana2_tr','LIKE','%'.$id_user.'%');
  
            })  

            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=',12)  ;  
                $query->where('penjadwalan.pelaksana2_tr','LIKE','%'.$id_user.'%');
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_12_0')  ;
                $query->where('penjadwalan.pelaksana1_tr','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_12_1')  ;
                $query->where('penjadwalan.pelaksana1_tr','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_12_2')  ;
                $query->where('penjadwalan.pelaksana2_tr','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_12_3')  ;
                $query->where('penjadwalan.pelaksana1_tr','LIKE','%'.$id_user.'%');
  
            })  
                     
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*', 'laporan_audit1.file_laporan_audit1','laporan_audit2.file_laporan_audit_tahap_2', 'laporan_tehnical_review.catatan_tr', 'laporan_tehnical_review.status_laporan_tr', 'laporan_tehnical_review.status_lanjut_ks');
       

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
             ->leftjoin('laporan_audit1','registrasi.id_laporan_audit1','=','laporan_audit1.id')
             ->leftjoin('laporan_audit2','registrasi.id_laporan_audit2','=','laporan_audit2.id')
             ->leftjoin('laporan_tehnical_review','registrasi.id_tehnical_review','=','laporan_tehnical_review.id')
             ->leftjoin('laporan_tinjauan','registrasi.id_tinjauan_komite','=','laporan_tinjauan.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')             
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=',14)  ;  
                $query->where('penjadwalan.pelaksana1_tinjauan','LIKE','%'.$id_user.'%');
                
  
            })   
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=',14)  ;  
                $query->where('penjadwalan.pelaksana2_tinjauan','LIKE','%'.$id_user.'%');
                
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','14_0')  ;
                $query->where('penjadwalan.pelaksana2_tinjauan','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','14_0')  ;
                $query->where('penjadwalan.pelaksana1_tinjauan','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','14_1')  ;
                $query->where('penjadwalan.pelaksana2_tinjauan','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','14_1')  ;
                $query->where('penjadwalan.pelaksana1_tinjauan','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','14_2')  ;
                $query->where('penjadwalan.pelaksana2_tinjauan','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','14_2')  ;
                $query->where('penjadwalan.pelaksana1_tinjauan','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','14_3')  ;
                $query->where('penjadwalan.pelaksana2_tinjauan','LIKE','%'.$id_user.'%');
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','14_3')  ;
                $query->where('penjadwalan.pelaksana1_tinjauan','LIKE','%'.$id_user.'%');
  
            })  
                     
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*', 'laporan_audit1.file_laporan_audit1','laporan_audit2.file_laporan_audit_tahap_2', 'laporan_tehnical_review.file_laporan_tr','laporan_tinjauan.catatan_tinjauan', 'laporan_tinjauan.status_laporan_tinjauan');
       

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

    public function dataPersiapanSidang(Request $request){
        $gdata = $request->except('_token','_method');
        $id_user = Auth::user()->id;
        //start
       
        $xdata = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->leftjoin('laporan_audit1','registrasi.id_laporan_audit1','=','laporan_audit1.id')
             ->leftjoin('laporan_audit2','registrasi.id_laporan_audit2','=','laporan_audit2.id')
             ->leftjoin('laporan_tehnical_review','registrasi.id_tehnical_review','=','laporan_tehnical_review.id')
             ->leftjoin('laporan_tinjauan','registrasi.id_tinjauan_komite','=','laporan_tinjauan.id')
             ->leftjoin('laporan_persiapan_sidang','registrasi.id_persiapan_sidang','=','laporan_persiapan_sidang.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')             
            ->where(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=',15)  ;  
                
  
            })    
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_15_0')  ;
                
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_15_1')  ;
               
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_15_2')  ;
               
  
            })  
            ->orWhere(function($query) use ($id_user){
                $query->where('registrasi.status_cancel','=',0)  ;  
                $query->where('registrasi.status','=','_15_3')  ;
                
  
            })  
                     
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*', 'laporan_audit1.file_laporan_audit1','laporan_audit2.file_laporan_audit_tahap_2', 'laporan_tehnical_review.file_laporan_tr','laporan_tinjauan.catatan_tinjauan', 'laporan_tinjauan.status_laporan_tinjauan','laporan_persiapan_sidang.catatan_persiapan_sidang', 'laporan_persiapan_sidang.status_persiapan_sidang');
       

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
                ->select('registrasi.*')
                ->where('registrasi.id',$id)
                ->get();        

        $dataKelompok = KelompokProduk::all();
        // $dataRegistrasi = Registrasi::find($id);
        $dataRegistrasi_ = json_decode($dataRegistrasi, true);

        //dd($dataRegistrasi_);

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

        $dataKetidaksesuaian = DB::table('ketidaksesuaian')
                ->where('id_registrasi',$id)
                // ->where('id_penjadwalan',$id_penjadwalan)
                ->orderBy('id','desc')
                ->limit(1)
                ->get();               
        $kt = json_decode($dataKetidaksesuaian, true);        
                
        return view('penjadwalan.laporanAudit',compact('dataRegistrasi','dataPenjadwalan','laporan2','dataKelompok','kt'));
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

        
        return view('penjadwalan.uploadKsb', compact('data','id_user','id_regis','laporan2'));
             
    }

    public function storeLaporanTR(Request $request)
    {

        $data = $request->except('_token','_method');
        //dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model4 = new LaporanTehnicalReview;
        $model3 = new User;

        $e = $model->find($data['id']);
        $j = $model4->find($e->id_tehnical_review);
        $u = $model3->find($e->id_user);

        if($j){

            if($data['status_laporan_tr']== '1'){
                $j->status_laporan_tr = 1;
                
                if($data['status_lanjut_ks']=='0'){
                    $e->status = 15;
                }else if($data['status_lanjut_ks']=='1'){
                    $e->status = 13;
    
                }
               
                //dd("masuk");
            }else if($data['status_laporan_tr']== '0'){
                $j->status_laporan_tr = 2;
                $e->status = '10_2';
            }
    
            if($request->has("file_laporan_tr")){
                $file = $request->file("file_laporan_tr");
                $file = $data["file_laporan_tr"];
               
                $filename = "TR-".$data['id'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/laporan/upload/Laporan Tehnical Review/".$u->id."/", $filename);
                $j->file_laporan_tr = $filename;
                   
            }
            $j->id_registrasi = $e->id;
            $j->catatan_tr = $data['catatan_tr'];
            $j->status_lanjut_ks = $data['status_lanjut_ks'];
            $e->save();
            $j->save();

        }else{

            if($data['status_laporan_tr']== '1'){
                $model4->status_laporan_tr = 1;
                
                if($data['status_lanjut_ks']=='0'){
                    $e->status = 15;
                }else if($data['status_lanjut_ks']=='1'){
                    $e->status = 13;
    
                }
               
                //dd("masuk");
            }else if($data['status_laporan_tr']== '0'){
                $model4->status_laporan_tr = 2;
                $e->status = '10_2';
            }
    
            if($request->has("file_laporan_tr")){
                $file = $request->file("file_laporan_tr");
                $file = $data["file_laporan_tr"];
               
                $filename = "TR-".$data['id'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/laporan/upload/Laporan Tehnical Review/".$u->id."/", $filename);
                $model4->file_laporan_tr = $filename;
                   
            }
            $model4->catatan_tr = $data['catatan_tr'];
            $model4->status_lanjut_ks = $data['status_lanjut_ks'];
            $model4->id_registrasi = $e->id;
            $model4->save();
            $e->id_tehnical_review = $model4->id;      
            $e->save();
            

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
            $redirect = redirect()->route('listtehnicalreview');


        return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('listtehnicalreview');
            return $redirectPass;
        }

    }

    public function storeLaporanKS(Request $request)
    {

        $data = $request->except('_token','_method');
        //dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model4 = new LaporanTinjauan;
        $model3 = new User;

        $e = $model->find($data['id']);
        $j = $model4->find($e->id_tinjauan_komite);
        $u = $model3->find($e->id_user);

        if($j){

            if($data['status_laporan_tinjauan']== '1'){
                $j->status_laporan_tinjauan = 1;
                $e->status = 15;
                
            
                //dd("masuk");
            }else if($data['status_laporan_tinjauan']== '0'){
                $j->status_laporan_tinjauan = 0 ;
                $e->status = '10_2';
            }
    
            if($request->has("file_laporan_tinjauan")){
                $file = $request->file("file_laporan_tinjauan");
                $file = $data["file_laporan_tinjauan"];
            
                $filename = "KS-".$data['id'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/laporan/upload/Laporan Tinjauan Komite/".$u->id."/", $filename);
                $j->file_laporan_tinjauan = $filename;
                
            }
            $j->id_registrasi = $e->id;
            $j->catatan_tinjauan = $data['catatan_tinjauan'];
            $e->save();
            $j->save();

        }else{

            if($data['status_laporan_tinjauan']== '1'){
                $model4->status_laporan_tinjauan = 1;
                $e->status = 15;
                
            
                //dd("masuk");
            }else if($data['status_laporan_tinjauan']== '0'){
                $model4->status_laporan_tinjauan = 0 ;
                $e->status = '10_2';
            }
    
            if($request->has("file_laporan_tinjauan")){
                $file = $request->file("file_laporan_tinjauan");
                $file = $data["file_laporan_tinjauan"];
            
                $filename = "KS-".$data['id'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/laporan/upload/Laporan Tinjauan Komite/".$u->id."/", $filename);
                $model4->file_laporan_tinjauan = $filename;
                
            }
            $model4->id_registrasi = $e->id;
            $model4->catatan_tinjauan = $data['catatan_tinjauan'];
            $model4->save();
            $e->id_tinjauan_komite = $model4->id; 
            $e->save();
            
            

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
            $redirect = redirect()->route('listtinjauan');


        return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('listtinjauan');
            return $redirectPass;
        }

    }

    public function storePersiapanSidang(Request $request)
    {

        $data = $request->except('_token','_method');
        //dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model4 = new LaporanPersiapanSidang;
        $model3 = new User;

        $e = $model->find($data['id']);
        $j = $model4->find($e->id_persiapan_sidang);
        $u = $model3->find($e->id_user);

        if($j){

            if($data['status_persiapan_sidang']== '1'){
                $j->status_persiapan_sidang = 1;
                $e->status = 16;
                
            
                //dd("masuk");
            }else if($data['status_persiapan_sidang']== '0'){
                $j->status_persiapan_sidang = 0 ;
                $e->status = '10_2';
            }
    
            
            $j->id_registrasi = $e->id;
            $j->catatan_persiapan_sidang = $data['catatan_persiapan_sidang'];
            $e->save();
            $j->save();

        }else{

            if($data['status_persiapan_sidang']== '1'){
                $model4->status_persiapan_sidang = 1;
                $e->status = 16;
                
            
                //dd("masuk");
            }else if($data['status_persiapan_sidang']== '0'){
                $model4->status_persiapan_sidang = 0 ;
                $e->status = '10_2';
            }
    
           
            $model4->id_registrasi = $e->id;
            $model4->catatan_persiapan_sidang = $data['catatan_persiapan_sidang'];
            $model4->save();
            $e->id_persiapan_sidang = $model4->id; 
            $e->save();
            
            

        }
            
        try{
            DB::Commit();
            Session::flash('success', "data berhasil disimpan!");            
            $redirect = redirect()->route('listpersiapansidang');


        return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            //$this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('listpersiapansidang');
            return $redirectPass;
        }

    }
    

}


    