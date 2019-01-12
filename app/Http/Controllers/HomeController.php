<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Biblioteca\Prestamo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->tipo_usuario !== 'Administrador'){
            $data = Prestamo::with('ejemplar')->where('usuario_id', Auth::user()->id)
            ->where('fecha_devolucion_max','<', date("Y-m-d H:i:s"))
            ->where('fecha_devolucion', null)
            ->get();
            // return $data;
            return view('home')->with('alerta',$data);
            // return view('home')->with('alerta','Tiene libros pendientes por devolver');
        }


        return view('home');
    }
}
