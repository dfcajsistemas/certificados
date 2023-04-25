<?php

namespace App\Http\Livewire;

use App\Models\Eleccione;
use App\Models\Lista;
use App\Models\Voto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Inicio extends Component
{
    public $voto, $eleccione_id, $elegida;

    protected $listeners=['gvoto'];

    public function updatedVoto(){
        $this->elegida=Lista::find($this->voto)->nombre;
    }

    public function render()
    {
        $eleccion=Eleccione::first();
        $v=Voto::where('user_id', Auth::user()->id)->where('eleccione_id', $eleccion->id)->first();
        $this->eleccione_id=$eleccion->id;
        return view('livewire.inicio', compact('eleccion', 'v'));
    }

    public function gvoto(){

        if($this->voto){

            $voto = new Voto();

            $voto->fecha=date('Y-m-d H:i:s');
            $voto->ip=request()->ip();
            $voto->lista_id = $this->voto;
            $voto->user_id=Auth::user()->id;
            $voto->eleccione_id=$this->eleccione_id;

            $voto->save();

            $this->emit('voto', "Voto registrado para $this->elegida.");

        }else{
            $this->emit('error', "Elija un candidato");
        }

    }
}
