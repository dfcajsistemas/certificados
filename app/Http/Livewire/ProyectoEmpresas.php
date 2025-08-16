<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ProyectoEmpresas extends Component
{
    use WithPagination;

    public $proyecto, $buscar, $metodo, $mtitulo, $idm, $razon_social;
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
        $empresas=$this->proyecto->empresas()->where('razon_social', 'like', '%'.$this->buscar.'%')->paginate($this->porPagina);
        return view('livewire.proyecto-empresas', compact('empresas'));
    }

    public function destroy($empresa_id){
        $this->proyecto->empresas()->detach($empresa_id);
        $this->emit('ms', 'Empresa eliminada del proyecto');
    }
}
