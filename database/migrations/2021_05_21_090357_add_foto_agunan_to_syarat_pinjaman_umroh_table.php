<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoAgunanToSyaratPinjamanUmrohTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('syarat_pinjaman_umroh', function (Blueprint $table) {
            $table->string('foto_agunan')->nullable()->after('scan_jaminan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('syarat_pinjaman_umroh', function (Blueprint $table) {
            //
        });
    }
}
