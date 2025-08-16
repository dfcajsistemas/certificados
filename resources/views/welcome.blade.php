<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <!--<link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">-->
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset("plugins/fontawesome-free/css/all.min.css")}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("dist/css/adminlte.min.css")}}">

    <style>
        .hero {
 height: 400px;
 background-color: #ccc;
 }

 .row {
  border: 1px solid #999;
  }
    </style>
</head>
    <body class="hold-transition lockscreen">

        <!-- Automatic element centering -->
        <div class="lockscreen-wrapper">
            <div class="lockscreen-logo">
                <a href="/" style="color: red;"><b>Control</b>Documentario</a>
            </div>
            <!-- User name -->
            <div class="lockscreen-name text-xl" style="color: #162C4F;">ControlDoc</div>

            <!-- /.lockscreen-item -->
            <div class="help-block text-center text-lg text-primary">
            {{-- Distrito Fiscal de Cajamarca --}}
            </div>
            <div class="text-center">
                @if (Route::has('login'))
                <div class="my-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-success"><i class="fa-solid fa-person-walking"></i> Administrar</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary"><i class="fa-solid fa-right-to-bracket"></i> Iniciar sesión</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-primary"><i class="fa-solid fa-user-pen"></i> Registro</a>
                        @endif
                    @endif
                </div>
                @endif
            </div>

        </div>
        <!-- /.center -->

    <!-- jQuery -->
    <script src="{{asset("plugins/jquery/jquery.min.js")}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset("plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset("dist/js/adminlte.min.js")}}"></script>

    </body>
</html>
