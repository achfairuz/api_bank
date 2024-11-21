<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nasabah', function (Blueprint $table) {

            $table->id("id_nasabah");
            $table->string('nama_lengkap', 100);
            $table->string('alamat');
            $table->string('nomor_telepon', 50);
            $table->string('email', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_bergabung')->nullable()->default(now());
            $table->string('nama_ibu', 50);
        });
    }

    public function down()
    {
        Schema::dropIfExists('nasabah');
    }
};