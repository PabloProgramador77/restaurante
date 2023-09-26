<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesa_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idMesa')->unsigned();
            $table->bigInteger('idUser')->unsigned();
            $table->timestamps();

            $table->foreign('idMesa')->references('id')->on('mesas')->onDelete('cascade');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mesa_users');
    }
};
