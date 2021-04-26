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
            $table->id();
            $table->bigInteger('id_nasabah')->unsigned();
            $table->bigInteger('id_user')->unsigned()->nullable();
            $table->date('tanggal_pengajuan');
            $table->tinyInteger('jangka_waktu');
            $table->integer('nominal');
            $table->enum('status', ['Pending', 'Terima', 'Tolak', 'Lunas']);
            $table->date('tanggal_diterima')->nullable();
            $table->date('tanggal_batas_pelunasan')->nullable();
            $table->date('tanggal_lunas')->nullable();
            $table->integer('terbayar')->default(0);
            $table->timestamps();

            $table->foreign('id_nasabah')->references('id')->on('nasabah');
            $table->foreign('id_user')->references('id')->on('users');
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
