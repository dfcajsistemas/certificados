<div class="row">
    <div class="col-sm-6">
        <div class="card card-outline card-navy">
            <div class="card-header">
                <h3 class="card-title test-muted">
                    <i class="fa-solid fa-key text-orange"></i>
                    Cambiar contraseña
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="password">Contraseña actual</label>
                            <input type="password" wire:model.defer='password' name="password" id="password" class="form-control" placeholder="Contraseña actual">
                            @error('password')
                                <span class="text-xs text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="npassword">Nueva contraseña</label>
                            <input type="password" wire:model.defer='npassword' name="npassword" id="npassword" class="form-control" placeholder="Nueva contraseña">
                            @error('npassword')
                                <span class="text-xs text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="cpassword">Confirmar contraseña</label>
                            <input type="password" wire:model.defer='cpassword' name="cpassword" id="cpassword" class="form-control" placeholder="Confirmar contraseña">
                            @error('cpassword')
                                <span class="text-xs text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-outline-info" wire:click.prevent='cambiarCon()' wire:loading.attr='disabled'><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 mb-2">
        <img src="{{asset('img/cer.jpg')}}" class="img-fluid">
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                window.livewire.on('con', m => {
                    noti(m['m'], m['t']);
                    setTimeout(() => {
                        window.location.href = "{{route('dashboard')}}";
                    }, 3000);
                });
            });

        </script>
    @endpush
</div>
