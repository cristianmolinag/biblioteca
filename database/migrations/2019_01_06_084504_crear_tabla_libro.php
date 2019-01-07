<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaLibro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libro', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('isbn')->unique();
            $table->string('titulo');
            $table->integer('anio');
            $table->integer('numero_paginas');
            $table->integer('autor_id')->unsigned();
            $table->integer('editorial_id')->unsigned();
            $table->integer('categoria_id')->unsigned();
            $table->foreign('autor_id')->references('id')->on('autor');
            $table->foreign('editorial_id')->references('id')->on('editorial');
            $table->foreign('categoria_id')->references('id')->on('categoria');   
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
        Schema::dropIfExists('libro');
    }
}
