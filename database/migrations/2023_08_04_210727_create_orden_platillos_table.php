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
        Schema::create('orden_platillos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idOrden')->unsigned();
            $table->bigInteger('idPlatillo')->unsigned();
            $table->bigInteger('cantidad')->unsigned();
            $table->string('nota')->nullable();
            $table->timestamps();

            $table->foreign('idOrden')->references('id')->on('ordens')->onDelete('cascade');
            $table->foreign('idPlatillo')->references('id')->on('platillos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_platillos');
    }
};
