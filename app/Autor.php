<?php

namespace Biblioteca;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autor';    

    protected $fillable = [
        'nombres', 'apellidos'
    ];
}
