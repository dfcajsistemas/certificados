<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} | {{$page}}</title>

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{asset("plugins/fontawesome-free/css/all.min.css")}}">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{asset("plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css")}}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{asset("plugins/toastr/toastr.min.css")}}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{asset("plugins/select2/css/select2.min.css")}}">
        <link rel="stylesheet" href="{{asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset("dist/css/adminlte.min.css")}}">

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="hold-transition sidebar-mini sidebar-collapse text-xs">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Pantalla completa">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('contrasena')}}" role="button" title="Cambiar contraseña">
                            <i class="fa-solid fa-key"></i>
                        </a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" role="button" title="Salir" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                        <form method="POST" id="logout-form" action="{{ route('logout') }}">
                            @csrf
                        </form>
                    </li>
                    @endauth
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar elevation-4 sidebar-light-primary">
                <!-- Brand Logo -->
                <a href="{{ route('dashboard') }}" class="brand-link bg-navy">
                    <img src="{{ asset('dist/img/logo.png') }}" alt="ControlDoc Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text font-weight-light">ControlDoc</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        @auth
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <div class="image">
                                    <img class="img-circle elevation-2" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                                </div>
                            @endif
                                <div class="info mt-1">
                                    <a href="#" class="d-block font-weight-bold text-primary">{{ Auth::user()->name }}</a>
                                </div>
                        @endauth
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link {{request()->routeIs('dashboard') ? "active" : ""}}">
                                  <i class="nav-icon fa-solid fa-gauge-high"></i>
                                  <p>
                                    Dashboard
                                  </p>
                                </a>
                            </li>
                        </ul>
                        @if (Auth::user()->rol)
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('accesos') }}" class="nav-link {{request()->routeIs('accesos') ? "active" : ""}}">
                                  <i class="nav-icon fa-solid fa-user-lock"></i>
                                  <p>
                                    Accesos
                                  </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('disciplinas') }}" class="nav-link {{request()->routeIs('disciplinas') ? "active" : ""}}">
                                  <i class="nav-icon fa-solid fa-tag"></i>
                                  <p>
                                    Disciplinas
                                  </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('proyectos') }}" class="nav-link {{request()->routeIs('proyectos') ? "active" : ""}}">
                                  <i class="nav-icon fa-solid fa-person-digging"></i>
                                  <p>
                                    Proyectos
                                  </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('empresas') }}" class="nav-link {{request()->routeIs('empresas') ? "active" : ""}}">
                                  <i class="nav-icon fa-solid fa-building"></i>
                                  <p>
                                    Empresas
                                  </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('documentos') }}" class="nav-link {{request()->routeIs('documentos') ? "active" : ""}}">
                                  <i class="nav-icon fa-solid fa-file-lines"></i>
                                  <p>
                                    Documentos
                                  </p>
                                </a>
                            </li>
                        </ul>
                        @endif
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('revisiones') }}" class="nav-link {{request()->routeIs('revisiones') ? "active" : ""}}">
                                  <i class="nav-icon fa-solid fa-file-circle-check"></i>
                                  <p>
                                    Revisiones
                                  </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('consultas') }}" class="nav-link {{request()->routeIs('consultas') ? "active" : ""}}">
                                  <i class="nav-icon fa-solid fa-magnifying-glass"></i>
                                  <p>
                                    Consultas
                                  </p>
                                </a>
                            </li>
                        </ul>

                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid pt-2">
                            {{ $slot }}
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    {{date("Y")}}
                </div>
                <!-- Default to the left -->
                <strong>GIO</strong> ControlDocumentario
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->
        <script src="{{asset("plugins/jquery/jquery-a.min.js")}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset("plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
        <!-- SweetAlert2 -->
        <script src="{{asset("plugins/sweetalert2/sweetalert2.min.js")}}"></script>
        <!-- Toastr -->
        <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
        <!-- Select2 -->
        <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset("dist/js/adminlte.min.js")}}"></script>

        @livewireScripts
        <script>
            function noti(msg, tipo='success'){
                toastr.options.progressBar = true;
                toastr[tipo](msg)
            }
            @if (session('error'))
                noti('{{session('error')}}', 'error');
            @endif
            @if (session('success'))
                noti('{{session('success')}}');
            @endif
        </script>
        @stack('scripts')

    </body>
</html>
