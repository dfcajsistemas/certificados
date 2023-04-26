<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Consultas extends Component
{
    use WithPagination;

    public function render()
    {

        return view('livewire.consultas')
            ->layoutData(['page'=>'Consultas']);;
    }
}
