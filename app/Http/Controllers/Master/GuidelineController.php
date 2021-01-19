<?php

namespace App\Http\Controllers\Master;
use Illuminate\Support\Facades\Auth;
use App\Models\System\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuidelineController extends Controller
{
    public function index(){
		$id = Auth::user()->id;
        $user = User::find($id);

		return view('master.guideline.index',compact('user'));
	}
}
