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
            <h5 class="text-titulo">Registro de libros</h5>
             <form method="POST" action="{{ route('prestamo.store') }}">
                @csrf
                <div class="row">
                    <div class="col form-group">
                        <label for="documento">Usuario: </label>
                        <input 
                            class="form-control {{ $errors->has('documento') ? ' is-invalid' : '' }}" 
                            value="{{ old('documento') }}" 
                            id="documento" 
                            name="documento"
                            placeholder="Ingrese el Documento" 
                            list="usuarios"
                            autocomplete="off"
                            required autofocus>
                            <datalist id="usuarios" class="">
                                @foreach ($datos['usuarios'] as $usuario)
                                    <option value="{{ $usuario->documento }}">{{ $usuario->apellidos }} {{ $usuario->nombres }}</option>
                                @endforeach
                            </datalist>
                        @if ($errors->has('documento'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('documento') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="col form-group">
                            <label for="titulo">Titulo: </label>
                            <input 
                            class="form-control {{ $errors->has('codigo') ? ' is-invalid' : '' }}" 
                            value="{{ old('codigo') }}" 
                            id="codigo" 
                            name="codigo"
                            placeholder="Ingrese el codigo" 
                            list="ejemplares"
                            autocomplete="off"
                            required autofocus>
                            <datalist id="ejemplares" class="">
                                @foreach ($datos['ejemplares'] as $ejemplar)
                                    <option value="{{ $ejemplar->codigo }}">{{ $ejemplar->libro->titulo }}</option>
                                @endforeach
                            </datalist>
                            @if ($errors->has('codigo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('codigo') }}</strong>
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