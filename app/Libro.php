<?php

namespace Biblioteca;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table='libro';

    protected $fillable = [
        'isbn','titulo','anio','numero_paginas','autor_id','editorial_id','categoria_id'
    ];

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
