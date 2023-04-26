<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-navy">
            <div class="card-header">
                <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Accesos</h3>
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
                            <button type="button" wire:click='create()' class="btn btn-primary btn-flat" title="Nuevo usuario"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                @if ($users->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th>CORREO</th>
                                    <th>ROL</th>
                                    <th>ESTADO</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ ($users->currentPage()-1)*$users->perPage() + $loop->index+1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{!! $user->rol==1?'<span class="text-primary">Admin</span>':'<span class="text-success">Común</span>' !!}</td>
                                        <td>{!! $user->estado==1?'<span class="badge badge-pill badge-success">Activo</span>':'<span class="badge badge-pill badge-secondary">Inactivo</span>' !!}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" wire:click='edit({{$user->id}})' class="btn btn-outline-info btn-xs" title="Editar"><i class="fa-solid fa-pencil"></i></button>
                                                <button type="button" onclick="confirmar('{{$user->name}}', {{$user->id}})" class="btn btn-outline-secondary btn-xs" title="Cambiar estado"><i class="fa-solid fa-toggle-off"></i></button>
                                                <button type="button" onclick="cpassword('{{$user->name}}', {{$user->id}})" class="btn btn-outline-primary btn-xs" title="Cambiar contraseña"><i class="fa-solid fa-key"></i></button>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $users->links() }}
                        <span class="text-muted">{{ $users->total() }} resultado(s)</span>
                    </div>
                @else
                    <span class="text-muted text-md"><i class="fa-solid fa-circle-info text-warning"></i> No se hallaron resultados para <b>{{$buscar}}</b></span>
                @endif
            </div>
        </div>
    </div>
        <x-modal idModal='modalRes' :mtitulo="$mtitulo" :metodo="$metodo">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" wire:model.defer='name' class="form-control" placeholder="Nombre">
                    @error('name')
                        <span class="text-xs text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="text" id="email" wire:model.defer='email' class="form-control" placeholder="Correo">
                    @error('email')
                        <span class="text-xs text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select id="rol" class="form-control" wire:model.defer='rol'>
                        <option value="0">Común</option>
                        <option value="1">Admin</option>
                    </select>
                    @error('rol')
                        <span class="text-xs text-danger">{{$message}}</span>
                    @enderror
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
                    nuser(m);
                });
                window.livewire.on('edit', m=>{
                    $('#modalRes').modal('hide');
                    noti(m);
                });
                window.livewire.on('status', m=>{
                    noti(m);
                });
                window.livewire.on('pass', m=>{
                    rpassword(m);
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

            function cpassword(m, id){
                Swal.fire({
                    title: 'Contraseña',
                    html: 'Cambiarás la contraseña de:<br><b>'+m+'</b>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, cambiar',
                    cancelButtonText: 'No'
                }).then((result)=>{
                    if(result.isConfirmed){
                        window.livewire.emit('password', id);
                        Swal.close();
                    }
                })
            }
            function nuser(r){
                Swal.fire(
                    '¡Usuario creado!',
                    r,
                    'success'
                )
            }
            function rpassword(r){
                Swal.fire(
                    '¡Contraseña cambiada!',
                    r,
                    'success'
                )
            }
        </script>
    @endpush
</div>
