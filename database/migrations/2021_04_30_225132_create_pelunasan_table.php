<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelunasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelunasan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pinjaman')->unsigned();
            $table->integer('nominal_pembayaran');
            $table->date('tanggal_pembayaran');
            $table->tinyInteger('cicilan_ke');
            $table->timestamps();

            $table->foreign('id_pinjaman')->references('id')->on('pinjaman');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelunasan');
    }
}
