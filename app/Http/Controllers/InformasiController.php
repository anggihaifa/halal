<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\System\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Berita;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;

class InformasiController extends Controller
{
    public function panduan(){
        return view('informasi/panduan');
    }

    public function alur(){
        return view('informasi/alur');
    }
}
