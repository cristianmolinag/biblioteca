<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\User;
use Biblioteca\Reserva;
use Auth;
use Carbon\Carbon;

class AppController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'documento' => 'required|numeric|digits_between:8,10',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ],
        [
            'documento.numeric' => 'Debe ingresar un documento válido'
        ]);

        $credenciales = request(['documento', 'password']);
        if (!Auth::attempt($credenciales)) {
            return response()->json([
                'message' => 'Usuario incorrecto'], 401);
        }

        $usuario = $request->user();
        $tokenResult = $usuario->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 
            'Successfully logged out']);
    }


    public function usuario(Request $request)
    {
        return response()->json($request->user());
    }

    public function getMisReservas(Request $request){

        $usuario = $request->user();

        $misReservas = Reserva::where('usuario_id', $usuario->id)->get();
        return response()->json($misReservas);

    }

    public function getPrestamosActivos(Request $request){
        $usuario = $request->user();

    }
}
