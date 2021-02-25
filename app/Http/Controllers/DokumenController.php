<?php

namespace App\Http\Controllers;

use App\Models\DokumenHalal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

use Log;

class DokumenController extends Controller
{
    
    public function index()
    {
        return view('dokumen.index');
    }
    public function indexUser()
    {
        return view('dokumen.indexUser');
    }
    public function indexPelanggan()
    {
        return view('dokumen.indexPelanggan');
    }

    public function dokumenView($id)
    {
     
        $data = DokumenHalal::find($id);
       
        $headers = $data->nama_file;
       
        $pathToFile = public_path('storage/dokumenHalal/'.$data->nama_file);
        //dd($pathToFile);

       /* return response()->file($pathToFile);
        return response()->file($pathToFile, $headers);*/

        return view('dokumen.viewer', compact('data'));
    }
    

    public function datatable(){
        $data= DB::table('dokumen_halal')
                    ->select('dokumen_halal.*')
                    ->get();
                
       //Log::info('ini data'. $data);
        return DataTables::of($data)->make();
    }

    public function datatableUser(){
        $data= DB::table('dokumen_halal')
                    ->where('role','user')
                    ->select('dokumen_halal.*')
                    ->get();
                
       //Log::info('ini data'. $data);
        return DataTables::of($data)->make();
    }

    public function datatablePelanggan(){
        $data= DB::table('dokumen_halal')
                    ->where('role','pelanggan')
                    ->select('dokumen_halal.*')
                    ->get();
                
       //Log::info('ini data'. $data);
        return DataTables::of($data)->make();
    }



   
    public function create()
    {

       
        return view('dokumen.create');
       
    }

    public function store(Request $request)
    {
        $data = $request->except('_token','_method');

       //

        $model = new DokumenHalal();


        
       // dd($request->file);

        try{

            DB::beginTransaction();

            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = $data['nama_file'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/dokumenHalal/", $filename);
                $model->nama_file = $filename;
                $model->role = $data['role'];
            }  

           
            $model->save();


            
            DB::commit();

            Session::flash('success',"Data berhasil disimpan!");

            $redirect = redirect()->route('dokumen.index');

        }catch(\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

            $redirect = redirect()->route('dokumen.create');
        }

        return $redirect;
    }

    
    public function edit(Request $request, $id)
    {
        //dd("masuk");
        $data = DokumenHalal::find($id);

        $data->nama_file_extension = $data->nama_file;
        $str = explode(".",$data->nama_file);
        $data->nama_file = $str[0];
        return view('dokumen.edit',compact('data'));
    }

    
    public function update(Request $request, $id)
    {
        //dd($id);
        $data = $request->except('_token','_method');

        $model = new DokumenHalal();
       

        try{

            DB::beginTransaction();
            $e = $model->find($id);

            //dd($data);

            if($request->has("file")){
                $file = $request->file("file");
                $file = $data["file"];
                $filename = $data['nama_file'].".".$file->getClientOriginalExtension();
                $file->storeAs("public/dokumenHalal/", $filename);
                $e->nama_file = $filename;
            }  
               
            $e->save();
            DB::commit();

            Session::flash('success', 'data berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('dokumen.index');
    }

   
    public function destroy(Request $request, $id)
    {   
       
        $model = new DokumenHalal();
        
        //$model = new JenisAkomodasi();
        try{
            DB::beginTransaction();
            $model = $model->find($id);

            Storage::deleteDirectory("public/dokumenHalal/".$model->nama_file);
            $model->delete();
            DB::commit();

            Session::flash('success', 'data berhasil di dihapus!');

        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('dokumen.index');
    }
}
