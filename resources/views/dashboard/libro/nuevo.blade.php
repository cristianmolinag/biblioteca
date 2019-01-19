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
            <h5 class="text-titulo">Registro de libros</h5>
            <form method="POST" action="{{ route('libro.store') }}">
                @csrf
                <div class="row">
                    <div class="col form-group">
                        <label for="isbn">ISBN: </label>
                        <input type="number" 
                            class="form-control {{ $errors->has('isbn') ? ' is-invalid' : '' }}" 
                            value="{{ old('isbn') }}" 
                            id="isbn" 
                            name="isbn"
                            placeholder="Ingrese el ISBN" 
                            required autofocus>
                        @if ($errors->has('isbn'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('isbn') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="col form-group">
                            <label for="titulo">Titulo: </label>
                            <input type="text" 
                                class="form-control {{ $errors->has('titulo') ? ' is-invalid' : '' }}" 
                                value="{{ old('titulo') }}" 
                                id="titulo" 
                                name="titulo"
                                placeholder="Ingrese el titulo" 
                                required autofocus>
                            @if ($errors->has('titulo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('titulo') }}</strong>
                            </span> 
                            @endif
                        </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="anio">Año: </label>
                        <input type="text" 
                            class="form-control {{ $errors->has('anio') ? ' is-invalid' : '' }}" 
                            value="{{ old('anio') }}" 
                            id="anio" 
                            name="anio"
                            maxlength="4"
                            pattern="\d*"
                            placeholder="Ingrese el año" 
                            required autofocus>
                        @if ($errors->has('anio'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('anio') }}</strong>
                        </span> 
                        @endif
                    </div>
                        <div class="col form-group">
                        <label for="numero_paginas">Número de páginas: </label>
                        <input type="text" 
                            class="form-control {{ $errors->has('numero_paginas') ? ' is-invalid' : '' }}" 
                            value="{{ old('numero_paginas') }}" 
                            id="numero_paginas" 
                            name="numero_paginas"
                            maxlength="4"
                            pattern="\d*"
                            placeholder="Ingrese el número de páginas" 
                            required autofocus>
                        @if ($errors->has('numero_paginas'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('numero_paginas') }}</strong>
                        </span> 
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="autor_id">Autor: </label>
                        <input 
                            class="form-control {{ $errors->has('autor_id') ? ' is-invalid' : '' }}" 
                            value="{{ old('autor_id') }}" 
                            id="autor_id"
                            name="autor_id"
                            placeholder="Ingrese el autor" 
                            list="autores"
                            autocomplete="off"
                            required autofocus>
                            <datalist id="autores" class="">
                                @foreach ($datos['autores'] as $autor)
                                    <option value="{{ $autor->autor_id }}">{{ $autor->apellidos }} {{ $autor->nombres }}</option>
                                @endforeach
                            </datalist>
                        @if ($errors->has('autor_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('autor_id') }}</strong>
                        </span> 
                        @endif
                    </div>
                        <div class="col form-group">
                        <label for="editorial_id">Editorial: </label>
                        <input 
                        class="form-control {{ $errors->has('editorial_id') ? ' is-invalid' : '' }}" 
                        value="{{ old('editorial_id') }}" 
                        id="editorial_id"
                        name="editorial_id"
                        placeholder="Ingrese la editorial" 
                        list="editoriales"
                        autocomplete="off"
                        required autofocus>
                        <datalist id="editoriales" class="">
                            @foreach ($datos['editoriales'] as $editorial)
                                <option value="{{ $editorial->editorial_id }}">{{ $editorial->nombre }}</option>
                            @endforeach
                        </datalist>
                        @if ($errors->has('editorial_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('editorial_id') }}</strong>
                        </span> 
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="categoria_id">Categoría: </label>
                        <input 
                        class="form-control {{ $errors->has('categoria_id') ? ' is-invalid' : '' }}" 
                        value="{{ old('categoria_id') }}" 
                        id="categoria_id"
                        name="categoria_id"
                        placeholder="Ingrese la categoría" 
                        list="categorias"
                        autocomplete="off"
                        required autofocus>
                        <datalist id="categorias" class="">
                            @foreach ($datos['categorias'] as $categoria)
                                <option value="{{ $categoria->categoria_id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </datalist>
                        @if ($errors->has('categoria_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('categoria_id') }}</strong>
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