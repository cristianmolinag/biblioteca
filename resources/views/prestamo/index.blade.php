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
            <h5 class="text-titulo">Listado de prestamos activos</h5>
            <div class="table-responsive-md">
                <table class="table table-striped table-bordered" style="width:100%" id="tabla">
                    <thead>
                        <tr>
                            <th># reserva</th>
                            <th>Código</th>
                            <th>Titulo</th>
                        @if(Auth::user()->tipo_usuario == 'Administrador')
                            <th>Usuario</th>
                        @endif
                            <th>Prestador</th>
                            <th>Fecha Prestamo</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <!-- @if(!$row->fecha_devolucion) -->
                        <tr>
                            <td class="text-center">{!! $row->reserva->id !!}</td>
                            <td class="text-center">{!!$row->reserva->ejemplar->codigo !!}</td>
                            <td class="text-center">{!!$row->reserva->ejemplar->libro->titulo!!}</td>
                            @if(Auth::user()->tipo_usuario == 'Administrador')
                            <td class="text-center">{!!$row->reserva->usuario->nombres .' '. $row->reserva->usuario->apellidos !!}</td>
                            @endif
                            <td class="text-center">{!!$row->prestador->nombres .' '. $row->prestador->apellidos !!}</td>
                            <td class="text-center">{!! $row->fecha_prestamo !!}</td>
                            <td class="text-center">
                                <a class="" href="{{ route('prestamo.show', ['id' => $row->id]) }}">Detalle</a>
                            </td>
                        </tr>
                        <!-- @endif -->
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection