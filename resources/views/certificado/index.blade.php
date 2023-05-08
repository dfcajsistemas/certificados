<x-app-layout page="Capacitaciones - Certificados">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-outline card-navy">
                <div class="card-header">
                    <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Capacitación</h3>
                </div>
                <div class="card-body">
                    <h4 class="text-blue">{{$capacitacion->nombre}}</h4>
                    <h6 class="text-gray"><small>Tipo:</small> {{$capacitacion->tipo}}</h6>
                    <h6 class="text-gray"><small>Fecha:</small> {{$capacitacion->desde}} @if ($capacitacion->hasta) al {{$capacitacion->hasta}} @endif</h6>
                    <h6 class="text-gray"><small>Estado:</small> {!! $capacitacion->estado==1?'<span class="badge badge-pill badge-success">Activo</span>':'<span class="badge badge-pill badge-secondary">Inactivo</span>' !!}</h6>
                </div>
                {!! QrCode::format('png')->generate('https://www.simplesoftware.io/#/docs/simple-qrcode/es', '../public/qrcodes/qrcode.png'); !!}
            </div>
            <div class="card card-outline card-navy">
                <div class="card-body">
                    <form action="{{route('capacitaciones.certificados.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <select name="estudiante_id" id="estudiante" class="form-control" style="width: 100%" required>

                                </select>
                                @error('estudiante_id')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <input type="date" name="emision" class="form-control" placeholder="F. emisión" value="{{date('Y-m-d')}}" value="{{old('emision')}}" required>
                                @error('emision')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="nota" class="form-control" placeholder="Nota" step="0.01" value="{{old('nota')}}">
                                @error('nota')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary" type="submit" title="Agregar certificado"><i class="fa-solid fa-file-circle-plus"></i></button>
                            </div>
                            <input type="hidden" name="cap" value="{{$capacitacion->id}}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">

            @livewire('certificados', ['cap'=>$capacitacion->id])
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('sm', m=>{
            $('#modalRes').modal('show');
        });
        window.livewire.on('edit', m=>{
            $('#modalRes').modal('hide');
            noti(m);
        });
        window.livewire.on('status', m=>{
            noti(m);
        });
        window.livewire.on('delete', m=>{
            noti(m);
        });
    });

    function cestado(m, id){
        Swal.fire({
            title: 'Confirmar',
            html: 'Cambiarás el estado del certificado de:<br><b>'+m+'</b>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, cambiar',
            cancelButtonText: 'No'
        }).then((result)=>{
            if(result.isConfirmed){
                window.livewire.emit('estado', id);
                Swal.close();
            }
        })
    }

    function celiminar(m, id){
        Swal.fire({
            title: 'Confirmar',
            html: 'Eliminarás el certificado de:<br><b>'+m+'</b>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No'
        }).then((result)=>{
            if(result.isConfirmed){
                window.livewire.emit('destroy', id);
                Swal.close();
            }
        })
    }


    var path = "{{ route('capacitaciones.certificados.bsestudiante') }}";

    $('#estudiante').select2({
        placeholder: 'Elija un estudiante',
        minimumInputLength: 3,
        ajax: {
            url: path,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.nombre,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    </script>
    @endpush
</x-app-layout>
