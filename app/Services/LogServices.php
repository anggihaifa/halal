<?php

namespace App\Services;
use App\Models\System\Log;

use Illuminate\Support\Facades\DB;

class LogServices{

    public static function createLog(string $name,$bumn_code,$activity,$date,$time){

        $dataLog = new Log();
        $dataLog->name = $name;
        $dataLog->bumn_code = $bumn_code;
        $dataLog->activity = $activity;
        $dataLog->date = $date;
        $dataLog->time = $time;
        $dataLog->save();

    }

}