<?php

namespace App\Http\Livewire;

use App\Models\Disciplina;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DisciplinaUsers extends Component
{
    use WithPagination;

    public $disciplina, $buscar, $metodo, $mtitulo, $idm, $nombre;
    public $porPagina='10';

    protected $queryString=[
        'buscar'=>['except'=>''],
        'porPagina'=>['except'=>'10']
    ];

    protected $paginationTheme='bootstrap';
    protected $listeners=['destroy'];

    public function updatingBuscar(){
        $this->resetPage();
    }

    public function updatingPorPagina(){
        $this->resetPage();
    }

    public function render()
    {
        $users=$this->disciplina->users()->where('name', 'like', '%'.$this->buscar.'%')->paginate($this->porPagina);
        return view('livewire.disciplina-users', compact('users'));
    }

    public function destroy(User $user){
        $this->disciplina->users()->detach($user->id);
        $this->emit('ms', 'Usuario eliminado de la disciplina');
    }
}
