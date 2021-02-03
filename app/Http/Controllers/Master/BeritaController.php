<?php

namespace App\Http\Controllers\Master;

use App\Models\System\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Services\FileUploadServices;
use App\Mail\KonfirmasiPembayaran;
use App\Mail\ProgresStatus;
use App\Jobs\SendEmailP;
use App\Jobs\SendEmailK;
use App\Jobs\SendEmailC;
use Illuminate\Support\Facades\Mail;
use PDF;
use Response;
use DateTimeZone;
use DateTime; 
use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\Models\Berita;
use Validator,Redirect,File;

class BeritaController extends Controller
{
    public function index(){
		$id = Auth::user()->id;
        $user = User::find($id);

		return view('master.berita.index',compact('user'));
    }
    
    public function create(){
		$id = Auth::user()->id;
        $user = User::find($id);

		return view('master.berita.create',compact('user'));
    }

    public function detailBerita($id){		
        $berita = Berita::find($id);     

		return view('master.berita.detail',compact('berita'));
    }

    public function cariBerita(Request $request){
        $data = $request->except('_token','_method');
        $berita = Db::table('berita')
                    ->where('judul_berita','like',"%".$data['katakunci']."%")
                    ->where('status_approve','=',1)
                    ->get();       
        // dd($berita);        

		return view('landingpage',compact('berita'));
    }

    public function detailBeritaUser($id){
        $berita = Berita::find($id);        
        $berita_all = Berita::all();

		return view('master.berita.detailUser',compact('berita','berita_all'));
    }

    public function edit($id){		
        $berita = Berita::find($id);
        $user = User::find($berita->id_user);

		return view('master.berita.edit',compact('berita','user'));
    }

    public function accBerita($id){
        $berita = Berita::find($id);

        DB::beginTransaction();
        if($berita->status_approve == 0){
            $berita->status_approve = 1;
        }else{
            $berita->status_approve = 0;
        }
        $berita->save();
        DB::commit();        

        Session::flash('success', "Data berita berhasil disimpan!");            
        $redirect = redirect()->route('berita.index');

        return $redirect;
    }

    public function dataBerita(){
        $id = Auth::user()->id;
        $user = User::find($id);

        if($user->usergroup_id == '6'){
            $xdata = DB::table('berita');
        }else{            
            $xdata = DB::table('berita')
            ->where('id_user','=',Auth::user()->id);
            // $xdata = DB::table('berita')
            //     ->join('users','berita.id_user','=','users.id')
            //     ->select('users.*')
            //     ->where('id_user','=',Auth::user()->id);
        }

        return Datatables::of($xdata)->make();
    }

    public function uploadImage(Request $request){
    //     request()->validate([
    //         'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //    ]);
       if ($files = $request->file('file')) {
           $destinationPath = public_path().'/assets/img/'; // upload path
        //    $path= public_path(). '/assets/img'.$image_name;
           $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profileImage);
        //    return response()->json($files->move($destinationPath, $profileImage));
            // return response()->json(["path" => $destinationPath.$profileImage]);
            return response()->json(request()->getHttpHost()."/assets/img/" . $profileImage);   
        }        
 
        // return Redirect::to("image")
        // ->withSuccess('Great! Image has been successfully uploaded.');                
    }             
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $data = $request->except('_token','_method');
        $berita = new Berita();

        DB::beginTransaction();
        $berita->id_user = $data['id_user'];
        $berita->judul_berita = $data['judul_berita'];
        $berita->nama_penulis = $data['nama_penulis'];
        // $berita->tanggal_publikasi = $data['tanggal_publikasi'];
        $berita->isi_berita = $data['isi_berita'];
        // dd($berita->isi_berita);
        $berita->save();        
        DB::commit();

        // dd($berita);
        Session::flash('success', "Data berita berhasil disimpan!");            
        $redirect = redirect()->route('berita.index');

        return $redirect;
    }
    
    public function destroy($id)
    {
        $model = new Berita();
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

        return redirect()->route('berita.index');
    }
    
}
