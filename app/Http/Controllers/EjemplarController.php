<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\Ejemplar;
use Biblioteca\Ubicacion;
use Biblioteca\Libro;
use DB;

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
            "ubicaciones" => DB::table('ubicacion AS u')->select('u.id AS ubicacion_id', 'u.nombre')->get(),
            "libros" => DB::table('libro AS l')->select('l.id AS libro_id', 'l.titulo')->get()
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
            'libro_id' => $request['libro_id'],
            'estado' => 'Disponible'
        ]);

        return redirect()->route('ejemplar.index')->with('message', 'Registro insertado con éxito!');          
    }

    public function edit($id){
        $data = Ejemplar::find($id);

        $datos = array(
            "ejemplar" => $data,
            "ubicaciones" => DB::table('ubicacion AS u')->select('u.id AS ubicacion_id', 'u.nombre')->get(),
            "libros" => DB::table('libro AS l')->select('l.id AS libro_id', 'l.titulo')->get()
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

    public function busqueda(Request $request){

        $tipoFiltro = $request->tipoFiltro;
        $filtro = $request->filtro;

        switch ($tipoFiltro) {
            case "Titulo":
                $ejemplares = DB::table('ejemplar as ej')
                ->join('libro as l', 'l.id', '=', 'ej.libro_id')
                ->join('autor as a', 'a.id', '=', 'l.autor_id')
                ->join('editorial as ed', 'ed.id', '=', 'l.editorial_id')
                ->join('ubicacion as u', 'u.id', '=', 'ej.ubicacion_id')
                ->select('ej.codigo', 'l.titulo', 'u.nombre as ubicacion',DB::raw('CONCAT(a.nombres, " ", a.apellidos) AS autor'), 'ed.nombre as editorial', 'ej.estado' )
                ->where('l.titulo', 'like', '%'.$filtro.'%')
                ->where('u.nombre', '!=', 'Baja')
                ->distinct('ej.id')
                ->orderBy('ej.estado', 'asc')
                ->get();
                break;
            case "Autor":
            $ejemplares = DB::table('ejemplar as ej')
                ->join('libro as l', 'l.id', '=', 'ej.libro_id')
                ->join('autor as a', 'a.id', '=', 'l.autor_id')
                ->join('editorial as ed', 'ed.id', '=', 'l.editorial_id')
                ->join('ubicacion as u', 'u.id', '=', 'ej.ubicacion_id')
                ->select('ej.codigo', 'l.titulo', 'u.nombre as ubicacion',DB::raw('CONCAT(a.nombres, " ", a.apellidos) AS autor'), 'ed.nombre as editorial', 'ej.estado' )
                ->where('u.nombre', '<>', 'Baja')
                ->where('a.nombres', 'like', '%'.$filtro.'%')
                ->orWhere('a.apellidos', 'like', '%'.$filtro.'%')
                ->distinct('ej.id')
                ->orderBy('ej.estado', 'asc')
                ->get();
                break;
            case "Editorial":
                $ejemplares = DB::table('ejemplar as ej')
                ->join('libro as l', 'l.id', '=', 'ej.libro_id')
                ->join('autor as a', 'a.id', '=', 'l.autor_id')
                ->join('editorial as ed', 'ed.id', '=', 'l.editorial_id')
                ->join('ubicacion as u', 'u.id', '=', 'ej.ubicacion_id')
                ->select('ej.codigo', 'l.titulo', 'u.nombre as ubicacion',DB::raw('CONCAT(a.nombres, " ", a.apellidos) AS autor'), 'ed.nombre as editorial', 'ej.estado' )
                ->where('ed.nombre', 'like', '%'.$filtro.'%')
                ->where('u.nombre', '!=', 'Baja')
                ->distinct('ej.id')
                ->orderBy('ej.estado', 'asc')
                ->get();
                break;
        }

        Return $ejemplares;
    }
}
