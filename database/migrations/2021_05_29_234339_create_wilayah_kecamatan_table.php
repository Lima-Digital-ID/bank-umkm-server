<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWilayahKecamatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wilayah_kecamatan', function (Blueprint $table) {
            $table->string('id');
            $table->integer('kabupaten_id')->unsigned();
            $table->string('nama');
            $table->timestamps();

            $table->foreign('kabupaten_id')->references('id')->on('wilayah_kabupaten')->cascadeOnUpdate()->cascadeOnDelete();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wilayah_kecamatan');
    }
}
