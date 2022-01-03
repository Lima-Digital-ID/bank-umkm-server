<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nasabah', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nik', 16)->nullable();
            $table->string('no_hp', 13);
            $table->text('alamat')->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('scan_ktp')->nullable();
            $table->string('selfie_ktp')->nullable();
            $table->string('npwp')->nullable();
            $table->string('surat_nikah')->nullable();
            $table->string('surat_jaminan')->nullable();
            $table->string('surat_domisili_usaha')->nullable();
            $table->string('email', 60)->unique();
            $table->string('password');
            $table->integer('id_tipe_nasabah')->unsigned()->nullable();
            $table->boolean('is_verified')->nullable()->default(0);
            $table->string('token')->nullable();
            $table->timestamps();

            $table->foreign('id_tipe_nasabah')->references('id')->on('tipe_nasabah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nasabah');
    }
}
