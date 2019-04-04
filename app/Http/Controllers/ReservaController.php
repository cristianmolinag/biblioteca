<?php

namespace Biblioteca\Http\Controllers;

use Auth;
use Biblioteca\Ejemplar;
use Biblioteca\Prestamo;
use Biblioteca\Reserva;
use Biblioteca\Ubicacion;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        if (Auth::user()->tipo_usuario == 'Administrador') {
            $data = Reserva::with('usuario', 'usuarioEstado', 'ejemplar')->where('estado', '=', 'Reservado')->get();
        } else {
            $data = Reserva::with('usuario', 'usuarioEstado', 'ejemplar')->where('estado', '=', 'Reservado')->where('usuario_id', Auth::user()->id)->get();
            // return $data;
        }
        return view('reserva.index', compact('data'));
    }

    public function create(Request $request)
    {
        $baja = Ubicacion::where('nombre', 'Baja')->first();
        $data = Ejemplar::where('estado', 'Disponible')->where('ubicacion_id', '<>', $baja->id)->with('libro')->get();
        return view('reserva.nuevo', compact('data'));
    }

    public function store(Request $request)
    {
        $usuario = Auth::user();

        if ($usuario->tipo_usuario != 'Administrador') {

            $misPendientes = Reserva::where(function ($query) use ($usuario) {
                $query->where('usuario_id', $usuario->id);
            })
                ->where(function ($query) use ($usuario) {
                    $query->where('estado', 'reservado')
                        ->orWhere('estado', 'prestado');
                })->get();

            if (count($misPendientes) >= 3) {
                return redirect()->route('reserva.nuevo')->with('error', 'No puede reservar el ejemplar. Tiene pendientes 3 préstamos o reservas');
            } else {

                $ejemplar = Ejemplar::Find($request->ejemplar_id);

                Reserva::create([
                    'usuario_id' => $usuario->id,
                    'ejemplar_id' => $ejemplar->id,
                    'usuario_estado_id' => $usuario->id,
                    'estado' => 'Reservado',
                ]);

                $ejemplar->estado = 'Reservado';
                $ejemplar->save();

                return redirect()->route('reserva.index')->with('message', 'reserva realizada con éxito, por favor acérquese a la biblioteca para la entrega del ejemplar');
            }

        }
    }

    public function update(Request $request, $id)
    {

        $prestador = Auth::user();
        $reserva = Reserva::find($id);
        $reserva->usuario_estado_id = $prestador->id;
        $reserva->estado = $request->estado;
        $reserva->save();
        $usuario = Auth::user();

        $ejemplar = Ejemplar::find($reserva->ejemplar_id);

        switch ($request->estado) {

            case 'Negado':
                $ejemplar->estado = 'Disponible';
                $mensaje = 'Reserva negada con éxito';
                break;

            case 'Prestado':

                $prestamos = Reserva::where('usuario_id', $usuario->id)->where('estado', 'Prestado')->get();
                if ($prestamos->count() < 3) {
                    $fecha_prestamo = date("Y-m-d H:i:s");
                    $fecha_devolucion_max = date("Y-m-d H:i:s", strtotime('+3 day', strtotime($fecha_prestamo)));

                    Prestamo::create([
                        'prestador_id' => $prestador->id,
                        'reserva_id' => $reserva->id,
                        'fecha_prestamo' => $fecha_prestamo,
                        'fecha_devolucion_max' => $fecha_devolucion_max,
                    ]);

                    $ejemplar->estado = 'Prestado';
                    $mensaje = 'Reserva aceptada con éxito';
                } else {
                    return redirect()->route('reserva.nuevo')->with('error', 'El usuario ' . $usuario->nombres . ' ' . $usuario->apellidos . ' tiene 3 prestamos pendientes por devolver');
                }
                break;
            case 'Cancelado':

                $ejemplar->estado = 'Disponible';
                $mensaje = 'Reserva cancelada con éxito';

            default:
                break;
        }

        $ejemplar->save();

        return redirect()->route('reserva.index')->with('message', $mensaje);
    }

}
