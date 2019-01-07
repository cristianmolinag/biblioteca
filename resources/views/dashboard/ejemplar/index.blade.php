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
            <h5 class="text-titulo">Listado de Ejemplares</h5>
            <div class="form-group">
                <a class="btn btn-success text-light float-md-right" href="{{ route('ejemplar.nuevo') }}">
                    Nuevo registro
                </a>
            </div>
            <div class="table-responsive-md">
                <table class="table table-striped table-bordered" style="width:100%" id="tabla">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Titulo</th>
                            <th>Ubicacion</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td>{!!$row->codigo!!}</td>
                            <td>{!!$row->libro->titulo!!}</td>
                            <td>{!!$row->ubicacion->nombre!!}</td>
                            <td class="text-center">
                            <a class="" href="{{ route('ejemplar.edit', ['id' => $row->id]) }}">
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
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-titulo">Cargar archivo plano</h5>
        </div>
    </div>
    <form method="POST" action="{{ route('ejemplar.file') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf
            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-file float-md-right">
                        <input type="file" class="custom-file-input" accept=".csv" name="file" required>
                        <label class="custom-file-label">Seleccione un archivo...</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <button class="btn btn-info text-light float-md-left" type="submit">
                        Cargar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection