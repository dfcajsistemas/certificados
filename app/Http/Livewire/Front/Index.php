<?php

namespace App\Http\Livewire\Front;

use App\Models\Sede;
use App\Models\Slider;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {

        $sliders = Slider::whereDate('hasta', '>=', Carbon::now())
                    ->get();
        $sedes=Sede::where('estado', 1)->get();
        return view('livewire.front.index', compact('sliders', 'sedes'))
                ->layout('layouts.front');
    }
}
