<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendingToStatusOnPelunasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE pelunasan MODIFY COLUMN status ENUM('Belum', 'Pending', 'Lunas', 'Gagal') DEFAULT 'Belum' NOT NULL AFTER metode_pembayaran");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE pelunasan MODIFY COLUMN status ENUM('Belum', 'Lunas') DEFAULT 'Belum' NOT NULL AFTER updated_at");
    }
}
