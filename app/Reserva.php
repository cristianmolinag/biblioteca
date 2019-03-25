<?php

namespace Biblioteca;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reserva';

    protected $fillable = [
      'usuario_id',
      'ejemplar_id',
      'estado',
      'usuario_estado_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function usuarioEstado(){
      return $this->belongsTo(User::class, 'usuario_estado_id');
    }

    public function ejemplar()
    {
        return $this->belongsTo(Ejemplar::class, 'ejemplar_id')->with('libro', 'ubicacion');
    }

    public function prestamo(){
      return $this->hasOne(Prestamo::class)->with('prestador');
    }
}
