<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaToDetailPenjualanTable extends Migration
{
    public function up()
    {
        Schema::table('detail_penjualan', function (Blueprint $table) {
            $table->decimal('Harga', 15, 2)->after('JumlahProduk');
        });
    }

    public function down()
    {
        Schema::table('detail_penjualan', function (Blueprint $table) {
            $table->dropColumn('Harga');
        });
    }
}
