@extends('layouts.app') 
@section('content')
<div class="row form-group">
        <a href="{{ URL::previous() }}" class="btn main-color text-light"><span data-feather="arrow-left"></span></a>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5 class="text-titulo">Edición del ejemplar {{ $datos['ejemplar']->codigo }}</h5>
            <form method="POST" action="{{ route('ejemplar.update', ['id' => $datos['ejemplar']->id]) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col form-group">
                        <label for="codigo">Código: </label>
                        <input type="number" 
                            class="form-control {{ $errors->has('codigo') ? ' is-invalid' : '' }}" 
                            value="{{ old('codigo', $datos['ejemplar']->codigo) }}" 
                            id="codigo" 
                            name="codigo"
                            placeholder="Ingrese el codigo" 
                            required autofocus>
                        @if ($errors->has('codigo'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('codigo') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="col form-group">
                        <label for="ubicacion_id">Ubicacion: </label>
                        <input 
                        class="form-control {{ $errors->has('ubicacion_id') ? ' is-invalid' : '' }}" 
                        value="{{ old('ubicacion_id', $datos['ejemplar']->ubicacion_id) }}" 
                        id="ubicacion_id"
                        name="ubicacion_id"
                        placeholder="Ingrese la ubicacion" 
                        list="ubicaciones"
                        autocomplete="off"
                        required autofocus>
                        <datalist id="ubicaciones" class="">
                            @foreach ($datos['ubicaciones'] as $row)
                                <option value="{{ $row->ubicacion_id }}">{{ $row->nombre }}</option>
                            @endforeach
                        </datalist>
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
                        {{-- {!! Form::select('libro_id', $datos['libros'], old('libro_id', $datos['ejemplar']->libro_id), 
                            ['placeholder' => 'Seleccione una opción', 'class' => 'form-control '. ($errors->has('libro_id') ? ' is-invalid' : '') ]) 
                        !!} --}}
                        <input 
                        class="form-control {{ $errors->has('libro_id') ? ' is-invalid' : '' }}" 
                        value="{{ old('libro_id', $datos['ejemplar']->libro_id) }}" 
                        id="libro_id"
                        name="libro_id"
                        placeholder="Ingrese el libro" 
                        list="libros"
                        autocomplete="off"
                        required autofocus>
                        <datalist id="libros" class="">
                            @foreach ($datos['libros'] as $row)
                                <option value="{{ $row->libro_id }}">{{ $row->titulo }}</option>
                            @endforeach
                        </datalist>
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