<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNontanahbangunanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nontanahbangunan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bumn_code')->unique();
            $table->string('no_item')->unique();
            $table->string('nama_asset')->index();
            $table->string('kode_kelompok_asset')->unique();
            $table->string('lokasi_koordinat');
            $table->string('lokasi_alamat');
            $table->string('spek_merek');
            $table->string('spek_tipe');
            $table->string('spek_dimensi');
            $table->string('spek_mobilitas');
            $table->string('spek_keterangan');
            $table->string('spek_sdk');
            $table->string('kondisi_fisik');
            $table->string('kondisi_keterpakaian');
            $table->string('kalibrasi_periode');
            $table->string('kalibrasi_tanggal_terakhir');
            $table->string('kalibrasi_tanggal_berikut');
            $table->string('kalibrasi_institusi');
            $table->string('lisensi_perolehan');
            $table->string('lisensi_tanggal_akhir');
            $table->string('lisensi_tanggal_berikut');
            $table->string('lisensi_institusi');
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
        Schema::dropIfExists('nontanahbangunan');
    }
}
