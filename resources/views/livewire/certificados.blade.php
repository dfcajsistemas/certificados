
<div class="card card-outline card-navy">
    <div class="card-header">
        <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Certificados</h3>
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
            </div>
        </div>
        @if ($certificados->count())
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>EMISIÓN</th>
                            <th>NOTA</th>
                            <th>ESTADO</th>
                            <th>ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($certificados as $certificado)
                            <tr>
                                <td>{{ ($certificados->currentPage()-1)*$certificados->perPage() + $loop->index+1 }}</td>
                                <td>{{ $certificado->nombre }}</td>
                                <td>{{ $certificado->emision }}</td>
                                <td>{{ $certificado->nota }}</td>
                                <td>{!! $certificado->estado==1?'<span class="badge badge-pill badge-success">Activo</span>':'<span class="badge badge-pill badge-secondary">Inactivo</span>' !!}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" onclick="qr('{{$certificado->id}})" class="btn btn-outline-primary btn-xs" title="Ver QR"><i class="fa-solid fa-qrcode"></i></button>
                                        <button type="button" onclick="certi('{{$certificado->id}})" class="btn btn-outline-primary btn-xs" title="Ver certificado"><i class="fa-solid fa-pager"></i></button>
                                        <button type="button" wire:click='edit({{$certificado->id}})' class="btn btn-outline-info btn-xs" title="Editar"><i class="fa-solid fa-pencil"></i></button>
                                        <button type="button" onclick="cestado('{{$certificado->nombre}}', {{$certificado->id}})" class="btn btn-outline-secondary btn-xs" title="Cambiar estado"><i class="fa-solid fa-toggle-off"></i></button>
                                        <button type="button" onclick="celiminar('{{$certificado->nombre}}', {{$certificado->id}})" class="btn btn-outline-danger btn-xs" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $certificados->links() }}
                <span class="text-muted">{{ $certificados->total() }} resultado(s)</span>
            </div>
        @else
            <span class="text-muted text-md"><i class="fa-solid fa-circle-info text-warning"></i> No se hallaron resultados para <b>{{$buscar}}</b></span>
        @endif
    </div>
    <x-modal idModal='modalRes' :mtitulo="$mtitulo" :metodo="$metodo">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="text-success text-center"><i class="fa-solid fa-user-graduate text-gray"></i> {{$nombre}}</h5>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="emision">Emisión</label>
                    <input type="date" id="emision" wire:model.defer='emision' class="form-control" placeholder="Emisión">
                    @error('emision')
                        <span class="text-xs text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="nota">Nota</label>
                    <input type="text" id="nota" wire:model.defer='nota' class="form-control" placeholder="Nota">
                    @error('nota')
                        <span class="text-xs text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
    </x-modal>
</div>

