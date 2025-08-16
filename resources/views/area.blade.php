<x-app-layout page="Áreas">
    <div class="row mb-3">
        <div class="col-sm-12">
            <select name="isede" id="bsede" class="form-control mr-2" style="width: 100%;">
            </select>
        </div>
    </div>

    @isset($sede_id)
        @livewire('areas', ['sede_id' => $sede_id])
    @endisset

    @push('scripts')
    <script>
        $('#bsede').select2({
            placeholder: 'Seleccione una sede',
            minimumInputLength: 3,
            ajax: {
                url: '{{route('areas.bsedes')}}',
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
        }).on('change', function(e) {
            window.location.href = '{{route("areas")}}/'+this.value;
        });
    </script>
    @endpush
</x-app-layout>
