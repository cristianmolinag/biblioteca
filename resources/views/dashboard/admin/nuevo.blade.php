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
            <h5 class="text-titulo">Registro de administradores del sistema</h5>
            <form method="POST" action="{{ route('admin.store') }}">
                @csrf
                <div class="row">
                    <div class="col form-group">
                        <label for="nombres">Nombres: </label>
                        <input type="text" 
                            class="form-control {{ $errors->has('nombres') ? ' is-invalid' : '' }}" 
                            value="{{ old('nombres') }}" 
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
                        value="{{ old('apellidos') }}" 
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
                <div class="row">
                    <div class="col form-group">
                        <label for="documento">Documento: </label>
                        <input type="text" 
                        class="form-control {{ $errors->has('documento') ? ' is-invalid' : '' }}" 
                        value="{{ old('documento') }}" 
                        id="documento"
                        name="documento"
                        placeholder="Ingrese el documento" 
                        required>
                        @if ($errors->has('documento'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('documento') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="col form-group">
                        <label for="correo">Correo: </label>
                        <input type="text" 
                        class="form-control {{ $errors->has('correo') ? ' is-invalid' : '' }}" 
                        value="{{ old('correo') }}" 
                        id="correo" 
                        name="correo"
                        placeholder="Ingrese el correo" 
                        required>
                        @if ($errors->has('correo'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('correo') }}</strong>
                        </span> 
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label for="password">Contraseña: </label>
                        <input type="password" 
                        class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" 
                        value="{{ old('password') }}" 
                        id="password"
                        name="password"
                        placeholder="Ingrese su contraseña" 
                        required>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
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