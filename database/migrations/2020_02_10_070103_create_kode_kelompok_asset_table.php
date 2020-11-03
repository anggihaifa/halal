<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKodeKelompokAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kode_kelompok_asset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_item')->unique();
            $table->string('kategori');
            $table->string('kode_kelompok');
            $table->string('nama_item');
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
        Schema::dropIfExists('kode_kelompok_asset');
    }
}
