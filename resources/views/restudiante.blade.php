<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Verifica tu certificado obtenido en BIARI" />
        <meta name="author" content="" />
        <title>Certificados - BIARI</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap Icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- SimpleLightbox plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('dist/css/styles.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="https://biariconsulting.com.pe/">
                    <img src="{{asset('img/logoBiari.png')}}" alt="Logo BIARI" style="width: 40%;">
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{route('login')}}" target="_blank"><i class="bi-person-circle text-primary"></i> Ingresar</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h2 class="mt-0">{{$estudiante->nombre}}</h2>
                        <hr class="divider" />
                        <p class="text-muted mb-5">Los siguientes son tus certificados emitidos.</p>
                    </div>
                </div>
                <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CÓD.</th>
                                    <th>CAPACITACIÓN</th>
                                    <th>FECHA</th>
                                    <th>VER</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($certificados as $certificado)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$certificado->capacitacion->id.'-'.$certificado->estudiante->id}}</td>
                                        <td>{{$certificado->capacitacion->nombre}}</td>
                                        <td>{{date('d/m/Y', strtotime($certificado->capacitacion->desde)).' '.(!is_null($certificado->capacitacion->hasta) ? date('d/m/Y', strtotime($certificado->capacitacion->hasta)) : "")}}</td>
                                        <td><a href="{{route('rcertificado', $certificado->id)}}" target="_blank" title="Ver certificado"><i class="bi-card-heading text-primary"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div >
                            {{$certificados->links()}}
                        </div>
                        <div class="text-center">
                            <a href="/" class="btn btn-secondary mt-3 text-center" title="Ir a inicio"><i class="bi-house-door"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Footer-->
        <footer class="bg-light py-2">
            <div class="container px-4 px-lg-5"><div class="small text-center text-muted">Copyright &copy;  {{date('Y')}}  - BIARI CONSULTING</div></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SimpleLightbox plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{asset('dist/js/scripts.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
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
    </body>
</html>
