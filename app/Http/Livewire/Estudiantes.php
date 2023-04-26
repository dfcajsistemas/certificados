<?php

namespace App\Http\Livewire;

use App\Models\Estudiante;
use Livewire\Component;
use Livewire\WithPagination;

class Estudiantes extends Component
{
    use WithPagination;

    public $buscar, $metodo, $mtitulo, $idm, $nombre, $dni, $correo, $telefono;
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
        $estudiantes=Estudiante::where('nombre', 'like', '%'.$this->buscar.'%')
                    ->orWhere('dni', 'like', '%'.$this->buscar.'%')
                    ->orderBy('nombre')
                    ->paginate($this->porPagina);
        return view('livewire.estudiantes', compact('estudiantes'))
            ->layoutData(['page'=>'Estudiantes']);
    }

    public function create(){

        $this->mtitulo='Nuevo estudiante';
        $this->metodo='store';

        $this->resetCom();
        $this->emit('sm', 'Mostrar modal!');
    }

    public function store(){
        $rules=[
            'nombre'=>'required|min:3',
            'dni'=>'required|min:8|unique:estudiantes,dni',
            'correo'=>'nullable|email'
        ];

        $messages=[
            'nombre.required'=>'Ingrese un nombre',
            'nombre.min'=>'Mínimo 3 caracteres',
            'dni.required'=>'Ingrese # documento',
            'dni.min'=>'Mínimo 8 caracteres',
            'dni.unique'=>'# documento existe',
            'correo.email'=>'Correo no válido'
        ];

        $this->validate($rules, $messages);

        $estudiante=Estudiante::create([
            'nombre'=>$this->nombre,
            'dni'=>$this->dni,
            'telefono'=>$this->telefono,
            'correo'=>$this->correo
        ]);

        $this->emit('add', "Estudiante <b>$estudiante->nombre</b> creado.");
    }

    public function resetCom(){
        $this->reset(['buscar', 'porPagina', 'idm', 'nombre', 'dni', 'correo', 'telefono']);
        $this->resetValidation();
    }
}
