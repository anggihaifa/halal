<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Services\FileUploadServices;
use App\Models\System\User;
use App\Models\Pelatihan;

class PelatihanController extends Controller
{
    public function index(){
      $id = Auth::user()->id;
        $user = User::find($id);

      return view('master.pelatihan.index',compact('user'));
    }
    
    public function create(){
      $id = Auth::user()->id;
      $user = User::find($id);
  
      return view('master.pelatihan.create',compact('user'));
    }

    public function uploadImagePelatihan(Request $request){
      //     request()->validate([
      //         'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      //    ]);
         if ($files = $request->file('file')) {
             $destinationPath = public_path().'/assets/img/pelatihan/'; // upload path
          //    $path= public_path(). '/assets/img'.$image_name;
             $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
             $files->move($destinationPath, $profileImage);
          //    return response()->json($files->move($destinationPath, $profileImage));
              // return response()->json(["path" => $destinationPath.$profileImage]);
              return response()->json(request()->getHttpHost()."/assets/img/pelatihan/" . $profileImage);   
          }        
   
          // return Redirect::to("image")
          // ->withSuccess('Great! Image has been successfully uploaded.');                
      } 

      public function dataPelatihan(){
        $id = Auth::user()->id;
        $user = User::find($id);

        if($user->usergroup_id == '11' || $user->usergroup_id == '1'){
            $xdata = DB::table('pelatihan');
        }else if($user->usergroup_id == '10'){
            $xdata = DB::table('pelatihan')
            ->where('id_user','=',Auth::user()->id);
        }

        return Datatables::of($xdata)->make();
    } 

    public function detailPelatihanUser($id){
      $pelatihan = Pelatihan::find($id);
      $pelatihan_all = Db::table('pelatihan')        
      ->where('status_approve','=',1)
      ->get();       

      return view('master.pelatihan.detailUser',compact('pelatihan','pelatihan_all'));
    }

    public function store(Request $request){
      $data = $request->except('_token','_method');      
      $pelatihan = new Pelatihan();

      DB::beginTransaction();
      $pelatihan->nama_penulis = $data['nama_penulis'];
      $pelatihan->id_user = $data['id_user'];
      $pelatihan->judul_pelatihan = $data['judul_pelatihan'];

      $file = $request->file("gambar_cover");
      $file = $data["gambar_cover"];
      $profileImage = "Pelatihan_".date('YmdHis') . "." . $file->getClientOriginalExtension();
      // $file->storeAs("public/",$profileImage);
      $file->storeAs("public/pelatihan/",$profileImage);

      $pelatihan->gambar_cover = $profileImage;
      // dd($data);

      $pelatihan->isi_pelatihan = $data['isi_pelatihan'];      
      $pelatihan->save();
      DB::commit();

      // dd($berita);
      Session::flash('success', "Data berita berhasil disimpan!");            
      $redirect = redirect()->route('pelatihan.index');

      return $redirect;
  }

  public function detailPelatihan($id){
    $pelatihan = Pelatihan::find($id);     

    return view('master.pelatihan.detail',compact('pelatihan'));
  }

  public function destroy($id)
    {
        $model = new Pelatihan();
        try{
            DB::beginTransaction();
            $model = $model->find($id);
            $model->delete();
            DB::commit();

            Session::flash('success', 'data berhasil di dihapus!');

        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('pelatihan.index');
    }

  public function edit($id){		
      $pelatihan = Pelatihan::find($id);
      $user = User::find($pelatihan->id_user);      

      return view('master.pelatihan.edit',compact('pelatihan','user'));
  }

  public function accPelatihan($id){
    $pelatihan = Pelatihan::find($id);

    DB::beginTransaction();
    if($pelatihan->status_approve == 0){
        $pelatihan->status_approve = 1;
    }else{
        $pelatihan->status_approve = 0;
    }
    $pelatihan->save();
    DB::commit();        

    Session::flash('success', "Data pelatihan berhasil disimpan!");            
    $redirect = redirect()->route('pelatihan.index');

    return $redirect;
}
}
