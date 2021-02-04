<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\JenisAkomodasi;
use App\Models\Master\DetailDarat;
use App\Models\Master\DetailLaut;
use App\Models\Master\DetailUdara;
use App\Models\Master\DetailPenginapan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

use Log;

class AkomodasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.akomodasi.index');
    }

    public function datatable(){
        $data_darat = DB::table('detail_transportasi_darat')
                ->join('jenis_akomodasi', 'detail_transportasi_darat.id_jenis_akomodasi', '=' ,'jenis_akomodasi.id')

                ->select('jenis_akomodasi.jenis_akomodasi as jenis_akomodasi','detail_transportasi_darat.*');

        $data_laut = DB::table('detail_transportasi_laut')
                ->join('jenis_akomodasi', 'detail_transportasi_laut.id_jenis_akomodasi', '=' ,'jenis_akomodasi.id')

                ->select('jenis_akomodasi.jenis_akomodasi as jenis_akomodasi','detail_transportasi_laut.*');

        $data_udara = DB::table('detail_transportasi_udara')
                ->join('jenis_akomodasi', 'detail_transportasi_udara.id_jenis_akomodasi', '=' ,'jenis_akomodasi.id')

                ->select('jenis_akomodasi.jenis_akomodasi as jenis_akomodasi','detail_transportasi_udara.*');
        $data_penginapan = DB::table('detail_penginapan')
                ->join('jenis_akomodasi', 'detail_penginapan.id_jenis_akomodasi', '=' ,'jenis_akomodasi.id')

                ->select('jenis_akomodasi.jenis_akomodasi as jenis_akomodasi','detail_penginapan.*');

        $data = $data_darat
                ->union($data_laut)
                ->union($data_udara)
                ->union($data_penginapan)

                ->get();
                
       //Log::info('ini data'. $data);
        return DataTables::of($data)->make();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $jenis_akomodasi = JenisAkomodasi::all();
       
        return view('master.akomodasi.create', compact('jenis_akomodasi'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token','_method');

       //

        $model = new DetailDarat();
        $model2 = new DetailLaut();
        $model3 = new DetailUdara();
        $model4 = new DetailPenginapan();


        try{

            DB::beginTransaction();
            if($data['jenis_akomodasi']=='1'){

                $model->transportasi_darat = $data['detail_akomodasi'];
                $model->id_jenis_akomodasi = $data['jenis_akomodasi'];
                $model->save();
            }
            elseif($data['jenis_akomodasi']=='2'){
                // dd($data);
                $model2->transportasi_laut = $data['detail_akomodasi'];
                $model2->id_jenis_akomodasi = $data['jenis_akomodasi'];
                $model2->save();
            }
            elseif($data['jenis_akomodasi']=='3'){

                $model3->transportasi_udara = $data['detail_akomodasi'];
                $model3->id_jenis_akomodasi = $data['jenis_akomodasi'];
                $model3->save();
            }
            elseif($data['jenis_akomodasi']=='4'){

                $model4->penginapan = $data['detail_akomodasi'];
                $model3->id_jenis_akomodasi = $data['jenis_akomodasi'];
                $model4->save();
            }
            
           
            //$model->save();
            DB::commit();

            Session::flash('success',"Data berhasil disimpan!");

            $redirect = redirect()->route('akomodasi.index');

        }catch(\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());

            $redirect = redirect()->route('akomodasi.create');
        }

        return $redirect;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id, $jenis_akomodasi)
    {
        //dd("masuk");
        $data =JenisAkomodasi::all();

        if($jenis_akomodasi == 'Transportasi Darat'){
            $data2 = DetailDarat::find($id);
        }
        if($jenis_akomodasi == 'Transportasi Laut'){
            $data2 = DetailLaut::find($id);
        }
        if($jenis_akomodasi == 'Transportasi Udara'){
            $data2 = DetailUdara::find($id);
        }
        if($jenis_akomodasi == 'Penginapan'){
            $data2 = DetailPenginapan::find($id);
        }
        

        return view('master.akomodasi.edit',compact('data','data2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($id);
        $data = $request->except('_token','_method');

        $model = new DetailDarat();
        $model2 = new DetailLaut();
        $model3 = new DetailUdara();
        $model4 = new DetailPenginapan();

        try{

            DB::beginTransaction();
            if($data['jenis_akomodasi']=='Transportasi Darat'){

                $e = $model->find($id);
                $e->transportasi_darat = $data['detail_akomodasi'];
                $e->id_jenis_akomodasi = '1';
               
            }
            elseif($data['jenis_akomodasi']=='Transportasi Laut'){

                $e = $model2->find($id);
                
                $e->transportasi_laut = $data['detail_akomodasi'];
                $e->id_jenis_akomodasi ='2';
               
            }
            elseif($data['jenis_akomodasi']=='Transportasi Udara'){

                $e = $model3->find($id);
               
                $e->transportasi_udara = $data['detail_akomodasi'];
                $e->id_jenis_akomodasi = '3';
               
            }
            elseif($data['jenis_akomodasi']=='Penginapan'){

                $e = $model4->find($id);
               
                $e->penginapan = $data['detail_akomodasi'];
                $e->id_jenis_akomodasi = '4';
              
            }
          
           
            $e->save();
            DB::commit();

            Session::flash('success', 'data berhasil di update!');
        }catch (\Exception $e){
            DB::rollBack();

            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('akomodasi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, $jenis_akomodasi)
    {   
        if($jenis_akomodasi == 'Transportasi Darat'){
            $model = new DetailDarat();
        }
        if($jenis_akomodasi == 'Transportasi Laut'){
            $model = new DetailLaut();
        }
        if($jenis_akomodasi == 'Transportasi Udara'){
            $model = new DetailUdara();
        }
        if($jenis_akomodasi == 'Penginapan'){
            $model = new DetailPenginapan();
        }

        //$model = new JenisAkomodasi();
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

        return redirect()->route('akomodasi.index');
    }
}
