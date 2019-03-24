<?php

namespace Biblioteca\Http\Controllers;

use Biblioteca\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $data = User::where('tipo_usuario', '=', 'Administrador')->get();
        return view('dashboard.admin.index', compact('data'));

    }

    public function create()
    {
        return view('dashboard.admin.nuevo');
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
            'tipo_usuario' => 'Administrador',
            'password' => Hash::make($request['password'])
        ]);

        return redirect()->back()->with('message', 'Registro insertado con éxito!');
    }

    public function edit($id){
        $data = User::find($id);

        return view('dashboard.admin.editar', compact('data'));
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

        return redirect()->route('admin.index')->with('message', 'Registro editado con éxito!');        
    }
}
