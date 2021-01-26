<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


 
    Schema::table('registrasi', function (Blueprint $table) {
        $table->string('id_penjadwalan',10);
    });