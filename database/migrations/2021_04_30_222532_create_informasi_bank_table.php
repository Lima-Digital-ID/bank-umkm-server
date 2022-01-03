<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformasiBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informasi_bank', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nasabah')->unsigned();
            $table->integer('id_bank')->unsigned();
            $table->string('no_rekening', 25);
            $table->string('nama_rekening', 60);
            $table->timestamps();

            $table->foreign('id_nasabah')->references('id')->on('nasabah');
            $table->foreign('id_bank')->references('id')->on('master_bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informasi_bank');
    }
}
