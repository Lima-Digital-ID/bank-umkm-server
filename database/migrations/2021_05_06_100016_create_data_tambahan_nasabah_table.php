<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTambahanNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_tambahan_nasabah', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nasabah')->unsigned();
            $table->string('tempat_tinggal', 50);
            $table->string('scan_npwp')->nullable();
            $table->string('ktp_suami')->nullable();
            $table->string('ktp_istri')->nullable();
            $table->string('surat_nikah')->nullable();
            $table->string('bpkb')->nullable();
            $table->string('domisili_usaha')->nullable();
            $table->timestamps();

            $table->foreign('id_nasabah')->references('id')->on('nasabah');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_tambahan_nasabah');
    }
}
