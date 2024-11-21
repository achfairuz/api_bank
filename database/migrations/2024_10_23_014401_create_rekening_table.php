<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekening', function (Blueprint $table) {
            $table->id('id_rekening');
            $table->unsignedBigInteger('id_nasabah')->nullable();
            $table->string('no_rekening', 100)->unique();
            $table->bigInteger('saldo')->default(0);
            $table->timestamp('tanggal_pembuatan')->nullable()->default(now());

            $table->foreign('id_nasabah')->references('id_nasabah')->on('nasabah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekening');
    }
}