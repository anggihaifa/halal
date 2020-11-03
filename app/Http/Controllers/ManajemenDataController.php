<?php

namespace App\Http\Controllers;

use App\Exports\ManajemenDataExport;
use App\Jobs\ImportData;
use App\Models\Master\Bumn;
use App\Models\TanahBangunan;
use App\Models\NonTanahBangunan;
use App\Imports\TanahBangunanImport;
use App\Http\Controllers\Controller;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\ExcelServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Services\LogServices;


class ManajemenDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bumn = Bumn::all();
        return view('manajemendata.formexport',compact('bumn'));
    }

    public function formImport(){
        $bumn = Bumn::all();
        return view('manajemendata.formimport',compact('bumn'));
    }

    public function formExport(){
        $bumn = Bumn::all();
        return view('manajemendata.formexport',compact('bumn'));
    }

    public function debug($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }

    public function importExcel(Request $request){

        $data = $request->except('_token');

        if(!isset($data['fileToUpload'])){
            Session::flash('error', "File upload tidak ada");
            return redirect()->route('manajemendata.formimport');
        }

        //validasi
        $this->validate($request, [
            'fileToUpload' => 'required|mimes:csv,xls,xlsx'
        ]);

        if(!isset($data['statusUpload'])){
            Session::flash('error', "Pilihan Import Data Belum Dipilih");
            return redirect()->route('manajemendata.formimport');
        }

        if(Auth::user()->usergroup_id ==  1){

            if($data['bumn_code'] == '0'){
                Session::flash('error', "Pilihan Bumn Belum Dipilih");
                return redirect()->route('manajemendata.formimport');
            }

            $bumn = $data['bumn_code'];
        }else{
            $bumn = Auth::user()->bumn_code;
        }
        $statusUpload   = $data['statusUpload'];
        $kategori       = $data['kategori_asset'];

        //get file excel
        $file = $request->file('fileToUpload');

        if($file){

            //create filename
            $filename = rand().$file->getClientOriginalName();
            $filePath = 'app/public/uploadfile/'.$filename;
            $file->storeAs('public/uploadfile',$filename);

            //import data to database
            //Excel::import(new TanahBangunanImport($statusUpload,$kategori,$bumn),storage_path($filePath));

            //validasi data sebelum di import
            $xstatus = "0";
            try{
                $rows = Excel::toArray(new TanahBangunanImport($statusUpload,$kategori,$bumn,$xstatus), storage_path($filePath));
                foreach ($rows as $row){

                    if($kategori == 'TB'){$columnArray = array_column($row,'no_item_tb');}
                    elseif($kategori == 'NTB'){$columnArray = array_column($row,'no_item_ntb');}

                    $checkFormat = array_key_exists("nama_asset",$row[0]) && array_key_exists("kodeasset",$row[0]) && array_key_exists("provinsi",$row[0]) && array_key_exists("nilai_awal",$row[0]);
            
                    //jika format header tidak sesuai
                    if(empty($columnArray)){

                        Session::flash('error', "Format tidak sesuai, check kembali format headernya");
                        return redirect()->route('manajemendata.formimport');

                    }else{

                        //check duplikasi data
                        if($checkFormat){
                            if(count($columnArray) != count(array_unique($columnArray))){
                                Session::flash('error', "Terdapat duplikasi data pada no item, no item harus unik, check kembali sebelum di import");
                                return redirect()->route('manajemendata.formimport');
                            }else{
                            //process import
                                try{
                                    $xstatus = "1";
                                    ImportData::dispatch($filename,$statusUpload,$kategori,$bumn,$xstatus);

                                    Session::flash('success', "Data berhasil di import");
                                    
                                    $name = Auth::user()->username;
                                    $bumn_code = Auth::user()->bumn_code;
                                    $activity = "import excel";
                                    date_default_timezone_set('Asia/Jakarta');
                                    $date = date('Y-m-d'); 
                                    $time = date('H:i:s'); 

                                    LogServices::createLog($name,$bumn_code,$activity,$date,$time);


                                    if($kategori =='TB'){
                                        //return redirect()->route('tanahbangunan.index');
                                        return redirect()->route('manajemendata.formimport');
                                    }elseif ($kategori == 'NTB'){
                                        //return redirect()->route('nontanahbangunan.index');
                                        return redirect()->route('manajemendata.formimport');
                                    }

                                }catch (\Exception $e){
                                    //Session::flash('error', $e->getMessage());
                                    Session::flash('error', "Format tidak lengkap, check kembali format headernya");
                                    return redirect()->route('manajemendata.formimport');
                                }
                            }
                        }else{
                            Session::flash('error', "Format tidak lengkap, check kembali format headernya");
                            return redirect()->route('manajemendata.formimport');
                        }
                    }

                }

            }catch (\Exception $e){

                //Session::flash('error', "Format tidak sesuai, check kembali format headernya");
                Session::flash('error', $e->getMessage());
                return redirect()->route('manajemendata.formimport');
            }

        }else{
            Session::flash('error', "File upload tidak ada");
            return redirect()->route('manajemendata.formimport');
        }

    }

    public function exportExcel(Request $request){
        $data = $request->except('_token');

        $dateNow        = date('YMdhis');

        if(Auth::user()->usergroup_id ==  1){

            if($data['bumn_code'] == '0'){
                Session::flash('error', "Pilihan Bumn Belum Dipilih");
                return redirect()->route('manajemendata.formimport');
            }

            $code = $data['bumn_code'];
        }else{
            $code = Auth::user()->bumn_code;
        }
        $kategori       = $data['kategori_asset'];
        $fileName       = $dateNow.'_'.$code.'_'.$kategori.'export.xlsx';

        $name = Auth::user()->username;
        $bumn_code = Auth::user()->bumn_code;
        $activity = "export excel";
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d'); 
        $time = date('H:i:s'); 

        LogServices::createLog($name,$bumn_code,$activity,$date,$time);   

        //$this->debug($data);
        return Excel::download(new ManajemenDataExport($code,$kategori),$fileName);

        Session::flash('success', "Data berhasil di export");
        return redirect()->route('manajemendata.formexport');

    }
}
