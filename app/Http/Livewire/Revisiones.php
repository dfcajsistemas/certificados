<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Revisiones extends Component
{
    public function render()
    {
        return view('livewire.revisiones')
                ->layoutData(['page'=>'Revisiones']);
    }
}
