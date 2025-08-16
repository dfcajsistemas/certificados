<?php

namespace App\Http\Livewire;

use App\Models\Disciplina;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Disciplinas extends Component
{
    use WithPagination;

    public $buscar, $metodo, $mtitulo, $idm, $nombre;
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
        $disciplinas=Disciplina::where('nombre', 'like', '%'.$this->buscar.'%')
                    ->orderBy('nombre')
                    ->paginate($this->porPagina);
        return view('livewire.disciplinas', compact('disciplinas'))
            ->layoutData(['page'=>'Disciplinas']);
    }

    public function create(){
        $this->mtitulo='Nueva disciplina';
        $this->metodo='store';

        $this->resetCom();
        $this->emit('sm', 'Mostrar modal');
    }

    public function store(){
        $rules=[
            'nombre'=>'required|min:3|unique:disciplinas,nombre',
        ];
        $messages=[
            'nombre.required'=>'Ingrese un nombre de disciplina',
            'nombre.min'=>'Mínimo 3 caracteres',
            'nombre.unique'=>'El nombre de disciplina ya existe',
        ];
        $this->validate($rules, $messages);

        $disciplina=Disciplina::create([
            'nombre'=>mb_strtoupper($this->nombre),
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id
        ]);

        $this->emit('ss', 'Disciplina agregada');
    }

    public function edit(Disciplina $disciplina){
        $this->mtitulo="Editar disciplina";
        $this->metodo="update";

        $this->resetCom();

        $this->idm=$disciplina->id;
        $this->nombre=$disciplina->nombre;

        $this->emit('sm', 'Mostrar modal!');
    }

    public function update(){
        $rules=[
            'nombre'=>'required|min:3|unique:disciplinas,nombre,'.$this->idm,
        ];
        $messages=[
            'nombre.required'=>'Ingrese un nombre',
            'nombre.min'=>'Mínimo 3 caracteres',
            'nombre.unique'=>'El nombre ya existe',
        ];

        $this->validate($rules, $messages);

        $disciplina=Disciplina::find($this->idm);

        $disciplina->update([
            'nombre'=>mb_strtoupper($this->nombre),
            'updated_by'=>Auth::user()->id
        ]);

        $this->emit('ss', 'Disciplina actualizada');
    }

    public function estado(Disciplina $disciplina){
        if($disciplina->estado=='1'){
            $disciplina->update([
                'estado'=>NULL,
                'updated_by'=>Auth::user()->id
            ]);
        }else{
            $disciplina->update([
                'estado'=>1,
                'updated_by'=>Auth::user()->id
            ]);
        }

        $this->emit('ms', 'Estado actualizado');
    }

    public function destroy(Disciplina $disciplina){
        if($disciplina->documentos->count() || $disciplina->users->count()){
            $this->emit('me', 'La disciplina no se puede eliminar porque tiene registros asociados');
            return;
        }else{
            $disciplina->delete();
            $this->emit('ms', 'Disciplina eliminada');
        }
    }

    public function resetCom(){
        $this->reset(['buscar', 'porPagina', 'idm','nombre']);
        $this->resetValidation();
    }
}
