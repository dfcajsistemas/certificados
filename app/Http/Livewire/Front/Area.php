<?php

namespace App\Http\Livewire\Front;

use App\Models\Area as ModelsArea;
use App\Models\Procedimiento;
use App\Models\Slider;
use Livewire\Component;
use Livewire\WithPagination;

class Area extends Component
{
    use WithPagination;

    public $area, $buscar;
    public $porPagina='10';

    protected $paginationTheme = 'bootstrap';

    public function mount(ModelsArea $area){
        $this->area=$area;
    }
    public function render()
    {
        $sliders = Slider::all();
        $procedimientos=Procedimiento::where('area_id', $this->area->id)
                        ->where('nombre', 'LIKE', '%'.$this->buscar.'%')
                        ->where('estado', 1)
                        ->paginate($this->porPagina);
        return view('livewire.front.area', compact('sliders', 'procedimientos'))
                ->layout('layouts.front');
    }
}
