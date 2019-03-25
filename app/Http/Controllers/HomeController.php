<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Biblioteca\Prestamo;
use Biblioteca\Reserva;

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
        // $usuario = Auth::user();
        // if($usuario->tipo_usuario !== 'Administrador'){
            
        //     $data = Prestamo::with(array('reserva' => function($query) use ($usuario)
        //     {
        //         return $query;
        //          $query->where('usuario_id', $usuario->id);
        //     }))->get();

        //     return $data;


        //     // $reservas = Reserva::where('usuario_id', Auth::user()->id)
        //     //     ->where('estado','Prestado')
        //     //     ->get(['id'])
        //     //     ->toArray();
        //     //     // return $reservas;
        //     // $filtro = array();
        //     // foreach ($reservas as $key => $reserva) {
        //     //     echo $reserva['id'];
        //     //     array_push($filtro, $reserva['id']);
        //     // }
        //     // // print_r($filtro);
        //     // return $filtro;

        //     // $data = Prestamo::whereIn('reserva_id', $filtro)->get();
        //     // return $data;
        //     // $subset = $reservas->map(function ($user) {
        //     //     return $user->only(['id']);
        //     // });
        //     // $data = Prestamo::with('reserva')->where('usuario_id', Auth::user()->id)
        //     // ->where('fecha_devolucion_max','<', date("Y-m-d H:i:s"))
        //     // ->where('fecha_devolucion', null)
        //     // ->get();
        //     // return $data;
        //     return view('home')->with('alerta',$data);
        // }


        return view('home');
    }
}
