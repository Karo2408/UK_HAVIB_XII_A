<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiskonToDetailPenjualanTable extends Migration
{
    public function up()
    {
        Schema::table('detail_penjualan', function (Blueprint $table) {
            $table->decimal('Diskon', 12, 2)->default(0)->after('Subtotal');
        });
    }

    public function down()
    {
        Schema::table('detail_penjualan', function (Blueprint $table) {
            $table->dropColumn('Diskon');
        });
    }
}
