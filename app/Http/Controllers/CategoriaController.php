<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $data = Categoria::All();
        return view('dashboard.categoria.index', compact('data'));
    }

    public function create()
    {
        return view('dashboard.categoria.nuevo');
    }

    public function store(Request $request)
    {
       $request->validate([
            'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50'
        ]);

        Categoria::create([
            'nombre' => $request['nombre']
        ]);

        return redirect()->route('categoria.index')->with('message', 'Registro insertado con éxito!');          
    }

    public function edit($id){
        $data = Categoria::find($id);

        return view('dashboard.categoria.editar', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50'
        ]);

        $data = Categoria::find($id);
        $data->nombre = $request['nombre'];
        $data->save();

        return redirect()->route('categoria.index')->with('message', 'Registro editado con éxito!');  
    }
}
