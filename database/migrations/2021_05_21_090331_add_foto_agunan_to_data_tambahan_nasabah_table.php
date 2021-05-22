<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoAgunanToDataTambahanNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_tambahan_nasabah', function (Blueprint $table) {
            $table->string('foto_agunan')->nullable()->after('domisili_usaha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_tambahan_nasabah', function (Blueprint $table) {
            //
        });
    }
}
