<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_registrasi');
            $table->bigInteger('biaya_pemeriksaan');
            $table->bigInteger('biaya_pengujian');
            $table->bigInteger('biaya_sidang_fatwa');
            $table->bigInteger('total_biaya_sertifikasi');
            $table->bigInteger('berkas_akad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akad');
    }
}
