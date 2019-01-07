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
            <h5 class="text-titulo">Registro de ejemplares</h5>
            <form method="POST" action="{{ route('ejemplar.store') }}">
                @csrf
                <div class="row">
                    <div class="col form-group">
                        <label for="codigo">Código: </label>
                        <input type="text" 
                            class="form-control {{ $errors->has('codigo') ? ' is-invalid' : '' }}" 
                            value="{{ old('codigo') }}" 
                            id="codigo" 
                            name="codigo"
                            placeholder="Ingrese el código" 
                            maxlength="13"
                            required autofocus>
                        @if ($errors->has('codigo'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('codigo') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="col form-group">
                        <label for="ubicacion_id">Ubicacion: </label>
                        {!! Form::select('ubicacion_id', $datos['ubicaciones'], old('ubicacion_id'), 
                            ['placeholder' => 'Seleccione una opción', 'class' => 'form-control '. ($errors->has('ubicacion_id') ? ' is-invalid' : '') ]) 
                        !!}
                        @if ($errors->has('ubicacion_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('ubicacion_id') }}</strong>
                        </span> 
                        @endif
                </div>
            </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="libro_id">Libro: </label>
                        {!! Form::select('libro_id', $datos['libros'], old('libro_id'), 
                            ['placeholder' => 'Seleccione una opción', 'class' => 'form-control '. ($errors->has('libro_id') ? ' is-invalid' : '') ]) 
                        !!}
                        @if ($errors->has('libro_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('libro_id') }}</strong>
                        </span> 
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn main-color text-light btn-block">Guardar</button>
            </form>
            
        </div>
    </div>
    
</div>
<br>
@endsection