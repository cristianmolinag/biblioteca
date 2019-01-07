<?php

namespace Biblioteca;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicacion';    

    protected $fillable = [
        'nombre'
    ];
}
