<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\Prestamo;
use Biblioteca\User;
use Biblioteca\Ejemplar;
use Auth;
use Biblioteca\Ubicacion;
use Biblioteca\Reserva;

class PrestamoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        if($usuario->tipo_usuario == 'Administrador'){
            $data = Reserva::with('prestamo', 'ejemplar', 'usuario', 'usuarioEstado')->where('estado', 'Prestado')->get();
        }
        else{
            $data = Reserva::with('prestamo', 'ejemplar', 'usuario', 'usuarioEstado')->where('estado', 'Prestado')->where('usuario_id', $usuario->id)->get();
            // return $data;
        }
        return view('prestamo.index', compact('data'));
    }

    public function create(Request $request)
    {
        $baja = Ubicacion::where('nombre', 'Baja')->first();
        $datos = array(
            "usuarios" => User::where('tipo_usuario', '!=', 'Administrador')->get(),
            "ejemplares" => Ejemplar::where('estado', 0)->where('ubicacion_id','<>', $baja->id)->with('libro')->get()    
        );
        return view('prestamo.nuevo', compact('datos'));
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

    public function show($id)
    {
            $data = Reserva::with('prestamo', 'ejemplar', 'usuario', 'usuarioEstado')->find($id);
            // return $data;
            return view('prestamo.detalle', compact('data'));
    }

    public function historial()
    {
        $usuario = Auth::user();
        if($usuario->tipo_usuario == 'Administrador'){
            $data = Reserva::with('prestamo', 'ejemplar', 'usuario', 'usuarioEstado')->get();
            return $data;
        }
        else{
            $data = Reserva::with('prestamo', 'ejemplar', 'usuario', 'usuarioEstado')->where('usuario_id', $usuario->id)->get();
            return $data;
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
