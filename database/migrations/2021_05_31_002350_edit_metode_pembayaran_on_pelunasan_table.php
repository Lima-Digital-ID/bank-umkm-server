<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditMetodePembayaranOnPelunasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelunasan', function (Blueprint $table) {
            $table->string('metode_pembayaran', 50)->nullable()->change();
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
            $table->string('metode_pembayaran', 50)->change();
        });
    }
}
