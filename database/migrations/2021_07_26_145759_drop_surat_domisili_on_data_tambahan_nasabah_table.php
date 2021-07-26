<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSuratDomisiliOnDataTambahanNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_tambahan_nasabah', function (Blueprint $table) {
            $table->dropColumn('surat_domisili');
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
            $table->binary('surat_domisili')->after('notaris')->nullable();
        });
    }
}
