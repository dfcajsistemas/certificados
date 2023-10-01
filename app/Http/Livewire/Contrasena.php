<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Contrasena extends Component
{
    public $password, $npassword, $cpassword;

    public function render()
    {
        return view('livewire.contrasena')
                ->layoutData(['page'=>'Cambiar contraseña']);
    }

    public function cambiarCon(){
        $this->validate([
            'password' => 'required',
            'npassword' => 'required|min:8',
            'cpassword' => 'required|same:npassword',
        ],
        [
            'password.required' => 'La contraseña actual es requerida.',
            'npassword.required' => 'La nueva contraseña es requerida.',
            'npassword.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'cpassword.required' => 'La confirmación de la nueva contraseña es requerida.',
            'cpassword.same' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        $user = auth()->user();
        if(Hash::check($this->password, $user->password)){
            $user->password = Hash::make($this->npassword);
            $user->save();
            $this->reset(['password', 'npassword', 'cpassword']);
            $this->emit('con', ['t'=>'success', 'm'=>'Contraseña cambiada, inicie sesión nuevamente.']);
        }else{
            $this->reset(['password']);
            $this->emit('con', ['t'=>'error', 'm'=>'La contraseña actual no coincide.']);
        }
    }
}
