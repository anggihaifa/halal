<?php

namespace App\Http\Controllers\System;

use App\Models\System\UserGroup;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\Datatables;

use Illuminate\Support\Facades\Auth;
use UxWeb\SweetAlert\SweetAlert;
use App\Services\LogServices;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('system.usergroup.index');
    }

    public function datatable(){
        $data = new UserGroup();
        $xdata = $data->orderBy('id','asc')->get();
        return Datatables::of($xdata)->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.usergroup.create');
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

        $model = new UserGroup();
        try{
            DB::beginTransaction();
            $model->fill($data);
            $model->save();
            DB::commit();

            Session::flash('success', 'Data berhasil disimpan ');
            $redirect = redirect()->route('usergroup.index');
        }catch (\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            $redirect = redirect()->route('usergroup.create');
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
        $data = UserGroup::find($id);

        return view('system.usergroup.edit',compact('data'));
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

        $model = new UserGroup();
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->save();
            DB::commit();

            Session::flash('success', 'data berhasil diupdate ');
        }catch (\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }
        return redirect()->route('usergroup.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = new UserGroup();
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->delete();
            DB::commit();

            Session::flash('error', 'Data berhasil dihapus ');
        }catch (\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('usergroup.index');
    }
}
