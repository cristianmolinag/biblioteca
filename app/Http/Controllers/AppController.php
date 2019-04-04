<?php

namespace Biblioteca\Http\Controllers;

use Auth;
use Biblioteca\Ejemplar;
use Biblioteca\Prestamo;
use Biblioteca\Reserva;
use Biblioteca\User;
use Illuminate\Http\Request;

class AppController extends Controller
{

    public function login(Request $request)
    {
        $credenciales = request(['documento', 'password']);

        if (!Auth::attempt($credenciales, true)) {
            return response()->json(null, 401);
        } else {
            if (Auth::user()->tipo_usuario == "Administrador") {
                Auth::logout();
                return response()->json(null, 401);
            }
            return response()->json([
                'token' => Auth::user()->remember_token, 200]);
        }
    }

    public function getUsuario(Request $request)
    {
        $usuario = User::where('remember_token', $request->header('token'))->first();

        if ($usuario) {
            return response()->json([
                'data' => $usuario, 200]);
        } else {
            return response()->json([null, 403]);
        }
    }

    public function getMisReservas(Request $request)
    {
        $usuario = User::where('remember_token', $request->header('token'))->first();

        if ($usuario) {
            $misReservas = Reserva::with('usuario', 'usuarioEstado', 'ejemplar')
                ->where(function ($query) use ($usuario) {
                    $query->where('usuario_id', $usuario->id);
                })
                ->where(function ($query) use ($request) {
                    $query->whereHas('ejemplar', function ($query) use ($request) {
                        $query->whereHas('libro', function ($query) use ($request) {
                            $query->where('titulo', 'like', "%{$request->value}%")
                                ->orWhere('isbn', 'like', "%{$request->value}%")
                                ->orWhereHas('autor', function ($query) use ($request) {
                                    $searchString = "%{$request->value}%";
                                    $query->whereRaw("(CONCAT(autor.nombres,' ',autor.apellidos) like ?)", [$searchString]);
                                })->orWhereHas('editorial', function ($query) use ($request) {
                                $query->where('nombre', 'like', "%{$request->value}%");
                            });
                        })->orWhere('codigo', 'like', "%{$request->value}%");
                    });
            })->paginate(5);
            return response()->json($misReservas);
        } else {
            return response()->json([null, 403]);
        }
    }

    public function getMisPrestamos(Request $request)
    {
        $usuario = User::where('remember_token', $request->header('token'))->first();
        if ($usuario) {

            $data = Prestamo::with('prestador', 'receptor', 'reserva')
                ->where(function ($query) use ($usuario) {
                    $query->whereHas('reserva', function ($query) use ($usuario) {
                        $query->where('usuario_id', $usuario->id);
                    });
                })->where(function ($query) use ($request) {
                $query->whereHas('reserva', function ($query) use ($request) {
                    $query->whereHas('ejemplar', function ($query) use ($request) {
                        $query->whereHas('libro', function ($query) use ($request) {
                            $query->where('titulo', 'like', "%{$request->value}%")
                                ->orWhere('isbn', 'like', "%{$request->value}%")
                                ->orWhereHas('autor', function ($query) use ($request) {
                                    $searchString = "%{$request->value}%";
                                    $query->whereRaw("(CONCAT(autor.nombres,' ',autor.apellidos) like ?)", [$searchString]);
                                })->orWhereHas('editorial', function ($query) use ($request) {
                                $query->where('nombre', 'like', "%{$request->value}%");
                            });
                        })->orWhere('codigo', 'like', "%{$request->value}%");
                    });
                });
            })->paginate(5);
            return response()->json($data, 200);

        } else {
            return response()->json([null, 403]);
        }
    }

    public function getMisPendientes(Request $request)
    {
        $usuario = User::where('remember_token', $request->header('token'))->first();

        if ($usuario) {

            $misPendientes = Reserva::with('ejemplar', 'prestamo')->where(function ($query) use ($usuario) {
                $query->where('usuario_id', $usuario->id);
            })
                ->where(function ($query) use ($usuario) {
                    $query->where('estado', 'reservado')
                        ->orWhere('estado', 'prestado');
                })->get();

            return response()->json($misPendientes, 200);
        } else {
            return response()->json([null, 403]);
        }

    }

    public function getEjemplares(Request $request)
    {
        $data = Ejemplar::with('ubicacion', 'libro')
            ->where(function ($query) {
                $query->whereHas('ubicacion', function ($query) {
                    $query->where('nombre', '!=', 'Baja');
                });
            })
            ->where(function ($query) use ($request) {
                $query->whereHas('libro', function ($query) use ($request) {
                    $query->where('titulo', 'like', "%{$request->value}%")
                        ->orWhere('isbn', 'like', "%{$request->value}%")
                        ->orWhereHas('autor', function ($query) use ($request) {
                            $searchString = "%{$request->value}%";
                            $query->whereRaw("(CONCAT(autor.nombres,' ',autor.apellidos) like ?)", [$searchString]);
                        })->orWhereHas('editorial', function ($query) use ($request) {
                        $query->where('nombre', 'like', "%{$request->value}%");
                    });
                })
                    ->orWhere('codigo', 'like', "%{$request->value}%");
            })->paginate(5);

        return response()->json($data);
    }

    public function reservar(Request $request)
    {
        $usuario = User::where('remember_token', $request->header('token'))->first();

        if ($usuario) {

            $misPendientes = Reserva::where(function ($query) use ($usuario) {
                $query->where('usuario_id', $usuario->id);
            })
                ->where(function ($query) use ($usuario) {
                    $query->where('estado', 'reservado')
                        ->orWhere('estado', 'prestado');
                })->get();

            if (count($misPendientes) >= 3) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => 'No puede reservar el ejemplar. Tiene pendientes 3 préstamos o reservas',
                ], 200);
            } else {

                $ejemplar = Ejemplar::Find($request->ejemplar_id);

                Reserva::create([
                    'usuario_id' => $usuario->id,
                    'ejemplar_id' => $ejemplar->id,
                    'usuario_estado_id' => $usuario->id,
                    'estado' => 'Reservado',
                ]);

                $ejemplar->estado = 'Reservado';
                $ejemplar->save();

                return response()->json([
                    'success' => true,
                    'data' => null,
                    'message' => 'reserva realizada con éxito, por favor acérquese a la biblioteca para la entrega del ejemplar',
                ], 200);
            }

        } else {
            return response()->json([null, 403]);
        }
    }

    public function cancelarReserva(Request $request)
    {
        $usuario = User::where('remember_token', $request->header('token'))->first();

        if ($usuario) {
            $reserva = Reserva::find($request->reserva_id);

            $reserva->estado = 'Cancelado';
            $ejemplar = Ejemplar::find($reserva->ejemplar_id);
            $ejemplar->estado = 'Disponible';

            $reserva->save();
            $ejemplar->save();

            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'reserva cancelada con éxito',
            ], 200);
        } else {
            return response()->json([null, 403]);
        }
    }
}
