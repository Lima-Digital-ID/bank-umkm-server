<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKantorCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kantor_cabang', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('kecamatan_id', 7)->collation('latin1_swedish_ci');
            $table->text('alamat');
            $table->string('phone', 13)->default('-');
            $table->timestamps();
    
            $table->foreign('kecamatan_id')->references('id')->on('wilayah_kecamatan');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kantor_cabang');
    }
}
