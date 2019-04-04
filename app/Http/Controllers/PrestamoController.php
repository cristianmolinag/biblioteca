<?php

namespace Biblioteca\Http\Controllers;

use Auth;
use Biblioteca\Ejemplar;
use Biblioteca\Prestamo;
use Biblioteca\Reserva;
use Biblioteca\Ubicacion;
use Biblioteca\User;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        if ($usuario->tipo_usuario == 'Administrador') {
            $data = Prestamo::with('prestador', 'receptor', 'reserva')->get();
        } else {
            $data = Prestamo::with('prestador', 'receptor', 'reserva')
                ->whereHas('reserva', function ($query) use ($usuario) {
                    $query->where('usuario_id', $usuario->id)
                    ->where('estado', 'Prestado');
                })->get();
            // $data = Reserva::with('prestamo', 'ejemplar', 'usuario', 'usuarioEstado')->where('estado', 'Prestado')->where('usuario_id', $usuario->id)->get();
            //  return $data;
        }
        return view('prestamo.index', compact('data'));
    }

    public function create(Request $request)
    {
        $baja = Ubicacion::where('nombre', 'Baja')->first();
        $datos = array(
            "usuarios" => User::where('tipo_usuario', '!=', 'Administrador')->get(),
            "ejemplares" => Ejemplar::where('estado', 0)->where('ubicacion_id', '<>', $baja->id)->with('libro')->get(),
        );
        return view('prestamo.nuevo', compact('datos'));
    }

    public function show($id)
    {
        $data = Prestamo::with('prestador', 'receptor', 'reserva')->find($id);
        // return $data;
        return view('prestamo.detalle', compact('data'));
    }

    public function historial()
    {
        $usuario = Auth::user();
        if ($usuario->tipo_usuario == 'Administrador') {

            $data = Prestamo::with('prestador', 'receptor', 'reserva')->get();
        } else {
            $data = Prestamo::with('prestador', 'receptor', 'reserva')
                ->whereHas('reserva', function ($query) use ($usuario) {
                    $query->where('usuario_id', $usuario->id);
                })->get();
        }
        return view('prestamo.historial', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $receptor = Auth::user();
        $reserva = Reserva::find($id);
        $reserva->usuario_estado_id = $receptor->id;
        $reserva->estado = 'Devuelto';
        $reserva->save();

        $ejemplar = Ejemplar::find($reserva->ejemplar_id);

        $prestamo = Prestamo::where('reserva_id', $reserva->id)->first();

        $prestamo->fecha_devolucion = date("Y-m-d H:i:s");
        $prestamo->receptor_id = $receptor->id;
        $prestamo->save();

        $ejemplar->estado = 'Disponible';
        $ejemplar->save();

        return redirect()->route('prestamo')->with('message', 'Ejemplar devuelto con éxito!');
    }
}
