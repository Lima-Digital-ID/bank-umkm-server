<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKartuKeluargaToDataTambahanNasabah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_tambahan_nasabah', function (Blueprint $table) {
            $table->string('kartu_keluarga')->after('tempat_tinggal')->nullable();
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
            $table->dropColumn('kartu_keluarga');
        });
    }
}
