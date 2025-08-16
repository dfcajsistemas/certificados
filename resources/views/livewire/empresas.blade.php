<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-navy">
            <div class="card-header">
                <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Empresas</h3>
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
                        <button type="button" wire:click='create()' class="btn btn-primary" title="Nueva empresa"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                @if ($empresas->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>RAZÓN SOCIAL</th>
                                    <th>RESPONSABLE</th>
                                    <th>CORREO</th>
                                    <th>TELÉFONO</th>
                                    <th>ESTADO</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($empresas as $empresa)
                                    <tr>
                                        <td>{{ $empresa->id }}</td>
                                        <td>{{ $empresa->razon_social }}</td>
                                        <td>{{ $empresa->responsable }}</td>
                                        <td>{{ $empresa->correo }}</td>
                                        <td>{{ $empresa->telefono }}</td>
                                        <td>{!! $empresa->estado==1?'<span class="badge badge-pill badge-success">Activo</span>':'<span class="badge badge-pill badge-secondary">Inactivo</span>' !!}</td>
                                        <td>
                                                <button type="button" wire:click='edit({{$empresa->id}})' class="btn btn-outline-info btn-xs" title="Editar"><i class="fa-solid fa-pencil"></i></button>
                                                <button type="button" wire:click='estado({{$empresa->id}})' class="btn btn-outline-secondary btn-xs" title="Cambiar estado"><i class="fa-solid fa-toggle-off"></i></button>
                                                <button type="button" onclick="celiminar('{{$empresa->razon_social}}', {{$empresa->id}})" class="btn btn-outline-danger btn-xs" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $empresas->links() }}
                        <span class="text-muted">{{ $empresas->total() }} resultado(s)</span>
                    </div>
                @else
                    <span class="text-muted text-md"><i class="fa-solid fa-circle-info text-warning"></i> No se hallaron resultados para <b>{{$buscar}}</b></span>
                @endif
            </div>
        </div>
    </div>
        <x-modal idModal='modalSed' largo="modal-lg" :mtitulo="$mtitulo" :metodo="$metodo">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="razon_social">Razón social</label>
                        <input type="text" id="razon_social" wire:model.defer='razon_social' class="form-control" placeholder="Razón social">
                        @error('razon_social')
                            <span class="text-xs text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="responsable">Responsable</label>
                        <input type="text" id="responsable" wire:model.defer='responsable' class="form-control" placeholder="Responsable">
                        @error('responsable')
                            <span class="text-xs text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="text" id="correo" wire:model.defer='correo' class="form-control" placeholder="Correo">
                        @error('correo')
                            <span class="text-xs text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" id="telefono" wire:model.defer='telefono' class="form-control" placeholder="Teléfono">
                        @error('telefono')
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
