<?php

namespace Biblioteca;

use Illuminate\Database\Eloquent\Model;

class Ejemplar extends Model
{
    protected $table='ejemplar';

    protected $fillable = [
       'codigo', 'ubicacion_id','libro_id', 'estado'
    ];
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }
    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
}
