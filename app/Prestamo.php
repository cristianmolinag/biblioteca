<?php

namespace Biblioteca;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table='prestamo';

    protected $fillable = [
        'prestador_id', // el bilbiotecario que presta
        'receptor_id', //  el bibliotecario que recibe
        'reserva_id',
        'fecha_prestamo',
        'fecha_devolucion_max',
        'fecha_devolucion'
    ];

    public function prestador()
    {
        return $this->belongsTo(User::class, 'prestador_id');
    }

    public function receptor()
    {
        return $this->belongsTo(User::class, 'receptor_id');
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id')->with('ejemplar', 'usuario');
    }
}
