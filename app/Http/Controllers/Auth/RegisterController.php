<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Mail\VerifikasiEmail;
use App\Mail\ResetPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data,[
            'name'=>['required','string','max:255'],
            'email'=>['required','string','email','max:255','unique:users'],
            'password'=>['required','string','min:8','confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function registerUser(){
        return view('auth.register');
    }

    public function store(Request $request){
        $data = $request->except('_method');

        $checkEmail = User::where('email',$data['email'])->first();
        $checkUsername = User::where('username',$data['username'])->first();

        if(isset($checkEmail)){
            $errstatus = "Email sudah terdaftar";
            $redirect = redirect('register')->with('errstatus',$errstatus);
            return $redirect;
        }

        if(isset($checkUsername)){
            $errstatus = "Username sudah terdaftar, silahkan pilih username lain";
            $redirect = redirect('register')->with('errstatus',$errstatus);
            return $redirect;
        }

        if($data['password'] != $data['confirmpassword']){
            $errstatus = "Data gagal disimpan!,Password dan Konfirmasi password tidak sama!";
            $redirect = redirect('register')->with('errstatus',$errstatus);
            return $redirect;
        }

        unset($data["confirmpassword"]);
        $data["password"] = Hash::make($data["password"]);

        $model = new User();
        try{
            DB::beginTransaction();
            $model->fill($data);
            $model->username = $data['username'];
            $model->name = ucwords($data['name']);
            $model->perusahaan = $data['perusahaan'];
            $model->negara = ucwords($data['negara']);
            $model->kota = ucwords($data['kota']);
            $model->alamat = $data['alamat'];
            $model->status = 0;
            $model->usergroup_id = 2;
            $model->save();
            $model->token = $model->id."REG".$data['_token'];
            $model->save();
            //DB::commit();

            /*Send Email */
            $getUSer = User::where('email','=',$data['email'])->get();



            foreach ($getUSer as $getU){
                $u = User::find($getU->id);

        				try{
        					Mail::to($u->email)->send(new VerifikasiEmail($u));
                            //Session::flash('success', "data berhasil disimpan!");
                            $statusreg = "Data berhasil disimpan, silahkan verifikasi email anda untuk bisa login";

                            DB::commit();
                                
        				}catch(\Exception $e){

        					//Session::flash('error', $e->getMessage());
                            Session::flash('success', "data berhasil disimpan!");
                            $statusreg = $e->getMessage();

        				}

            }
		
    			$redirect = redirect('login')->with('statusreg',$statusreg);
    			return $redirect;

            }catch (\Exception $e){
                DB::rollBack();

                //$this->debugs($e->getMessage());

                Session::flash('error', $e->getMessage());
                $redirectPass = redirect()->route('register');
                return $redirectPass;
            }
    }

    public function verifyUser($token){
        $verifyUser = User::where('token',$token)->first();

        if(isset($verifyUser)){
            if($verifyUser->status == 0){

                $model = new User();
                DB::beginTransaction();
                $e = $model->find($verifyUser->id);
                $e->status = 1;
                $e->save();
                DB::commit();

                $statusreg = "Email berhasil terverifikasi, silahkan login";

             }else{
                $statusreg = "Email sudah terverifikasi, silahkan login";

             }

        }else{
            $statusreg = "Email tidak teridentifikasi";

        }

        $redirect = redirect('login')->with('statusreg',$statusreg);
        return $redirect;

    }

    public function forgotPassword(){
        return view('auth.input_email');
    }

    public function sendResetPassword(Request $request){
        $data = $request->except('_method');
        $getUSer = User::where('email','=',$data['email'])->get();

        // echo "<pre>";
        // print_r($getUSer);
        // echo "</pre>";

        if(count($getUSer)){
            foreach ($getUSer as $getU){
                $u = User::find($getU->id);
                Mail::to($u->email)->send(new ResetPassword($u));

            }
            $statusreg = "Link sudah dikirim ke email anda, silahkan dicek";
            $redirect = redirect('login')->with('statusreg',$statusreg);
            return $redirect;
        }else{
            $errstatus = "Email tidak terdaftar";
            $redirect = redirect('login')->with('errstatus',$errstatus);
            return $redirect;
        }

    }

    public function resetPassword($token){
        $data = User::where('token',$token)->first();

        return view('auth.reset_password', compact('data'));
    }

    public function storeNewPassword(Request $request, $id){
        $data = $request->except('_token','_method');

        $xid = $data['id'];
        unset($data["confirmpassword"]);
        $data["password"] = Hash::make($data["password"]);

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die();

        $model = new User();
        try{
            DB::beginTransaction();
            $a = $model->find($xid);
            $a->fill($data);
            $a->save();
            DB::commit();

            $statusreg = "Password berhasil diupdate";
            $redirect = redirect('login')->with('statusreg',$statusreg);
            return $redirect;

        }catch (\Exception $e){
            DB::rollBack();

            $statusreg = "Terjadi kesalahan, hapar hubungin helpdesk";
            $redirect = redirect('login')->with('statusreg',$statusreg);
            return $redirect;
        }
    }



}
