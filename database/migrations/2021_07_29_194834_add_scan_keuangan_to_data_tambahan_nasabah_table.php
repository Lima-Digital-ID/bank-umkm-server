<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScanKeuanganToDataTambahanNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_tambahan_nasabah', function (Blueprint $table) {
            $table->dropColumn('notaris');
            $table->binary('scan_keuangan')->nullable()->after('akta');
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
            $table->dropColumn('scan_keuangan');
        });
    }
}
