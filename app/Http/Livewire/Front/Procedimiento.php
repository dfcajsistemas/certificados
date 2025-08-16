<?php

namespace App\Http\Livewire\Front;

use App\Models\Paso;
use App\Models\Procedimiento as ModelsProcedimiento;
use App\Models\Slider;
use Livewire\Component;

class Procedimiento extends Component
{
    public $procedimiento;

    public function mount(ModelsProcedimiento $procedimiento){
        $this->procedimiento=$procedimiento;
    }
    public function render()
    {
        $sliders = Slider::all();
        $pasos=Paso::where('procedimiento_id', $this->procedimiento->id)
                ->where('estado', 1)
                ->orderBy('orden', 'asc')
                ->get();
        return view('livewire.front.procedimiento', compact('sliders', 'pasos'))
                ->layout('layouts.front');
    }
}
