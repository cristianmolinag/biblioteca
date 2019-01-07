<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AlumnoController extends Controller
{
    public function index()
    {
        $data = User::where('tipo_usuario', '=', 'Alumno')->get();
        return view('dashboard.alumno.index', compact('data'));
    }

    public function create()
    {
        return view('dashboard.alumno.nuevo');
    }

    public function store(Request $request)
    {
       $request->validate([
            'nombres' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50',
            'apellidos' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50',
            'documento' => 'required|numeric|digits_between:8,10|unique:usuario',
            'correo' => 'required|email|unique:usuario',
            'password' => 'required|string'
        ],
        [
            'documento.numeric' => 'Debe ingresar un documento válido'
        ]);

        User::create([
            'nombres' => $request['nombres'],
            'apellidos' => $request['apellidos'],
            'documento' => $request['documento'],
            'correo' => $request['correo'],
            'tipo_usuario' => 'Alumno',
            'password' => Hash::make($request['password'])
        ]);

        return redirect()->route('alumno.index')->with('message', 'Registro insertado con éxito!');          
    }

    public function edit($id){
        $data = User::find($id);

        return view('dashboard.alumno.editar', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50',
            'apellidos' => 'required|string|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u|max:50',
            'documento' => 'required|numeric|digits_between:8,10|unique:usuario,documento,'.$id,
            'correo' => 'required|email|unique:usuario,correo,'.$id,
            'password' => 'nullable|string'
        ],
        [
            'documento.numeric' => 'Debe ingresar un documento válido'
        ]);

        $usuario = User::find($id);
        $usuario->nombres = $request['nombres'];
        $usuario->apellidos = $request['apellidos'];
        if($usuario->documento !== $request['documento'])
            $usuario->documento = $request['documento'];
        if($usuario->correo !== $request['correo'])
            $usuario->correo = $request['correo'];
        if($request['password'])
            $usuario->password = Hash::make($request['password']);
        $usuario->save();

        return redirect()->route('alumno.index')->with('message', 'Registro editado con éxito!');  
    }

    public function file(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        if (count($data) > 0) 
        {
            foreach ($data as $row => $value) {

                if(!User::where('documento','=',$value[2])->where('correo','=',$value[3])->first())
                {
                    User::create([
                        'nombres' => $value[0],
                        'apellidos' => $value[1],
                        'documento' => $value[2],
                        'correo' => $value[3],
                        'tipo_usuario' => 'Alumno',
                        'password' => Hash::make($value[2])
                        ]);      
                    }
                }
            return redirect()->route('alumno.index')->with('message', 'Registros insertados con éxito!');
        }
        else
        {
            return redirect()->route('alumno.index')->with('message', 'El archivo no tiene registros!');
        }
    }
}
