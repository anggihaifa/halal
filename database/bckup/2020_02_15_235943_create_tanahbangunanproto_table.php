<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanahbangunanprotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanahbangunanproto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bumn_code')->unique();
            $table->string('no_item')->unique();
            $table->string('nama_asset')->index();
            $table->string('kode_kelompok_asset')->unique();
            $table->string('lokasi_koordinat');
            $table->string('lokasi_rutr');
            $table->string('lokasi_alamat');
            $table->string('kondisi_fisik');
            $table->string('kondisi_utilitas');
            $table->string('kodisi_histori');
            $table->string('luasan_tanah');
            $table->string('luasan_bagunan');
            $table->string('faktor_gempa');
            $table->string('faktor_banjir');
            $table->string('faktor_longsor');
            $table->string('faktor_tsunami');
            $table->string('faktor_puting_beliung');
            $table->string('faktor_petir');
            $table->string('faktor_erupsi');
            $table->string('publik_air');
            $table->string('publik_listrik');
            $table->string('publik_jaringan');
            $table->string('publik_telekomunikasi');
            $table->string('legal_hgb');
            $table->string('legal_masalah');
            $table->string('legal_imb');
            $table->string('p_nilai_awal');
            $table->string('p_nilai_revaluasi');
            $table->string('p_tahun_awal');
            $table->string('p_tahun_revaluasi');
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
        Schema::dropIfExists('tanahbangunanproto');
    }
}
