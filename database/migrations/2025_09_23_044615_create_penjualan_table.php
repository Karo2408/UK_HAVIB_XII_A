<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->Increments('PenjualanID');
            $table->dateTime('TanggalPenjualan');
            $table->decimal('TotalHarga', 10, 2);
            $table->unsignedInteger('PelangganID')->nullable();
            $table->unsignedInteger('UserID');
            
            $table->foreign('PelangganID')->references('PelangganID')->on('pelanggan')->onDelete('set null');
            $table->foreign('UserID')->references('UserID')->on('user')->onDelete('cascade');
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
        Schema::dropIfExists('penjualan');
    }
}
