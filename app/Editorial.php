<?php

namespace Biblioteca;

use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    protected $table = 'editorial';    

    protected $fillable = [
        'nombre'
    ];
}
