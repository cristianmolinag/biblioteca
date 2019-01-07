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
            <h5 class="text-titulo">Listado de autores</h5>
            <div class="form-group">
                <a class="btn btn-success text-light float-md-right" href="{{ route('autor.nuevo') }}">
                    Nuevo registro
                </a>
            </div>
            <div class="table-responsive-md">
                <table class="table table-striped table-bordered" style="width:100%" id="tabla">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Fecha Creación</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td class="text-center">{!!$row->nombres!!}</td>
                            <td class="text-center">{!!$row->apellidos!!}</td>
                            <td class="text-center">{!!$row->created_at!!}</td>
                            <td class="text-center">
                            <a class="" href="{{ route('autor.edit', ['id' => $row->id]) }}">
                            Editar
                        </button>
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