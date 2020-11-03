<?php

namespace App\Http\Controllers\System;

use App\Models\System\Log;
use App\Models\Master\Bumn;
use App\Models\System\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;

class LogController extends Controller
{
    public function index(){
        $bumn = Bumn::all();
        $user = User::all();
        return view('system.log.index',compact('bumn','user'));
    }

    public function debug($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }

    public function datatable(Request $request){
        $gdata = $request->except('_token','_method');

        $data = new Log();
        if(isset($gdata['name'])){
            $data = $data->where('name','=',$gdata['name']);
        }
        if(isset($gdata['bumn_code'])){
            $data = $data->where('bumn_code','=',$gdata['bumn_code']);
        }
        if(isset($gdata['activity'])){
            $data = $data->where('activity','LIKE',$gdata['activity'].'%');
        }

        if(isset($gdata['startdate']) && isset($gdata['enddate'])){
            $data = $data
                    ->where('date','>=',$gdata['startdate'])
                    ->where('date','<=',$gdata['enddate']);
        }else{
            //jika default tampilan data khusus hari ini
            $today = date('Y-m-d');
            $data = $data
                    ->where('date','>=',$today)
                    ->where('date','<=',$today);
        }

        $data = $data->orderBy('id','desc');
        
        return DataTables::of($data)->make();
    }
}
