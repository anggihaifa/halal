<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePenjawalanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjadwalan', function (Blueprint $table) {
            $table->renameColumn('tipe', 'progres_penjadwalan');
            $table->string('pelaksana1_audit1', 150)->nullable();
            $table->string('pelaksana2_audit1', 150)->nullable();
            $table->string('pelaksana1_audit2', 150)->nullable();
            $table->string('pelaksana2_audit2', 150)->nullable();
            $table->string('pelaksana1_rapat', 150)->nullable();
            $table->string('pelaksana2_rapat', 150)->nullable();
            $table->string('pelaksana3_rapat', 150)->nullable();
            $table->string('pelaksana1_tinjauan', 150)->nullable();
            $table->string('pelaksana2_tinjauan', 150)->nullable();
            $table->string('pelaksana3_tinjauan', 150)->nullable();
            $table->string('laporan_audit1', 150)->nullable();
            $table->string('laporan_audit2_pelaksana1', 150)->nullable();
            $table->string('laporan_audit2_pelaksana2', 150)->nullable();
            $table->string('sppd_audit2', 150)->nullable();
            $table->string('berita_acara_audit2', 150)->nullable();
            $table->string('laporan_rapat', 150)->nullable();
            $table->string('laporan_tinjauan', 150)->nullable();
   
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
