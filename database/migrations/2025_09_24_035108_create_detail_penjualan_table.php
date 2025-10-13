<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->Increments('DetailID');
            $table->unsignedInteger('PenjualanID');
            $table->unsignedInteger('ProdukID');
            $table->integer('JumlahProduk');
            $table->decimal('Subtotal', 15, 2);

            $table->foreign('PenjualanID')->references('PenjualanID')->on('penjualan')->onDelete('cascade');
            $table->foreign('ProdukID')->references('ProdukID')->on('produk')->onDelete('cascade');
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
        Schema::dropIfExists('detail_penjualan');
    }
}
