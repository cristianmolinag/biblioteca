<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Biblioteca\User;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    
    public function index(){
        $data = Auth::user();
        return view('usuario.perfil', compact('data'));
    }

    public function update(Request $request, $id){
        if($request->password){
            $data = User::find(Auth::user()->id);
            $data->password = Hash::make($request['password']);
            $data->save();
            return redirect()->route('usuario.perfil')->with('message', 'Contraseña actualizada con éxito!');
        }
        else{
            return redirect()->route('usuario.perfil')->with('message', 'Si desea cambiar la contraseña debe diligenciar el campo');
        }
    }

}
