<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuidelineController extends Controller
{
    public function index(){
		return view('master.guideline.index');
	}
}
