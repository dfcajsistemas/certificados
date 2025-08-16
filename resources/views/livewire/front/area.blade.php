<div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mt-7 mt-lg-0">
                <div class="row align-items-end mb-4">
                    <div class="col-lg-7 mb-5">
                        <h6 class="text-secondary font-weight-semi-bold text-uppercase mb-3">Área</h6>
                        <h1 class="section-title mb-3">{{$area->nombre}}</h1>
                        <ul>
                        @foreach ($area->funcions as $funcion)
                            <li>{{$funcion->descripcion}}</li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <ul>
                            <li><small>Sig.: </small>{{$area->siglas}}</li>
                            @if($area->responsable)
                            <li><small>Resp.: </small>{{$area->responsable}}</li>
                            @endif
                            <li>{{$area->correo}}</li>
                            @if($area->telefono)
                            <li>{{$area->telefono}}</li>
                            @endif
                            <li>{{$area->ubicacion}}</li>
                        </ul>
                        @if ($area->plano)
                        <a class="btn btn-sm btn-secondary m-1" href="{{asset('storage/'.$area->plano)}}" data-lightbox="portfolio">
                            <i class="fa fa-map"></i>
                        </a>
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <h3 class="my-4 section-title">Procedimientos</h3>
                        <div class="w-100 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" wire:model.defer="buscar" wire:keydown.enter='render' style="padding: 25px;" placeholder="Buscar">
                                <div class="input-group-append">
                                    <button class="btn btn-primary px-4" wire:click='render()'>Buscar</button>
                                </div>
                            </div>
                        </div>
                        @if($procedimientos->count()>0)
                        <ul class="list-inline m-0">
                            @foreach ($procedimientos as $procedimiento)
                            <li class="mb-1 py-2 px-3 bg-light d-flex justify-content-between align-items-center">
                                <a class="text-dark" href="{{route('procedimiento', $procedimiento->id)}}"><i class="fa fa-angle-right text-secondary mr-2"></i>{{$procedimiento->nombre}}</a>
                                <span class="badge badge-primary badge-pill">{{$procedimiento->pasos->count()}} Pas.</span>
                            </li>
                            @endforeach
                        </ul>
                        {{$procedimientos->links()}}
                        @else
                        <div class="alert alert-warning" role="alert">
                            No se encontraron resultados para la búsqueda: {{$buscar}}
                        </div>
                        @endif
                        <a href="{{route('sede', $area->sede->id)}}" class="btn btn-primary my-3">Regresar</a>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 mt-5 mt-lg-0">
                <div id="header-carousel" class="carousel slide carousel-fade mt-5" data-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            $i=0;
                        @endphp
                        @foreach ($sliders as $slider)
                        <div class="carousel-item {{$i==0 ? 'active' : ''}}">
                            <img class="img-fluid" src="{{asset('storage/'.$slider->imagen)}}" alt="{{$slider->titulo}}">
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
</div>
