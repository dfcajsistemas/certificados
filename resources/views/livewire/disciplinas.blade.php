<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-navy">
            <div class="card-header">
                <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Disciplinas</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-1">
                        <select wire:model="porPagina" class="form-control mr-2">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-9">
                        <input wire:model.defer="buscar" wire:keydown.enter='render' type="text" class="form-control" placeholder="Buscar">
                    </div>
                    <div class="col-md-2">
                        @if ($buscar!='')
                            <button wire:click="$set('buscar','')" class="btn btn-secondary mr-1" title="Limpiar filtros"><i class="fa-solid fa-eraser"></i></button>
                        @endif
                        <button type="button" wire:click='render()' class="btn btn-info" title="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <button type="button" wire:click='create()' class="btn btn-primary" title="Nueva disciplina"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                @if ($disciplinas->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>ESTADO</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($disciplinas as $disciplina)
                                    <tr>
                                        <td>{{ $disciplina->id }}</td>
                                        <td>{{ $disciplina->nombre }}</td>
                                        <td>{!! $disciplina->estado==1?'<span class="badge badge-pill badge-success">Activo</span>':'<span class="badge badge-pill badge-secondary">Inactivo</span>' !!}</td>
                                        <td>
                                            <a href="{{route('disciplinas.users', $disciplina->id)}}" class="btn btn-outline-primary btn-xs" title="Agregar usuarios"><i class="fa fa-user"></i></a>
                                            <button type="button" wire:click='edit({{$disciplina->id}})' class="btn btn-outline-info btn-xs" title="Editar"><i class="fa-solid fa-pencil"></i></button>
                                            <button type="button" wire:click='estado({{$disciplina->id}})' class="btn btn-outline-secondary btn-xs" title="Cambiar estado"><i class="fa-solid fa-toggle-off"></i></button>
                                            <button type="button" onclick="celiminar('{{$disciplina->nombre}}', {{$disciplina->id}})" class="btn btn-outline-danger btn-xs" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $disciplinas->links() }}
                        <span class="text-muted">{{ $disciplinas->total() }} resultado(s)</span>
                    </div>
                @else
                    <span class="text-muted text-md"><i class="fa-solid fa-circle-info text-warning"></i> No se hallaron resultados para <b>{{$buscar}}</b></span>
                @endif
            </div>
        </div>
    </div>
        <x-modal idModal='modalSed' :mtitulo="$mtitulo" :metodo="$metodo">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" wire:model.defer='nombre' class="form-control" placeholder="Nombre">
                        @error('nombre')
                            <span class="text-xs text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </x-modal>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                window.livewire.on('sm', m=>{
                    $('#modalSed').modal('show');
                });
                window.livewire.on('ss', m=>{
                    $('#modalSed').modal('hide');
                    noti(m);
                });
                window.livewire.on('ms', m=>{
                    noti(m);
                });
                window.livewire.on('me', m=>{
                    noti(m, 'error');
                });
            });

            function celiminar(m, id){
                Swal.fire({
                    title: '¿Seguro que deseas eliminar?',
                    html: '<b>'+m+'</b>',
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
        </script>
    @endpush
</div>
