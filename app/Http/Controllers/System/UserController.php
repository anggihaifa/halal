<?php

namespace App\Http\Controllers\System;

use App\Models\Master\Bumn;
use App\Models\System\User;
use App\Models\System\DetailUser;
use App\Http\Controllers\Controller;
use App\Models\System\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    public function index(){
        return view('system.user.index');
    }

    public function debug($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }

    public function datatable(){
        //return DataTables::of(User::with('bumn'))->make();
        //$data = new User();
        //$xdata = $data->orderBy('id','desc')->leftJoin('usergroup','usergroup_id','=','usergroup.id')->get();
        $xdata = DB::table('users')
                ->join('usergroup','users.usergroup_id','=','usergroup.id')
                ->select('users.*','usergroup.usergroup as role')
                ->where('usergroup_id','=','1')
                ->orWhere('usergroup_id','=','3')
                ->orWhere('usergroup_id','=','6')
                ->orWhere('usergroup_id','=','7')
                 ->orWhere('usergroup_id','=','8')
                ->orWhere('usergroup_id','=','9')
                ->orderBy('users.id','desc');
                //->get();
        return Datatables::of($xdata)->make();
    }

    public function listPelanggan(){
        return view('pelanggan.index');
    }

    public function dataPelanggan(Request $request){
        $gdata = $request->except('_token','method');

        //start
        $xdata = DB::table('users')
                ->join('usergroup','users.usergroup_id','=','usergroup.id')
                ->select('users.*','usergroup.usergroup as role');

        //search condition
        if(isset($gdata['email'])){
            $xdata = $xdata->where('email','LIKE','%'.$gdata['email'].'%');
        }
        if(isset($gdata['username'])){
            $xdata = $xdata->where('username','LIKE','%'.$gdata['username'].'%');
        }
        if(isset($gdata['name'])){
            $xdata = $xdata->where('name','LIKE','%'.$gdata['name'].'%');
        }
        if(isset($gdata['perusahaan'])){
            $xdata = $xdata->where('perusahaan','LIKE','%'.$gdata['perusahaan'].'%');
        }        

        //end
        $xdata =  $xdata
                  ->where('usergroup_id','=','2')
                  ->orderBy('users.id','desc');

        return Datatables::of($xdata)->make();   
    }

    public function create(){
        $userGroup = UserGroup::all();
        /*$userGroup = new UserGroup;
        $userGroup = $userGroup->where('id','!=','2')->get();*/
        return view('system.user.create', compact('userGroup'));
    }

    public function debugs ($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }

    public function store(Request $request){
        $data = $request->except('_token','_method');

        if($data['password'] != $data['confirmpassword']){
            $redirectPass = redirect()->route('user.create');
            Session::flash('error',"Data gagal disimpan!" . "Password dan Konfirmasi password tidak sama!");
            return $redirectPass;
        }

        unset($data["confirmpassword"]);
        $data["password"] = Hash::make($data["password"]);

        $model = new User();
        //$this->debugs($data);

        try{
            //$this->debugs($data);
            DB::beginTransaction();
            $model->fill($data);
            $model->save();
            DB::commit();

            Session::flash('success', "data berhasil disimpan!");
            $redirect = redirect()->route('user.index');
            return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            $this->debugs($e->getMessage());

            Session::flash('error', $e->getMessage());
            $redirectPass = redirect()->route('user.create');
            return $redirectPass;
        }

    }

    public function edit($id){
        $data = User::find($id);
        $userGroup = UserGroup::all();
        /*$userGroup = new UserGroup;
        $userGroup = $userGroup->where('id','!=','2')->get();*/

        return view('system.user.edit',compact('data','userGroup'));
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
        return redirect()->route('user.index');
    }

    public function destroy($id){
        $model = new User();
        try{
            DB::beginTransaction();
            $e = $model->find($id);
            $e->delete();
            DB::commit();

            $name = Auth::user()->username;
            $bumn_code = Auth::user()->bumn_code;
            $activity = "Delete Data User";
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d'); 
            $time = date('H:i:s'); 
            LogServices::createLog($name,$bumn_code,$activity,$date,$time);

            Session::flash('success',"Data berhasil dihapus!");
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error',"Data gagal dihapus ! ". $e->getMessage());
        }

        return redirect()->route('user.index');
    }

    //update
    public function editProfile($id){

        $model = new DetailUser();
        $model2 = new User();

        $id_real = Auth::user()->id;
        $data = User::find($id);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://apps.sucofindo.co.id/sciapi/index.php/invoice/listunitkerja',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $response = curl_exec($curl);   
        curl_close($curl);

        $response = json_decode($response);
        $cabang = $response->data;
       

        //dd($id_real == $data['id']);
        if($data['id'] ==$id_real){

            if(empty($data->detail_id)==0){
                //dd("isset");
                $data2 = DetailUser::find($data->detail_id);
            }else{
                try{
                    //dd("masuk");
                    DB::beginTransaction();
                    $model->id_user = $id;
                    $model->save();
    
                    $e = DetailUser::where('id_user', '=', $id)->first();
                    $f = $model2->find($id);
                    $f->detail_id = $e->id;
                    $f->save();
                    DB::commit();
                    
                    $data2 = $e;
                }catch (\Exception $e){
                   // dd("try");
                    DB::rollBack();
                    Session::flash('error', $e->getMessage());
                }
                   
                $data2 = DetailUser::where('id_user', '=', $id)->first();   
               
            }

            //dd($data2);
            
            return view('system.user.editprofile',compact('data','data2','cabang'));
        }else{
            return redirect('login');
        }
       
       
    }

    public function updateProfile(Request $request){
        $data = $request->except('_token','_method','telp','noreg_bpjph','no_sertifikat_diklat','no_ujikom','masaberlaku_ujikom','pendidikan','pelatihan','dokumen_pendukung','jenis_kelamin','status_karyawan','foto');
        $data2 = $request->except('_token','_method','username','name','email','perusahaan','negara','kota','alamat','kode_wilayah');
        $id = Auth::user()->id;

        $model = new User();
        $model2 = new DetailUser();
        try{
            DB::beginTransaction();
            $a = $model->find($id);
            $e = $model2->find($a->detail_id);
            $a->fill($data);
            $e->fill($data2);

            if($request->has("foto")){
                $file = $request->file("foto");
                $file = $data2["foto"];
                $filename = "Foto-".$id.".".$file->getClientOriginalExtension();
                $file->storeAs("public/detailUser/".$id."/", $filename);
                $e->foto = $filename;
                //dd("asup");
            }     
            $a->save();
            $e->save();
            DB::commit();
            
            Session::flash('success', "data berhasil diupdate!");

        }catch (\Exception $a){

            DB::rollBack();

            Session::flash('error', $a->getMessage());
        }
        return redirect()->route('home.index');

    }

    public function change_Password(){
        return view('system.user.change_password');
    }

    public function updatePassword(Request $request){

        $data = $request->except('_token','_method');
        $currentPassword = $data["current-password"];
        $newPassword = $data["password"];
        $currentPassword2 = Auth::user()->password;
        $id = Auth::user()->id;

        if(Hash::check($currentPassword,$currentPassword2)){

            if($currentPassword==$newPassword){
                Session::flash('error', "password tidak boleh sama dengan password sebelumnya.");
                return redirect()->route('home');
            }

            if($data['password'] != $data['new-password-confirmation']){
                $redirectPass = redirect()->route('home');
                Session::flash('error',"Data gagal disimpan!" . "Password dan Konfirmasi password tidak sama!");
                return $redirectPass;
            }

            unset($data["current-password"]);
            unset($data["new-password-confirmation"]);
            $data["password"] = Hash::make($data["password"]);

            $model = new User();
            try{
                //$this->debugs($data);
                DB::beginTransaction();
                $a = $model->find($id);
                $a->fill($data);
                $a->save();
                DB::commit();

                //$redirect = redirect()->route('logout');
                //return $redirect;
                Auth::logout();
                $statusreg = "Password berhasil diupdate";
                $redirect = redirect('login')->with('statusreg',$statusreg);
                return $redirect;

            }catch (\Exception $e){
                DB::rollBack();

                $this->debugs($e->getMessage());

                Session::flash('error', $e->getMessage());
                $redirectPass = redirect()->route('home.index');
                return $redirectPass;
            }

        }else{
            Session::flash('error', "password lama tidak sesuai");
            return redirect()->route('home.index');
        }

    }


}
