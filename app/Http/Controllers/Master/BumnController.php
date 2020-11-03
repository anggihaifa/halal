<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Bumn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Services\LogServices;
//use Alert;

class BumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.bumn.index');
    }

    public function datatable(){
        $data = new Bumn();
        $xdata = $data->orderBy('id','asc')->get();
        return DataTables::of($xdata)->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.bumn.create');
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


        $model = new Bumn();
        try{
            DB::beginTransaction();
            $model->fill($data);
            $model->save();
            DB::commit();

            $name = Auth::user()->username;
            $bumn_code = Auth::user()->bumn_code;
            $activity = "Create Data Master BUMN";
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d'); 
            $time = date('H:i:s'); 
            LogServices::createLog($name,$bumn_code,$activity,$date,$time); 

            Session::flash('success',"Data berhasil disimpan!");

            $redirect = redirect()->route('bumn.index');

        }catch(\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

            $redirect = redirect()->route('bumn.create');
        }

        return $redirect;
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
        $data = Bumn::find($id);

        return view('master.bumn.edit',compact('data'));
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
        $data = $request->except('_token','_method');

        $model = new Bumn();
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->save();
            DB::commit();

            $name = Auth::user()->username;
            $bumn_code = Auth::user()->bumn_code;
            $activity = "Update Data Master BUMN";
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d'); 
            $time = date('H:i:s'); 
            LogServices::createLog($name,$bumn_code,$activity,$date,$time);

            Session::flash('success', 'data berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('bumn.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = new Bumn();
        try{
            DB::beginTransaction();
            $model = $model->find($id);
            $model->delete();
            DB::commit();

            $name = Auth::user()->username;
            $bumn_code = Auth::user()->bumn_code;
            $activity = "Delete Data Master BUMN";
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d'); 
            $time = date('H:i:s'); 
            LogServices::createLog($name,$bumn_code,$activity,$date,$time);

            Session::flash('success', 'data berhasil di dihapus!');

        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('bumn.index');
    }
}
