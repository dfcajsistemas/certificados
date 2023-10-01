<x-app-layout page="Consultas">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-navy">
                <div class="card-header">
                    <a href="{{route('consultas.restudiante')}}" class="btn btn-primary">Estudiante/Certificados</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{route('consultas.restudiante')}}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-md-10 mb-2">
                                        <select name="estudiante_id" id="estudiante" class="form-control" style="width: 100%">

                                        </select>
                                        @error('estudiante_id')
                                            <span class="text-xs text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary" type="submit" title="Buscar"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                @if ($certificados->count())

                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>TIPO</th>
                                        <th>NOTA</th>
                                        <th>HORAS</th>
                                        <th>INICIÓ</th>
                                        <th>FINALIZÓ</th>
                                        <th>ESTADO</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($certificados as $certificado)
                                        <tr>
                                            <td>{{$certificado->id}}</td>
                                            <td>{{$certificado->capacitacion->nombre}}</td>
                                            <td>{{$certificado->capacitacion->tipo}}</td>
                                            <td>{{$certificado->nota}}</td>
                                            <td>{{$certificado->capacitacion->horas}}</td>
                                            <td>{{$certificado->capacitacion->desde}}</td>
                                            <td>{{$certificado->capacitacion->hasta}}</td>
                                            <td>{!! $certificado->estado==1?'<span class="badge badge-pill badge-success">Activo</span>':'<span class="badge badge-pill badge-secondary">Inactivo</span>' !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$certificados->links()}}
                                @else
                                        <p><i class="fa-solid fa-circle-info text-info"></i> No se encontraron registros</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>


    var path = "{{ route('consultas.bsestudiante') }}";

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
