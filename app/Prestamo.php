<?php

namespace Biblioteca;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table='prestamo';

    protected $fillable = [
        'prestador_id', // el bilbiotecario que presta
        'receptor_id', //  el bibliotecario que recibe
        'usuario_id', //el usuario que solicita el préstamo
        'ejemplar_id',
        'fecha_prestamo',
        'fecha_devolucion_max',
        'fecha_devolucion'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function prestador()
    {
        return $this->belongsTo(User::class, 'prestador_id');
    }

    public function receptor()
    {
        return $this->belongsTo(User::class, 'receptor_id');
    }
    public function ejemplar()
    {
        return $this->belongsTo(Ejemplar::class)->with('libro', 'ubicacion');
    }
}
