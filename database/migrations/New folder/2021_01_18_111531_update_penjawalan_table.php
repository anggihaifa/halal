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
        //
        Schema::table('penjadwalan', function (Blueprint $table) {
            $table->string('tipe', 150)->nullable()->change();
            $table->string('status_audit1', 150)->default('0')->change();;
            $table->string('status_audit2', 150)->default('0')->change();;
            $table->string('status_rapat', 150)->default('0')->change();;
            $table->string('status_tinjauan', 150)->default('0')->change();;
            $table->string('updated_by', 150)->nullable()->change();
            $table->dateTime('mulai_audit1', $precision = 0)->nullable();
            $table->dateTime('selesai_audit1', $precision = 0)->nullable();
            $table->dateTime('mulai_audit2', $precision = 0)->nullable();
            $table->dateTime('selesai_audit2', $precision = 0)->nullable();
            $table->dateTime('mulai_rapat', $precision = 0)->nullable();
            $table->dateTime('selesai_rapat', $precision = 0)->nullable();
            $table->dateTime('mulai_tinjauan', $precision = 0)->nullable();
            $table->dateTime('selesai_tinjauan', $precision = 0)->nullable();
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
