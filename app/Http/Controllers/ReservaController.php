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

        if (Auth::user()->tipo_usuario != 'Administrador') {

            $ejemplar = Ejemplar::Find($request->id);
            $usuario = Auth::user();
            $prestamos = Reserva::where('usuario_id', $usuario->id)->where('estado', 'Prestado')->get();

            if ($prestamos->count() < 3) {
                Reserva::create([
                    'usuario_id' => $usuario->id,
                    'ejemplar_id' => $ejemplar->id,
                    'usuario_estado_id' => $usuario->id,
                    'estado' => 'Reservado',
                ]);

                $ejemplar->estado = 'Reservado';
                $ejemplar->save();

                return redirect()->route('reserva.index')->with('message', 'Reserva registrada con éxito!');
            } else {
                return redirect()->route('reserva.nuevo')->with('error', 'El usuario ' . $usuario->nombres . ' ' . $usuario->apellidos . ' tiene 3 prestamos pendientes por devolver');
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
                return $prestamos->count();
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
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'documento' => 'required|string|max:17|exists:usuario',
    //         'codigo' => 'required|string|max:13|exists:ejemplar',
    //     ]);

    //     $usuario = User::where('documento', $request->documento)->first();
    //     $prestamos = Prestamo::where('usuario_id', $usuario->id)->get();

    //     if($prestamos->count() < 3){

    //         $fecha_prestamo = date("Y-m-d H:i:s");
    //         $fecha_devolucion_max = date ("Y-m-d H:i:s", strtotime ( '+3 day' , strtotime ( $fecha_prestamo )));
    //         $ejemplar = Ejemplar::where('codigo', $request->codigo)->first();

    //         Prestamo::create([
    //             'prestador_id' => Auth::user()->id,
    //             'usuario_id' => $usuario->id,
    //             'ejemplar_id' => $ejemplar->id,
    //             'fecha_prestamo' => $fecha_prestamo,
    //             'fecha_devolucion_max' => $fecha_devolucion_max
    //         ]);

    //         $ejemplar->estado = true;
    //         $ejemplar->save();

    //         return redirect()->route('prestamo')->with('message', 'Prestamo registrado con éxito!');
    //     }
    //     else{
    //         return redirect()->route('prestamo.nuevo')->with('error', 'El usuario '. $usuario->nombres .' '.$usuario->apellidos . ' tiene 3 prestamos pendientes por devolver');
    //     }
    // }

    // public function show($id){
    //     if(Auth::user()->tipo_usuario == 'Administrador'){
    //         $data = Prestamo::with('usuario', 'prestador', 'ejemplar', 'receptor')->find($id);
    //     }
    //     else{
    //         $data = Prestamo::where('usuario_id', Auth::user()->id)->where('id',$id)->with('usuario', 'prestador', 'ejemplar', 'receptor')->first();
    //     }

    //     if($data){
    //         return view('prestamo.detalle', compact('data'));
    //     }
    //     else{
    //         return redirect('/home');
    //     }
    // }

    // public function historial(){
    //     if(Auth::user()->tipo_usuario == 'Administrador'){
    //         $data = Prestamo::with('usuario', 'prestador', 'ejemplar')->get();
    //     }
    //     else{
    //         $data = Prestamo::with('usuario', 'prestador', 'ejemplar')->where('usuario_id', Auth::user()->id)->get();
    //     }
    //     return view('prestamo.historial', compact('data'));
    // }

    // public function update(Request $request, $id){

    //     $data = Prestamo::find($id);
    //     $data->fecha_devolucion = date("Y-m-d H:i:s");
    //     $data->receptor_id = Auth::user()->id;
    //     $data->save();

    //     $ejemplar = Ejemplar::find($data->id);
    //     $ejemplar->estado = false;
    //     $ejemplar->save();

    //     return redirect()->route('prestamo')->with('message', 'Ejemplar devuelto con éxito!');
    // }
}
