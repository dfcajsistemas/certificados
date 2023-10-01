<?php

namespace App\Http\Livewire;

use App\Models\Capacitacion;
use App\Models\Certificado;
use App\Models\Estudiante;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $nusu=User::where('estado', 1)->count();
        $nest=Estudiante::where('estado', 1)->count();
        $ncap=Capacitacion::where('estado', 1)->count();
        $ncer=Certificado::join('capacitacions', 'certificados.capacitacion_id', '=', 'capacitacions.id')->where('certificados.estado', 1)->where('capacitacions.estado', 1)->count();
        return view('livewire.dashboard', compact('nusu', 'nest', 'ncap', 'ncer'))
            ->layoutData(['page'=>'Dashboard']);
    }
}
