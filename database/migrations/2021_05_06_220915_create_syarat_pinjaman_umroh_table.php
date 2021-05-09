<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyaratPinjamanUmrohTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syarat_pinjaman_umroh', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nasabah')->unsigned();
            $table->string('suket_travel')->nullable();
            $table->string('selfie_usaha')->nullable();
            $table->string('siup')->nullable();
            $table->string('nib')->nullable();
            $table->string('scan_jaminan')->nullable();
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
        Schema::dropIfExists('syarat_pinjaman_umroh');
    }
}
