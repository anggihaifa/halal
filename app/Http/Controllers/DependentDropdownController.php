<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kabupaten;

class DependentDropdownController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::pluck('id', 'nama_provinsi');

        return view('registrasi.create', [
            'prov' => $provinsi,
        ]);
    }

    public function store(Request $request)
    {
        $kabupaten = Kabupaten::where('id_provinsi', $request->get('id'))
            ->pluck('id', 'nama_kabupaten');
    
        return response()->json($kabupaten);
    }
}
