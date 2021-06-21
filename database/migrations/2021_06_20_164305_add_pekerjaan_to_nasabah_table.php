<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPekerjaanToNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nasabah', function (Blueprint $table) {
            $table->string('pekerjaan', 100)->after('jenis_kelamin')->nullable();
            $table->string('jabatan', 50)->after('pekerjaan')->nullable();
            $table->text('alamat_perusahaan')->after('jabatan')->nullable();
            $table->string('kontak_perusahaan', 15)->after('alamat_perusahaan')->nullable();
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
            $table->dropColumn('pekerjaan');
            $table->dropColumn('jabatan');
            $table->dropColumn('alamat_perusahaan');
            $table->dropColumn('kontak_perusahaan');
        });
    }
}
