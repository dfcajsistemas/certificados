<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-navy">
            <div class="card-header">
                <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Capacitaciones</h3>
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
                            <button type="button" wire:click='create()' class="btn btn-primary btn-flat" title="Nuevo capacitacion"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                @if ($capacitacions->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th>TIPO</th>
                                    <th>HORAS</th>
                                    <th>INICIÓ</th>
                                    <th>FINALIZÓ</th>
                                    <th>ESTADO</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($capacitacions as $capacitacion)
                                    <tr>
                                        <td>{{ ($capacitacions->currentPage()-1)*$capacitacions->perPage() + $loop->index+1 }}</td>
                                        <td>{{ $capacitacion->nombre }}</td>
                                        <td>{{ $capacitacion->tipo }}</td>
                                        <td>{{ $capacitacion->horas }}</td>
                                        <td>{{ $capacitacion->desde }}</td>
                                        <td>{{ $capacitacion->hasta }}</td>
                                        <td>{!! $capacitacion->estado==1?'<span class="badge badge-pill badge-success">Activo</span>':'<span class="badge badge-pill badge-secondary">Inactivo</span>' !!}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" wire:click='edit({{$capacitacion->id}})' class="btn btn-outline-info btn-xs" title="Editar"><i class="fa-solid fa-pencil"></i></button>
                                                <button type="button" onclick="confirmar('{{$capacitacion->nombre}}', {{$capacitacion->id}})" class="btn btn-outline-secondary btn-xs" title="Cambiar estado"><i class="fa-solid fa-toggle-off"></i></button>
                                                <a href="{{route('capacitaciones.certificados', $capacitacion->id)}}" class="btn btn-outline-primary btn-xs" title="Certificadosphp artisan "><i class="fa-solid fa-certificate"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $capacitacions->links() }}
                        <span class="text-muted">{{ $capacitacions->total() }} resultado(s)</span>
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
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <input type="text" id="tipo" wire:model.defer='tipo' class="form-control" placeholder="Tipo">
                        @error('tipo')
                            <span class="text-xs text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="horas"># Horas</label>
                        <input type="number" id="horas" wire:model.defer='horas' class="form-control" placeholder="# Horas" step=".01">
                        @error('horas')
                            <span class="text-xs text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="desde">Inició</label>
                        <input type="date" id="desde" wire:model.defer='desde' class="form-control" placeholder="Inició">
                        @error('desde')
                            <span class="text-xs text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="hasta">Finalizó</label>
                        <input type="date" id="hasta" wire:model.defer='hasta' class="form-control" placeholder="Finalizó">
                        @error('hasta')
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
