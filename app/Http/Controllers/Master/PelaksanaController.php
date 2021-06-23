<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Bumn;
use App\Models\System\User;
use App\Http\Controllers\Controller;
use App\Models\System\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class PelaksanaController extends Controller
{
    public function index(){
        return view('master.detailpelaksana.index');
    }


    public function datatable(){
        //return DataTables::of(User::with('bumn'))->make();
        //$data = new User();
        //$xdata = $data->orderBy('id','desc')->leftJoin('usergroup','usergroup_id','=','usergroup.id')->get();
        $xdata = DB::table('users')
                ->join('usergroup','users.usergroup_id','=','usergroup.id')
                ->select('users.*','usergroup.usergroup as role')
                 ->where('usergroup_id','=','10')
                ->orWhere('usergroup_id','=','11')
                ->orWhere('usergroup_id','=','12')
                ->orderBy('users.id','desc');
                //->get();
        return Datatables::of($xdata)->make();
    }

   

    public function edit($id){
        $data = User::find($id);
        $userGroup = UserGroup::all();
        /*$userGroup = new UserGroup;
        $userGroup = $userGroup->where('id','!=','2')->get();*/

        return view('master.detailpelaksana.edit',compact('data','userGroup'));
    }

    public function update(Request $request,$id){
        $data = $request->except('_token','_method');

        $model = new User();
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->fill($data);
            $e->save();
            DB::commit();

            Session::flash('success', "data berhasil disimpan!");
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }
        return redirect()->route('detailpelaksana.index');
    }

    
    


}
