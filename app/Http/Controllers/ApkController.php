<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\User;
use Illuminate\Support\Facades\Hash;

class ApkController extends Controller
{
    public function login(Request $request)
    {
        // return $request;
        $usuario = User::where('documento', '=',$request['documento'])->first();
        if(!!$usuario)
        {
            if(Hash::check($request['password'], $usuario->password)) {
                return $usuario;
           }
        }
        return "false";
    }
}
