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
            <h5 class="text-titulo">Listado de administradores del sistema</h5>
            <div class="form-group">
                <a class="btn btn-success text-light float-md-right" href="{{ route('admin.nuevo') }}">
                    Nuevo registro
                </a>
            </div>
            <div class="table-responsive-md">
                <table class="table table-striped table-bordered" style="width:100%" id="tabla">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Documento</th>
                            <th>Correo</th>
                            <th>Fecha Creación</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $usuario)
                        <tr>
                            <td class="text-center">{!!$usuario->nombres!!}</td>
                            <td class="text-center">{!!$usuario->apellidos!!}</td>
                            <td class="text-center">{!!$usuario->documento!!}</td>
                            <td class="text-center">{!!$usuario->correo!!}</td>
                            <td class="text-center">{!!$usuario->created_at!!}</td>
                            <td class="text-center">
                            <a class="" href="{{ route('admin.edit', ['id' => $usuario->id]) }}">
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