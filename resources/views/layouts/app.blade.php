<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Biblioteca UDC</title>
	<link rel="shortcut icon" href="http://www.universitariadecolombia.edu.co//assets/images/favicon-81x81.png" type="image/x-icon">
	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ 'https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css' }}">
	<link rel="stylesheet" href="{{ 'https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css' }}">

</head>
	<body class="" style="background: linear-gradient(rgba(255,255,255,.2), rgba(255,255,255,.2)), url('/imagenes/sede1-biblioteca.jpg');">
	<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow main-color">
		<a class="navbar-brand text-center col-sm-3 col-md-2 mr-0" href="{{ route('home') }}"> <img src="/imagenes/udc-logo.png" alt="Logo UDC" width="90px"></a>		
		@guest 
		@else 
		@auth 
		@if(Auth::user()->tipo_usuario == 'Administrador')
			<a class="nw-100 text-light" href="{{ route('prestamo') }}">
				Prestar libro
			</a>
			<a class="nw-100 text-light" href="{{ route('prestamo.historial') }}">
				Historial
			</a>
		@else
			<a class="nw-100 text-light" href="{{ route('prestamo.activos') }}">
				Prestamos activos
			</a>
			<a class="nw-100 text-light" href="{{ route('prestamo.porUsuario') }}">
				Mis prestamos
			</a>
			@endif 
			<a class="nw-100 text-light" href="{{ route('usuario.perfil') }}">
				Perfil
			</a>
		@endauth
		<ul class="navbar-nav px-3">
			<li class="nav-item text-nowrap">
				<span class="navbar-text text-light">
                                Hola {{ Auth::user()->nombres }} <span class="caret"></span> |
				<a class="dnav-link text-light" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
				</span>
			</li>

			@endguest
		</ul>
	</nav>
	@guest
	<main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
		<br>
		<br>
		<br> @yield('content')
	</main>
	@else 
	@auth 
	@if(Auth::user()->tipo_usuario == 'Administrador')
	<div class="container-fluid">
		<div class="row">
			<nav class="col-md-2 d-none d-md-block sidebar third-color">
				<div class="sidebar-sticky">
					<ul class="nav flex-column">

						<li class="nav-item">
							<a class="nav-link {{ request()->is('home') ? 'active text-light' : '' }}" href="{{ route('home') }}">
								<span data-feather="home"></span>
								Inicio 
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin') || request()->is('admin/nuevo') || request()->is('admin/edit/*') ? 'active text-light' : '' }}"
							 	href="{{ route('admin.index')}} ">
								<span data-feather="file"></span>
								Administradores
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('docente') || request()->is('docente/nuevo') || request()->is('docente/edit/*') ? 'active text-light' : '' }}"
								href="{{ route('docente.index')}} ">
								<span data-feather="file"></span>
								Docentes
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('alumno') || request()->is('alumno/nuevo') || request()->is('alumno/edit/*') ? 'active text-light' : '' }}"
								href="{{ route('alumno.index')}} ">
								<span data-feather="file"></span>
								Alumnos
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('autor') || request()->is('autor/nuevo') || request()->is('autor/edit/*') ? 'active text-light' : '' }}"
								href="{{ route('autor.index')}} ">
								<span data-feather="file"></span>
								Autores
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('editorial') || request()->is('editorial/nuevo') || request()->is('editorial/edit/*') ? 'active text-light' : '' }}"
								href="{{ route('editorial.index')}} ">
								<span data-feather="file"></span>
								Editoriales
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('categoria') || request()->is('categoria/nuevo') || request()->is('categoria/edit/*') ? 'active text-light' : '' }}"
								href="{{ route('categoria.index')}} ">
								<span data-feather="file"></span>
								Categorias
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('libro') || request()->is('libro/nuevo') || request()->is('libro/edit/*') ? 'active text-light' : '' }}"
								href="{{ route('libro.index')}} ">
								<span data-feather="file"></span>
								Libros
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('ubicacion') || request()->is('ubicacion/nuevo') || request()->is('ubicacion/edit/*') ? 'active text-light' : '' }}"
								href="{{ route('ubicacion.index')}} ">
								<span data-feather="file"></span>
								Ubicaciones
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('ejemplar') || request()->is('ejemplar/nuevo') || request()->is('ejemplar/edit/*') ? 'active text-light' : '' }}"
								href="{{ route('ejemplar.index')}} ">
								<span data-feather="file"></span>
								Ejemplares
							</a>
						</li>
					</ul>
				</div>
			</nav>
		</div>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<br>
			<br> 
			<div class="card">
				<br>
				<div style="margin-top:20px; margin-bottom:20px;">
				@yield('content')
				</div>
				<br>
			</div>
		</main>
		@else
		<main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
			<br>
			<br>
			<br>
			<div class="card">
				<br>
				@yield('content')
				<br>
			</div>
		</main>
		@endif 
		@endauth 
		@endguest

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>

		<!-- Icons -->
		<script src="{{ asset('https://unpkg.com/feather-icons/dist/feather.min.js') }}"></script>

		<script>
			$(document).ready( function () {
        $('#tabla').DataTable({
					dom: 'Bfrtip',
					buttons: [
            'copyHtml5',
            'excelHtml5'
        ],
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }
        });
    } );
		</script>
		<script>
			feather.replace();
		</script>
</body>

</html>