@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!empty($alerta))
                        <div class="alert alert-danger"> 
                        <h5>Atención:</h5>
                        Los siguientes prestamos superaron la fecha máxima de entrega:
                        </div>
                        @foreach ($alerta as $item)
                        <div class="alert alert-danger">
                            <strong>Titulo: </strong> {!! $item->ejemplar->libro->titulo !!} **
                            <strong>Fecha prestamo: </strong> {!! $item->fecha_prestamo !!} **
                            <strong>Fecha Entrega Max: </strong> {!! $item->fecha_devolucion_max !!} **
                            <strong>Dias de mora: </strong>{!! (strtotime(date("Y-m-d")) - strtotime($item->fecha_devolucion_max))/3600/24 !!}
                        </div>
                        @endforeach
                        <hr>   
                    @else
                        Inicio de sesión exitoso!.
                    @endif
                </div>
    </div>
</div>
@endsection
