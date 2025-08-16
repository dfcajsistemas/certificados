<div>
    @if ($sliders->count()>0)
    <!-- Carousel Start -->
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-sm-4">
                    <img src="{{asset('img/procedimientos.png')}}" alt="Procedimientos simples" class="img-fluid">
                </div>
                <div class="col-sm-8">
                    <div id="header-carousel" class="carousel slide carousel-fade" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @php
                                $p=0;
                            @endphp
                            @foreach ($sliders as $slider)
                                <li data-target="#header-carousel" data-slide-to="{{$p}}" class="{{$p==0 ? 'active': ""}}"></li>
                                @php
                                    $p++;
                                @endphp
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @php
                                $i=0;
                            @endphp
                            @foreach ($sliders as $slider)
                            <div class="carousel-item {{$i==0 ? 'active' : ''}}">
                                <img class="img-fluid" style="object-fit: cover;" src="storage/{{$slider->imagen}}" alt="{{$slider->titulo}}">
                            </div>
                            @php
                                $i++;
                            @endphp
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
    </div>
    <!-- Carousel End -->
    @endif

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h6 class="text-secondary font-weight-semi-bold text-uppercase mb-3">Nuestras sedes</h6>
                    <h1 class="mb-4 section-title">Sedes policiales</h1>
                    <p>Elija una sede y navegue entre sus dependencias policiales, conozca su funciones, sus procedimientos, pasos y requisitos de cada servicio.</p>
                </div>
                <div class="col-lg-6 pt-5 pt-lg-0">
                    <div class="owl-carousel service-carousel position-relative">
                        @foreach ($sedes as $sede)
                        <div class="d-flex flex-column align-items-center text-center bg-light rounded overflow-hidden pt-4">
                            <div class="icon-box bg-light text-secondary shadow mt-2 mb-4">
                                <i class="fa fa-2x fa-building"></i>
                            </div>
                            <h5 class="font-weight-bold mb-2 px-4">{{$sede->nombre}}</h5>
                            <smal>{{$sede->direccion}}</smal>
                            <a href="{{route('sede', $sede->id)}}" class="btn btn-primary my-3 py-2 px-4">Ir</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
