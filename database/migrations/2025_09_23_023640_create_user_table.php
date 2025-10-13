<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
        $table->Increments('UserID');
        $table->string('Nama', 50);
        $table->string('Email', 255)->unique();
        $table->string('Password', 255);
        $table->enum('Role', ['admin', 'kasir'])->default('kasir');
        $table->rememberToken(); // biar Auth Laravel lancar
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
        Schema::dropIfExists('user');
    }
}
