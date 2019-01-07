<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\Ejemplar;
use Biblioteca\Ubicacion;
use Biblioteca\Libro;

class EjemplarController extends Controller
{
    public function index()
    {
        $data = Ejemplar::with('ubicacion', 'libro')->get();
        return view('dashboard.ejemplar.index', compact('data'));
    }

    public function create()
    {
        $datos = array(
            "ubicaciones" => Ubicacion::pluck('nombre','id'),
            "libros" => Libro::pluck('titulo', 'id')
        );
        return view('dashboard.ejemplar.nuevo', compact('datos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:13|unique:ejemplar',
            'ubicacion_id' => 'required|numeric',
            'libro_id' => 'required|numeric',
        ]);
            
        //return $request;
        Ejemplar::create([
            'codigo' => $request['codigo'],
            'ubicacion_id' => $request['ubicacion_id'],
            'libro_id' => $request['libro_id']
        ]);

        return redirect()->route('ejemplar.index')->with('message', 'Registro insertado con éxito!');          
    }

    public function edit($id){
        $data = Ejemplar::find($id);

        $datos = array(
            "ejemplar" => $data,
            "ubicaciones" => Ubicacion::pluck('nombre','id'),
            "libros" => Libro::pluck('titulo', 'id')
        );
        return view('dashboard.ejemplar.editar', compact('datos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|string|max:13|unique:ejemplar,codigo,'.$id,
            'ubicacion_id' => 'required|numeric',
            'libro_id' => 'required|numeric',
        ]);

        $data = Ejemplar::find($id);
        if($request['codigo'] !== $data->codigo)
            $data->codigo = $request['codigo'];
        $data->ubicacion_id = $request['ubicacion_id'];
        $data->libro_id = $request['libro_id'];
        $data->save();

        return redirect()->route('ejemplar.index')->with('message', 'Registro editado con éxito!');  
    }

    public function file(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        if (count($data) > 0) 
        {
            foreach ($data as $row => $value) {
                if(!Ejemplar::where('codigo','=',$value[0])->first())
                {
                    Ejemplar::create([
                        'codigo' => $value[0],
                        'ubicacion_id' => $value[1],
                        'libro_id' => $value[2]
                        ]);      
                    }
                }
            return redirect()->route('ejemplar.index')->with('message', 'Registros insertados con éxito!');
        }
        else
        {
            return redirect()->route('ejemplar.index')->with('message', 'El archivo no tiene registros!');
        }
    }
}
