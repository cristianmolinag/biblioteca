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
        <h5 class="text-titulo">Perfil de {{ $data->nombres }} {{ $data->apellidos }}</h5>
            <form method="POST" action="{{ route('usuario.update', ['id' => $data->id]) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col form-group">
                        <label for="nombres">Nombres: </label>
                    <p class="text-muted">{{ $data->nombres }}</p>
                    </div>
                    <div class="col form-group">
                        <label for="apellidos">Apellidos: </label>
                    <p class="text-muted">{{ $data->apellidos }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="documento">Documento: </label>
                    <p class="text-muted">{{ $data->documento }}</p>
                    </div>
                    <div class="col form-group">
                        <label for="correo">Correo: </label>
                    <p class="text-muted">{{ $data->correo }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label for="password">Contraseña: </label>
                        <input type="password" 
                        class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" 
                        id="password"
                        name="password"
                        placeholder="Ingrese su contraseña nueva">
                    </div>
                </div>
                <button type="submit" class="btn main-color text-light btn-block">Actualizar</button>
            </form>
            
        </div>
    </div>
    
</div>
@endsection