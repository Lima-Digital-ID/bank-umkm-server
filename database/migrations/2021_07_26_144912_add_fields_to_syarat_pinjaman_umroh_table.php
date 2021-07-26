<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSyaratPinjamanUmrohTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('syarat_pinjaman_umroh', function (Blueprint $table) {
            $table->binary('npwp_usaha')->after('foto_agunan')->nullable();
            $table->binary('akta')->after('npwp_usaha')->nullable();
            $table->binary('notaris')->after('akta')->nullable();
            $table->binary('surat_domisili')->after('notaris')->nullable();
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
            $table->dropColumn('npwp_usaha');
            $table->dropColumn('akta');
            $table->dropColumn('notaris');
            $table->dropColumn('surat_domisili');
        });
    }
}
