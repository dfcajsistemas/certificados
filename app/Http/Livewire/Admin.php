<?php

namespace App\Http\Livewire;

use App\Models\Eleccione;
use App\Models\Voto;
use Livewire\Component;

class Admin extends Component
{
    public function render()
    {
        $eleccion=Eleccione::first();
        return view('livewire.admin', compact('eleccion'));
    }
}
