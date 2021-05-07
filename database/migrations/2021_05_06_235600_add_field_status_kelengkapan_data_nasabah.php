<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldStatusKelengkapanDataNasabah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nasabah', function (Blueprint $table) {
            $table->tinyInteger('status_kelengkapan_data')
                    ->default(0)
                    ->after('is_verified')
                    ->comment('Default 0, 1 untuk diterima, 2 untuk ditolak');
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
            $table->dropColumn('status_kelengkapan_data');
        });
    }
}
