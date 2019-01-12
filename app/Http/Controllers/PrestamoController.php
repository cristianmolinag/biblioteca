<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\Prestamo;

class PrestamoController extends Controller
{
    public function index()
    {
        $data = Prestamo::with('usuario', 'prestador', 'ejemplar')->where('fecha_devolucion','=', null)->get();
        return view('prestamo.index', compact('data'));
    }

    public function create(Request $request)
    {
        // return $request;
        
        return view('prestamo.nuevo', compact('data'));
    }
}
