<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaReserva extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id')->unsigned();
            $table->integer('ejemplar_id')->unsigned();
            $table->integer('usuario_estado_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('usuario_estado_id')->references('id')->on('usuario');
            $table->foreign('ejemplar_id')->references('id')->on('ejemplar');
            $table->enum('estado', ['Reservado', 'Cancelado', 'Prestado', 'Vencido', 'Negado', 'Devuelto']);
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
        Schema::dropIfExists('reserva');
    }
}
