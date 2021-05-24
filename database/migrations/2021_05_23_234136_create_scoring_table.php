<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoring', function (Blueprint $table) {
            $table->id();
            $table->integer('id_option')->unsigned()->nullable();
            $table->integer('id_nasabah')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('id_option')->references('id')->on('option');
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
        Schema::dropIfExists('scoring');
    }
}
