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
            <h5 class="text-titulo">Historial de prestamos</h5>
            {{-- <div class="form-group">
                <a class="btn btn-success text-light float-md-right" href="{{ route('prestamo.nuevo') }}">
                    Nuevo prestamo
                </a>
            </div> --}}
            <div class="table-responsive-md">
                <table class="table table-striped table-bordered" style="width:100%" id="tabla">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Titulo</th>
                            <th>Usuario</th>
                            <th>Prestador</th>
                            <th>Fecha Prestamo</th>
                            <th>Fecha Dev Max</th>
                            <th>Fecha Dev</th>
                            {{-- <th>Devolver</th> --}}
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td class="text-center">{!!$row->ejemplar->codigo!!}</td>
                            <td class="text-center">{!!$row->ejemplar->libro->titulo!!}</td>
                            <td class="text-center">{!!$row->usuario->nombres .' '. $row->usuario->apellidos !!}</td>
                            <td class="text-center">{!!$row->prestador->nombres .' '. $row->prestador->apellidos !!}</td>
                            <td class="text-center">{!!$row->fecha_prestamo!!}</td>
                            <td class="text-center">
                                @if (strtotime(date("Y-m-d H:i:s")) < strtotime($row->fecha_devolucion_max))
                                <p class="text-muted">{!! $row->fecha_devolucion_max !!}</p>
                                @else
                                <p class="text-danger">{!! $row->fecha_devolucion_max !!}</p>
                                @endif
                            </td>
                            <td class="text-center">{!!$row->fecha_devolucion!!}</td>
                            <td class="text-center">
                                @if(Auth::user()->tipo_usuario == 'Administrador')
                                <a class="" href="{{ route('prestamo.show', ['id' => $row->id]) }}">Detalle</a>
                                @else
                                <a class="" href="{{ route('prestamo.detalle', ['id' => $row->id]) }}">Detalle</a>
                                @endif 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection