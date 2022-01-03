<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBungaToPelunasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelunasan', function (Blueprint $table) {
            $table->integer('bunga')->nullable()->after('nominal_pembayaran');
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
            $table->dropColumn('bunga');
        });
    }
}
