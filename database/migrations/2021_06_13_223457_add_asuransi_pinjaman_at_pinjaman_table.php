<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAsuransiPinjamanAtPinjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->integer('asuransi_pinjaman')->nullable()->after('status_pencairan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn('asuransi_pinjaman');
        });
    }
}
