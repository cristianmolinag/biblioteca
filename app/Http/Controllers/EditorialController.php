<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\Editorial;

class EditorialController extends Controller
{
    public function index()
    {
        $data = Editorial::All();
        return view('dashboard.editorial.index', compact('data'));
    }

    public function create()
    {
        return view('dashboard.editorial.nuevo');
    }

    public function store(Request $request)
    {
       $request->validate([
            'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50'
        ]);

        Editorial::create([
            'nombre' => $request['nombre']
        ]);

        return redirect()->route('editorial.index')->with('message', 'Registro insertado con éxito!');          
    }

    public function edit($id){
        $data = Editorial::find($id);

        return view('dashboard.editorial.editar', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50'
        ]);

        $data = Editorial::find($id);
        $data->nombre = $request['nombre'];
        $data->save();

        return redirect()->route('editorial.index')->with('message', 'Registro editado con éxito!');  
    }
}
