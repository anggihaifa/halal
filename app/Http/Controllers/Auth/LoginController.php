<?php

namespace App\Http\Controllers\Auth;

use App\Models\System\User;
use App\Models\Master\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use App\Services\LogServices;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers{
        logout as performLogout;
    }

    public function authenticate(Request $request)
    {
        
        $username = $request->get('username');
        $password = $request->get('password');

        //dd($username);

        //$getUSer = User::where('username',$username)->first();
        $getUSer = User::where('username',$username)
                   ->orWhere('email',$username)
                   ->get();
       
        // print_r($getUSer);
        // echo "<br>";           
        // if(count($getUSer)){
        //     echo "ada";
        // }else{
        //     echo "tidak ada";
        // }           
                
        if(count($getUSer)){
            foreach($getUSer as $getU){
                $status = $getU->status;
                /*echo"<pre>";
                print_r($status);
                print_r($getU);
                echo"</pre>";
                die();  */ 
                
                if($status == '0'){
                    $errstatus = "Email belum diverifikasi, silahkan verifikasi terlebih dahulu";
                    $redirect = redirect('login')->with('errstatus',$errstatus);
                    return $redirect;
                }else{
                    
                    if(Auth::attempt(["username"=>$username,"password"=>$password])){
                        return redirect()->route('home.index');
                    }elseif(Auth::attempt(["email"=>$username,"password"=>$password])){                        
                        return redirect()->route('home.index');    
                    }elseif(["username"=>$username,"password"=>$password]){
                        // dd("masuk sini");
                        return redirect()->route('home.index');
                    }elseif(["email"=>$username,"password"=>$password]){
                        
                        return redirect()->route('home.index');
                    }
                    else{
                        $errstatus = "Username atau Password tidak sesuai";
                        $redirect = redirect('login')->with('errstatus',$errstatus);
                        return $redirect;
                    }
                }
            }     
        }else{
            $errstatus = "Username atau email tidak terdaftar";
            $redirect = redirect('login')->with('errstatus',$errstatus);
            return $redirect;
        }

                  
            
    }

    
    public function login(){
        // if(Auth::user()){
        //     //return redirect()->route('home');
        // }else{
        //     return view('auth/login');
        // }
        $getFaq =   DB::table('faq')
                    ->where('status','aktif')
                    ->orderBy('step','asc') 
                    ->get();
        $dataFaq = json_decode($getFaq,true);         
        return view('auth/login', compact('dataFaq'));
    }
    public function loginAs(){
        // if(Auth::user()){
        //     //return redirect()->route('home');
        // }else{
        //     return view('auth/login');
        // }
        $getFaq =   DB::table('faq')
                    ->where('status','aktif')
                    ->orderBy('step','asc') 
                    ->get();
        $dataFaq = json_decode($getFaq,true);         
        return view('auth/login_as', compact('dataFaq'));
    }

    public function change_password(){
        return view('auth/change_password');
    }

    public function logout(){
    
        Auth::logout();

        return redirect()->route('login');
        //return view('auth/login');
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
