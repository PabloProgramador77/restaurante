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
        Schema::create('menu_categorias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idCategoria')->unsigned();
            $table->bigInteger('idPlatillo')->unsigned();
            $table->timestamps();

            $table->foreign('idCategoria')->references('id')->on('categorias')->onDelete('cascade');
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
        Schema::dropIfExists('menu_categorias');
    }
};
