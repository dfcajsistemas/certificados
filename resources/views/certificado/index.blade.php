<x-app-layout page="Capacitaciones - Certificados">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline card-navy">
                <div class="card-header">
                    <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Capacitación</h3>
                </div>

            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-outline card-navy">
                <div class="card-header">
                    <h3 class="card-title text-muted"><i class="fa-solid fa-angle-right text-orange"></i> Certificados</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('capacitaciones.certificados.store', $capacitacion->id)}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <select name="estudiante_id" id="estudiante" style="width: 100%">

                                </select>
                                @error('estudiante_id')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="date" name="emision" class="form-control" placeholder="F. emisión" value="{{date('Y-m-d')}}" value="{{old('emision')}}">
                                @error('emision')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-2">
                                <input type="number" name="nota" class="form-control" placeholder="Nota" step="0.01" value="{{old('nota')}}">
                                @error('nota')
                                    <span class="text-xs text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-1">
                                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-user-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
    var path = "{{ route('capacitaciones.certificados.bsestudiante') }}";

    $('#estudiante').select2({
        placeholder: 'Elija un estudiante',
        minimumInputLength: 3,
        ajax: {
            url: path,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.nombre,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    $(document).on('select2:open', () => {
        document.querySelector('#estudiante').focus();
      });
    </script>
    @endpush
</x-app-layout>
