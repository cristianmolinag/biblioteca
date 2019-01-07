<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\Ubicacion;

class UbicacionController extends Controller
{
    public function index()
    {
        $data = Ubicacion::All();
        return view('dashboard.ubicacion.index', compact('data'));
    }

    public function create()
    {
        return view('dashboard.ubicacion.nuevo');
    }

    public function store(Request $request)
    {
       $request->validate([
            'nombre' => 'required|string|max:50|unique:ubicacion'
        ]);

        Ubicacion::create([
            'nombre' => $request['nombre']
        ]);

        return redirect()->route('ubicacion.index')->with('message', 'Registro insertado con éxito!');          
    }

    public function edit($id){
        $data = Ubicacion::find($id);

        return view('dashboard.ubicacion.editar', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:ubicacion,nombre,'.$id,
        ]);

        $data = Ubicacion::find($id);
        $data->nombre = $request['nombre'];
        $data->save();

        return redirect()->route('ubicacion.index')->with('message', 'Registro editado con éxito!');  
    }
}
