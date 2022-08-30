<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Lesly Sol">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Órdenes') }}</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <!-- Fonts -->
        <!--<link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
        <link href="{{ asset('css/sticky-footer.css') }}" rel="stylesheet">
        <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <script src="{{asset('js/bootbox/bootbox.min.js')}}"></script>
    </head>
    <body>
        <div class="wrapper" id="app">
            <!-- Sidebar -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <b>Órdenes</b>
                </div>
                <ul class="list-unstyled components">
                    <li><a href="{{url('/ordenes')}}"><i class="fas fa-list"></i>Listado de órdenes</a></li>
                    <li><a href="{{url('/nueva-orden')}}"><i class="fas fa-file"></i>Nueva orden</a></li>
                    <li><a href="{{url('/usuarios')}}"><i class="fas fa-user"></i>Usuarios</a></li>
                </ul>
            </nav>
            <div id="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn active">
                            <i class="fas fa-align-justify"></i>
                        </button>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="oi oi-person" title="person" aria-hidden="true"></span>{{Auth::user()->name}}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdown01">
                                    <a class="dropdown-item" href="{{url('/logout')}}">Cerrar Sesión</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                @yield('content')
            </div><!--page content-->
        </div><!--wrapper-->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-11">
                        <span>Órdenes.</span>
                    </div>
                    <div class="col-md-1">
                        <span class="mb-3 text-muted text-center">&copy; <?php echo date('Y') ?></span>
                    </div>
                </div>
            </div>
        </footer>
        <script>
            $(document).ready(function(){
                $('#sidebarCollapse').on('click',function(){
                    $('#sidebar').toggleClass('active');
                });
            });
        </script>
    </body>
</html>
