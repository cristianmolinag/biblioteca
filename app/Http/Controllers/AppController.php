<?php

namespace Biblioteca\Http\Controllers;

use Illuminate\Http\Request;
use Biblioteca\User;
use Biblioteca\Reserva;
use Biblioteca\Prestamo;
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


    public function getUsuario(Request $request)
    {
        return response()->json($request->user());
    }

    public function getMisReservas(Request $request){

        $usuario = $request->user();

        $misReservas = Reserva::with('usuario', 'usuarioEstado', 'ejemplar', 'prestamo')->where('usuario_id', $usuario->id)->get();
        return response()->json($misReservas);
    }

    public function getMisPrestamos(Request $request){
        $usuario = $request->user();
         $data = Prestamo::with('prestador', 'receptor', 'reserva')->whereHas( 'reserva', function($query) use($usuario) {
            $query->where('usuario_id', $usuario->id);
        })->get();
        return response()->json($data);
    }

    public function busqueda(Request $request){

        $tipoFiltro = $request->tipoFiltro;
        $filtro = $request->filtro;

        switch ($tipoFiltro) {
            case "Titulo":
                $ejemplares = DB::table('ejemplar as ej')
                ->join('libro as l', 'l.id', '=', 'ej.libro_id')
                ->join('autor as a', 'a.id', '=', 'l.autor_id')
                ->join('editorial as ed', 'ed.id', '=', 'l.editorial_id')
                ->join('ubicacion as u', 'u.id', '=', 'ej.ubicacion_id')
                ->select('ej.codigo', 'l.titulo', 'u.nombre as ubicacion',DB::raw('CONCAT(a.nombres, " ", a.apellidos) AS autor'), 'ed.nombre as editorial', 'ej.estado' )
                ->where('l.titulo', 'like', '%'.$filtro.'%')
                ->where('u.nombre', '!=', 'Baja')
                ->distinct('ej.id')
                ->orderBy('ej.estado', 'asc')
                ->get();
                break;
            case "Autor":
            $ejemplares = DB::table('ejemplar as ej')
                ->join('libro as l', 'l.id', '=', 'ej.libro_id')
                ->join('autor as a', 'a.id', '=', 'l.autor_id')
                ->join('editorial as ed', 'ed.id', '=', 'l.editorial_id')
                ->join('ubicacion as u', 'u.id', '=', 'ej.ubicacion_id')
                ->select('ej.codigo', 'l.titulo', 'u.nombre as ubicacion',DB::raw('CONCAT(a.nombres, " ", a.apellidos) AS autor'), 'ed.nombre as editorial', 'ej.estado' )
                ->where('u.nombre', '<>', 'Baja')
                ->where('a.nombres', 'like', '%'.$filtro.'%')
                ->orWhere('a.apellidos', 'like', '%'.$filtro.'%')
                ->distinct('ej.id')
                ->orderBy('ej.estado', 'asc')
                ->get();
                break;
            case "Editorial":
                $ejemplares = DB::table('ejemplar as ej')
                ->join('libro as l', 'l.id', '=', 'ej.libro_id')
                ->join('autor as a', 'a.id', '=', 'l.autor_id')
                ->join('editorial as ed', 'ed.id', '=', 'l.editorial_id')
                ->join('ubicacion as u', 'u.id', '=', 'ej.ubicacion_id')
                ->select('ej.codigo', 'l.titulo', 'u.nombre as ubicacion',DB::raw('CONCAT(a.nombres, " ", a.apellidos) AS autor'), 'ed.nombre as editorial', 'ej.estado' )
                ->where('ed.nombre', 'like', '%'.$filtro.'%')
                ->where('u.nombre', '!=', 'Baja')
                ->distinct('ej.id')
                ->orderBy('ej.estado', 'asc')
                ->get();
                break;
        }

        Return $ejemplares;
    }
}
