<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldSyaratPinjamanUmroh extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nasabah', function (Blueprint $table) {
            $table->tinyInteger('syarat_pinjaman_umroh')
                    ->default(0)
                    ->after('is_verified')
                    ->comment('Default 0 untuk belum mengajukan, 1 untuk diterima, 2 untuk pending, 3 untuk tolak');
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
            $table->dropColumn('syarat_pinjaman_umroh');
        });
    }
}
