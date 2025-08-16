<x-app-layout page="Disciplina - Usuario">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-outline card-navy">
                <div class="card-header">
                    <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Disciplina</h3>
                </div>
                <div class="card-body">
                    <h4 class="text-blue">{{$disciplina->nombre}}</h4>
                    <h6 class="text-gray"><small>Estado:</small> {!! $disciplina->estado==1?'<span class="badge badge-pill badge-success">Activo</span>':'<span class="badge badge-pill badge-secondary">Inactivo</span>' !!}</h6>
                </div>
            </div>

            <div class="card card-outline card-navy">
                <div class="card-body">
                    <form action="{{route('disciplinas.users.store', $disciplina->id)}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="user">Usuario</label>
                                <select name="user_id" id="user" class="form-control" style="width: 100%" required>

                                </select>
                                @error('user_id')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block" type="submit" title="Agregar usuario"><i class="fa-solid fa-user-plus"></i></button>
                                <a href="{{route('disciplinas')}}" class="btn btn-secondary btn-block" title="Regresar"><i class="fa-solid fa-chevron-left"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            @livewire('disciplina-users', ['disciplina' => $disciplina])
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            window.livewire.on('ms', m=>{
                noti(m);
            });
        });
        function celiminar(m, id){
            Swal.fire({
                title: '¿Segur@ que deseas eliminar?',
                html: '<span class="text-danger">'+m+'</span>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then((result)=>{
                if(result.isConfirmed){
                    window.livewire.emit('destroy', id);
                    Swal.close();
                }
            })
        }
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
    </script>
    @endpush
</x-app-layout>
