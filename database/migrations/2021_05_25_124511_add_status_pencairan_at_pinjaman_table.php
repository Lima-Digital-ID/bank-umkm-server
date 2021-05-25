<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPencairanAtPinjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->enum('status_pencairan', ['Pending','Terima', 'Tolak'])->default('Pending')->after('status')->nullable();
            $table->text('alasan_penolakan_pencairan')->nullable()->after('status_pencairan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn('status_pencairan');
            $table->dropColumn('alasan_penolakan_pencairan');
        });
    }
}
