<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CustomizePelunasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelunasan', function (Blueprint $table) {
            $table->date('jatuh_tempo_cicilan')->after('id_pinjaman');
            $table->date('tanggal_pembayaran')->nullable()->change();
            $table->enum('status', ['Belum', 'Lunas'])->default('Belum');
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
            $table->dropColumn('jatuh_tempo_cicilan');
            $table->date('tanggal_pembayaran')->change();
            $table->dropColumn('status');
        });
    }
}
