<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-navy">
            <div class="card-header">
                <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Documentos</h3>
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
                        <button type="button" wire:click='create()' class="btn btn-primary" title="Nuevo documento"><i class="fa-solid fa-plus"></i></button>
                        {{-- <a href="{{route('documentos.create')}}" class="btn btn-primary" title="Nuevo documento"><i class="fa-solid fa-plus"></i></a> --}}
                    </div>
                </div>
                @if ($documentos->count())
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CÓDIGO</th>
                                <th>ENLACE</th>
                                <th>FECHA</th>
                                <th>DISCIPLINA</th>
                                <th>PROYECTO</th>
                                <th>EMPRESA</th>
                                <th>ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documentos as $documento)
                            <tr>
                                <td>{{ $documento->id }}</td>
                                <td>{{ $documento->codigo }}</td>
                                <td><a href="C:\Users\{{ auth()->user()->nfotocheck.$documento->enlace }}">C:\Users\{{ auth()->user()->nfotocheck.$documento->enlace }}</a></td>
                                <td>{{ date('d/m/Y', strtotime($documento->fecha)) }}</td>
                                <td>{{ $documento->disciplina->nombre }}</td>
                                <td>{{ $documento->proyecto->nombre }}</td>
                                <td>{{ $documento->empresa->razon_social }}</td>
                                <td>
                                    <button type="button" wire:click='edit({{$documento->id}})' class="btn btn-outline-info btn-xs" title="Editar"><i class="fa-solid fa-pencil"></i></button>
                                    <button type="button" onclick="celiminar('{{$documento->nombre}}', {{$documento->id}})" class="btn btn-outline-danger btn-xs" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $documentos->links() }}
                    <span class="text-muted">{{ $documentos->total() }} resultado(s)</span>
                </div>
                @else
                <span class="text-muted text-md"><i class="fa-solid fa-circle-info text-warning"></i> No se hallaron resultados para <b>{{$buscar}}</b></span>
                @endif
            </div>
        </div>
    </div>
    <x-modal idModal='modal' largo="modal-lg" :mtitulo="$mtitulo" :metodo="$metodo">
        <div class="row">
            <div class="col-md-4">
                <label for="codigo">Código</label>
                <input type="text" wire:model.defer="codigo" id="codigo" class="form-control" placeholder="Código" required>
                @error('codigo')
                <span class="text-xs text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-8">
                <label for="enlace">Enlace</label>
                <input type="text" wire:model.defer="enlace" id="enlace" class="form-control" placeholder="\OneDrive - Newmont USA Limited\Proyectos\..." required>
                @error('enlace')
                <span class="text-xs text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="fecha">Fecha</label>
                <input type="date" wire:model.defer="fecha" id="fecha" class="form-control" placeholder="Fecha" required>
                @error('fecha')
                <span class="text-xs text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="proyecto">Proyecto</label>
                <select wire:model="proyecto_id" id="proyecto" class="form-control" required>
                    <option value="">Elija un proyecto</option>
                    @foreach ($proyectos as $proyecto)
                    <option value="{{$proyecto->id}}">{{$proyecto->nombre}}</option>
                    @endforeach
                </select>
                @error('proyecto_id')
                <span class="text-xs text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="empresa">Empresa</label>
                <select wire:model.defer="empresa_id" id="empresa" class="form-control" required>
                    <option value="">Elija un empresa</option>
                    @if($proyecto_id)
                    @foreach ($empresas as $empresa)
                    <option value="{{$empresa->id}}">{{$empresa->razon_social}}</option>
                    @endforeach
                    @endif
                </select>
                @error('empresa_id')
                <span class="text-xs text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="disciplina">Disciplina</label>
                <select wire:model="disciplina_id" id="disciplina" class="form-control" required>
                    <option value="">Elija una disciplina</option>
                    @foreach ($disciplinas as $disciplina)
                    <option value="{{$disciplina->id}}">{{$disciplina->nombre}}</option>
                    @endforeach
                </select>
                @error('disciplina_id')
                <span class="text-xs text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-8 mb-2">
                <label for="user">Responsable</label>
                <select wire:model.defer="user_id" id="user" class="form-control" required>
                    <option value="">Elija un responsable</option>
                    @if($disciplina_id)
                    @foreach ($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                    @endif
                </select>
                @error('user_id')
                <span class="text-xs text-danger">{{$message}}</span>
                @enderror
            </div>            
        </div>
    </x-modal>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('sm', m => {
                $('#modal').modal('show');
            });
            window.livewire.on('ss', m => {
                $('#modal').modal('hide');
                noti(m);
            });
            
            window.livewire.on('ms', m => {
                noti(m);
            });
            window.livewire.on('me', m => {
                noti(m, 'error');
            });
        });

        function celiminar(m, id) {
            Swal.fire({
                title: '¿Seguro que deseas eliminar?',
                html: '<b>' + m + '</b>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('destroy', id);
                    Swal.close();
                }
            })
        }
    </script>
    @endpush
</div>