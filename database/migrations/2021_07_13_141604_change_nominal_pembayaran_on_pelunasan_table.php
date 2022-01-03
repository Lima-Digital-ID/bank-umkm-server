<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominalPembayaranOnPelunasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelunasan', function (Blueprint $table) {
            $table->dropColumn('nominal_pembayaran');
            $table->dropColumn('bunga');
        });

        Schema::table('pelunasan', function (Blueprint $table) {
            $table->double('nominal_pembayaran', 11, 2, true)->after('jatuh_tempo_cicilan');
            $table->double('bunga', 11, 2, true)->after('nominal_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelunasan', function (Blueprint $table) {
            
        });
    }
}
