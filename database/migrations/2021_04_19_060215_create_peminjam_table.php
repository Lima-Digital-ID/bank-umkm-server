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
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nik', 16);
            $table->string('no_hp', 13);
            $table->text('alamat');
            $table->string('profil')->nullable()->default('profile-default.png');
            $table->string('scan_ktp')->nullable();
            $table->string('foto_dengan_ktp')->nullable();
            $table->string('npwp')->nullable();
            $table->string('surat_nikah')->nullable();
            $table->string('surat_domisili_usaha')->nullable();
            $table->string('jenis_pekerjaan')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->enum('status', ['Nonaktif', 'Aktif'])->default('Nonaktif');
            $table->string('nama_penjamin');
            $table->string('nik_penjamin', 16);
            $table->string('no_hp_penjamin', 13);
            $table->text('alamat_penjamin');
            $table->string('nama_akun_bank')->nullable();
            $table->string('bank')->nullable();
            $table->string('norek')->nullable();
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
