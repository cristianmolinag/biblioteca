<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEjemplar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ejemplar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->unique();
            $table->integer('ubicacion_id')->unsigned();
            $table->integer('libro_id')->unsigned();
            $table->foreign('ubicacion_id')->references('id')->on('ubicacion');
            $table->foreign('libro_id')->references('id')->on('libro');
            $table->enum('estado', ['Prestado', 'Reservado', 'Disponible']);
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
        Schema::dropIfExists('ejemplar');
    }
}
