<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjadwalanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjadwalan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('tipe', 150)->default('NULL');
            $table->string('status_audit1', 150)->default('0');
            $table->string('status_audit2', 150)->default('0');
            $table->string('status_rapat', 150)->default('0');
            $table->string('status_tinjauan', 150)->default('0');
            $table->string('updated_by', 150)->default('NULL');
            $table->dateTime('mulai_audit1', $precision = 0)->default('NULL');
            $table->dateTime('selesai_audit1', $precision = 0)->default('NULL');
            $table->dateTime('mulai_audit2', $precision = 0)->default('NULL');
            $table->dateTime('selesai_audit2', $precision = 0)->default('NULL');
            $table->dateTime('mulai_rapat', $precision = 0)->default('NULL');
            $table->dateTime('selesai_rapat', $precision = 0)->default('NULL');
            $table->dateTime('mulai_tinjauan', $precision = 0)->default('NULL');
            $table->dateTime('selesai_tinjauan', $precision = 0)->default('NULL');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjadwalan');
    }
}
