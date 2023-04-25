<div class="row">
    @php
        $d=strtotime($eleccion->desde);
        $h=strtotime($eleccion->hasta);
        $a=strtotime(date('Y-m-d H:i:s'));
    @endphp
    <div class="col-md-12 m-2">
        <h6><i class="fa-solid fa-check-to-slot text-orange"></i> {{$eleccion->nombre}} - VOTE</h6>
    </div>
    @if($a<$d)
        <div class="col-md-12 text-center m-3">
            <h1 class="text-gray"><i class="fa-solid fa-clock text-warning"></i> Las votaciones se inician el {{date('d/m/Y H:i:s', strtotime($eleccion->desde))}}</h1>
        </div>
    @elseif ($a>$h)
        <div class="col-md-12 text-center m-3">
            <h1 class="text-gray"><i class="fa-solid fa-clock text-warning"></i> Las votaciones terminaron el {{date('d/m/Y H:i:s', strtotime($eleccion->hasta))}}</h1>
        </div>
    @elseif ($a>=$d && $a<=$h)
        @if (!$v)
            @foreach ($eleccion->listas as $lista)
            <div class="col-md-6">
                <div class="card">
                    <img class="card-img-top img-fluid" src="{{asset('/img/'.$lista->imagen)}}">
                    <div class="card-body text-center" style="border: 1px #c3c3c3 solid;">
                      <h5 class="text-bold text-maroon">{{$lista->nombre}}</h5>
                      <p class="card-text">{!!$lista->descripcion!!}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item text-center" style="border: 1px #c3c3c3 solid;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="voto" wire:model="voto" id="voto{{$lista->id}}" value="{{$lista->id}}" checked>
                            <label class="form-check-label text-red" for="voto{{$lista->id}}">
                            Vote aquí
                            </label>
                        </div>
                      </li>
                    </ul>
                </div>
            </div>
            <!-- /.col -->

            @endforeach
            <div class="col-md-12 m-2 text-center">
                <button class="btn btn-primary" onclick="confirmar('{{$elegida}}');"><i class="fa-solid fa-check-to-slot"></i> Enviar voto</button>
            </div>
            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function(){
                    window.livewire.on('voto', m=>{
                        noti(m);
                    });
                    window.livewire.on('error', m=>{
                        noti(m, 'error');
                    });
                });

                function confirmar(m){
                    if(m){
                        Swal.fire({
                            title: 'Confirmar',
                            html: '¿Seguro que deseas votar por<br><b>'+m+'</b>?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Si, votar',
                            cancelButtonText: 'No'
                        }).then((result)=>{
                            if(result.isConfirmed){
                                window.livewire.emit('gvoto');
                                Swal.close();
                            }
                        })
                    }else{
                        noti('Elija un candidato.', 'error');
                    }
                }

            </script>
            @endpush
        @else
            <div class="col-md-12 text-center m-3">
                <h1 class="text-info">Ya votaste</h1>
            </div>
            <div class="col-md-12 text-center m-3">
                <h3 class="text-gray"><i class="fa-solid fa-handshake-simple text-warning"></i> Se agredece su participación.</h3>
            </div>
        @endif
    @endif
</div>
