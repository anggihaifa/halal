<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function dataReminderPembayaran(Request $request){
        DB::beginTransaction();
        $reminder = DB::table('pembayaran')
                ->select('*')
                ->where('id_registrasi','desc')                
                ->get();
        
        $reminder->save();

        $reminder = DB::table('pembayaran')
                ->select('*')
                ->where('id_registrasi','desc')                
                ->get();
        
        $reminder->save();
        DB::commit();
    }
}
