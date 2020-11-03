<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\KodeAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
//use Psy\Util\Str;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Services\LogServices;

class KodeAssetController extends Controller
{
    public function index(){
        return view('master.kodeasset.index');
    }

    public function datatable(Request $request){
        $gdata = $request->except('_token','_method');
        $data = new KodeAsset();
        if(isset($gdata['kode_kelompok'])){
            $data = $data->where('kode_kelompok','=',$gdata['kode_kelompok']);
        }
        if(isset($gdata['nama_item'])){
            $data = $data->where('nama_item','=',$gdata['nama_item']);
        }
        $xdata = $data->orderBy('id','asc')->get();
        return Datatables::of($xdata)->make();
    }

    public function datatableSearch(Request $request){
        $gdata = $request->except('_token','_method');
        $data = new KodeAsset();
        if(isset($gdata['kode_kelompok'])){
            $data = $data->where('kode_kelompok','=',$gdata['kode_kelompok']);
        }
        if(isset($gdata['nama_item'])){
            $data = $data->where('nama_item','=',$gdata['nama_item']);
        }
        $xdata = $data->orderBy('id','asc')->get();
        return Datatables::of($xdata)->make();
    }

    public function create(){
        return view('master.kodeasset.create');
    }

    public function debug($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }

    public function store(Request $request){
        $data = $request->except('_token','_method');
        $kodeAsset = implode('.',str_split($data['kode_kelompok']));
        $model = new KodeAsset();
        try{
            DB::beginTransaction();
            $model->fill($data);
            $model->save();
            //$model->kode_kelompok = $kodeAsset;
            //$model->save();
            DB::commit();

            $name = Auth::user()->username;
            $bumn_code = Auth::user()->bumn_code;
            $activity = "Create Data Master Kode Asset";
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d'); 
            $time = date('H:i:s'); 
            LogServices::createLog($name,$bumn_code,$activity,$date,$time);

            Session::flash('success',"Data berhasil disimpan!");

            $redirect = redirect()->route('kodeasset.index');

        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

            $redirect = redirect()->route('kodeasset.create');
        }

        return $redirect;

    }

    public function edit($id){
        $data = KodeAsset::find($id);

        return view('master.kodeasset.edit',compact('data'));
    }

    public function update(Request $request, $id){
        $data = $request->except('_token','_method');

        $model = new KodeAsset();
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->save();
            DB::commit();

            $name = Auth::user()->username;
            $bumn_code = Auth::user()->bumn_code;
            $activity = "Update Data Master Kode Asset";
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d'); 
            $time = date('H:i:s'); 
            LogServices::createLog($name,$bumn_code,$activity,$date,$time);

            Session::flash('success', 'Data berhasil diupdate!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('kodeasset.index');
    }

    public function destroy($id){
        $model = new KodeAsset();
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->delete();
            DB::commit();

            $name = Auth::user()->username;
            $bumn_code = Auth::user()->bumn_code;
            $activity = "Delete Data Master Kode Asset";
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d'); 
            $time = date('H:i:s'); 
            LogServices::createLog($name,$bumn_code,$activity,$date,$time);

            Session::flash('success',"Data berhasil dihapus !");
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', "Data gagal dihapus !");
        }

        return redirect()->route('kodeasset.index');
    }
}
