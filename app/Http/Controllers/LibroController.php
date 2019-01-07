<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\Libro;
use Biblioteca\Autor;
use Biblioteca\Categoria;
use Biblioteca\Editorial;

class LibroController extends Controller
{
    public function index()
    {
        $data = Libro::with('autor', 'categoria','editorial')->get();
        return view('dashboard.libro.index', compact('data'));
    }

    public function create()
    {
        $datos = array(
            "autores" => Autor::pluck('nombres','id'),
            "categorias" => Categoria::pluck('nombre', 'id'),
            "editoriales" => Editorial::pluck('nombre', 'id')
        );
        return view('dashboard.libro.nuevo', compact('datos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|string|max:17|unique:libro',
            'titulo' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50',
            'anio' => 'required|numeric|digits:4',
            'numero_paginas' => 'required|numeric|digits_between:1,5',
            'autor_id' => 'required|numeric',
            'editorial_id' => 'required|numeric',
            'categoria_id' => 'required|numeric',
        ]);
            
        //return $request;
        Libro::create([
            'isbn' => $request['isbn'],
            'titulo' => $request['titulo'],
            'anio' => $request['anio'],
            'numero_paginas' => $request['numero_paginas'],
            'autor_id' => $request['autor_id'],
            'editorial_id' => $request['editorial_id'],
            'categoria_id' => $request['categoria_id']
        ]);

        return redirect()->route('libro.index')->with('message', 'Registro insertado con éxito!');          
    }

    public function edit($id){
        $data = Libro::find($id);

        $datos = array(
            "libro" => $data,
            "autores" => Autor::pluck('nombres','id'),
            "categorias" => Categoria::pluck('nombre', 'id'),
            "editoriales" => Editorial::pluck('nombre', 'id')
        );
        return view('dashboard.libro.editar', compact('datos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'isbn' => 'required|string|max:17|unique:libro,isbn,'.$id,
            'titulo' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50',
            'anio' => 'required|numeric|digits:4',
            'numero_paginas' => 'required|numeric|digits_between:1,5',
            'autor_id' => 'required|numeric',
            'editorial_id' => 'required|numeric',
            'categoria_id' => 'required|numeric',
        ]);
        $data = Libro::find($id);
        if($request['isbn'] !== $data->isbn)
            $data->isbn = $request['isbn'];
        $data->titulo = $request['titulo'];
        $data->anio = $request['anio'];
        $data->numero_paginas = $request['numero_paginas'];
        $data->autor_id = $request['autor_id'];
        $data->editorial_id = $request['editorial_id'];
        $data->categoria_id = $request['categoria_id'];
        $data->save();

        return redirect()->route('libro.index')->with('message', 'Registro editado con éxito!');  
    }

    public function file(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        if (count($data) > 0) 
        {
            foreach ($data as $row => $value) {

                if(!Libro::where('isbn','=',$value[0])->first())
                {
                    Libro::create([
                        'isbn' => $value[0],
                        'titulo' => $value[1],
                        'anio' => $value[2],
                        'numero_paginas' => $value[3],
                        'autor_id' => $value[4],
                        'editorial_id' => $value[5],
                        'categoria_id' => $value[6]
                        ]);      
                    }
                }
            return redirect()->route('libro.index')->with('message', 'Registros insertados con éxito!');
        }
        else
        {
            return redirect()->route('libro.index')->with('message', 'El archivo no tiene registros!');
        }
    }
}
