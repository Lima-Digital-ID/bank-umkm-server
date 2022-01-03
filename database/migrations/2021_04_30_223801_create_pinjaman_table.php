<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nasabah')->unsigned();
            $table->integer('id_user')->unsigned()->nullable();
            $table->integer('id_jenis_pinjaman')->unsigned();
            $table->integer('nominal');
            $table->tinyInteger('jangka_waktu');
            $table->enum('status', ['Pending', 'Terima', 'Tolak', 'Lunas']);
            $table->date('tanggal_diterima')->nullable();
            $table->date('jatuh_tempo')->nullable();
            $table->date('tanggal_lunas')->nullable();
            $table->integer('terbayar')->nullable()->default(0);
            $table->timestamps();
            
            $table->foreign('id_nasabah')->references('id')->on('nasabah');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_jenis_pinjaman')->references('id')->on('jenis_pinjaman');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pinjaman');
    }
}
