<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToKantorCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kantor_cabang', function (Blueprint $table) {
            $table->string('kode_area', 10)->nullable()->after('id');
            $table->string('jenis', 50)->nullable()->after('nama');
            $table->string('fax', 50)->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kantor_cabang', function (Blueprint $table) {
            
            $table->dropColumn('kode_area');
            $table->dropColumn('jenis');
            $table->dropColumn('fax');
            
        });
    }
}
