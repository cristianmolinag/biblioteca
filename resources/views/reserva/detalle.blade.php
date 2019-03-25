@extends('layouts.app') 
@section('content')
<div class="row form-group">
        <a href="{{ URL::previous() }}" class="btn main-color text-light"><span data-feather="arrow-left"></span></a>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <h5 class="text-titulo">Detalle del prestamo # {{ $data->id }}</h5>
            <hr>
            <div class="card">
                <div class="card-header">
                    Datos del prestamo
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Fecha préstamo: </h5>
                                <p class="text-muted">{{ $data->fecha_prestamo }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Fecha devolución máx: </h5>
                                @if (strtotime(date("Y-m-d H:i:s")) < strtotime($data->fecha_devolucion_max))
                                <p class="text-muted">{{ $data->fecha_devolucion_max }}</p>
                                @else
                                <p class="text-danger">{{ $data->fecha_devolucion_max }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Fecha devolución: </h5>
                                @if ($data->fecha_devolucion)
                                <p class="text-muted">{{ $data->fecha_devolucion }}</p>
                                    @else
                                <p class="text-muted">-</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Prestado por: </h5>
                                <p class="text-muted">{{ $data->prestador->nombres }} {{ $data->prestador->apellidos }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Recibido por: </h5>
                                @if ($data->receptor)
                                    <p class="text-muted">{{ $data->receptor->nombres }} {{ $data->receptor->apellidos }}</p>
                                @else
                                    <p class="text-muted">-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    Datos del libro
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Código libro:</h5>
                                <p class="text-muted">{{ $data->ejemplar->codigo }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Isbn:</h5>
                                <p class="text-muted">{{ $data->ejemplar->libro->isbn }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Titulo: </h5>
                                <p class="text-muted">{{ $data->ejemplar->libro->titulo }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Autor: </h5>
                                <p class="text-muted">{{ $data->ejemplar->libro->autor->nombres }} {{ $data->ejemplar->libro->autor->apellidos }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Editorial: </h5>
                                <p class="text-muted">{{ $data->ejemplar->libro->editorial->nombre }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Categoría: </h5>
                                <p class="text-muted">{{ $data->ejemplar->libro->categoria->nombre }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    Datos del usuario
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Usuario:</h5>
                                <p class="text-muted">{{ $data->usuario->nombres }} {{ $data->usuario->apellidos }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Documento: </h5>
                                <p class="text-muted">{{ $data->usuario->documento }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <h5>Tipo usuario: </h5>
                                <p class="text-muted">{{ $data->usuario->tipo_usuario }}</p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <br>
            @if($data->ejemplar->estado && Auth::user()->tipo_usuario == 'Administrador')
            <form method="POST" action="{{ route('prestamo.update', ['id' => $data->id]) }}">
                @method('PUT')
                @csrf
                <button type="submit" class="btn main-color text-light btn-block">Devolver</button>
            </form>
            <br>
            @endif
    </div>
</div>
@endsection