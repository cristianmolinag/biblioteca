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
            @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
            @endif
            <h5 class="text-titulo">Nueva reserva</h5>
            <div class="table-responsive-md">
                <table class="table table-striped table-bordered" style="width:100%" id="tabla">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Titulo</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Editorial</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td class="text-center">{!! $row->codigo !!}</td>
                            <td class="text-center">{!! $row->libro->titulo !!}</td>
                            <td class="text-center">{!! $row->libro->autor->nombres .' '. $row->libro->autor->apellidos !!}</td>
                            <td class="text-center">{!! $row->libro->categoria->nombre !!}</td>
                            <td class="text-center">{!! $row->libro->editorial->nombre !!}</td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('reserva.store', ['id' => $row->id]) }}">
                                @csrf
                                    <button type="submit" class="btn btn-link">Solicitar reserva</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    
</div>
<br>
@endsection

