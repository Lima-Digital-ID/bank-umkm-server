<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipeInTableNasabah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nasabah', function (Blueprint $table) {
            $table->bigInteger('id_tipe')->unsigned()->nullable()->after('status');
            $table->foreign('id_tipe')->references('id')->on('tipe_nasabah');
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
            $table->dropForeign('nasabah_id_tipe_foreign');
            $table->dropColumn('id_tipe');
        });
    }
}
