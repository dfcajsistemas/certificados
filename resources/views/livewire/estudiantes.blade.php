<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-navy">
            <div class="card-header">
                <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Estudiantes</h3>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <select wire:model="porPagina" class="form-control rounded-0 mr-2">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <input wire:model.defer="buscar" wire:keydown.enter='render' type="text" class="form-control" placeholder="Buscar">
                    <div class="input-group-append">
                        @if ($buscar!='')
                            <button wire:click="$set('buscar','')" class="btn btn-secondary btn-flat" title="Limpiar filtros"><i class="fa-solid fa-eraser"></i></button>
                        @endif
                        <button type="button" wire:click='render()' class="btn btn-info btn-flat" title="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <button type="button" wire:click='create()' class="btn btn-primary btn-flat" title="Nuevo estudiante"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                @if ($estudiantes->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th># DOCUMENTO</th>
                                    <th>CORREO</th>
                                    <th>TELÉFONO</th>
                                    <th>ESTADO</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estudiantes as $estudiante)
                                    <tr>
                                        <td>{{ ($estudiantes->currentPage()-1)*$estudiantes->perPage() + $loop->index+1 }}</td>
                                        <td>{{ $estudiante->nombre }}</td>
                                        <td>{{ $estudiante->dni }}</td>
                                        <td>{{ $estudiante->correo }}</td>
                                        <td>{{ $estudiante->telefono }}</td>
                                        <td>{!! $estudiante->estado==1?'<span class="badge badge-pill badge-success">Activo</span>':'<span class="badge badge-pill badge-secondary">Inactivo</span>' !!}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" wire:click='edit({{$estudiante->id}})' class="btn btn-outline-info btn-xs" title="Editar"><i class="fa-solid fa-pencil"></i></button>
                                                <button type="button" onclick="confirmar('{{$estudiante->nombre}}', {{$estudiante->id}})" class="btn btn-outline-secondary btn-xs" title="Cambiar estado"><i class="fa-solid fa-toggle-off"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $estudiantes->links() }}
                        <span class="text-muted">{{ $estudiantes->total() }} resultado(s)</span>
                    </div>
                @else
                    <span class="text-muted text-md"><i class="fa-solid fa-circle-info text-warning"></i> No se hallaron resultados para <b>{{$buscar}}</b></span>
                @endif
            </div>
        </div>
    </div>
        <x-modal idModal='modalRes' :mtitulo="$mtitulo" :metodo="$metodo">
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
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="dni"># Documento</label>
                        <input type="text" id="dni" wire:model.defer='dni' class="form-control" placeholder="# Documento">
                        @error('dni')
                            <span class="text-xs text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="telefono"># Teléfono</label>
                        <input type="text" id="telefono" wire:model.defer='telefono' class="form-control" placeholder="# Teléfono">
                        @error('telefono')
                            <span class="text-xs text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="text" id="correo" wire:model.defer='correo' class="form-control" placeholder="Correo">
                        @error('correo')
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
                    $('#modalRes').modal('show');
                });
                window.livewire.on('add', m=>{
                    $('#modalRes').modal('hide');
                    noti(m);
                });
                window.livewire.on('edit', m=>{
                    $('#modalRes').modal('hide');
                    noti(m);
                });
                window.livewire.on('status', m=>{
                    noti(m);
                });
            });

            function confirmar(m, id){
                Swal.fire({
                    title: 'Confirmar',
                    html: 'Cambiarás el estado de:<br><b>'+m+'</b>',
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
        </script>
    @endpush
</div>
