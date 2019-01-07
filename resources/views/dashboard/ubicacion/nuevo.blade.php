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
            <h5 class="text-titulo">Registro de ubicaciones</h5>
            <form method="POST" action="{{ route('ubicacion.store') }}">
                @csrf
                <div class="row">
                    <div class="col form-group">
                        <label for="nombre">Nombre: </label>
                        <input type="text" 
                            class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" 
                            value="{{ old('nombre') }}" 
                            id="nombre" 
                            name="nombre"
                            placeholder="Ingrese el nombe" 
                            required autofocus>
                        @if ($errors->has('nombre'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('nombre') }}</strong>
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