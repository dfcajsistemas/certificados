<div class="row">
    <div class="col-md-12 m-2">
        <h6><i class="fa-solid fa-check-to-slot text-orange"></i> {{$eleccion->nombre}}</h6>
    </div>
    <div class="col-md-5">
        <div class="card card-outline card-navy">
            <div class="card-header">
                <h4 class="card-title text-muted"><i class="fa-solid fa-square-poll-vertical"></i> Resultados</h4>
                <div class="card-tools">
                    <button class="btn btn-sm btn-tool" wire:click='render()'>
                        <i class="fa-solid fa-arrows-rotate text-warning"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-info mt-2" role="status" wire:loading wire:target='render'>
                      <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <table class="table table-hover table-valign-middle">
                    <thead>
                        <tr>
                            <th>Candidato</th>
                            <th>Votos</th>
                            <th>Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $tv=DB::table('votos')->where('eleccione_id', $eleccion->id)->count();
                        @endphp
                        @foreach ($eleccion->listas as $lista)
                            @php
                                $v=DB::table('votos')->where('lista_id', $lista->id)->count();
                                if($v>0){
                                    $p=round(($v/$tv)*100, 2);
                                }else{
                                    $p=0;
                                }
                            @endphp
                        <tr>
                            <td>
                                <img src="{{asset("img/".$lista->imagen)}}" class="img-circle img-size-32 mr-2">
                                {{$lista->nombre}}
                            </td>
                            <td class="text-primary text-bold">{{$v}}</td>
                            <td class="text-success text-bold">{{$p}} %</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>

            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card card-outline card-navy">
            <div class="card-header">
                <h4 class="card-title text-muted"><i class="fa-solid fa-person-booth"></i> Votaron</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-info mt-2" role="status" wire:loading wire:target='render'>
                      <span class="sr-only">Loading...</span>
                    </div>
                </div>
                @if ($eleccion->votos->count())
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Ip</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $n=0;
                        @endphp
                        @foreach ($eleccion->votos as $voto)
                            @php
                                $n++;
                            @endphp
                        <tr>
                            <td>{{$n}}</td>
                            <td>{{$voto->user->name}}</td>
                            <td>{{$voto->fecha}}</td>
                            <td>{{$voto->ip}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                Aún nadie ha votado
                @endif
            </div>
        </div>
    </div>



</div>
