<?php

namespace App\Http\Livewire\Front;

use App\Models\Area;
use App\Models\Sede as ModelsSede;
use App\Models\Slider;
use Livewire\Component;
use Livewire\WithPagination;

class Sede extends Component
{
    use WithPagination;

    public $sede, $buscar;
    public $porPagina='10';

    protected $paginationTheme = 'bootstrap';

    public function mount(ModelsSede $sede){
        $this->sede=$sede;
    }
    public function render()
    {
        $sliders = Slider::all();
        $areas=Area::where('sede_id', $this->sede->id)
                ->where('estado', 1)
                ->where('nombre', 'LIKE', '%'.$this->buscar.'%')
                ->paginate($this->porPagina);
        return view('livewire.front.sede', compact('sliders', 'areas'))
                ->layout('layouts.front');
    }
}
