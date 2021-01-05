<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use App\Services\FileUploadServices;

class FaqController extends Controller
{
	public function index(){
        $getFaq =   DB::table('faq')
                    ->where('status','aktif')
                    ->orderBy('step','asc') 
                    ->get();
        $dataFaq = json_decode($getFaq,true);         
        // return view('auth/login', compact('dataFaq'));
		return view('master.faq.index', compact('dataFaq'));
	}

	public function datatable(){
		$data = new Faq();
        $xdata = $data->orderBy('id','desc')->get();
        return DataTables::of($xdata)->make();
	}


	public function create(){
		return view('master.faq.create');
	}

	public function store(Request $request){
		$data = $request->except('_token','_method');

        $model = new Faq();
        $status = "FAQ";
        try{
            DB::beginTransaction();
            $model->fill($data);
            $model->save();

            //for file
            if(isset($data['file'])){
            	$value =  $data["file"];
            	$key = $model->id;
            	$model->file = FileUploadServices::getFileNameMaster($value,$status,$key);
            	FileUploadServices::getUploadFileMaster($value,$status,$key);
            	$model->save();
            }
            
            DB::commit();

            Session::flash('success',"Data berhasil disimpan!");

            $redirect = redirect()->route('faq.index');

        }catch(\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

            $redirect = redirect()->route('faq.create');
        }

        return $redirect;
	}

	public function faqDetail($id){
		$data = Faq::find($id);

        return view('master.faq.detail',compact('data'));
	}

	public function edit($id){
		$data = Faq::find($id);
        return view('master.faq.edit',compact('data'));
	}

	public function update(Request $request, $id){
		 $data = $request->except('_token','_method');

		 $model = new Faq();
		 $status = "FAQ";
		 $e = $model->find($id);

		try{
            DB::beginTransaction();
            $e->fill($data);
            $e->save();
            if(isset($data['file'])){
                $value = $data["file"];
                $key   = $id;
                $e->file = FileUploadServices::getFileNameMaster($value,$status,$key);
            	FileUploadServices::getUploadFileMaster($value,$status,$key);
            	$e->save();  
            }
            DB::commit();

            Session::flash('success', 'data berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('faq.index');
	}

	public function destroy($id){
		$model = new Faq();
		$status = "FAQ";

		$model = $model->find($id);
        $x = $model->file;


        try{
            DB::beginTransaction();
            FileUploadServices::deleteUploadFileMaster($x,$status);
            $model->delete();
            DB::commit();
            
            Session::flash('success', 'data berhasil di dihapus!');

        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('faq.index');
	}
}