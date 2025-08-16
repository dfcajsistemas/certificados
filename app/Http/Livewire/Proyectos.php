<?php

namespace App\Http\Livewire;

use App\Models\Proyecto;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Proyectos extends Component
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
        $proyectos=Proyecto::where('nombre', 'like', '%'.$this->buscar.'%')
                    ->orderBy('nombre')
                    ->paginate($this->porPagina);
        return view('livewire.proyectos', compact('proyectos'))
            ->layoutData(['page'=>'Proyectos']);
    }

    public function create(){
        $this->mtitulo='Nuevo proyecto';
        $this->metodo='store';

        $this->resetCom();
        $this->emit('sm', 'Mostrar modal');
    }

    public function store(){
        $rules=[
            'nombre'=>'required|min:3|unique:proyectos,nombre',
        ];
        $messages=[
            'nombre.required'=>'Ingrese un nombre de proyecto',
            'nombre.min'=>'Mínimo 3 caracteres',
            'nombre.unique'=>'El nombre del proyecto ya existe',
        ];

        $this->validate($rules, $messages);

        $proyecto=Proyecto::create([
            'nombre'=>mb_strtoupper($this->nombre),
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id
        ]);

        $this->emit('ss', 'Proyecto agregado');
    }

    public function edit(Proyecto $proyecto){
        $this->mtitulo='Editar proyecto';
        $this->metodo='update';

        $this->resetCom();

        $this->idm=$proyecto->id;
        $this->nombre=$proyecto->nombre;

        $this->emit('sm', 'Mostrar modal');
    }

    public function update(){
        $rules=[
            'nombre'=>'required|min:3|unique:proyectos,nombre,'.$this->idm,
        ];
        $messages=[
            'nombre.required'=>'Ingrese un nombre de proyecto',
            'nombre.min'=>'Mínimo 3 caracteres',
            'nombre.unique'=>'El nombre del proyecto ya existe',
        ];

        $this->validate($rules, $messages);

        $proyecto=Proyecto::find($this->idm);
        $proyecto->update([
            'nombre'=>mb_strtoupper($this->nombre),
            'updated_by'=>Auth::user()->id
        ]);

        $this->emit('ss', 'Proyecto actualizado');
    }

    public function estado(Proyecto $proyecto){
        if($proyecto->estado==1){
            $proyecto->update([
                'estado'=>NULL,
                'updated_by'=>Auth::user()->id
            ]);
        }else{
            $proyecto->update([
                'estado'=>1,
                'updated_by'=>Auth::user()->id
            ]);
        }

        $this->emit('ms', 'Estado actualizado');
    }

    public function destroy(Proyecto $proyecto){
        if($proyecto->documentos->count() || $proyecto->empresas->count()){
            $this->emit('me', 'El proyecto no se puede eliminar porque tiene registros asociados');
            return;
        }else{
            $proyecto->delete();
            $this->emit('ms', 'Proyecto eliminada');
        }
    }

    public function resetCom(){
        $this->reset(['buscar', 'porPagina', 'idm','nombre']);
        $this->resetValidation();
    }
}
