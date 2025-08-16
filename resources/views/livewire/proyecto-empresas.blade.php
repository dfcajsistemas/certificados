<div class="card card-outline card-navy">
    <div class="card-header">
        <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Proyectos</h3>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-2">
                <select wire:model="porPagina" class="form-control mr-2">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-md-8">
                <input wire:model.defer="buscar" wire:keydown.enter='render' type="text" class="form-control" placeholder="Buscar">
            </div>
            <div class="col-md-2">
                @if ($buscar!='')
                    <button wire:click="$set('buscar','')" class="btn btn-secondary mr-1" title="Limpiar filtros"><i class="fa-solid fa-eraser"></i></button>
                @endif
                <button type="button" wire:click='render()' class="btn btn-info" title="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
        @if ($empresas->count())
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>RAZÓN SOCIAL</th>
                            <th>ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr>
                                <td>{{ $empresa->id }}</td>
                                <td>{{ $empresa->razon_social }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" onclick="celiminar('{{$empresa->name}}', {{$empresa->id}})" class="btn btn-outline-danger btn-xs" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>
                                    </div>
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
