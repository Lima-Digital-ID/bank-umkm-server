<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKembaliPinjamPadaOnNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nasabah', function (Blueprint $table) {
            $table->date('kembali_pinjam_pada')->after('token')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('nasabah', function (Blueprint $table) {
            $table->dropColumn('kembali_pinjam_pada');            
        });
        
    }
}
