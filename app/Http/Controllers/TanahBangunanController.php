<?php

namespace App\Http\Controllers;

use App\Models\Master\Bumn;
use App\Models\Master\KodeAsset;
use App\Models\TanahBangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Services\LogServices;

class TanahBangunanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$kodeAsset = KodeAsset::all();
        $kodeAsset = new KodeAsset();
        $kodeAsset = $kodeAsset
                    ->where('kode_kelompok','LIKE','1.%')
                    ->orWhere('kode_kelompok','LIKE','2.%')->get();          
        return view('tanahbangunan.index',compact('kodeAsset'));
    }

    public function listBki(){
        $kodeAsset = new KodeAsset();
        $kodeAsset = $kodeAsset
                    ->where('kode_kelompok','LIKE','1.%')
                    ->orWhere('kode_kelompok','LIKE','2.%')->get();
        return view('tanahbangunan.listbki',compact('kodeAsset'));
    }

    public function listSci(){
        $kodeAsset = new KodeAsset();
        $kodeAsset = $kodeAsset
                    ->where('kode_kelompok','LIKE','1.%')
                    ->orWhere('kode_kelompok','LIKE','2.%')->get();
        return view('tanahbangunan.listsci',compact('kodeAsset'));
    }

    public function listSi(){
        $kodeAsset = new KodeAsset();
        $kodeAsset = $kodeAsset
                    ->where('kode_kelompok','LIKE','1.%')
                    ->orWhere('kode_kelompok','LIKE','2.%')->get();
        return view('tanahbangunan.listsi',compact('kodeAsset'));
    }

    public function debug($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }

    public function datatable(Request $request){
        $gdata = $request->except('_token','_method');
        $data = new TanahBangunan();
        if(isset($gdata['no_item'])){
            $data = $data->where('no_item','=',$gdata['no_item']);
        }
        if(isset($gdata['nama_asset'])){
            $data = $data->where('nama_asset','=',$gdata['nama_asset']);
        }
        if(isset($gdata['kode_kelompok_asset'])){
            $data = $data->where('kode_kelompok_asset','=',$gdata['kode_kelompok_asset']);
        }
        $xdata = $data->orderBy('id','desc');
        return DataTables::of($xdata)->make();
    }

    public function datatableSCI(Request $request){
        $gdata = $request->except('_token','_method');
        $data = new TanahBangunan();
        if(isset($gdata['no_item'])){
            $data = $data->where('no_item','=',$gdata['no_item']);
        }
        if(isset($gdata['nama_asset'])){
            $data = $data->where('nama_asset','=',$gdata['nama_asset']);
        }
        if(isset($gdata['kode_kelompok_asset'])){
            $data = $data->where('kode_kelompok_asset','=',$gdata['kode_kelompok_asset']);
        }
        $xdata = $data
                ->where('bumn_code','=','SCI')
                ->orderBy('id','desc');
        return DataTables::of($xdata)->make();
    }

    public function datatableSI(Request $request){
        $gdata = $request->except('_token','_method');
        $data = new TanahBangunan();
        if(isset($gdata['no_item'])){
            $data = $data->where('no_item','=',$gdata['no_item']);
        }
        if(isset($gdata['nama_asset'])){
            $data = $data->where('nama_asset','=',$gdata['nama_asset']);
        }
        if(isset($gdata['kode_kelompok_asset'])){
            $data = $data->where('kode_kelompok_asset','=',$gdata['kode_kelompok_asset']);
        }
        $xdata = $data
            ->where('bumn_code','=','SI')
            ->orderBy('id','desc');
        return DataTables::of($xdata)->make();
    }

    public function datatableBKI(Request $request){
        $gdata = $request->except('_token','_method');
        $data = new TanahBangunan();
        if(isset($gdata['no_item'])){
            $data = $data->where('no_item','=',$gdata['no_item']);
        }
        if(isset($gdata['nama_asset'])){
            $data = $data->where('nama_asset','=',$gdata['nama_asset']);
        }
        if(isset($gdata['kode_kelompok_asset'])){
            $data = $data->where('kode_kelompok_asset','=',$gdata['kode_kelompok_asset']);
        }
        $xdata = $data
            ->where('bumn_code','=','BKI')
            ->orderBy('id','desc');
        return DataTables::of($xdata)->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bumn = Bumn::all();
        $kodeAsset = new KodeAsset();
        $kodeAsset = $kodeAsset
                    ->where('kode_kelompok','LIKE','1.%')
                    ->orWhere('kode_kelompok','LIKE','2.%')->get();  
        return view('tanahbangunan.create',compact('bumn','kodeAsset'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token','_method');

        //$this->debug($data);

        $model = new TanahBangunan();
        try{
            DB::beginTransaction();
            $model->fill($data);
            $model->save();
            if(Auth::user()->usergroup_id ==  1){

                if($data['bumn_code'] == '0'){
                    Session::flash('error', "Pilihan Bumn Belum Dipilih");
                    return redirect()->route('manajemendata.formimport');
                }

                $bumn = $data['bumn_code'];
                $model->bumn_code = $bumn;
            }else{
                $bumn = Auth::user()->bumn_code;
                $model->bumn_code = $bumn;
            }
            $model->save();
            DB::commit();

            $name = Auth::user()->username;
            $bumn_code = Auth::user()->bumn_code;
            $activity = "Create Data Tanah Bangunan";
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d'); 
            $time = date('H:i:s'); 
            LogServices::createLog($name,$bumn_code,$activity,$date,$time); 

            Session::flash('success', "Data berhasil disimpan ");
            return redirect()->route('tanahbangunan.index');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
            return redirect()->route('tanahbangunan.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data       = TanahBangunan::find($id);
        $bumn       = Bumn::all();
        $kodeAsset = new KodeAsset();
        $kodeAsset = $kodeAsset
                    ->where('kode_kelompok','LIKE','1.%')
                    ->orWhere('kode_kelompok','LIKE','2.%')->get();  

        return view('tanahbangunan.edit',compact('data','bumn','kodeAsset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data   = $request->except('_token','_method');

        $model = new TanahBangunan();
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->save();
            DB::commit();

            $name = Auth::user()->username;
            $bumn_code = Auth::user()->bumn_code;
            $activity = "Update Data Tanah Bangunan";
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d'); 
            $time = date('H:i:s'); 
            LogServices::createLog($name,$bumn_code,$activity,$date,$time); 
    

            Session::flash('success','Data berhasil di update');

        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error',$e->getMessage());
        }
        return redirect()->route('tanahbangunan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = new TanahBangunan();

        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->delete();
            DB::commit();

            $name = Auth::user()->username;
            $bumn_code = Auth::user()->bumn_code;
            $activity = "Delete Data Tanah Bangunan";
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d'); 
            $time = date('H:i:s'); 
            LogServices::createLog($name,$bumn_code,$activity,$date,$time); 

            Session::flash('success',"Data berhasi dihapus");

        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error',"Data gagal dihapus ". $e->getMessage());
        }

        return redirect()->route('tanahbangunan.index');
    }

}
