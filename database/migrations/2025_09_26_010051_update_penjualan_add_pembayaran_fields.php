<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePenjualanAddPembayaranFields extends Migration
{
    public function up()
    {
        Schema::table('penjualan', function (Blueprint $table) {
            if (!Schema::hasColumn('penjualan', 'Metode')) {
                $table->enum('Metode', ['cash', 'debit', 'e-wallet', 'transfer'])->default('cash');
            }
            if (!Schema::hasColumn('penjualan', 'JumlahBayar')) {
                $table->decimal('JumlahBayar', 15, 2)->nullable();
            }
            if (!Schema::hasColumn('penjualan', 'Kembalian')) {
                $table->decimal('Kembalian', 15, 2)->nullable();
            }
            if (!Schema::hasColumn('penjualan', 'Status')) {
                $table->enum('Status', ['selesai', 'pending'])->default('selesai');
            }
        });
    }

    public function down()
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn(['Metode', 'JumlahBayar', 'Kembalian', 'Status']);
        });
    }
}
