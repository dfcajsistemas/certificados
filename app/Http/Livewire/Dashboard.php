<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Capacitacion;
use App\Models\Certificado;
use App\Models\Estudiante;
use App\Models\Sede;
use App\Models\Slider;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $nusu=User::where('estado', 1)->count();
        $nest=2;
        $ncap=3;
        $ncer=4;
        return view('livewire.dashboard', compact('nusu', 'nest', 'ncap', 'ncer'))
            ->layoutData(['page'=>'Dashboard']);
    }
}
