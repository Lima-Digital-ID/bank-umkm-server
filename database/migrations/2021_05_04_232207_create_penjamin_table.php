<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjaminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjamin', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nasabah')->unsigned();
            $table->string('nama');
            $table->string('nik', 16)->nullable();
            $table->string('no_hp', 13);
            $table->text('alamat')->nullable();
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
        Schema::dropIfExists('penjamin');
    }
}
