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
use App\LogKegiatan;
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
        if($data['mulai'] && $data['selesai']){
            $dataAuditor1_TidakLuangRaw =  DB::table('penjadwalan')
            ->where(function($query) use ($data){
                $query->where('mulai_audit1','<=', $data['mulai']);
                $query->where('selesai_audit1','>=', $data['mulai']);
            })
            ->orWhere(function($query) use ($data){
                $query->where('mulai_audit1','>=', $data['mulai']);
                $query->where('mulai_audit1','<=', $data['selesai']);
                
            })
            ->select('pelaksana1_audit1')
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
                //$query->where('id_registrasi','!=', $data['id_regis']);
              
            })
            
            /*->get();*/
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
           ->select('pelaksana1_audit1')
            ->get();

            $dataAuditor2_TidakLuangRaw =  DB::table('penjadwalan')
            ->where(function($query) use ($data){
                $query->where('mulai_audit2','<=', $data['mulai']);
                $query->where('selesai_audit2','>=', $data['mulai']);
            })
            ->orWhere(function($query) use ($data){
                $query->where('mulai_audit2','>=', $data['mulai']);
                $query->where('mulai_audit2','<=', $data['selesai']);
              
            })
            
            /*->get();*/
           ->select('pelaksana1_audit2','pelaksana2_audit2')
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
            return response()->json($dataAuditor1);    
        }    
        //Log::info('ini data auditor: '.$dataAuditor1);
       
    }


    public function dataDDTehnicalReview(Request $request)
    {

        $data = $request->except('_token','_method');
        $kodewilayah = Auth::user()->kode_wilayah;
        
        $dataAuditor1_TidakLuang =  DB::table('penjadwalan')
                                    ->where('id_registrasi',$data['id_regis'])
                                    ->select('pelaksana1_audit1')
                                    ->get();

        $dataAuditor2_TidakLuang =  DB::table('penjadwalan')
                                    ->where('id_registrasi',$data['id_regis'])
                                    ->select('id','pelaksana1_audit2','pelaksana2_audit2')
                                    ->get();   
        
        $dataAuditor1_TidakLuang= json_decode($dataAuditor1_TidakLuang, true);

        //Log::info($dataAuditor2_TidakLuangRaw);    
        $dataAuditor2_TidakLuang= json_decode($dataAuditor2_TidakLuang, true);
        //Log::info($dataAuditor2_TidakLuangRaw);        
       

        if($kodewilayah == '119'){

           if($dataAuditor1_TidakLuang == NULL && $dataAuditor2_TidakLuang  == NULL ){

                $dataAuditor1 = DB::table('users')
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
                                // ->where(function($query) use ($key,$key2){
                                //         $query->where('usergroup_id','10')  ; 
                                        
                                //         $query->where('id','!=',$key['pelaksana1_audit1']);                     
                                //         $query->where('id','!=',$key2['pelaksana1_audit2']);
                                //         $query->where('id','!=',$key2['pelaksana2_audit2']);
                                        

                                // })
                                ->where(function($query) use ($key,$key2){
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
                            // ->where(function($query) use ($key){
                            //         $query->where('usergroup_id','10')  ;  
                            //         $query->where('id','!=',$key['pelaksana1_audit1']);
                                                                        
                            // })
                            ->where(function($query) use ($key){
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
                        // ->where(function($query) use ($key2){
                        //         $query->where('usergroup_id','10')  ;  
                        //         $query->where('id','!=',$key2['pelaksana1_audit2']);
                        //         $query->where('id','!=',$key2['pelaksana2_audit2']);
                                
                                
                        // })
                        ->where(function($query) use ($key2){
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
                    // ->where(function($query) use ($kodewilayah){
                    //     $query->where('usergroup_id','10');
                    //     $query->where('kode_wilayah',$kodewilayah);
                    // })
                    ->where(function($query) use ($kodewilayah){
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
                                // ->where(function($query) use ($key,$key2,$kodewilayah){
                                //         $query->where('usergroup_id','10')  ; 
                                //         $query->where('kode_wilayah',$kodewilayah);
                                //         $query->where('id','!=',$key['pelaksana1_audit1']);                     
                                //         $query->where('id','!=',$key2['pelaksana1_audit2']);
                                //         $query->where('id','!=',$key2['pelaksana2_audit2']);
                                        

                                // })
                                ->where(function($query) use ($key,$key2,$kodewilayah){
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
                            // ->where(function($query) use ($key,$kodewilayah){
                            //         $query->where('usergroup_id','10')  ; 
                            //         $query->where('kode_wilayah',$kodewilayah); 
                            //         $query->where('id','!=',$key['pelaksana1_audit1']);
                                                                        
                            // })
                            ->where(function($query) use ($key,$kodewilayah){
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
                        // ->where(function($query) use ($key2,$kodewilayah){
                        //         $query->where('usergroup_id','10')  ; 
                        //         $query->where('kode_wilayah',$kodewilayah); 
                        //         $query->where('id','!=',$key2['pelaksana1_audit2']);
                        //         $query->where('id','!=',$key2['pelaksana2_audit2']);
                                
                                
                        // })
                        ->where(function($query) use ($key2,$kodewilayah){
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
        // dd($data);


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
            $j->selesai_audit1 = $data['selesai_audit1'];
            $j->status_penjadwalan_audit1 = 1;
            $e->status = '7_1';
            $j->pelaksana1_audit1 = $data['pelaksana1_audit1'];
            $j->skema = $data['skema_audit'];

            $e->save();
            $j->save();
        }else{
           //dd($data['mulai_audit1']);
            $model2->mulai_audit1 = $data['mulai_audit1'];
            $model2->selesai_audit1 = $data['selesai_audit1'];
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
            $this->LogKegiatan($data['idregis1'], Auth::user()->id, Auth::user()->name, 7, "Menjadwalkan audit tahap 1. Dan menunggu reviewer mengkonfirmasi jadwal.", Auth::user()->usergroup_id);

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
            $j->selesai_audit2 = $data['selesai_audit2'];
            $j->status_penjadwalan_audit2 = 1;
            $j->pelaksana1_audit2 = $data['pelaksana1_audit2'];
            $j->pelaksana2_audit2 = $data['pelaksana2_audit2'];
            $e->status= '9_1';
            $e->save();  

            $j->save();
        }else{
           //dd($data['mulai_audit1']);
            $model2->mulai_audit2 = $data['mulai_audit2'];
            $model2->selesai_audit2 = $data['selesai_audit2'];
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
            $this->LogKegiatan($data['idregis2'], Auth::user()->id, Auth::user()->name, 9, "Menjadwalkan audit tahap 2. Dan menunggu reviewer mengkonfirmasi jadwal.", Auth::user()->usergroup_id);

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
        // dd($data);


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
            $this->LogKegiatan($data['idregis3'], Auth::user()->id, Auth::user()->name, 11, "Menjadwalkan technical review. Dan menunggu reviewer mengkonfirmasi jadwal.", Auth::user()->usergroup_id);
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
            $this->LogKegiatan($data['idregis4'], Auth::user()->id, Auth::user()->name, 13, "Menjadwalkan komite sertifikasi. Dan menunggu reviewer mengkonfirmasi jadwal.", Auth::user()->usergroup_id);
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
        
        return view('penjadwalan.listPersiapanSidang');
    }

    public function daftarPeriksaRekomendasi($id_registrasi){

        // dd($id_registrasi);

        $model2 = new Registrasi();
        $model3 = new KelompokProduk();        
        
        $dataRegis = DB::table('registrasi')                                      
             ->select('registrasi.*','ruang_lingkup.ruang_lingkup','penjadwalan.skema', 'penjadwalan.mulai_audit1', 'penjadwalan.selesai_audit2', 'penjadwalan.pelaksana1_audit2','pelaksana2_audit2', 'kelompok_produk.kelompok_produk', 'laporan_audit1.file_laporan_audit1', 'laporan_audit2.file_konfirmasi_sk_audit','laporan_audit2.file_surat_tugas','laporan_audit2.file_rencana_audit','laporan_audit2.file_laporan_audit_tahap_2','laporan_audit2.file_bap','laporan_audit2.file_bap_sampel','laporan_audit2.file_daftar_hadir')
             ->where('registrasi.id',$id_registrasi)
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('laporan_audit2','registrasi.id','=','laporan_audit2.id_registrasi')
             ->join('laporan_audit1','registrasi.id','=','laporan_audit1.id_registrasi')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id')                          
             ->get(); 

        $daftarPeriksaRekomendasi = DB::table('daftar_periksa_rekomendasi')
            ->select('daftar_periksa_rekomendasi.*')
            ->where('daftar_periksa_rekomendasi.id_registrasi', $id_registrasi)
            ->get();

        //dd($daftarPeriksaRekomendasi);
        if(isset($daftarPeriksaRekomendasi[0])){
            $dataRegis = json_decode($dataRegis, true);
            $dataPeriksaRekomendasi = json_decode($daftarPeriksaRekomendasi, true);
            // dd($dataRegis);
            return view('penjadwalan.daftarPeriksaRekomendasi',compact('dataRegis','dataPeriksaRekomendasi'));
        }else{

            Session::flash('error', "data belum tersedia!"); 
            return redirect()->back();
        }
        // $reg = $model2->find($id_registrasi);
      
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
            ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.kode_wilayah','registrasi.alamat_perusahaan' ,'registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*')
             //->join('registrasi_alamatkantor', 'registrasi.id','=','registrasi_alamatkantor.id_registrasi')
            ->where('registrasi.status_cancel','=',0)
            ->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%') 
            ->where(function($query) use ($id_user){
               
                    $query->where('registrasi.status','=',8) 
                    ->orwhere('registrasi.status','=','8_0') 
                    ->orwhere('registrasi.status','=','8_1') 
                    ->orwhere('registrasi.status','=','8_2')
                    ->orwhere('registrasi.status','=',9) 
                    ->orwhere('registrasi.status','=','9_0') 
                    ->orwhere('registrasi.status','=','9_1') 
                    ->orwhere('registrasi.status','=','9_2');  
            }); 

        //filter condition        
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('registrasi.no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        if(isset($gdata['nama_perusahaan'])){
            $xdata = $xdata->where('registrasi.nama_perusahaan','LIKE','%'.$gdata['nama_perusahaan'].'%');
        }
        if(isset($gdata['mulai_audit1'])){
            $xdata = $xdata->where('penjadwalan.mulai_audit1','LIKE','%'.$gdata['mulai_audit1'].'%');
        }
        
        //end
        $xdata = $xdata
        ->groupBy('registrasi.id')
                 ->orderBy('id_regis','desc');

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
            ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','registrasi.kode_wilayah','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*','laporan_audit1.file_laporan_audit1','laporan_audit2.file_laporan_audit_tahap_2','laporan_tehnical_review.file_laporan_tr','laporan_tinjauan.file_laporan_tinjauan','laporan_tehnical_review.catatan_tr','laporan_tinjauan.catatan_tinjauan','laporan_persiapan_sidang.catatan_persiapan_sidang','registrasi.alamat_perusahaan')
            //  ->join('laporan_audit1','registrasi.id_laporan_audit1','=','laporan_audit1.id')
            ->where('registrasi.status_cancel','=',0)
            ->where('registrasi.status','!=',18)
            ->where('penjadwalan.status_penjadwalan_audit2','=',3)
            ->where(function($query) use ($id_user){
               
                $query->where('penjadwalan.pelaksana1_audit2','LIKE','%'.$id_user.'%')
                ->orWhere('penjadwalan.pelaksana2_audit2','LIKE','%'.$id_user.'%');
    
            });  

        //filter condition        
        if(isset($gdata['no_registrasi'])){            
            $xdata = $xdata->where('registrasi.no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');            
        }
        if(isset($gdata['nama_perusahaan'])){
            $xdata = $xdata->where('registrasi.nama_perusahaan','LIKE','%'.$gdata['nama_perusahaan'].'%');
        }
        if(isset($gdata['mulai_audit2'])){
            $xdata = $xdata->where('penjadwalan.mulai_audit2','LIKE','%'.$gdata['mulai_audit2'].'%');
        }

        //end
        $xdata = $xdata
        ->groupBy('registrasi.id')
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
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*', 'laporan_audit1.file_laporan_audit1','laporan_audit2.file_laporan_audit_tahap_2', 'laporan_tehnical_review.catatan_tr', 'laporan_tehnical_review.status_laporan_tr', 'laporan_tehnical_review.status_lanjut_ks','laporan_audit2.file_laporan_ketidaksesuaian','laporan_audit2.file_bap' )

            ->where('registrasi.status_cancel','=',0) 
            ->where('registrasi.status','=',12)              
            ->where(function($query) use ($id_user){
                $query->where('penjadwalan.pelaksana1_tr','LIKE','%'.$id_user.'%')
                ->orWhere('penjadwalan.pelaksana2_tr','LIKE','%'.$id_user.'%');
                
            });
           
       

        //filter condition
        if(isset($gdata['no_registrasi'])){
            $xdata = $xdata->where('registrasi.no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        }
        if(isset($gdata['nama_perusahaan'])){
            $xdata = $xdata->where('registrasi.nama_perusahaan','LIKE','%'.$gdata['nama_perusahaan'].'%');
        }
        //end
        $xdata = $xdata
        ->groupBy('registrasi.id')
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
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*', 'laporan_audit1.file_laporan_audit1','laporan_audit2.file_laporan_audit_tahap_2', 'laporan_tehnical_review.file_laporan_tr','laporan_tinjauan.catatan_tinjauan', 'laporan_tinjauan.status_laporan_tinjauan','laporan_audit2.file_laporan_ketidaksesuaian','laporan_audit2.file_bap' )

             ->where('registrasi.status_cancel','=',0) 
             ->where('registrasi.status','=',14)              
             ->where(function($query) use ($id_user){
                 $query->where('penjadwalan.pelaksana1_tinjauan','LIKE','%'.$id_user.'%')
                 ->orWhere('penjadwalan.pelaksana2_tinjauan','LIKE','%'.$id_user.'%');
                 
             });
                     
           
       

            if(isset($gdata['no_registrasi'])){
                $xdata = $xdata->where('registrasi.no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
            }
            if(isset($gdata['nama_perusahaan'])){
                $xdata = $xdata->where('registrasi.nama_perusahaan','LIKE','%'.$gdata['nama_perusahaan'].'%');
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
             ->leftjoin('pembayaran','registrasi.id','=','pembayaran.id_registrasi') 
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenis','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.perusahaan as perusahaan','penjadwalan.*', 'laporan_audit1.file_laporan_audit1','laporan_audit2.file_laporan_audit_tahap_2', 'laporan_tehnical_review.file_laporan_tr','laporan_tinjauan.file_laporan_tinjauan','laporan_tinjauan.catatan_tinjauan', 'laporan_tinjauan.status_laporan_tinjauan','laporan_persiapan_sidang.catatan_persiapan_sidang', 'laporan_persiapan_sidang.status_persiapan_sidang','laporan_audit2.file_laporan_ketidaksesuaian','laporan_audit2.file_bap', 'pembayaran.status_tahap1','pembayaran.status_tahap2','pembayaran.status_tahap3', 'registrasi.jenis_pendanaan','registrasi.nama_fasilitator')

             ->where('registrasi.status_cancel','=',0)      
             ->where('registrasi.status','=',15);
       

            if(isset($gdata['no_registrasi'])){
                $xdata = $xdata->where('registrasi.no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
            }
            if(isset($gdata['nama_perusahaan'])){
                $xdata = $xdata->where('registrasi.nama_perusahaan','LIKE','%'.$gdata['nama_perusahaan'].'%');
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

    public function berkasView($id_regis, $id_user, $file){
        // dd($file);
        if($file == 'penawaran_harga'){
            $data = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($data as $key ) {
                $penawaranHarga = $key;
            }

            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('penawaranHarga'));
        }else if($file == 'konfirmasi_sk'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi = $key;
            }

            $data = DB::table('laporan_audit2')
                ->where('id_registrasi', $id_regis)
                ->select('*')
                ->get();
            
            foreach ($data as $key ) {
                $konfirmasiSK = $key;
            }
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi','konfirmasiSK'));
        }else if($file == 'surat_tugas'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi = $key;
            }

            $data = DB::table('laporan_audit2')
                ->where('id_registrasi', $id_regis)
                ->select('*')
                ->get();
            
            foreach ($data as $key ) {
                $suratTugas = $key;
            }
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi','suratTugas'));
        }else if($file == 'audit_plan'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi = $key;
            }

            $data = DB::table('laporan_audit2')
                ->where('id_registrasi', $id_regis)
                ->select('*')
                ->get();
            
            foreach ($data as $key ) {
                $auditPlan = $key;
            }
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi','auditPlan'));
        }else if($file == 'laporan_audit_tahap1'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi = $key;
            }

            $data = DB::table('laporan_audit1')
                ->where('id_registrasi', $id_regis)
                ->select('*')
                ->get();
            
            foreach ($data as $key ) {
                $audit1 = $key;
            }
    
            // dd($datkey);
            // return view('penjadwalan.viewerBerkas', compact('dataRegistrasi','audit1'));
            return response()->download('storage/laporan/download/Laporan Audit1/'.$audit1->file_laporan_audit1);
        }else if($file == 'laporan_audit_tahap2'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi = $key;
            }

            $data = DB::table('laporan_audit2')
                ->where('id_registrasi', $id_regis)
                ->select('*')
                ->get();
            
            foreach ($data as $key ) {
                $audit2 = $key;
            }
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi','audit2'));
        }else if($file == 'bap'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi = $key;
            }

            $data = DB::table('laporan_audit2')
                ->where('id_registrasi', $id_regis)
                ->select('*')
                ->get();
            
            foreach ($data as $key ) {
                $bap = $key;
            }
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi','bap'));
        }else if($file == 'baps'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi = $key;
            }

            $data = DB::table('laporan_audit2')
                ->where('id_registrasi', $id_regis)
                ->select('*')
                ->get();
            
            foreach ($data as $key ) {
                $baps = $key;
            }
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi','baps'));
        }else if($file == 'daftarHadir'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi = $key;
            }

            $data = DB::table('laporan_audit2')
                ->where('id_registrasi', $id_regis)
                ->select('*')
                ->get();
            
            foreach ($data as $key ) {
                $daftarHadir = $key;
            }
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi','daftarHadir'));
        }else if($file == 'suratPermohonan'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi1 = $key;
            }            
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi1'));
        }else if($file == 'daftarHadirSidang'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi2 = $key;
            }            
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi2'));
        }else if($file == 'beritaAcaraSidang'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi3 = $key;
            }            
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi3'));
        }else if($file == 'tandaTerima'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi4 = $key;
            }            
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi4'));
        }else if($file == 'keputusanFatwa'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi5 = $key;
            }            
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi5'));
        }else if($file == 'dokumentasiSidang'){

            $dataRegis = DB::table('registrasi')
                ->where('id', $id_regis)
                ->select('*')
                ->get();

            foreach ($dataRegis as $key ) {
                $dataRegistrasi6 = $key;
            }            
    
            // dd($datkey);
            return view('penjadwalan.viewerBerkas', compact('dataRegistrasi6'));
        }
                    //  dd($datkey);         
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

    public function listMonitoringLog($id){
        $id_user = $id;
        return view('penjadwalan.listMonitoringLog', compact('id_user'));
    }

    public function dataMonitoringLog(Request $request, $id){
        $gdata = $request->except('_token','_method');
        $id_user = $id;
        //start
       
        $dataAudit1 = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id') 
            ->where('registrasi.status_cancel','=',0)  
            ->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%')
        
            ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenisR','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.id as id_user','penjadwalan.mulai_audit1 as mulai','penjadwalan.selesai_audit1 as selesai','penjadwalan.pelaksana1_audit1 as pelaksana1','penjadwalan.pelaksana2_audit1 as pelaksana2', 'penjadwalan.skema as skema', 'penjadwalan.ktg_audit2 as ktg')
            ->orderBy('mulai','desc');

        

       
        
       
               
       
        // if(isset($gdata['no_registrasi'])){

        //     $dataAudit1 = $dataAudit1->where('registrasi.no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
           
        // }
        // if(isset($gdata['nama_perusahaan'])){
        //     $dataAudit1 = $dataAudit1->where('registrasi.nama_perusahaan','LIKE','%'.$gdata['nama_perusahaan'].'%');
           
            
        // }
        // if(isset($gdata['mulai'])){
        //     $dataAudit1 = $dataAudit1->where('penjadwalan.mulai_audit1','LIKE','%'.$gdata['mulai'].'%');
        // }

        $xdata = $dataAudit1
        ->get();

      
        return Datatables::of($xdata)->make();
    }
    public function dataMonitoringLog2(Request $request, $id){
        $gdata = $request->except('_token','_method');
        $id_user = $id;
        //start
       
        

        $dataAudit2 = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id') 
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenisR','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.id as id_user','penjadwalan.mulai_audit2 as mulai','penjadwalan.selesai_audit2 as selesai','penjadwalan.pelaksana1_audit2 as pelaksana1','penjadwalan.pelaksana2_audit2 as pelaksana2', 'penjadwalan.skema as skema', 'penjadwalan.ktg_audit2 as ktg' )
             ->where('registrasi.status_cancel','=',0)  
            ->where(function($query) use ($id_user){
              
                $query->where('penjadwalan.pelaksana1_audit2','LIKE','%'.$id_user.'%')
                ->orWhere('penjadwalan.pelaksana2_audit2','LIKE','%'.$id_user.'%');
                //$query->where('penjadwalan.status_penjadwalan_audit2','=', 4);
  
            })
            ->orderBy('mulai','desc');
        
       
               
       
        // if(isset($gdata['no_registrasi'])){

           
        //     $dataAudit2 = $dataAudit2->where('registrasi.no_registrasi','LIKE','%'.$gdata['no_registrasi'].'%');
        // }
        // if(isset($gdata['nama_perusahaan'])){
           
        //     $dataAudit2 = $dataAudit2->where('registrasi.nama_perusahaan','LIKE','%'.$gdata['nama_perusahaan'].'%');
            
        // }
        // if(isset($gdata['mulai'])){
        //     $dataAudit2 = $dataAudit2->where('penjadwalan.mulai_audit2','LIKE','%'.$gdata['mulai'].'%');

        // }

        $xdata = $dataAudit2
        ->get();

      
        return Datatables::of($xdata)->make();
    }

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
            ->where('registrasi.status_cancel','=',0)  
            ->where('penjadwalan.pelaksana1_audit1','LIKE','%'.$id_user.'%')
        
            ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenisR','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.id as id_user','penjadwalan.mulai_audit1 as mulai','penjadwalan.selesai_audit1 as selesai','penjadwalan.pelaksana1_audit1 as pelaksana1','penjadwalan.pelaksana2_audit1 as pelaksana2', 'penjadwalan.skema as skema', 'penjadwalan.ktg_audit2 as ktg');

        

       

        $xdata = $dataAudit1->get();

      
        return Datatables::of($xdata)->make();
    }
    public function dataLog2(Request $request){
        $gdata = $request->except('_token','_method');
        $id_user = Auth::user()->id;
        //start
        

        $dataAudit2 = DB::table('registrasi')
             ->join('ruang_lingkup','registrasi.id_ruang_lingkup','=','ruang_lingkup.id')
             ->join('kelompok_produk','registrasi.jenis_produk','=','kelompok_produk.id')
             ->join('users','registrasi.id_user','=','users.id')
             ->join('penjadwalan','registrasi.id_penjadwalan','=','penjadwalan.id') 
             ->select('registrasi.id as id_regis', 'registrasi.no_registrasi as no_registrasi','registrasi.status as status','registrasi.nama_perusahaan as nama_perusahaan','ruang_lingkup.ruang_lingkup as jenisR','kelompok_produk.kelompok_produk as kelompok','users.name as name','users.id as id_user','penjadwalan.mulai_audit2 as mulai','penjadwalan.selesai_audit2 as selesai','penjadwalan.pelaksana1_audit2 as pelaksana1','penjadwalan.pelaksana2_audit2 as pelaksana2', 'penjadwalan.skema as skema', 'penjadwalan.ktg_audit2 as ktg' )
             ->where('registrasi.status_cancel','=',0)  
            ->where(function($query) use ($id_user){
              
                $query->where('penjadwalan.pelaksana1_audit2','LIKE','%'.$id_user.'%')
                ->orWhere('penjadwalan.pelaksana2_audit2','LIKE','%'.$id_user.'%');
                //$query->where('penjadwalan.status_penjadwalan_audit2','=', 4);
  
            }) ;
        
       
               
       
      

        $xdata = $dataAudit2->get();

      
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
        $now=  Carbon::now()->toDateString();


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model4 = new LaporanTehnicalReview;
        $model3 = new User;

        $e = $model->find($data['id']);
        $j = $model4->find($e->id_tehnical_review);
        $u = $model3->find($e->id_user);
        $p = $model2->find($e->id_penjadwalan);

        if($j){

            if($data['status_laporan_tr']== '1'){
                $j->status_laporan_tr = 1;
                
                if($data['status_lanjut_ks']=='0'){
                    $e->status = 15;
                    $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 12, "Upload Berkas Hasil Technical Review dan lanjut ke tahapan persiapan sidang penetapan kehalalan.", Auth::user()->usergroup_id);
                }else if($data['status_lanjut_ks']=='1'){
                    $e->status = 13;
                    $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 12, "Upload Berkas Hasil Technical Review dan lanjut ke tahapan komite sertifikasi.", Auth::user()->usergroup_id);
                }
               
               
                //dd("masuk");
            }else if($data['status_laporan_tr']== '0'){
                $j->status_laporan_tr = 2;
                $e->status = '10_1';
                $p->status_penjadwalan_tr = 0;

                $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 12, "Laporan technical review ditolak, harap perbaiki.", Auth::user()->usergroup_id);
            }
    
            if($request->has("file_laporan_tr")){
                $file = $request->file("file_laporan_tr");
                $file = $data["file_laporan_tr"];
               
                $filename = "TR-".$data['id'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/laporan/upload/Laporan Tehnical Review/", $filename);
                $j->file_laporan_tr = $filename;
                   
            }
            $j->id_registrasi = $e->id;
            $j->catatan_tr = $data['catatan_tr'];
            $j->status_lanjut_ks = $data['status_lanjut_ks'];
            $p->selesai_tr = $now;
            $p->save();
            $e->save();
            $j->save();

        }else{

            if($data['status_laporan_tr']== '1'){
                $model4->status_laporan_tr = 1;
                
                if($data['status_lanjut_ks']=='0'){
                    $e->status = 15;
                    $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 12, "Upload Berkas Hasil Technical Review dan lanjut ke tahapan persiapan sidang penetapan kehalalan.", Auth::user()->usergroup_id);
                }else if($data['status_lanjut_ks']=='1'){
                    $e->status = 13;
                    $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 12, "Upload Berkas Hasil Technical Review dan lanjut ke tahapan komite sertifikasi.", Auth::user()->usergroup_id);
    
                }
               
                //dd("masuk");
            }else if($data['status_laporan_tr']== '0'){
                $model4->status_laporan_tr = 2;
                $e->status = '10_1';
                $p->status_penjadwalan_tr = 0;
                $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 12, "Laporan technical review ditolak, harap perbaiki.", Auth::user()->usergroup_id);
            }
    
            if($request->has("file_laporan_tr")){
                $file = $request->file("file_laporan_tr");
                $file = $data["file_laporan_tr"];
               
                $filename = "TR-".$data['id'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/laporan/upload/Laporan Tehnical Review/", $filename);
                $model4->file_laporan_tr = $filename;
                   
            }
            $model4->catatan_tr = $data['catatan_tr'];
            $model4->status_lanjut_ks = $data['status_lanjut_ks'];
            $model4->id_registrasi = $e->id;
            $model4->save();
            $e->id_tehnical_review = $model4->id; 
            $p->selesai_tr = $now;
            $p->save();     
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
        $now=  Carbon::now()->toDateString();
        //dd($data);


        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        $model4 = new LaporanTinjauan;
        $model3 = new User;

        $e = $model->find($data['id']);
        $j = $model4->find($e->id_tinjauan_komite);
        $u = $model3->find($e->id_user);
        $p = $model2->find($e->id_penjadwalan);

        if($j){

            if($data['status_laporan_tinjauan']== '1'){
                $j->status_laporan_tinjauan = 1;
                $e->status = 15;
                $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 14, "Upload Berkas Hasil Komite Sertifikasi dan lanjut ke tahapan persiapan sidang penetapan kehalalan.", Auth::user()->usergroup_id);
                //dd("masuk");
            }else if($data['status_laporan_tinjauan']== '0'){
                $j->status_laporan_tinjauan = 0 ;
                $e->status = '10_1';
                $p->status_penjadwalan_tinjauan = 0;
                $p->status_penjadwalan_tr = 0;

                $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 14, "Laporan hasil Komite Sertifikasi ditolak, harap perbaiki.", Auth::user()->usergroup_id);
            }
    
            if($request->has("file_laporan_tinjauan")){
                $file = $request->file("file_laporan_tinjauan");
                $file = $data["file_laporan_tinjauan"];
            
                $filename = "KS-".$data['id'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/laporan/upload/Laporan Tinjauan Komite/", $filename);
                $j->file_laporan_tinjauan = $filename;
                
            }
            $j->id_registrasi = $e->id;
            $j->catatan_tinjauan = $data['catatan_tinjauan'];
            $p->selesai_tinjauan = $now;
            $p->save();
            $e->save();
            $j->save();

        }else{

            if($data['status_laporan_tinjauan']== '1'){
                $model4->status_laporan_tinjauan = 1;
                $e->status = 15;
                $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 14, "Upload Berkas Hasil Komite Sertifikasi dan lanjut ke tahapan persiapan sidang penetapan kehalalan.", Auth::user()->usergroup_id);
            
                //dd("masuk");
            }else if($data['status_laporan_tinjauan']== '0'){
                $model4->status_laporan_tinjauan = 0 ;
                $e->status = '10_1';
                $p->status_penjadwalan_tr = 0;
                $p->status_penjadwalan_tinjauan = 0;

                $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 14, "Laporan hasil Komite Sertifikasi ditolak, harap perbaiki.", Auth::user()->usergroup_id);
            }
    
            if($request->has("file_laporan_tinjauan")){
                $file = $request->file("file_laporan_tinjauan");
                $file = $data["file_laporan_tinjauan"];
            
                $filename = "KS-".$data['id'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/laporan/upload/Laporan Tinjauan Komite/", $filename);
                $model4->file_laporan_tinjauan = $filename;
                
            }
            $model4->id_registrasi = $e->id;
            $model4->catatan_tinjauan = $data['catatan_tinjauan'];
            $model4->save();
            $e->id_tinjauan_komite = $model4->id; 
            $e->save();
            $p->selesai_tinjauan = $now;
            $p->save();
            

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
        $p = $model2->find($e->id_penjadwalan);

        if($j){

            if($data['status_persiapan_sidang']== '1'){
                $j->status_persiapan_sidang = 1;
                $e->status = 16;
                
            
                //dd("masuk");
            }else if($data['status_persiapan_sidang']== '0'){
                $j->status_persiapan_sidang = 0 ;
                $e->status = '10_1';
                $p->status_penjadwalan_tr = 0;
                $p->status_penjadwalan_tinjauan = 0;
            }
    
            
            $j->id_registrasi = $e->id;
            $j->catatan_persiapan_sidang = $data['catatan_persiapan_sidang'];
            $p->save();
            $e->save();
            $j->save();

        }else{

            if($data['status_persiapan_sidang']== '1'){
                $model4->status_persiapan_sidang = 1;
                $e->status = 16;
                
            
                //dd("masuk");
            }else if($data['status_persiapan_sidang']== '0'){
                $model4->status_persiapan_sidang = 0 ;
                $e->status = '10_1';
                $p->status_penjadwalan_tr = 0;
                $p->status_penjadwalan_tinjauan = 0;
            }
    
           
            $model4->id_registrasi = $e->id;
            $model4->catatan_persiapan_sidang = $data['catatan_persiapan_sidang'];
            $p->save();
            $model4->save();
            $e->id_persiapan_sidang = $model4->id; 
            $e->save();
            
            

        }
            
        try{
            DB::Commit();
            $this->LogKegiatan($data['id'], Auth::user()->id, Auth::user()->name, 15, "Laporan Hasil Akhir Audit Disetujui, Tahapan Lanjut ke Proses Sidang Fatwa.", Auth::user()->usergroup_id);
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

    public function LogKegiatan($id_registrasi, $id_user, $nama, $id_kegiatan, $judul_kegiatan, $usergroup_id){
        $model3 = new LogKegiatan();
        DB::beginTransaction();
            $model3->id_registrasi = $id_registrasi;
            $model3->id_user = $id_user;
            $model3->nama_user = $nama;
            $model3->id_kegiatan = $id_kegiatan;
            $model3->usergroup_id = $usergroup_id;
            $model3->judul_kegiatan = $judul_kegiatan;            
            $model3->save();
        DB::commit();
    }
}


    