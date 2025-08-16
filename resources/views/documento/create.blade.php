<x-app-layout page="Documentos - Crear">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-navy">
                <div class="card-header">
                    <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Registrar documento</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('documentos.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="codigo">Código</label>
                                <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Código" value="{{old('codigo')}}" required>
                                @error('codigo')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label for="enlace">Enlace</label>
                                <input type="text" name="enlace" id="enlace" class="form-control" placeholder="Enlace" value="{{old('enlace')}}" required>
                                @error('enlace')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" placeholder="Fecha" value="{{old('fecha')}}" required>
                                @error('fecha')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="proyecto">Proyecto</label>
                                <select name="proyecto_id" id="proyecto" class="form-control" style="width: 100%" required onchange="cempresas(this.value)">
                                    <option value="">Elija un proyecto</option>
                                    @foreach ($proyectos as $proyecto)
                                        <option value="{{$proyecto->id}}" {{old('proyecto_id')==$proyecto->id?'selected':''}}>{{$proyecto->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('proyecto_id')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="empresa">Empresa</label>
                                <select name="empresa_id" id="empresa" class="form-control" style="width: 100%" required>
                                    <option value="">Elija un empresa</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{$empresa->id}}" {{old('empresa_id')==$empresa->id?'selected':''}}>{{$empresa->razon_social}}</option>
                                    @endforeach
                                </select>
                                @error('proyecto_id')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="disciplina">Disciplina</label>
                                <select name="disciplina_id" id="disciplina" class="form-control" style="width: 100%" required>
                                    <option value="">Elija una disciplina</option>
                                    @foreach ($disciplinas as $disciplina)
                                        <option value="{{$disciplina->id}}" {{old('disciplina_id')==$disciplina->id?'selected':''}}>{{$disciplina->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('disciplina_id')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-8 mb-2">
                                <label for="user">Usuario</label>
                                <select name="user_id" id="user" class="form-control" style="width: 100%" required>

                                </select>
                                @error('user_id')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit" title="Agregar usuario"><i class="fa-solid fa-file-circle-plus"></i> Agregar</button>
                                <a href="{{route('disciplinas')}}" class="btn btn-secondary" title="Regresar"><i class="fa-solid fa-chevron-left"></i> Regresar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    @push('scripts')
    <script>
        var path = "{{ route('disciplinas.busers') }}";
        $('#user').select2({
            placeholder: 'Elija un usuario',
            minimumInputLength: 3,
            ajax: {
                url: path,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        function cempresas(ps){
            fetch('/documentos/bempresas/'+ps)
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    console.log(data);
                })
        }
    </script>
    @endpush
</x-app-layout>
