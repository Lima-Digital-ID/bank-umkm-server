<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldMetodePembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelunasan', function (Blueprint $table) {
            $table->string('metode_pembayaran')
                    ->nullable()
                    ->after('cicilan_ke');
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
            $table->dropColumn('metode_pembayaran');
        });
    }
}
