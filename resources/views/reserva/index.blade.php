@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(Auth::user()->tipo_usuario != 'Administrador')
            <h5 class="text-titulo">Mis reservas</h5>
            <div class="form-group">
                <a class="btn btn-success text-light float-md-right" href="{{ route('reserva.nuevo') }}">
                    Nueva reserva
                </a>
            </div>
            <div class="table-responsive-md">
                <table class="table table-striped table-bordered" style="width:100%" id="tabla">
                    <thead>
                        <tr>
                            <th>Código ejemplar</th>
                            <th>Titulo</th>
                            <th>Fecha Reserva</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td class="text-center">{!! $row->ejemplar->codigo !!}</td>
                            <td class="text-center">{!! $row->ejemplar->libro->titulo !!}</td>
                            <td class="text-center">{!! $row->created_at !!}</td>
                            <td class="text-center">
                            <form  method="POST" action="{!! route('reserva.update', ['id' => $row->id]) !!}">
                            @method('PUT')
                            @csrf
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" name="estado" id="estado">
                                            <option value="Cancelado">Cancelar</option>
                                        </select>
                                    </div>  
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary form-control">Enviar</button>
                                    </div>
                                </div>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <h5 class="text-titulo">Listado de reservas activas</h5>
            <div class="table-responsive-md">
                <table class="table table-striped table-bordered" style="width:100%" id="tabla">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Perfil</th>
                            <th>Código ejemplar</th>
                            <th>Titulo</th>
                            <th>Fecha Reserva</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td class="text-center">{!! $row->usuario->nombres .' '. $row->usuario->apellidos !!}</td>
                            <td class="text-center">{!! $row->usuario->tipo_usuario !!}</td>
                            <td class="text-center">{!! $row->ejemplar->codigo !!}</td>
                            <td class="text-center">{!! $row->ejemplar->libro->titulo !!}</td>
                            <td class="text-center">{!! $row->created_at !!}</td>
                            <td class="text-center">
                            <form  method="POST" action="{!! route('reserva.update', ['id' => $row->id]) !!}">
                            @method('PUT')
                            @csrf
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" name="estado" id="estado">
                                            <option value="Negado">Negar</option>
                                            <option value="Prestado">Prestar</option>
                                        </select>
                                    </div>  
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary form-control">Enviar</button>
                                    </div>
                                </div>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
