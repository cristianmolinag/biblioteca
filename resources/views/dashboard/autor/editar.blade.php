@extends('layouts.app') 
@section('content')
<div class="row form-group">
        <a href="{{ URL::previous() }}" class="btn main-color text-light"><span data-feather="arrow-left"></span></a>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5 class="text-titulo">Edición del autor {{ $data->nombres }}</h5>
            <form method="POST" action="{{ route('autor.update', ['id' => $data->id]) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col form-group">
                        <label for="nombres">Nombres: </label>
                        <input type="text" 
                            class="form-control {{ $errors->has('nombres') ? ' is-invalid' : '' }}" 
                            value="{{ old('nombres', $data->nombres) }}" 
                            id="nombres" 
                            name="nombres"
                            placeholder="Ingrese los nombres" 
                            required autofocus>
                        @if ($errors->has('nombres'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('nombres') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="col form-group">
                        <label for="apellidos">Apellidos: </label>
                        <input type="text" 
                        class="form-control {{ $errors->has('apellidos') ? ' is-invalid' : '' }}" 
                        value="{{ old('apellidos', $data->apellidos) }}" 
                        id="apellidos" 
                        name="apellidos"
                        placeholder="Ingrese los apellidos" 
                        required>
                        @if ($errors->has('apellidos'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('apellidos') }}</strong>
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