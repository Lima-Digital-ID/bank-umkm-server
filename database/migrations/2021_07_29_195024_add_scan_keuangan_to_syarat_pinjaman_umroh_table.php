<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScanKeuanganToSyaratPinjamanUmrohTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('syarat_pinjaman_umroh', function (Blueprint $table) {
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
        Schema::table('syarat_pinjaman_umroh', function (Blueprint $table) {
            $table->dropColumn('scan_keuangan');
        });
    }
}
