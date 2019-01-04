<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Biblioteca UDC</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simple-sidebar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ 'https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css' }}">



</head>
<body class="second-color">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel main-color">
            <div class="container">
                <a class="navbar-brand text-light" href="{{ url('/') }}">
                    <img src="/imagenes/udc-logo.png" alt="Logo UDC" width="110px">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @if(Auth::user()->tipo_usuario == 'Administrador')
                                <li class="nav-item active">
                                    <a class="nav-link text-light" href="{{ route('admin') }}">Panel de control</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="#">Prestar libro</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="#">Historial</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="#">Pendientes</a>
                                </li>
                            @else
                                 <li class="nav-item">
                                    <a class="nav-link text-light" href="#">Mis prestamos</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link text-light" href="#">Consultar libros</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest

                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nombres }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('https://code.jquery.com/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js') }}"></script>
     <!-- Menu Toggle Script -->
    <script >
        $("#wrapper").toggleClass("toggled");
    </script>
</body>
</html>
