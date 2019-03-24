<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        if(Auth::user()->tipo_usuario == 'Administrador'){
            $data = Prestamo::with('usuario', 'prestador', 'ejemplar')->where('fecha_devolucion','=', null)->get();
        }
        else{
            $data = Prestamo::with('usuario', 'prestador', 'ejemplar')->where('fecha_devolucion','=', null)->where('usuario_id', Auth::user()->id)->get();
        }
        return view('prestamo.index', compact('data'));
    }

    // public function create(Request $request)
    // {
    //     $baja = Ubicacion::where('nombre', 'Baja')->first();
    //     $datos = array(
    //         "usuarios" => User::where('tipo_usuario', '!=', 'Administrador')->get(),
    //         "ejemplares" => Ejemplar::where('estado', 0)->where('ubicacion_id','<>', $baja->id)->with('libro')->get()    
    //     );
    //     return view('prestamo.nuevo', compact('datos'));
    // }

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
