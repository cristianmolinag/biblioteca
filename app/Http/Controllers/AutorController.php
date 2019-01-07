<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\Autor;

class AutorController extends Controller
{
    public function index()
    {
        $data = Autor::All();
        return view('dashboard.autor.index', compact('data'));
    }

    public function create()
    {
        return view('dashboard.autor.nuevo');
    }

    public function store(Request $request)
    {
       $request->validate([
            'nombres' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50',
            'apellidos' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50',
        ]);

        Autor::create([
            'nombres' => $request['nombres'],
            'apellidos' => $request['apellidos']
        ]);

        return redirect()->route('autor.index')->with('message', 'Registro insertado con éxito!');          
    }

    public function edit($id){
        $data = Autor::find($id);

        return view('dashboard.autor.editar', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50',
            'apellidos' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50'
        ]);

        $data = Autor::find($id);
        $data->nombres = $request['nombres'];
        $data->apellidos = $request['apellidos'];
        $data->save();

        return redirect()->route('autor.index')->with('message', 'Registro editado con éxito!');  
    }
}
