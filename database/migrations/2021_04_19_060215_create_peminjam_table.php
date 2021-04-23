<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nasabah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nik', 16);
            $table->string('no_hp', 13);
            $table->text('alamat');
            $table->string('profil')->nullable()->default('profile-default.png');
            $table->string('scan_ktp');
            $table->string('foto_dengan_ktp');
            $table->string('npwp')->nullable();
            $table->string('surat_nikah')->nullable();
            $table->string('surat_domisili_usaha')->nullable();
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->enum('status', ['Nonaktif', 'Aktif'])->default('Nonaktif');
            $table->timestamps();
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
