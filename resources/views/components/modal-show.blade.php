@props(['idModal'=>'modal', 'largo'=>'', 'mtitulo'=>''])

<div wire:ignore.self class="modal fade" tabindex="-1" id="{{$idModal}}" role="dialog">
    <div class="modal-dialog {{$largo}}">
      <div class="modal-content">
        <div wire:loading.inline-flex wire:loading.class='overlay'>
            <i class="fa-solid fa-3x fa-spinner fa-spin"></i>
        </div>
        <div class="modal-header">
          <h5 class="modal-title"><i class="fa-solid fa-pen-to-square text-orange"></i> {{$mtitulo}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- <div class="row"> --}}
                {{$slot}}
            {{-- </div> --}}
        </div>
      </div>
    </div>
</div>
