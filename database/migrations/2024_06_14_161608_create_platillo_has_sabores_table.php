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
        Schema::create('platillo_has_sabores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idPlatillo')->unsigned();
            $table->bigInteger('idSabor')->unsigned();
            $table->timestamps();

            $table->foreign('idPlatillo')->references('id')->on('platillos')->onDelete('cascade');
            $table->foreign('idSabor')->references('id')->on('sabores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platillo_has_sabores');
    }
};
