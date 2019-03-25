<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPrestamo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prestador_id')->unsigned();
            $table->integer('receptor_id')->nullable()->unsigned();    
            $table->integer('reserva_id')->unsigned();            
            $table->foreign('prestador_id')->references('id')->on('usuario');
            $table->foreign('receptor_id')->references('id')->on('usuario');
            $table->foreign('reserva_id')->references('id')->on('reserva');
            $table->date('fecha_prestamo');
            $table->date('fecha_devolucion_max');
            $table->date('fecha_devolucion')->nullable();
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
        Schema::dropIfExists('prestamo');
    }
}
