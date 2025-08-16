<div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mt-7 mt-lg-0">
                <div class="row align-items-end mb-4">
                    <div class="col-lg-12 mb-3">
                        <h6 class="text-secondary font-weight-semi-bold text-uppercase mb-3">Procedimiento</h6>
                        <h1 class="section-title">{{$procedimiento->nombre}}</h1>
                    </div>
                    <div class="col-lg-12">
                        <h3 class="mb-4 section-title">Pasos</h3>
                        @if($pasos->count()>0)
                        <ul class="list-inline m-0">
                            @foreach ($pasos as $paso)
                            <li class="mb-1 py-2 px-3 bg-light d-flex justify-content-between align-items-center">
                                <span class="text-dark"><i class="fa fa-angle-right text-secondary mr-2"></i>{{$paso->descripcion}}</span>
                                @if($paso->formato)
                                <button type="button" id="bformato" class="text-secondary" style="border:none;"  data-toggle="modal"
                                    data-src="{{asset('storage/'.$paso->formato)}}" data-target="#formatoModal">
                                    <i class="fa fa-file-pdf"></i> Formato
                                </button>
                                @endif
                            </li>
                                @if ($paso->requisitos->count()>0)
                                <ul>
                                    @foreach ($paso->requisitos as $requisito)
                                    <li>{{$requisito->descripcion}}</li>
                                    @endforeach
                                </ul>
                                @endif
                            @endforeach
                        </ul>
                        @else
                        <div class="alert alert-warning" role="alert">
                            Aún no se han registrado pasos para el procedimiento.
                        </div>
                        @endif
                        <a href="{{route('area', $procedimiento->area->id)}}" class="btn btn-primary my-3">Regresar</a>
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

    <!-- Video Modal Start -->
    <div class="modal fade" id="formatoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="" id="formato"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Modal End -->
    @push('scripts')
    <script>
    $(document).ready(function () {
        var $formatoSrc;
        $('#bformato').click(function () {
            $formatoSrc = $(this).data("src");
        });
        console.log($formatoSrc);

        $('#formatoModal').on('shown.bs.modal', function (e) {
            $("#formato").attr('src', $formatoSrc);
        })

        $('#formatoModal').on('hide.bs.modal', function (e) {
            $("#formato").attr('src', $formatoSrc);
        })
    });
    </script>
    @endpush
</div>
