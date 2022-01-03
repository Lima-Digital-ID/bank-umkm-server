<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePhoneLengthOnKantorCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kantor_cabang', function (Blueprint $table) {
            $table->string('phone', 50)->after('alamat')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kantor_cabang', function (Blueprint $table) {
            $table->string('phone', 13)->after('alamat')->change();
        });
    }
}
