<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_rekening')->nullable();
            $table->unsignedBigInteger('rekening_tujuan')->nullable();
            $table->timestamp('tanggal_transaksi')->nullable()->default(now());
            $table->bigInteger('jumlah_transaksi')->default(0);
            $table->enum('jenis_transaksi', ['Pembelian', 'Isi saldo', 'Transfer'])->default('Isi saldo');

            // Define foreign keys
            $table->foreign('id_rekening')->references('id_rekening')->on('rekening');
            $table->foreign('rekening_tujuan')->references('id_rekening')->on('rekening');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}